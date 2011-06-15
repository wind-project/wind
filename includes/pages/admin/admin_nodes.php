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

class admin_nodes {

	var $tpl;
	
	function admin_nodes() {
		
	}
	
	function form_search_nodes() {
		global $db;
		$form_search_nodes = new form(array('FORM_NAME' => 'form_search_nodes'));
		$form_search_nodes->db_data('nodes.id, nodes.name, areas.id, regions.id');
		$form_search_nodes->db_data_enum('areas.id', $db->get("id AS value, name AS output", "areas"));
		$form_search_nodes->db_data_enum('regions.id', $db->get("id AS value, name AS output", "regions"));
		$form_search_nodes->db_data_search();
		return $form_search_nodes;
	}

	function table_nodes() {
		global $construct, $db, $main;
		$form_search_nodes = $this->form_search_nodes();
		$where = $form_search_nodes->db_data_where(array("nodes__name" => "starts_with"));
		$table_nodes = new table(array('FORM_NAME' => 'table_nodes', 'TABLE_NAME' => 'table_nodes'));
		$table_nodes->db_data(
			'nodes.id, nodes.name AS nodes__name, areas.name AS areas__name',
			'nodes ' .
			'LEFT JOIN areas ON nodes.area_id = areas.id ' .
			'LEFT JOIN regions ON areas.region_id = regions.id',
			$where,
			"",
			"nodes.id ASC");
		$table_nodes->db_data_search($form_search_nodes);
		for($i=1;$i<count($table_nodes->data);$i++) {
			if (isset($table_nodes->data[$i])) {
				$table_nodes->data[$i]['nodes__name'] .= " (#".$table_nodes->data[$i]['id'].")";
				$table_nodes->info['EDIT'][$i] = makelink(array("page" => "mynodes", "node" => $table_nodes->data[$i]['id']));
			}
		}
		$table_nodes->info['EDIT_COLUMN'] = 'nodes__name';
		$table_nodes->db_data_multichoice('node', 'id');
		$table_nodes->info['MULTICHOICE_LABEL'] = 'delete';
		$table_nodes->db_data_remove('id');
		return $table_nodes;
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['form_search_nodes'] = $construct->form($this->form_search_nodes(), __FILE__);
		$this->tpl['table_nodes'] = $construct->table($this->table_nodes(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_table_nodes() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("nodes", '', "id = '".$value."'");
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>