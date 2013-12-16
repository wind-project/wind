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

class gmap_json {
	
	function gmap_json() {
		
	}
	
	function output() {
		global $db, $lang, $vars;
		
		$node = $db->get('latitude, longitude', 'nodes', "id = ".intval(get('node')));
		$node = isset($node[0])?$node[0]:'';

		// Preprocess filter
		$filters = array(
				'p2p' => false,
				'ap' => false,
				'client' => false,
				'unlinked' => false
		);
		$request_filters = get('filter')?explode(",",get('filter')):array();
		foreach($request_filters as $filter) {
			if (in_array($filter, array_keys($filters))) {
				$filters[$filter] = true;
			}
		}
		
		// Prepare SQL query.
		$having = '';
		if (get('node') != '') $having .= ($having!=''?' OR ':'')."id = ".intval(get('node'));
		if ($filters['p2p'] == 1) $having .= ($having!=''?' OR ':'').'total_p2p > 0';
		if ($filters['ap'] == 1) $having .= ($having!=''?' OR ':'').'total_aps > 0';
		if ($filters['client'] == 1) $having .= ($having!=''?' OR ':'').'(total_p2p = 0 AND total_aps = 0 AND total_client_on_ap > 0)';
		if ($filters['unlinked'] == 1) $having .= ($having!=''?' OR ':'').'(total_p2p = 0 AND total_aps = 0 AND total_client_on_ap = 0)';
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
		
		// Create json object
		$json = array(
				'meta' => array(
						'bounds' => $vars['gmap']['bounds']),
				'nodes' => array(),
				'links' => array()
		);
		
		// Push node information
		foreach ((array) $nodes as $key => $value) {
			$node = array();
			if (get('node') == $value['id']) {
				$node['selected'] =  true;
			}
			
			// Calculate type
			if ($value['total_aps'] != 0 && $value['total_p2p'] != 0) {
				$node['type'] = 'p2p-ap';
			} elseif ($value['total_aps'] != 0) {
				$node['type'] = 'ap';
			} elseif ($value['total_p2p'] != 0) {
				$node['type'] = 'p2p';
			} elseif ($value['total_client_on_ap'] != 0) {
				$node['type'] = 'client';
			} else {
				$node['type'] = 'unlinked';
			}
			$node['id'] = intval($value['id']);
			
			$node['name'] = $value['nodes__name'];
			$node['area'] = $value['areas__name'];
			
			$node['lat'] = floatval($value['latitude']);
			$node['lon'] = floatval($value['longitude']);
			$node['url'] = absolute_link(array("page" => "nodes", "node" => $value['id']), false, true, false);
			
			$node['total_ap'] = intval($value['total_aps']);
			$node['total_p2p'] = intval($value['total_p2p']);
			$node['total_ap_subscriptions'] = intval($value['total_client_on_ap']);
			$node['total_clients'] = intval($value['total_clients']);
				
			// Append node
			$json['nodes'][$value['id']] = $node;
		}
		
		// Craft sql query
		$where = '';
		if ($filters['p2p'] == 1) $where .= ($where!=''?' OR ':'')."p2p.type = 'p2p'";
		if ($filters['client'] == 1) $where .= ($where!=''?' OR ':'')."clients.type = 'client'";
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
		
		// Push link information
		foreach ((array) $links as $key => $value) {
			$link = array();
			$link['type'] = $value['type'];
			$link['id'] = intval($value['id']);
			$link['lat1'] = floatval($value['n1_lat']);
			$link['lon1'] = floatval($value['n1_lon']);
			$link['lat2'] = floatval($value['n2_lat']);
			$link['lon2'] =  floatval($value['n2_lon']);
			$link['status'] = ($value['l1_status']!='active' || $value['l2_status']!='active'?'inactive':'active');
			$json['links'][$link['id']] = $link;
		}
		
		header("Content-type: application/json; charset=".$lang['charset']);
		echo json_encode($json);
		exit;
	}

}
