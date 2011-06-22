<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
 * Copyright (C) 2010 Vasilis Tsiligiannis <b_tsiligiannis@silverton.gr>
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
			'nodes.id,
        	nodes.name AS nodes__name,
        	areas.name AS areas__name,
        	COUNT(DISTINCT p2p.id) AS total_active_p2p,
        	COUNT(DISTINCT aps.id) AS total_active_aps,
        	COUNT(DISTINCT p2p.id)+COUNT(DISTINCT client.id) AS total_active_peers,
        	COUNT(DISTINCT cl.id) AS total_active_clients',
			'nodes
			LEFT JOIN areas ON nodes.area_id = areas.id
			LEFT JOIN regions ON areas.region_id = regions.id
			LEFT JOIN links ON nodes.id = links.node_id AND links.status = "active"
			LEFT JOIN links AS client ON links.peer_ap_id = client.id
									  AND links.type = "client"
									  AND client.type = "ap"
									  AND client.status = "active"
			LEFT JOIN links AS p2p ON p2p.peer_node_id = links.node_id
								   AND links.peer_node_id = p2p.node_id
								   AND links.type = "p2p"
								   AND p2p.type = "p2p"
								   AND p2p.status = "active"
			LEFT JOIN links AS aps ON nodes.id = aps.node_id
								   AND aps.type = "ap"
								   AND aps.status = "active"
			LEFT JOIN links AS cl ON cl.peer_ap_id = aps.id
								  AND cl.type = "client"
								  AND cl.status = "active"
			INNER JOIN users_nodes ON nodes.id = users_nodes.node_id 
			LEFT JOIN users ON users.id = users_nodes.user_id',
			'users.status = "activated"'.
			($where!=''?' AND ('.$where.')':""),
			'nodes.id'.
			($having!=''?' HAVING ('.$having.')':""),
			"total_active_peers DESC, total_active_aps DESC, total_active_clients DESC, nodes.id");
		$table_nodes->db_data_search($form_search_nodes);
		for($i=1;$i<count($table_nodes->data);$i++) {
			if (isset($table_nodes->data[$i])) {
				$table_nodes->data[$i]['nodes__name'] .= " (#".$table_nodes->data[$i]['id'].")";
				$table_nodes->data[$i]['total_active_peers'] = $table_nodes->data[$i]['total_active_peers'].($table_nodes->data[$i]['total_active_aps']>0?" (+".$table_nodes->data[$i]['total_active_aps']." ".$lang['aps'].")":"");
				$table_nodes->info['EDIT'][$i] = makelink(array("page" => "nodes", "node" => $table_nodes->data[$i]['id']));
			}
		}
		$table_nodes->info['EDIT_COLUMN'] = 'nodes__name';
		$table_nodes->db_data_remove('id', 'total_active_p2p', 'total_active_aps');
		return $table_nodes;
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct, $vars, $main;
		$this->tpl['form_search_nodes'] = $construct->form($this->form_search_nodes(), __FILE__);
		$this->tpl['table_nodes'] = $construct->table($this->table_nodes(), __FILE__);

		$this->tpl['link_fullmap'] = makelink(array("page" => "gmap", "node" => get('node')));
		$this->tpl['link_gearth'] = makelink(array("page" => "gearth", "subpage" => "download", "node" => get('node'), "show_p2p" => "1", "show_aps" => "1", "show_clients" => "1", "show_unlinked" => "1", "show_links_p2p" => "1", "show_links_client" => "1"));
		if(get('show_map') == "no") $this->tpl['gmap_key_ok'] = "nomap";
		else $this->tpl['gmap_key_ok'] = include_gmap(htmlspecialchars("?page=gmap&subpage=js&node=".get('node')));

		return template($this->tpl, __FILE__);
	}

}

?>
