<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
 * Copyright (C) 2009 Vasilis Tsiligiannis <b_tsiligiannis@silverton.gr>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 2 dated June, 1991.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

class mysql {
	var $mysql_link;
	var $error;
	var $error_report;
	var $last_query;
	var $insert_id;
	var $affected_rows;
	var $log=FALSE;
	var $logs_table='';
	var $log_insert_id;
	var $log_last_query;
	
	var $total_queries=0;
	var $total_time=0;
	
	function mysql($server, $user, $password, $database) {
		if (!$this->mysql_link = @mysql_connect($server, $user, $password, TRUE)) {
			$this->error();
			return;
		}
		if (!@mysql_select_db($database, $this->mysql_link)) {
			$this->error();
			return;
		}
	}
	
	function close_mysql() {
		return mysql_close($this->mysql_link);
	}
	
	function query($query) {
		$this->insert_id = 0;
		$this->affected_rows = 0;
		$this->last_query=$query;
		$this->total_queries += 1;
		$mt = $this->getmicrotime();
		$q = mysql_query($query, $this->mysql_link);
		$this->total_time += ($this->getmicrotime() - $mt);
		$this->error();
		return $q;
	}
	
	function query_data($query) {
		$q = $this->query($query);
		return $this->result_to_data($q);
	}
	
	function result_to_data($result) {
		if ($result === FALSE) {
			return FALSE;
		} elseif ($result === TRUE) {
			return TRUE;
		}
		$i = 0;
		$res = array();
		while ($ret = mysql_fetch_assoc($result)) {
			while (list ($key, $value) = each ($ret)) {
				$res[$i][$key] = $value;
			}
			$i++;
		}
		mysql_free_result($result);
		return $res;
	}
	
	function get_fields($table) {
		return $this->query_data("SHOW FIELDS FROM `$table`");
	}

	function get($select="*", $from, $where="", $group_by="", $order_by="", $limit="") {
		return $this->query_data("SELECT $select FROM $from".($where==""?"":" WHERE $where").($group_by==""?"":" GROUP BY $group_by").($order_by==""?"":" ORDER BY $order_by").($limit==""?"":" LIMIT $limit"));
	}
	
	function add($table, $data, $addlog=TRUE, $try_date_in=TRUE) {
		$table_start = preg_split("/[\s,]+/", $table);
		$table_start = $table_start[0];
		$db_fields = $this->query_data("SHOW FIELDS FROM `$table_start`");
		for ($i=0;$i<count($db_fields);$i++) {
			$nulls[$db_fields[$i]['Field']] = $db_fields[$i]['Null'];
			$nulls['`'.$db_fields[$i]['Field'].'`'] = $db_fields[$i]['Null'];
			if ($try_date_in && !isset($data['date_in'])) {
				if ($db_fields[$i]['Field'] == 'date_in') {
					$data['date_in'] = $this->date_now();
				}
			}
		}
		$keys = "";
		$values = "";
		while (list ($key, $value) = each ($data)) {
			$key_t = explode(".", $key);
			$key_t = $key_t[count($key_t)-1];
			if ($value === '' && $nulls[$key_t] != 'YES') {
				if (!isset($not_null_keys)) $not_null_keys = array();
				array_push($not_null_keys, $table.".".$key);
			}
			$keys .= $key.", ";
			$value = str_replace("'", "\\'", $value);
			$value = str_replace("\\\\'", "\\'", $value);
			$values .= ($value === '' || $value === NULL?'NULL':"'".$value."'").", ";
		}
		$keys = substr($keys, 0, -2);
		$values = substr($values, 0, -2);
		$query = "INSERT INTO $table ($keys) VALUES ($values)";
		if (isset($not_null_keys)) {
			$this->output_error_fields_required($not_null_keys);
			if ($addlog) $this->add_log('ADD', $table, $this->insert_id, serialize($data), $query, $this->get_error());
			return FALSE;
		}
		$res = $this->query_data($query);
		if ($res === TRUE) $this->insert_id = mysql_insert_id($this->mysql_link);
		if ($addlog) $this->add_log('ADD', $table, $this->insert_id, serialize($data), $query, (!$res?$this->get_error():''));
		return $res;
	}
	
	function set($table, $data, $where='', $addlog=TRUE) {
		$table_start = preg_split("/[\s,]+/", $table);
		$table_start = $table_start[0];
		if ($addlog && $this->log) $aff = $this->query_data("SELECT ".$table_start.".id FROM $table WHERE $where");
		$db_fields = $this->query_data("SHOW FIELDS FROM `$table_start`");
		for ($i=0;$i<count($db_fields);$i++) {
			$nulls[$db_fields[$i]['Field']] = $db_fields[$i]['Null'];
			$nulls['`'.$db_fields[$i]['Field'].'`'] = $db_fields[$i]['Null'];
		}
		$sets="";
		while (list ($key, $value) = each ($data)) {
			$key_t = explode(".", $key);
			$key_t = $key_t[count($key_t)-1];
			if ($value === '' && $nulls[$key_t] != 'YES') {
				if (!isset($not_null_keys)) $not_null_keys = array();
				array_push($not_null_keys, $table.".".$key);
			}
			$value = str_replace("'", "\\'", $value);
			$value = str_replace("\\\\'", "\\'", $value);
			$sets .= $key."=".($value === '' || $value === NULL?'NULL':"'".$value."'").", ";
		}
		$sets = substr($sets, 0, -2);
		$query = "UPDATE $table SET $sets".($where!=''?" WHERE $where":'');
		if (isset($not_null_keys)) {
			$this->output_error_fields_required($not_null_keys);
			if ($addlog && isset($aff)) {
				for ($i=0;$i<count($aff);$i++) {
					$this->add_log('EDIT', $table_start, $aff[$i]['id'], serialize($data), $query, $this->get_error());
				}
			}
			return FALSE;
		}
		$res = $this->query_data($query);
		if ($addlog && isset($aff)) {
			for ($i=0;$i<count($aff);$i++) {
				$this->add_log('EDIT', $table_start, $aff[$i]['id'], serialize($data), $query, (!$res?$this->get_error():''));
			}
		}
		return $res;
	}

