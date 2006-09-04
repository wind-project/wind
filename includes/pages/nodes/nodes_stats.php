<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2006 John Kolovos <cirrus@awmn.net>
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

class nodes_stats {
	
	function output() {
		global $db;
		
		$stats_nodes_active =
				$db->cnt('',
						'nodes ' .
						'INNER JOIN links AS l1 ON l1.node_id = nodes.id ' .
						'LEFT JOIN links AS p2p ON (l1.type = "p2p" AND p2p.type = "p2p" AND l1.node_id = p2p.peer_node_id AND p2p.node_id = l1.peer_node_id) ' .
						'LEFT JOIN links AS clients ON (l1.type = "client" AND l1.peer_ap_id = clients.id) ' .
						'INNER JOIN users_nodes ON nodes.id = users_nodes.node_id ' .
						'LEFT JOIN users ON users.id = users_nodes.user_id',
						'users.status = "activated" AND l1.status = "active" AND (p2p.status = "active" OR clients.status = "active")',
						'nodes.id'
						);
		$stats_nodes_total =
				$db->cnt('',
						'nodes ' .
						'INNER JOIN users_nodes ON nodes.id = users_nodes.node_id ' .
						'LEFT JOIN users ON users.id = users_nodes.user_id',
						'users.status = "activated"',
						'nodes.id'
						);
		$stats_backbone =
				$db->cnt('',
						'nodes ' .
						'INNER JOIN links AS l1 ON l1.node_id = nodes.id ' .
						'INNER JOIN links AS l2 ON (l1.type = "p2p" AND l2.type = "p2p" AND l1.node_id = l2.peer_node_id AND l2.node_id = l1.peer_node_id) ' .
						'INNER JOIN users_nodes ON nodes.id = users_nodes.node_id ' .
						'LEFT JOIN users ON users.id = users_nodes.user_id',
						'users.status = "activated" AND l1.status = "active" AND l2.status = "active"',
						'nodes.id'
						);
		$stats_links =
				$db->cnt('',
						'nodes ' .
						'INNER JOIN links AS l1 ON l1.node_id = nodes.id ' .
						'LEFT JOIN links AS p2p ON (l1.id < p2p.id AND l1.type = "p2p" AND p2p.type = "p2p" AND l1.node_id = p2p.peer_node_id AND p2p.node_id = l1.peer_node_id) ' .
						'LEFT JOIN links AS clients ON (l1.type = "client" AND l1.peer_ap_id = clients.id) ' .
						'INNER JOIN users_nodes ON nodes.id = users_nodes.node_id ' .
						'LEFT JOIN users ON users.id = users_nodes.user_id',
						'users.status = "activated" AND l1.status = "active" AND (p2p.status = "active" OR clients.status = "active")',
						'l1.id'
						);
		$stats_aps =
				$db->cnt('',
						'nodes ' .
						'INNER JOIN links ON links.node_id = nodes.id AND links.type = "ap" AND links.status = "active" ' .
						'INNER JOIN users_nodes ON nodes.id = users_nodes.node_id ' .
						'LEFT JOIN users ON users.id = users_nodes.user_id',
						'users.status = "activated"',
						'links.id'
						);
		$stats_services_active =
				$db->cnt('',
						'nodes_services',
						'nodes_services.status = "active"'
						);
		$stats_services_total =
				$db->cnt('',
						'nodes_services',
						''
						);

		header ("Content-Type: text/xml");
		echo "<?xml version=\"1.0\"?>\n";
		echo "<statistics>\n";
		echo "<nodes>\n";
		echo "<active>".$stats_nodes_active."</active>\n";
		echo "<total>".$stats_nodes_total."</total>\n";
		echo "<backbone>".$stats_backbone."</backbone>\n";
		echo "<ap>".$stats_aps."</ap>\n";
		echo "</nodes>\n";
		echo "<links>".$stats_links."</links>\n";
		echo "<services>\n";
		echo "<active>".$stats_services_active."</active>\n";
		echo "<total>".$stats_services_total."</total>\n";
		echo "</services>\n";
		echo "</statistics>\n";
		exit;
	}
}

?>
