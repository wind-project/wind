<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
 * Copyright (C) 2009-2010 Vasilis Tsiligiannis <b_tsiligiannis@silverton.gr>
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

include_once(ROOT_PATH.'globals/classes/geocalc.php');

$geocalc = new GeoCalc();

include_once(ROOT_PATH.'globals/classes/srtm.php');
$srtm = new srtm($vars['srtm']['path']);

class nodes_view {

	var $tpl;
	
	function nodes_view() {
		
	}

	function calculate_distance($a_node, $b_node) {
		global $db, $geocalc, $srtm;
		$a_node_i = $db->get('latitude, longitude, elevation', 'nodes', "id = '".$a_node."'");
		$b_node_i = $db->get('latitude, longitude, elevation', 'nodes', "id = '".$b_node."'");

		$lat1 = isset($a_node_i[0]['latitude'])?$a_node_i[0]['latitude']:1;   // choose something better than '1' here
		$lon1 = isset($a_node_i[0]['longitude'])?$a_node_i[0]['longitude']:1; // the same
		$lat2 = isset($b_node_i[0]['latitude'])?$b_node_i[0]['latitude']:1;   // the same
		$lon2 = isset($b_node_i[0]['longitude'])?$b_node_i[0]['longitude']:1; // the same

		$a_node_el = str_replace(",", ".", $srtm->get_elevation($lat1, $lon1, FALSE));
		$b_node_el = str_replace(",", ".", $srtm->get_elevation($lat2, $lon2, FALSE));
		
		$dist   = $geocalc->GCDistance($lat1, $lon1, $lat2, $lon2);
		
		if ($a_node_el != FALSE && $b_node_el != FALSE) {
			$a_node_el += (integer)$a_node_i[0]['elevation'];
			$b_node_el += (integer)$b_node_i[0]['elevation'];
			$dist = sqrt( pow($dist * 1000, 2) + pow( abs($a_node_el - $b_node_el), 2 ) ) / 1000;
		}

		return $dist;
	}
	
	function table_ip_ranges() {
		global $db;
		$table_ip_ranges = new table(array('TABLE_NAME' => 'table_ip_ranges', 'FORM_NAME' => 'table_ip_ranges'));
		$table_ip_ranges->db_data(
			'ip_ranges.id, "" AS ip_range, ip_ranges.ip_start, ip_ranges.ip_end, ip_ranges.date_in, ip_ranges.status, ip_ranges.delete_req',
			'ip_ranges',
			'ip_ranges.node_id = '.intval(get('node')),
			"",
			"ip_ranges.date_in ASC");
		foreach( (array) $table_ip_ranges->data as $key => $value) {
			if ($key != 0) {
				$table_ip_ranges->data[$key]['ip_start'] = long2ip($table_ip_ranges->data[$key]['ip_start']);
				$table_ip_ranges->data[$key]['ip_end'] = long2ip($table_ip_ranges->data[$key]['ip_end']);
				$table_ip_ranges->data[$key]['ip_range'] = $table_ip_ranges->data[$key]['ip_start']." - ".$table_ip_ranges->data[$key]['ip_end'];
			}
		}
		$table_ip_ranges->db_data_multichoice('ip_ranges', 'id');
		$table_ip_ranges->db_data_multichoice_checked('delete_req', 'Y');
		$table_ip_ranges->info['MULTICHOICE_LABEL'] = 'delete_request';
		$table_ip_ranges->db_data_remove('id', 'ip_start', 'ip_end', 'delete_req');
		$table_ip_ranges->db_data_translate('ip_ranges__status');
		return $table_ip_ranges;
	}

