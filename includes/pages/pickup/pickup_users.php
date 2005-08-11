<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
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

class pickup_users {

	var $tpl;
	
	function pickup_users() {
		
	}
	
	function form_search_users() {
		global $db;
		$form_search_nodes = new form(array('FORM_NAME' => 'form_search_users'));
		$form_search_nodes->db_data('users.username');
		$form_search_nodes->db_data_search();
		return $form_search_nodes;
	}

	function table_users() {
		global $construct, $db, $main;
		$form_search_users = $this->form_search_users();
		$where = $form_search_users->db_data_where(array("users__username" => "starts_with"));
		$table_users = new table(array('TABLE_NAME' => 'table_users'));
		$table_users->db_data(
			'users.id, users.username',
			'users',
			"users.status = 'activated'".($where!=''?' AND ('.$where.')':""),
			'users.id',
			"users.username ASC");
		$table_users->db_data_search($form_search_users);
		for($i=1;$i<count($table_users->data);$i++) {
			if (isset($table_users->data[$i])) {
				$table_users->info['PICKUP_VALUE'][$i] = $table_users->data[$i]['id'];
				$table_users->info['PICKUP_OUTPUT'][$i] = $table_users->data[$i]['username'];
			}
		}
		$table_users->info['PICKUP_COLUMN'] = 'username';
		$table_users->info['PICKUP_OBJECT'] = stripslashes(get('object'));
		$table_users->db_data_remove('id');
		return $table_users;
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct, $main;
		$main->header->hide = TRUE;
		$main->menu->hide = TRUE;
		$main->footer->hide = TRUE;
		$this->tpl['form_search_users'] = $construct->form($this->form_search_users(), __FILE__);
		$this->tpl['table_users'] = $construct->table($this->table_users(), __FILE__);
		return template($this->tpl, __FILE__);
	}

}

?>