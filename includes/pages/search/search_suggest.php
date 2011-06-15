<?php
/*
* WiND - Wireless Nodes Database
*
* Copyright (C) 2006 John Kolovos <cirrus@awmn.net>
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

class search_suggest {

	var $tpl;
	var $limit = 10;

	function search_suggest() {

	}

	function output() {
		global $db, $vars;
		$q = get('q');
		$widget = get('widget');
		if(isset($widget) && $widget =="true") {
			$this->tpl['widget'] = "1";
			$this->tpl['url'] = $vars['site']['url'];
			$this->limit = 5;
		} else {
			$this->tpl['widget'] = "0";
		}
		$i = 0;

		if (is_numeric($q) && strpos($q, ".") === FALSE) {
			$this->tpl['nodes_search'] = $db->get(
										'nodes.id, nodes.name',
										'nodes
										INNER JOIN users_nodes ON users_nodes.node_id = nodes.id
										INNER JOIN users ON users_nodes.user_id = users.id',
										'users.status = "activated" AND nodes.id LIKE "'.replace_sql_wildcards($q).'%"',
										'nodes.id',
										'nodes.id ASC',
										$this->limit);
			foreach ((array)$this->tpl['nodes_search'] as $key => $value) {
				$this->tpl['nodes_search'][$key]['href'] = makelink(array("page" => "nodes", "node" => $this->tpl['nodes_search'][$key]['id']));
			}
		} elseif (is_ip($q, FALSE)) {
			$where = "(";
			$s_ranges = ip_to_ranges($q,FALSE);
			foreach ($s_ranges as $s_range) {
				$where .= "(ip_ranges.ip_start BETWEEN ".ip2long($s_range['min'])." AND ".ip2long($s_range['max']).") OR ";
			}
			$where = substr($where, 0, -4).")";
			$this->tpl['ip_search'] = $db->get(
										'ip_ranges.ip_start, nodes.id',
										'ip_ranges
										LEFT JOIN nodes ON ip_ranges.node_id = nodes.id',
										$where,
										'',
										'ip_ranges.status ASC, ip_ranges.ip_start ASC',
										$this->limit);
			foreach ((array)$this->tpl['ip_search'] as $key => $value) {
				$this->tpl['ip_search'][$key]['ip_start'] = long2ip($this->tpl['ip_search'][$key]['ip_start']);
				$this->tpl['ip_search'][$key]['href'] = makelink(array("page" => "nodes", "node" => $this->tpl['ip_search'][$key]['id']));
			}
		} elseif ((strpos($q, ".") !== FALSE && intval($q) == 0) || substr($q, -strlen(".".$vars['dns']['root_zone'])) == ".".$vars['dns']['root_zone']) {
			$this->tpl['dns_search'] = $db->get(
										'dns_zones.name, dns_zones.type, nodes.id',
										'dns_zones
										LEFT JOIN nodes ON dns_zones.node_id = nodes.id',
										'dns_zones.name LIKE "'.replace_sql_wildcards(substr($q, 0, strrpos($q, "."))).'"',
										'',
										'dns_zones.status ASC, dns_zones.name ASC',
										$this->limit);
			foreach ((array)$this->tpl['dns_search'] as $key => $value) {
				if($this->tpl['dns_search'][$key]['type'] == "forward") $this->tpl['dns_search'][$key]['name'] .= ".".$vars['dns']['root_zone'];
				$this->tpl['dns_search'][$key]['href'] = makelink(array("page" => "nodes", "node" => $this->tpl['dns_search'][$key]['id']));
			}
		} else {
			$this->tpl['nodes_search'] = $db->get(
										'nodes.id, nodes.name',
										'nodes
										INNER JOIN users_nodes ON users_nodes.node_id = nodes.id
										INNER JOIN users ON users_nodes.user_id = users.id',
										'users.status = "activated" AND nodes.name LIKE "'.replace_sql_wildcards($q).'%"',
										'nodes.id',
										'nodes.name ASC',
										$this->limit);
			foreach ((array)$this->tpl['nodes_search'] as $key => $value) {
				$this->tpl['nodes_search'][$key]['href'] = makelink(array("page" => "nodes", "node" => $this->tpl['nodes_search'][$key]['id']));
			}
		}

		echo template($this->tpl, __FILE__);
		exit;

	}

}

?>