	function table_dns() {
		global $db, $vars;
		$table_dns = new table(array('TABLE_NAME' => 'table_dns', 'FORM_NAME' => 'table_dns'));
		$table_dns->db_data(
			'dns_zones.id, dns_zones.name, dns_zones.date_in, dns_zones.status, dns_zones.type',
			'dns_zones',
			'dns_zones.node_id = '.intval(get('node')),
			"",
			"dns_zones.type ASC, dns_zones.date_in ASC");
		$table_dns->db_data_multichoice('dns_zones', 'id');
		for($i=1;$i<count($table_dns->data);$i++) {
			if (isset($table_dns->data[$i])) {
				if ($table_dns->data[$i]['type'] == 'forward') $table_dns->data[$i]['name'] .= ".".$vars['dns']['root_zone'];
				$table_dns->info['EDIT'][$i] = makelink(array("page" => "mynodes", "subpage" => "dnszone", "zone" => $table_dns->data[$i]['id']));
			}
		}
		$table_dns->info['EDIT_COLUMN'] = 'name';
		$table_dns->db_data_remove('id', 'type');
		$table_dns->db_data_translate('dns_zones__status');
		return $table_dns;
	}

	function table_nameservers() {
		global $db, $vars;
		$table_nameservers = new table(array('TABLE_NAME' => 'table_nameservers', 'FORM_NAME' => 'table_nameservers'));
		$table_nameservers->db_data(
			'dns_nameservers.id, dns_nameservers.name, dns_nameservers.ip, dns_nameservers.date_in, dns_nameservers.status, nodes.name_ns AS nodes_name_ns',
			'dns_nameservers, nodes',
			"nodes.id = ".intval(get('node'))." AND dns_nameservers.node_id = nodes.id",
			"",
			"dns_nameservers.name ASC");
		foreach( (array) $table_nameservers->data as $key => $value) {
			if ($key != 0) {
				$table_nameservers->data[$key]['ip'] = long2ip($table_nameservers->data[$key]['ip']);
				$table_nameservers->data[$key]['name'] = strtolower(($table_nameservers->data[$key]['name']!=''?$table_nameservers->data[$key]['name'].".":"").$table_nameservers->data[$key]['nodes_name_ns'].".".$vars['dns']['ns_zone']);
			}
		}
		$table_nameservers->db_data_multichoice('dns_nameservers', 'id');
		for($i=1;$i<count($table_nameservers->data);$i++) {
			if (isset($table_nameservers->data[$i])) {
				$table_nameservers->info['EDIT'][$i] = makelink(array("page" => "mynodes", "subpage" => "dnsnameserver", "nameserver" => $table_nameservers->data[$i]['id']));
			}
		}
		$table_nameservers->info['EDIT_COLUMN'] = 'name';
		$table_nameservers->db_data_remove('id', 'nodes_name_ns');
		$table_nameservers->db_data_translate('dns_nameservers__status');
		return $table_nameservers;
	}
	
	function table_links_p2p() {
		global $db;
		$table_links = new table(array('TABLE_NAME' => 'table_links_p2p'));
		$table_links->db_data(
			'"" AS distance, n1.name AS node_name, n1.id AS node_id, n2.name AS peer_node_name, l1.type AS links__type, l1.info AS links__info, l1.peer_node_id AS links__peer_node_id, l1.date_in AS links__date_in, l1.ssid AS links__ssid, l1.protocol AS links__protocol, l1.channel AS links__channel, l1.equipment AS links__equipment, l1.status AS l1_status, l2.status AS l2_status, "" AS links__status',
			'links AS l1
			INNER JOIN links AS l2 ON l1.peer_node_id = l2.node_id
			INNER JOIN nodes AS n1 ON l1.node_id = n1.id
			INNER JOIN nodes AS n2 ON l2.node_id = n2.id',
			"l1.node_id = ".intval(get('node'))." AND l2.peer_node_id = l1.node_id AND l1.type ='p2p' AND l2.type = 'p2p'",
			"",
			"l1.date_in ASC");
		$table_links->db_data(
			'"" AS distance, n1.name AS node_name, n1.id AS node_id, n2.name AS peer_node_name, l1.type AS links__type, l1.info AS links__info, l2.node_id AS links__peer_node_id, l1.date_in AS links__date_in, l2.ssid AS links__ssid, l2.protocol AS links__protocol, l2.channel AS links__channel, l1.equipment AS links__equipment, l1.status AS l1_status, l2.status AS l2_status, "" AS links__status',
			'links AS l1
			INNER JOIN links AS l2 ON l1.peer_ap_id = l2.id
			INNER JOIN nodes AS n1 ON l1.node_id = n1.id
			INNER JOIN nodes AS n2 ON l2.node_id = n2.id',
			"l1.node_id = ".intval(get('node'))." AND l1.type ='client' AND l2.type = 'ap'",
			"",
			"l1.date_in ASC");
		foreach( (array) $table_links->data as $key => $value) {
			$table_links->data[$key]['distance'] = $this->calculate_distance($table_links->data[$key]['node_id'], $table_links->data[$key]['links__peer_node_id']);
			if ($key != 0) {
				if ($table_links->data[$key]['l1_status'] == 'active' && $table_links->data[$key]['l2_status'] == 'active') {
					$table_links->data[$key]['links__status'] = 'active';
				} else {
					$table_links->data[$key]['links__status'] = 'inactive';
				}
				$table_links->info['EDIT'][$key] = makelink(array('page' => 'nodes', 'node' => $table_links->data[$key]['links__peer_node_id']));
			}
		}
		$table_links->db_data_translate('links__status', 'links__type');
		$table_links->db_data_hide('peer_node_name', 'links__info', 'links__peer_node_id', 'l1_status', 'l2_status');
		return $table_links;
	}
	
