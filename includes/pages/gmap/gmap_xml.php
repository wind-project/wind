<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
 * Copyright (C) 2011 Vasilis Tsiligiannis <b_tsiligiannis@silverton.gr>
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

class gmap_xml {
	
	function gmap_xml() {
		
	}
	
	function output() {
		global $db, $lang;
		
		$node = $db->get('latitude, longitude', 'nodes', "id = ".intval(get('node')));
		$node = isset($node[0])?$node[0]:'';

		$having = '';
		if (get('node') != '') $having .= ($having!=''?' OR ':'')."id = ".intval(get('node'));
		if (get('show_p2p') == 1) $having .= ($having!=''?' OR ':'').'total_p2p > 0';
		if (get('show_aps') == 1) $having .= ($having!=''?' OR ':'').'total_aps > 0';
		if (get('show_clients') == 1) $having .= ($having!=''?' OR ':'').'(total_p2p = 0 AND total_aps = 0 AND total_client_on_ap > 0)';
		if (get('show_unlinked') == 1) $having .= ($having!=''?' OR ':'').'(total_p2p = 0 AND total_aps = 0 AND total_client_on_ap = 0)';
		if ($having != '') $nodes = $db->get(
			'nodes.id, nodes.latitude, nodes.longitude, nodes.name AS nodes__name, areas.name AS areas__name, COUNT(DISTINCT p2p.id) AS total_p2p, COUNT(DISTINCT aps.id) AS total_aps, COUNT(DISTINCT clients.id) AS total_clients, COUNT(DISTINCT client_ap.id) AS total_client_on_ap',
			'nodes
			LEFT JOIN areas ON nodes.area_id = areas.id
			LEFT JOIN links AS p2p_t ON nodes.id = p2p_t.node_id
			LEFT JOIN links AS p2p ON p2p.type = "p2p" AND p2p_t.peer_node_id = p2p.node_id AND p2p.peer_node_id = p2p_t.node_id
			LEFT JOIN links AS aps ON nodes.id = aps.node_id AND aps.type = "ap"
			LEFT JOIN links AS client_ap ON p2p_t.type = "client" AND client_ap.type = "ap" AND p2p_t.peer_ap_id = client_ap.id
			LEFT JOIN links AS clients ON p2p_t.type = "ap" AND clients.type = "client" AND clients.peer_ap_id = p2p_t.id
			INNER JOIN users_nodes ON nodes.id = users_nodes.node_id
			LEFT JOIN users ON users.id = users_nodes.user_id',
			"users.status = 'activated'",
			'nodes.id' .
			($having!=''?' HAVING '.$having:''));
		$xml = "<?xml version=\"1.0\" encoding=\"".$lang['charset']."\" standalone=\"yes\"?>\r"; 
		$xml .= "<wind>\r";
		$xml .= "<nodes>\r";
		foreach ((array) $nodes as $key => $value) {
			$xml .= "<";
			if (get('node') == $value['id']) {
				$xml .= 'selected';
			} elseif ($value['total_aps'] != 0 && $value['total_p2p'] != 0) {
				$xml .= 'p2p-ap';
			} elseif ($value['total_aps'] != 0) {
				$xml .= 'ap';
			} elseif ($value['total_p2p'] != 0) {
				$xml .= 'p2p';
			} elseif ($value['total_client_on_ap'] != 0) {
				$xml .= 'client';
			} else {
				$xml .= 'unlinked';
			}
			$xml .= ' id="'.$value['id'].'"';
			$xml .= ' name="'.htmlspecialchars($value['nodes__name'], ENT_COMPAT, $lang['charset']).'"';
			$xml .= ' area="'.htmlspecialchars($value['areas__name'], ENT_COMPAT, $lang['charset']).'"';
			if ($value['total_p2p'] != 0) $xml .= ' p2p="'.$value['total_p2p'].'"';
			if ($value['total_aps'] != 0) $xml .= ' aps="'.$value['total_aps'].'"';
			if ($value['total_client_on_ap'] != 0) $xml .= ' client_on_ap="'.$value['total_client_on_ap'].'"';
			if ($value['total_clients'] != 0) $xml .= ' clients="'.$value['total_clients'].'"';
			$xml .= ' lat="'.$value['latitude'].'"';
			$xml .= ' lon="'.$value['longitude'].'"';
			$xml .= ' url="'.htmlspecialchars(makelink(array("page" => "nodes", "node" => $value['id']))).'"';
			$xml .= " />\r";
		}
		$xml .= "</nodes>\r";
		
		$where = '';
		if (get('show_links_p2p') == 1) $where .= ($where!=''?' OR ':'')."p2p.type = 'p2p'";
		if (get('show_links_client') == 1) $where .= ($where!=''?' OR ':'')."clients.type = 'client'";
		if ($where != '') $links = $db->get(
			'IFNULL(p2p.id, clients.id) AS id, IFNULL(p2p.type, clients.type) AS type, n1.latitude AS n1_lat, n1.longitude AS n1_lon, IFNULL(n_p2p.latitude, n_clients.latitude) AS n2_lat, IFNULL(n_p2p.longitude, n_clients.longitude) AS n2_lon, l1.status AS l1_status, IFNULL(p2p.status, clients.status) AS l2_status',
			'links AS l1 ' .
			"LEFT JOIN links AS p2p ON (l1.id < p2p.id AND l1.type = 'p2p' AND p2p.type = 'p2p' AND l1.node_id = p2p.peer_node_id AND p2p.node_id = l1.peer_node_id) " .
			"LEFT JOIN links AS clients ON (l1.type = 'ap' AND clients.type = 'client' AND l1.id = clients.peer_ap_id) " .
			"LEFT JOIN nodes AS n1 ON l1.node_id = n1.id " .
			"LEFT JOIN nodes AS n_p2p ON p2p.node_id = n_p2p.id " .
			"LEFT JOIN nodes AS n_clients ON clients.node_id = n_clients.id",
			($where!=''?'('.$where.')':'')." HAVING n1_lat IS NOT NULL AND n1_lon IS NOT NULL AND n2_lat IS NOT NULL AND n2_lon IS NOT NULL"
			);
		$xml .= "<links>\r";
		foreach ((array) $links as $key => $value) {
			$xml .= "<link_".$value['type'];
			$xml .= ' id="'.$value['id'].'"';
			$xml .= ' lat1="'.$value['n1_lat'].'"';
			$xml .= ' lon1="'.$value['n1_lon'].'"';
			$xml .= ' lat2="'.$value['n2_lat'].'"';
			$xml .= ' lon2="'.$value['n2_lon'].'"';
			$xml .= ' status="'.($value['l1_status']!='active' || $value['l2_status']!='active'?'inactive':'active').'"';
			$xml .= " />\r";
		}
		$xml .= "</links>\r";
		$xml .= "</wind>\r";
		
		header("Expires: 0");
		header("Content-type: text/xml; charset=".$lang['charset']);
		echo $xml;
		exit;
	}

}
