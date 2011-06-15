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

class admin_users {

	var $tpl;
	
	function admin_users() {
		
	}
	
	function form_search_users() {
		global $db;
		$form_search_nodes = new form(array('FORM_NAME' => 'form_search_users'));
		$form_search_nodes->db_data('users.username, users.surname, users.name, users.email, users.status, rights.type');
		$form_search_nodes->db_data_search();
		return $form_search_nodes;
	}

	function table_users() {
		global $construct, $db, $main;
		$form_search_users = $this->form_search_users();
		$where = $form_search_users->db_data_where(array("users__username" => "starts_with", "users__surname" => "starts_with", "users__name" => "starts_with", "users__email" => "starts_with"));
		$table_users = new table(array('FORM_NAME' => 'table_users', 'TABLE_NAME' => 'table_users'));
		$table_users->db_data(
			'users.id, users.username, "" AS fullname, users.surname, users.name, users.email, users.phone',
			'users LEFT JOIN rights ON users.id = rights.user_id',
			$where,
			'users.id',
			'users.date_in DESC');
		$table_users->db_data_search($form_search_users);
		for($i=1;$i<count($table_users->data);$i++) {
			if (isset($table_users->data[$i])) {
				$table_users->data[$i]['fullname'] = $table_users->data[$i]['surname']." ".$table_users->data[$i]['name'];
				$table_users->info['EDIT'][$i] = makelink(array("page" => "users", "user" => $table_users->data[$i]['id']));
			}
		}
		$table_users->info['EDIT_COLUMN'] = 'username';
		$table_users->db_data_multichoice('users', 'id');
		$table_users->info['MULTICHOICE_LABEL'] = 'delete';
		$table_users->db_data_remove('id', 'surname', 'name');
		return $table_users;
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['form_search_users'] = $construct->form($this->form_search_users(), __FILE__);
		$this->tpl['table_users'] = $construct->table($this->table_users(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_table_users() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("users", '', "id = '".$value."'");
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>