	function table_links_ap($id) {
		global $db;
		$table_links = new table(array('TABLE_NAME' => 'table_links_ap'));
		$table_links->db_data(
			'nodes.id AS c_node_id, nodes.name AS c_node_name, l1.status AS c_status, l2.date_in AS links__date_in, l2.ssid AS links__ssid, l2.type AS links__type, l2.info AS links__info, l2.protocol AS links__protocol, l2.channel AS links__channel, l2.equipment AS links__equipment, l2.status AS links__status',
			'links AS l2
			LEFT JOIN links AS l1 ON l1.peer_ap_id = l2.id
			LEFT JOIN nodes ON l1.node_id = nodes.id',
			"(l1.type = 'client' OR l1.id IS NULL) AND l2.id = '".$id."'",
			"",
			"l1.date_in ASC");
		foreach( (array) $table_links->data as $key => $value) {
			if ($key != 0) {
				$table_links->info['EDIT'][$key] = makelink(array('page' => 'nodes', 'node' => $table_links->data[$key]['c_node_id']));
			}
		}
		return $table_links;
	}

	function table_ipaddr_subnets() {
		global $construct, $db;
		$table_ipaddr_subnets = new table(array('TABLE_NAME' => 'table_ipaddr_subnets'));
		$table_ipaddr_subnets->db_data(
			'ip_addresses.date_in, ip_addresses.hostname, ip_addresses.ip, ip_addresses.mac, ip_addresses.type AS ip_addresses__type, ip_addresses.always_on, ip_addresses.info, subnets.ip_start, subnets.ip_end, subnets.type, nodes.name AS nodes__name, nodes.id AS nodes__id, links.type AS links__type',
			'subnets ' .
			"LEFT JOIN links ON links.id = subnets.link_id " .
			"LEFT JOIN ip_addresses ON " .
				"ip_addresses.node_id = ".intval(get('node'))." AND (subnets.ip_start <= ip_addresses.ip AND subnets.ip_end >= ip_addresses.ip) " .
			"LEFT JOIN nodes ON links.peer_node_id = nodes.id",
			"subnets.node_id = ".intval(get('node'))." AND subnets.type IN ('local', 'link')",
			"",
			"subnets.type ASC, links.type DESC, subnets.ip_start ASC, ip_addresses.ip",
			FALSE);
		
		$table_ipaddr_subnets->db_data(
			'ip_addresses.date_in, ip_addresses.hostname, ip_addresses.ip, ip_addresses.mac, ip_addresses.type AS ip_addresses__type, ip_addresses.always_on, ip_addresses.info, subnets.ip_start, subnets.ip_end, subnets.type, nodes.name AS nodes__name, nodes.id AS nodes__id, links.type AS links__type',
			'subnets ' .
			"LEFT JOIN links ON links.id = subnets.link_id AND subnets.node_id = links.node_id " .
			"LEFT JOIN ip_addresses ON " .
				"ip_addresses.node_id = links.node_id AND (subnets.ip_start <= ip_addresses.ip AND subnets.ip_end >= ip_addresses.ip) " .
			"LEFT JOIN nodes ON links.node_id = nodes.id",
			"links.peer_node_id = ".intval(get('node'))." AND subnets.type = 'link'",
			"",
			"subnets.ip_start ASC, ip_addresses.ip",
			FALSE);

		$table_ipaddr_subnets->db_data(
			'ip_addresses.date_in, ip_addresses.hostname, ip_addresses.ip, ip_addresses.mac, ip_addresses.type AS ip_addresses__type, ip_addresses.always_on, ip_addresses.info, subnets.ip_start, subnets.ip_end, subnets.type, nodes.name AS nodes__name, nodes.id AS nodes__id',
			'subnets ' .
			"LEFT JOIN ip_addresses ON " .
				"ip_addresses.node_id = subnets.client_node_id AND (subnets.ip_start <= ip_addresses.ip AND subnets.ip_end >= ip_addresses.ip) " .
			"LEFT JOIN nodes ON subnets.client_node_id = nodes.id",
			"subnets.node_id = ".intval(get('node'))." AND subnets.type = 'client'",
			"",
			"subnets.ip_start ASC, ip_addresses.ip",
			FALSE);

		foreach( (array) $table_ipaddr_subnets->data as $key => $value) {
			if ($key != 0) {
				$table_ipaddr_subnets->data[$key]['ip'] = long2ip($table_ipaddr_subnets->data[$key]['ip']);
				$table_ipaddr_subnets->data[$key]['ip_start'] = long2ip($table_ipaddr_subnets->data[$key]['ip_start']);
				$table_ipaddr_subnets->data[$key]['ip_end'] = long2ip($table_ipaddr_subnets->data[$key]['ip_end']);
			}
		}
		$table_ipaddr_subnets->db_data_translate('ip_addresses__type', 'ip_addresses__always_on', 'subnets__type');
		$table_ipaddr_subnets->db_data_hide('subnets__ip_start', 'subnets__ip_end', 'subnets__type', 'nodes__name', 'nodes__id', 'links__type');
		return $table_ipaddr_subnets;
	}

