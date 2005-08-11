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
		global $db, $lang;
		$form_search_nodes = new form(array('FORM_NAME' => 'form_search_nodes'));
		$form_search_nodes->db_data('nodes.id, nodes.name, areas.id, regions.id');
		$form_search_nodes->db_data_enum('areas.id', $db->get("id AS value, name AS output", "areas"));
		$form_search_nodes->db_data_enum('regions.id', $db->get("id AS value, name AS output", "regions"));
		array_push($form_search_nodes->data, array('Compare' => 'numeric', 'Field' => 'total_active_peers', 'fullField' => 'total_active_peers'));
		array_push($form_search_nodes->data, array('Compare' => 'numeric', 'Field' => 'total_active_clients', 'fullField' => 'total_active_clients'));
		array_push($form_search_nodes->data, array('Field' => 'has_ap', 'fullField' => 'has_ap', 'Type' => 'enum', 'Type_Enums' => array(array('value' => 'Y', 'output' => $lang['yes']), array('value' => 'N', 'output' => $lang['no']))));
		$form_search_nodes->db_data_search();
		return $form_search_nodes;
	}

	function table_nodes() {
		global $construct, $db, $main, $lang;
		$form_search_nodes = $this->form_search_nodes();
		$where = $form_search_nodes->db_data_where(array("nodes__name" => "starts_with", "total_active_peers" => 'exclude', "total_active_clients" => 'exclude', "has_ap" => 'exclude'));
		$having = $form_search_nodes->db_data_where(array("nodes__id" => "exclude", "nodes__name" => "exclude", "areas__id" => "exclude", "regions__id" => "exclude", "has_ap" => 'exclude'));
		if ($form_search_nodes->data[6]['value'] != '') {
			$having .= ($having!=''?' AND ':'').'total_active_aps '.($form_search_nodes->data[6]['value']=='Y'?'>':'=').' 0';
		}
		$table_nodes = new table(array('TABLE_NAME' => 'table_nodes'));
		$table_nodes->db_data(
			'nodes.id, nodes.name AS nodes__name, areas.name AS areas__name, COUNT(DISTINCT l2.id) AS total_active_p2p, COUNT(DISTINCT aps.id) AS total_active_aps, COUNT(DISTINCT l1.id) AS total_active_peers, COUNT(DISTINCT cl.id) AS total_active_clients',
			'nodes
			LEFT JOIN areas ON nodes.area_id = areas.id
			LEFT JOIN regions ON areas.region_id = regions.id
			LEFT JOIN links AS l1 ON nodes.id = l1.node_id
			LEFT JOIN links AS l2 ON l1.type != "ap"
			LEFT JOIN links AS aps ON nodes.id = aps.node_id AND aps.type = "ap" AND aps.status = "active"
			LEFT JOIN links AS cl ON l1.type = "ap" AND cl.status = "active" AND cl.type = "client" AND cl.peer_ap_id = l1.id ' .
			'INNER JOIN users_nodes ON nodes.id = users_nodes.node_id ' .
			'LEFT JOIN users ON users.id = users_nodes.user_id',
			"(l1.type IS NULL OR (" .
			"(l1.type = 'p2p' AND l2.type = 'p2p' AND l1.peer_node_id = l2.node_id AND l2.peer_node_id = l1.node_id) OR " .
			"(l1.type = 'ap') OR " .
			"(l1.type = 'client' AND l2.type = 'ap' AND l1.peer_ap_id = l2.id)) AND " .
			"(l1.status = 'active' AND (l2.status = 'active' OR l1.type = 'ap'))) " .
			"AND users.status = 'activated'".
			($where!=''?' AND ('.$where.')':""),
			'nodes.id'.
			($having!=''?' HAVING ('.$having.')':""),
			"total_active_peers DESC, total_active_clients DESC, nodes.id");
		$table_nodes->db_data_search($form_search_nodes);
		for($i=1;$i<count($table_nodes->data);$i++) {
			if (isset($table_nodes->data[$i])) {
				$table_nodes->data[$i]['nodes__name'] .= " (#".$table_nodes->data[$i]['id'].")";
				$table_nodes->data[$i]['total_active_peers'] = $table_nodes->data[$i]['total_active_p2p'].($table_nodes->data[$i]['total_active_aps']>0?" (+".$table_nodes->data[$i]['total_active_aps']." ".$lang['aps'].")":"");
				$table_nodes->info['EDIT'][$i] = makelink(array("page" => "nodes", "node" => $table_nodes->data[$i]['id']));
			}
		}
		$table_nodes->info['EDIT_COLUMN'] = 'nodes__name';
		$table_nodes->db_data_remove('id', 'total_active_p2p', 'total_active_aps');
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