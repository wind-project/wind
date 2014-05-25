<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2012 Leonidas Papadopoulos <leonidas@wna.gr>
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

#if (get('log') != '') include_once(ROOT_PATH."includes/pages/admin/admin_nodechangeslog_log.php");

class nodechangeslog {

	var $tpl;
	var $page;
	
	function admin_nodechangeslog() {
		if (get('log') != '') {
			$p = "nodechangeslog_log";
			$this->page = new $p;
		}		
	}
	
	function table_nodechangeslog() {
		global $construct, $db, $main;
		$table_nodechangeslog = new table(array('FORM_NAME' => 'table_nodechangeslog', 'TABLE_NAME' => 'table_nodechangeslog'));
		$table_nodechangeslog->db_data(
			'nodesettingschanges.dateline, nodes.name,  nodesettingschanges.changemenu, nodesettingschanges.changemade, users.username, nodesettingschanges.comment',
			'nodesettingschanges INNER JOIN `users` ON `users`.`id` = `nodesettingschanges`.`uid` INNER JOIN `nodes` ON `nodes`.`id` = `nodesettingschanges`.`nodeid` ',
			"",
			"",
			"nodesettingschanges.entryid DESC");
		for($i=1;$i<count($table_nodechangeslog->data);$i++) {
			if (isset($table_nodechangeslog->data[$i])) {
				#$table_nodechangeslog->data[$i]['ip_start'] = long2ip($table_nodechangeslog->data[$i]['ip_start']);
				#$table_nodechangeslog->data[$i]['ip_end'] = long2ip($table_nodechangeslog->data[$i]['ip_end']);
				#$table_nodechangeslog->info['EDIT'][$i] = makelink(array("page" => "admin", "subpage" => "nodechangeslog", "area" => $table_nodechangeslog->data[$i]['id']));
			}
		}
		#$table_nodechangeslog->info['EDIT_COLUMN'] = 'nodechangeslog__name';
		$table_nodechangeslog->db_data_multichoice('dateline');
		$table_nodechangeslog->info['MULTICHOICE_LABEL'] = '';
		#$table_nodechangeslog->db_data_remove('id', 'uid');
		return $table_nodechangeslog;
	}
	
	function output() {
		if (get('log') != '') {
			return $this->page->output();
		} else {
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
			global $construct;
			#$this->tpl['link_area_add'] = makelink(array('page' => 'admin', 'subpage' => 'nodechangeslog', 'area' => 'add'));
			$this->tpl['table_nodechangeslog'] = $construct->table($this->table_nodechangeslog(), __FILE__);
			return template($this->tpl, __FILE__);
		}
	}

	function output_onpost_table_nodechangeslog() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("nodechangeslog", "id = '".$value."'");
		}
		if ($ret) {
			#$main->message->set_fromlang('info', 'delete_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>