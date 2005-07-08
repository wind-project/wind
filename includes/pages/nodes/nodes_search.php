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

class nodes_search {

	var $tpl;
	
	function nodes_search() {
		
	}
	
	function form_search_nodes() {
		global $db;
		$form_search_nodes = new form(array('FORM_NAME' => 'form_search_nodes'));
		$form_search_nodes->db_data('nodes.id, nodes.name, areas.id, regions.id');
		$form_search_nodes->db_data_enum('areas.id', $db->get("id AS value, name AS output", "areas"));
		$form_search_nodes->db_data_enum('regions.id', $db->get("id AS value, name AS output", "regions"));
		array_push($form_search_nodes->data, array('Compare' => 'numeric', 'Field' => 'total_active_peers', 'fullField' => 'total_active_peers'));
		$form_search_nodes->db_data_search();
		return $form_search_nodes;
	}

	function table_nodes() {
		global $construct, $db, $main;
		$form_search_nodes = $this->form_search_nodes();
		$where = $form_search_nodes->db_data_where(array("nodes__name" => "starts_with", "total_active_peers" => 'exclude'));
		$having = $form_search_nodes->db_data_where(array("nodes__id" => "exclude", "nodes__name" => "exclude", "areas__id" => "exclude", "regions__id" => "exclude"));
		$table_nodes = new table(array('TABLE_NAME' => 'table_nodes'));
		$table_nodes->db_data(
			'nodes.id, nodes.name AS nodes__name, areas.name AS areas__name, COUNT(l1.id) AS total_active_peers',
			'nodes
			LEFT JOIN areas ON nodes.area_id = areas.id
			LEFT JOIN regions ON areas.region_id = regions.id
			LEFT JOIN links AS l1 ON nodes.id = l1.node_id
			LEFT JOIN links AS l2 ON l1.type != "ap"',
			"l1.type IS NULL OR (" .
			"(l1.type = 'p2p' AND l2.type = 'p2p' AND l1.peer_node_id = l2.node_id AND l2.peer_node_id = l1.node_id) OR " .
			"(l1.type = 'ap') OR " .
			"(l1.type = 'client' AND l2.type = 'ap' AND l1.peer_ap_id = l2.id)) AND " .
			"(l1.status = 'active' AND (l2.status = 'active' OR l1.type = 'ap'))".
			($where!=''?' AND ('.$where.')':""),
			'nodes.id'.
			($having!=''?' HAVING ('.$having.')':""));
		$table_nodes->db_data_search($form_search_nodes);
		for($i=1;$i<count($table_nodes->data);$i++) {
			if (isset($table_nodes->data[$i])) {
				$table_nodes->data[$i]['nodes__name'] .= " (#".$table_nodes->data[$i]['id'].")";
				$table_nodes->info['EDIT'][$i] = makelink(array("page" => "nodes", "node" => $table_nodes->data[$i]['id']));
			}
		}
		$table_nodes->info['EDIT_COLUMN'] = 'nodes__name';
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

}

?>