	function del($table, $using="", $where="", $addlog=TRUE) {
		$table_start = preg_split("/[\s,]+/", $table);
		$table_start = $table_start[0];
		if ($addlog && $this->log) $aff = $this->query_data("SELECT ".$table_start.".id FROM ".($using==""?"$table":"$using").($where==""?"":" WHERE $where"));
		$query = "DELETE FROM $table".($using==""?"":" USING $using").($where==""?"":" WHERE $where");
		$res = $this->query_data($query);
		if ($res === TRUE) $this->affected_rows = mysql_affected_rows($this->mysql_link);
		if ($addlog && isset($aff)) {
			for ($i=0;$i<count($aff);$i++) {
				$this->add_log('DELETE', $table_start, $aff[$i]['id'], '', $query, (!$res?$this->get_error():''));
			}
		}
		return $res;
	}

	function cnt($select="*", $table, $where="", $group_by="", $order_by="", $limit="") {
		if ($select == '') $select = '*';
		$query = "SELECT $select FROM $table".($where==""?"":" WHERE $where").($group_by==""?"":" GROUP BY $group_by").($order_by==""?"":" ORDER BY $order_by").($limit==""?"":" LIMIT $limit");
		$q = $this->query($query);
		return mysql_num_rows($q);
	}
	
	function error() {
		$this->error = mysql_errno();
		$this->error_report = mysql_error();
		if ($this->error == 1062) {
			$this->output_error_duplicate_entry();
		} elseif ($this->error > 0) {			
			$this->output_error();
		}
	}
	
	function output_error_duplicate_entry() {
		global $main, $lang;
		mb_ereg(".*'(.*)'.*", $this->error_report, $ereg);
		$duplicate_entries = $ereg[1];
		$main->message->set($lang['message']['error']['duplicate_entry']['title'], str_replace("##duplicate_entries##", $duplicate_entries, $lang['message']['error']['duplicate_entry']['body']));
	}

	function output_error_fields_required($fields_required) {
		global $main, $lang;
		$fields_required_text = '';
		foreach ($fields_required as $key => $value) {
			if ($fields_required_text != '') $fields_required_text .= ", "; 
			$fields_required_text .= $lang['db'][str_replace(".", "__", $value)];
		}
		$main->message->set($lang['message']['error']['fields_required']['title'], str_replace("##fields_required##", $fields_required_text, $lang['message']['error']['fields_required']['body']));
	}
	
	function output_error($num='', $report='') {
		global $main;
		if ($num !== '') $this->error = $num;
		if ($num !== '') $this->error_report = $report;
		if (isset($main)) {
			if ($main->userdata->privileges['admin'] === TRUE) {
				$main->message->set('MySQL Error', $this->get_error().'<br /><br />Last MySQL query:<br />'.$this->last_query);
			} else {
				$main->message->set_fromlang('error', 'database_error');	
			}
		}
	}
	
	function get_error() {
		return $this->error.": ".$this->error_report;
	}
	
	function add_log($type, $table, $affected_id, $data, $query="", $error="") {
		if (!$this->log) return;
		global $main;
		$date = "'".date_now()."'";
		$user_type = "'".$main->userdata->user_type."'";
		$user_id = $main->userdata->user_id;
		$type = "'".$type."'";
		$ip = "'".get_ip()."'";
		$dns = "'".get_dns()."'";
		$table = "'".$table."'";
		if ($user_type == "''") return;
		if ($data == '') $data = 'NULL'; else $data = "'".addslashes($data)."'";
		if ($query == '') $query = 'NULL'; else $query = "'".addslashes($query)."'";
		if ($error == '') $error = 'NULL'; else $error = "'".addslashes($error)."'";
		$log_query = "INSERT INTO ".$this->logs_table." (date, user_type, user_id, type, ip, dns, tablename, affected_id, data, query, error) VALUES ($date, $user_type, $user_id, $type, $ip, $dns, $table, $affected_id, $data, $query, $error)";
		$insert_id_return = $this->insert_id;
		$last_query_return = $this->last_query;
		$this->query_data($log_query);
		$this->log_insert_id = $this->insert_id;
		$this->log_last_query = $this->last_query;
		
		$this->insert_id = $insert_id_return;
		$this->last_query = $last_query_return;
	}

	function getmicrotime(){ 
		list($usec, $sec) = explode(" ",microtime()); 
		return ((float)$usec + (float)$sec); 
	} 

	function date_now() {
	      return date("Y-m-d H:i:s");
	}

}

?>