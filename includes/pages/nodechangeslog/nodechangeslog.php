<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005-2014 by WiND Contributors (see AUTHORS.txt)
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
			'node_settings_changes.dateline, nodes.name,  node_settings_changes.changemenu, node_settings_changes.changemade, users.username, node_settings_changes.comment',
			'node_settings_changes INNER JOIN `users` ON `users`.`id` = `node_settings_changes`.`uid` INNER JOIN `nodes` ON `nodes`.`id` = `node_settings_changes`.`node_id` ',
			"",
			"",
			"node_settings_changes.id DESC");
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