	function table_services() {
		global $db, $vars, $lang;
		$table_services = new table(array('TABLE_NAME' => 'table_services', 'FORM_NAME' => 'table_services'));
		$table_services->db_data(
			'services.title, nodes_services.id, nodes.id AS nodes__id, ip_addresses.ip, nodes_services.url, nodes_services.info, nodes_services.status, nodes_services.date_in, IFNULL(nodes_services.protocol, services.protocol) AS protocol, IFNULL(nodes_services.port, services.port) AS port',
			'nodes_services
			LEFT JOIN nodes on nodes_services.node_id = nodes.id
			LEFT JOIN services on nodes_services.service_id = services.id
			LEFT JOIN ip_addresses ON ip_addresses.id = nodes_services.ip_id',
			"nodes_services.node_id = '".get('node')."'",
			'',
			"services.title ASC");

		foreach( (array) $table_services->data as $key => $value) {
			if ($key != 0) {
				if ($table_services->data[$key]['ip']) {
					$table_services->data[$key]['ip'] = long2ip($table_services->data[$key]['ip']);
					if ($table_services->data[$key]['protocol'] && $table_services->data[$key]['port']) {
						$table_services->data[$key]['ip'] .= ' ('.$lang['db']['nodes_services__protocol-'.$table_services->data[$key]['protocol']].'/'.$table_services->data[$key]['port'].')';
					}
				}
				$table_services->info['LINK']['services__title'][$key] = htmlspecialchars($table_services->data[$key]['url']);
			}
		}
		$table_services->db_data_remove('id','nodes__id', 'url', 'protocol', 'port');
		$table_services->db_data_translate('nodes_services__status');
		return $table_services;
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct, $db, $vars, $main;
		$main->html->head->add_script("text/javascript", "./templates/basic/scripts/javascripts/fancyzoom/js-global/FancyZoom_packed.js");
		$main->html->head->add_script("text/javascript", "./templates/basic/scripts/javascripts/fancyzoom/js-global/FancyZoomHTML_packed.js");
		$main->html->body->tags['onload']="setupZoom();";
		if ($db->cnt('',
					'nodes ' .
					'INNER JOIN users_nodes ON users_nodes.node_id = nodes.id ' .
					'INNER JOIN users ON users_nodes.user_id = users.id',
					"nodes.id = ".intval(get('node')).
					' AND users.status = "activated"')
			 == 0) {
			$main->message->set_fromlang('error', 'node_not_found');
			return;
		}
		$this->tpl['node'] = $db->get(
			'nodes.id, nodes.name, nodes.date_in, nodes.latitude, nodes.longitude, nodes.elevation, nodes.info, areas.name as area_name, regions.name as region_name, users.username AS owner_username, users.email AS owner_email',
			'nodes
			LEFT JOIN areas ON nodes.area_id = areas.id
			LEFT JOIN regions ON areas.region_id = regions.id
			LEFT JOIN users_nodes ON users_nodes.node_id = nodes.id
			LEFT JOIN users ON users.id = users_nodes.user_id',
			"nodes.id = ".intval(get('node'))." AND (users_nodes.owner = 'Y' OR users_nodes.owner IS NULL)");
		$this->tpl['node'] = $this->tpl['node'][0];
		$this->tpl['link_contact'] = makelink(array("subpage" => "contact"), TRUE);
		$this->tpl['table_ip_ranges'] = $construct->table($this->table_ip_ranges(), __FILE__);
		$this->tpl['table_dns'] = $construct->table($this->table_dns(), __FILE__);
		$this->tpl['table_nameservers'] = $construct->table($this->table_nameservers(), __FILE__);
		$this->tpl['table_links_p2p'] = $construct->table($this->table_links_p2p(), __FILE__);

		$t = $db->get('id, type', 'links', "node_id = ".intval(get('node')));
		foreach( (array) $t as $key => $value) {
			if ($value['type'] == 'ap') $this->tpl['table_links_ap'][$value['id']] = $construct->table($this->table_links_ap($value['id']), __FILE__);
		}

		$this->tpl['table_ipaddr_subnets'] = $construct->table($this->table_ipaddr_subnets(), __FILE__);
		$this->tpl['table_services'] = $construct->table($this->table_services(), __FILE__);
		$t = $db->get('id, date_in, view_point, info', 'photos', "node_id = ".intval(get('node')));
		foreach( (array) $t as $key => $value) {
			$this->tpl['photosview'][$value['view_point']] = $value;
			$this->tpl['photosview'][$value['view_point']]['image_s'] = $vars['folders']['photos'].'photo-'.$this->tpl['photosview'][$value['view_point']]['id'].'-s.jpg';
			$this->tpl['photosview'][$value['view_point']]['image'] = $vars['folders']['photos'].'photo-'.$this->tpl['photosview'][$value['view_point']]['id'].'.jpg';
		}
		
		$this->tpl['link_plot_link'] = makelink(array("page" => "nodes", "subpage" => "plot_link", "a_node" => $this->tpl['node']['id']));
		if((isset($main->userdata->privileges['admin']) && $main->userdata->privileges['admin'] === TRUE) || $db->cnt('', "users_nodes", "node_id = ".get('node')." AND user_id = '".$main->userdata->user."'") > 0) $this->tpl['edit_node'] = makelink(array("page" => "mynodes", "node" => get('node')));
		$this->tpl['link_fullmap'] = makelink(array("page" => "gmap", "node" => get('node')));
		$this->tpl['link_gearth'] = makelink(array("page" => "gearth", "subpage" => "download", "node" => get('node'), "show_p2p" => "1", "show_aps" => "1", "show_clients" => "1", "show_unlinked" => "1", "show_links_p2p" => "1", "show_links_client" => "1"));
		if(get('show_map') == "no") $this->tpl['gmap_key_ok'] = "nomap";
		else $this->tpl['gmap_key_ok'] = include_gmap(htmlspecialchars("?page=gmap&subpage=js&node=".get('node')));
		return template($this->tpl, __FILE__);
	}

}

?>
