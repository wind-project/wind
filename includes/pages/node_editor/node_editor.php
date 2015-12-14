<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005-2014 	by WiND Contributors (see AUTHORS.txt)
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if (get('subpage') != '')
	require_once(ROOT_PATH."includes/pages/node_editor/node_editor_".get('subpage').".php");

class node_editor {

	var $tpl;
	var $page;
	
	function __construct() {
		if (get('subpage') != '') {
			$p = "node_editor_".get('subpage');
			$this->page = new $p;
		}
	}
	
	function has_owner_access() {
		global $db, $main;
		if ($main->userdata->privileges['admin'] === true)
			return true;
		
		if ($db->cnt('', "users_nodes", "user_id = '".$main->userdata->user."' AND node_id = ".intval(get('node'))." AND owner = 'Y'") > 0)
			return true;
		
		return false;
	}
	
	function form_node() {
		global $db, $main;
		$form_node = new form(array('FORM_NAME' => 'form_node'));
		$form_node->db_data('nodes.name, nodes.area_id, nodes.latitude, nodes.longitude, nodes.elevation, nodes.status, nodes.due_date, nodes.info'.($this->has_owner_access() || get('node') == 'add'?', users_nodes.user_id, users_nodes.user_id':''));
		if ($this->has_owner_access() || get('node') == 'add') {
			$form_node->data[8]['Field'] = 'user_id_owner';
			$form_node->data[8]['fullField'] = 'user_id_owner';
			if (get('node') == 'add') {
				$temp = $db->get("users.id AS value, users.username AS output", "users", "users.id = '".$main->userdata->user."'");
			} else {
				$temp = $db->get("users.id AS value, users.username AS output", "users_nodes, users", "users.id = users_nodes.user_id AND users_nodes.node_id = ".intval(get('node'))." AND users_nodes.owner = 'Y'");			
			}
			$form_node->db_data_pickup("user_id_owner", "users", $temp);
			$form_node->db_data_pickup("users_nodes.user_id", "users", $db->get("users.id AS value, users.username AS output", "users_nodes, users", "users.id = users_nodes.user_id AND users_nodes.node_id = ".intval(get('node'))." AND users_nodes.owner != 'Y'"), TRUE);
			$form_node->data[9]['Null'] = 'YES';
		}
		
		if ($main->userdata->privileges['admin'] === true)
			$form_node->db_data('nodes.id, nodes.name_ns');
		$form_node->db_data_enum('nodes.area_id', $db->get("id AS value, name AS output", "areas", "", "","name ASC"));
		$form_node->db_data_values("nodes", "id", intval(get('node')));
		return $form_node;
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
        
        function table_ip_ranges_v6() {
		global $db;
		$table_ip_ranges_v6 = new table(array('TABLE_NAME' => 'table_ip_ranges_v6', 'FORM_NAME' => 'table_ip_ranges_v6'));
		$table_ip_ranges_v6->db_data(
			'ip_ranges_v6.id, "" AS ip_range_v6, ipv6_node_repos.v6net AS v6net, ip_ranges_v6.date_in, ip_ranges_v6.status, ip_ranges_v6.delete_req',
			'ip_ranges_v6, ipv6_node_repos',
			'ip_ranges_v6.node_id = '.intval(get('node')).' and ip_ranges_v6.v6net_id = ipv6_node_repos.id',
			"",
			"ip_ranges_v6.date_in ASC");
		foreach( (array) $table_ip_ranges_v6->data as $key => $value) {
			if ($key != 0) {
				$table_ip_ranges_v6->data[$key]['v6net'] = inet_ntop($table_ip_ranges_v6->data[$key]['v6net']);
			}
		}
		$table_ip_ranges_v6->db_data_multichoice('ip_ranges_v6', 'id');
		$table_ip_ranges_v6->db_data_multichoice_checked('delete_req', 'Y');
		$table_ip_ranges_v6->info['MULTICHOICE_LABEL'] = 'delete_request';
		$table_ip_ranges_v6->db_data_remove('id', 'ip_range_v6', 'delete_req');
		$table_ip_ranges_v6->db_data_translate('ip_ranges_v6__status');
		return $table_ip_ranges_v6;
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
				$table_dns->info['EDIT'][$i] = make_ref('/node_editor/dnszone', array("zone" => $table_dns->data[$i]['id'], "node" => intval(get('node'))));
			}
		}
		$table_dns->info['EDIT_COLUMN'] = 'name';
		$table_dns->info['MULTICHOICE_LABEL'] = 'delete';
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
				$table_nameservers->info['EDIT'][$i] = make_ref('/node_editor/dnsnameserver', array("nameserver" => $table_nameservers->data[$i]['id'], "node" => intval(get('node'))));
			}
		}
		$table_nameservers->info['EDIT_COLUMN'] = 'name';
		$table_nameservers->info['MULTICHOICE_LABEL'] = 'delete';
		$table_nameservers->db_data_remove('id', 'nodes_name_ns');
		$table_nameservers->db_data_translate('dns_nameservers__status');
		return $table_nameservers;
	}

	function table_links() {
		global $db;
		$table_links = new table(array('TABLE_NAME' => 'table_links', 'FORM_NAME' => 'table_links'));
		$table_links->db_data(
			'links.id, links.type, "" AS peer, links.peer_node_id, n_p.name AS peer_node_name, n_c.name AS peer_ap_nodename, n_c.id AS peer_ap_nodeid, l_c.ssid AS peer_ap_ssid, links.ssid, links.status',
			'links
			LEFT JOIN nodes AS n_p ON links.peer_node_id = n_p.id
			LEFT JOIN links AS l_c ON links.peer_ap_id = l_c.id
			LEFT JOIN nodes AS n_c ON l_c.node_id = n_c.id',
			"links.node_id = ".intval(get('node')),
			"",
			"links.type ASC, links.date_in ASC");
		$table_links->db_data_multichoice('links', 'id');
		for($i=1;$i<count($table_links->data);$i++) {
			if (isset($table_links->data[$i])) {
				if ($table_links->data[$i]['type'] == 'p2p') {
					$table_links->data[$i]['peer'] = $table_links->data[$i]['peer_node_name']." (#".$table_links->data[$i]['peer_node_id'].")";
				}
				if ($table_links->data[$i]['type'] == 'client') {
					$table_links->data[$i]['peer'] = $table_links->data[$i]['peer_ap_nodename']." (#".$table_links->data[$i]['peer_ap_nodeid'].")";
					$table_links->data[$i]['ssid'] = $table_links->data[$i]['peer_ap_ssid'];
				}				
				$table_links->info['EDIT'][$i] = make_ref('/node_editor/link', array('node' => intval(get('node')), "link" => $table_links->data[$i]['id']));
			}
		}
		$table_links->info['EDIT_COLUMN'] = 'type';
		$table_links->info['MULTICHOICE_LABEL'] = 'delete';
		$table_links->db_data_remove('id', 'peer_node_id', 'peer_node_name', 'peer_ap_nodename', 'peer_ap_nodeid', 'peer_ap_ssid');
		$table_links->db_data_translate('links__type', 'links__status');
		return $table_links;
	}
	
	function table_links_ap($id) {
		global $db;
		$table_links = new table(array('TABLE_NAME' => 'table_links_ap_'.$id, 'FORM_NAME' => 'table_links_ap_'.$id));
		$table_links->db_data(
			'links.id, "" AS peer, links.type, links.node_id, nodes.name, links.status',
			'links
			LEFT JOIN nodes ON links.node_id = nodes.id',
			"links.type = 'client' AND links.peer_ap_id = '".$id."'",
			"",
			"links.date_in ASC");
		$table_links->db_data_multichoice('links', 'id');
		for($i=1;$i<count($table_links->data);$i++) {
			if (isset($table_links->data[$i])) {
				$table_links->data[$i]['peer'] = $table_links->data[$i]['name']." (#".$table_links->data[$i]['node_id'].")";
			}
		}
		$table_links->info['MULTICHOICE_LABEL'] = 'delete';
		$table_links->db_data_remove('id', 'node_id', 'name');
		$table_links->db_data_translate('links__type', 'links__status');
		return $table_links;
	}

	function table_subnets() {
		global $construct, $db, $lang;
		$table_subnets = new table(array('TABLE_NAME' => 'table_subnets', 'FORM_NAME' => 'table_subnets'));
		$table_subnets->db_data(
			'subnets.id, "" AS subnet, subnets.ip_start, subnets.ip_end, subnets.type, "" AS peer, n_l.name AS link_node_name, n_l.id AS link_node_id, n_c.name AS client_node_name, n_c.id AS client_node_id, links.type AS links_type, links.ssid AS links_ssid',
			'subnets
			LEFT JOIN links ON links.id = subnets.link_id
			LEFT JOIN nodes AS n_l ON n_l.id = links.peer_node_id
			LEFT JOIN nodes AS n_c ON n_c.id = client_node_id',
			'subnets.node_id = '.intval(get('node')),
			"",
			"subnets.type ASC, subnets.ip_start ASC");
		foreach( (array) $table_subnets->data as $key => $value) {
			if ($key != 0) {
				$table_subnets->data[$key]['ip_start'] = long2ip($table_subnets->data[$key]['ip_start']);
				$table_subnets->data[$key]['ip_end'] = long2ip($table_subnets->data[$key]['ip_end']);
				$table_subnets->data[$key]['subnet'] = $table_subnets->data[$key]['ip_start']." - ".$table_subnets->data[$key]['ip_end'];
				if ($table_subnets->data[$key]['type'] == 'link') {
					if($table_subnets->data[$key]['links_type'] == 'p2p')
						$table_subnets->data[$key]['peer'] = $table_subnets->data[$key]['link_node_name']." (#".$table_subnets->data[$key]['link_node_id'].")";
					elseif ($table_subnets->data[$key]['links_type'] == 'ap')
						$table_subnets->data[$key]['peer'] = $lang['ap']." - ".$table_subnets->data[$key]['links_ssid'];
				}
				if ($table_subnets->data[$key]['type'] == 'client') {
					$table_subnets->data[$key]['peer'] = $table_subnets->data[$key]['client_node_name']." (#".$table_subnets->data[$key]['client_node_id'].")";
				}
			}
		}
		$table_subnets->db_data_multichoice('subnets', 'id');
		for($i=1;$i<count($table_subnets->data);$i++) {
			if (isset($table_subnets->data[$i])) {
				$table_subnets->info['EDIT'][$i] = make_ref('/node_editor/subnet', array('node' => intval(get('node')), "subnet" => $table_subnets->data[$i]['id']));
			}
		}
		$table_subnets->info['EDIT_COLUMN'] = 'subnet';
		$table_subnets->info['MULTICHOICE_LABEL'] = 'delete';
		$table_subnets->db_data_remove('id', 'ip_start', 'ip_end', 'link_node_name', 'link_node_id', 'client_node_name', 'client_node_id','links_type','links_ssid');
		$table_subnets->db_data_translate('subnets__type');
		return $table_subnets;
	}

	function table_ipaddr() {
		global $construct, $db;
		$table_ipaddr = new table(array('TABLE_NAME' => 'table_ipaddr', 'FORM_NAME' => 'table_ipaddr'));
		$table_ipaddr->db_data(
			'ip_addresses.id, ip_addresses.hostname, ip_addresses.ip, ip_addresses.mac, ip_addresses.type, ip_addresses.always_on',
			'ip_addresses',
			'ip_addresses.node_id = '.intval(get('node')),
			"",
			"ip_addresses.ip ASC");
		foreach( (array) $table_ipaddr->data as $key => $value) {
			if ($key != 0) {
				$table_ipaddr->data[$key]['ip'] = long2ip($table_ipaddr->data[$key]['ip']);
			}
		}
		$table_ipaddr->db_data_multichoice('ip_addresses', 'id');
		for($i=1;$i<count($table_ipaddr->data);$i++) {
			if (isset($table_ipaddr->data[$i])) {
				$table_ipaddr->info['EDIT'][$i] = make_ref('/node_editor/ipaddr', array('node' => intval(get('node')), "ipaddr" => $table_ipaddr->data[$i]['id']));
			}
		}
		$table_ipaddr->info['EDIT_COLUMN'] = 'hostname';
		$table_ipaddr->info['MULTICHOICE_LABEL'] = 'delete';
		$table_ipaddr->db_data_remove('id');
		$table_ipaddr->db_data_translate('ip_addresses__type', 'ip_addresses__always_on');
		return $table_ipaddr;
	}

	function table_services() {
		global $construct, $db, $main;
		$table_services = new table(array('TABLE_NAME' => 'table_services', 'FORM_NAME' => 'table_services'));
		$table_services->db_data(
			'services.title, nodes_services.id, nodes.id AS nodes__id, ip_addresses.ip, nodes_services.url, nodes_services.info, nodes_services.status, nodes_services.date_in',
			'nodes_services
			LEFT JOIN nodes on nodes_services.node_id = nodes.id
			LEFT JOIN services on nodes_services.service_id = services.id
			LEFT JOIN ip_addresses ON ip_addresses.id = nodes_services.ip_id',
			"nodes_services.node_id = '".get('node')."'",
			'',
			"nodes_services.date_in ASC");
		foreach( (array) $table_services->data as $key => $value) {
			if ($key != 0) {
				if ($table_services->data[$key]['ip']) 
					$table_services->data[$key]['ip'] = long2ip($table_services->data[$key]['ip']);
				$table_services->info['EDIT'][$key] = make_ref('/node_editor/services', array("node" => intval(get('node')), "service" => $table_services->data[$key]['id']));
			}
		}
		$table_services->info['EDIT_COLUMN'] = 'title';
		$table_services->db_data_translate('nodes_services__status');
		$table_services->db_data_multichoice('nodes_services', 'id');
		$table_services->info['MULTICHOICE_LABEL'] = 'delete';
		$table_services->db_data_remove('id','nodes__id');
		return $table_services;
	}
	
	function table_nodesettingschanges() {
		global $construct, $db, $main;
		$table_nodesettingschanges = new table(array('TABLE_NAME' => 'table_nodesettingschanges', 'FORM_NAME' => 'table_nodesettingschanges'));
		$table_nodesettingschanges->db_data(
			'node_settings_changes.changemenu, node_settings_changes.changemade, node_settings_changes.reason, node_settings_changes.comment, node_settings_changes.dateline, users.username',
			'node_settings_changes
			INNER JOIN users on node_settings_changes.uid = users.id',
			"node_settings_changes.node_id = '".get('node')."'",
			'',
			"node_settings_changes.id DESC");
		
		for($i=1;$i<count($table_nodesettingschanges->data);$i++) {
			if (isset($table_nodesettingschanges->data[$i])) {
				#$table_actionlog->data[$i]['ip_start'] = long2ip($table_actionlog->data[$i]['ip_start']);
				#$table_actionlog->data[$i]['ip_end'] = long2ip($table_actionlog->data[$i]['ip_end']);
				#$table_actionlog->info['EDIT'][$i] = makelink(array("page" => "admin", "subpage" => "actionlog", "area" => $table_actionlog->data[$i]['id']));
			}
		}
		
		return $table_nodesettingschanges;
	}

	function table_photosview() {
		global $db, $vars;
		$table_photosview = new table(array('TABLE_NAME' => 'table_photosview', 'FORM_NAME' => 'table_photosview'));
		$table_photosview->db_data(
			'photos.id, photos.date_in, photos.view_point, photos.info',
			'photos',
			'photos.node_id = '.intval(get('node')));
		$i=1;
		$t[0] = $table_photosview->data[0];
		$t[0]['photo'] = 'photo';
		foreach( (array) array('N','NE','E','SE','S','SW','W','NW', 'PANORAMIC') as $value) {
			foreach( (array) $table_photosview->data as $key => $valuek) {
				if ($table_photosview->data[$key]['view_point'] == $value) {$p = $key; break;}
				unset($p);
			}
			if (isset($p) && ($table_photosview->data[$p]['view_point'] == $value)) {
				$table_photosview->data[$p]['photo'] = surl($vars['folders']['photos'].'photo-'.$table_photosview->data[$p]['id'].'-s.jpg');
				$t[$i] = $table_photosview->data[$p];
			} else {
				$t[$i] = array('id' => '', 'date_in' => '', 'view_point' => $value, 'info' => '', 'photo' => '');
			}
			$i++;
		}
		$table_photosview->data = $t;
		$table_photosview->db_data_multichoice('photos', 'id');
		$table_photosview->info['MULTICHOICE_LABEL'] = 'delete';
		$table_photosview->db_data_remove('id');
		return $table_photosview;
	}

	function output() {
		global $construct, $main, $db;
		
		if (get('subpage') != '')
			return $this->page->output();
		if (isset($_POST['form_name']) && (strstr($_POST['form_name'], 'table_links_ap') !== FALSE))
			return $this->output_onpost_table_links_ap();
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name']))
			return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		
		
		
		include_map_dependencies();
		$this->tpl['form_node'] = $construct->form($this->form_node(), __FILE__);
		$this->tpl['node'] = get('node');
		if (get('action') == 'delete') {
			if ($db->del('nodes, 
					dns_nameservers, 
					dns_zones, 
					dns_zones_nameservers, 
					ip_addresses, 
					ip_ranges, 
					links, 
					nodes_services, 
					photos, 
					services, 
					subnets, 
					users_nodes', 
				'nodes 
					LEFT JOIN dns_nameservers ON nodes.id = dns_nameservers.node_id 
					LEFT JOIN dns_zones ON nodes.id = dns_zones.node_id 
					LEFT JOIN dns_zones_nameservers ON  dns_zones.id = dns_zones_nameservers.zone_id OR dns_nameservers.id = dns_zones_nameservers.nameserver_id 
					LEFT JOIN ip_addresses ON nodes.id = ip_addresses.node_id 
					LEFT JOIN ip_ranges ON nodes.id = ip_ranges.node_id 
					LEFT JOIN links ON nodes.id = links.node_id 
					LEFT JOIN nodes_services ON nodes.id = nodes_services.node_id 
					LEFT JOIN services ON nodes_services.service_id = services.id 
					LEFT JOIN photos ON nodes.id = photos.node_id 
					LEFT JOIN subnets ON nodes.id = subnets.node_id 
					LEFT JOIN users_nodes ON nodes.id = users_nodes.node_id', 
				"nodes.id = ".intval(get('node')))) { 
				$main->message->set_fromlang('info', 'delete_success', self_ref());
			} else {
				$main->message->set_fromlang('error', 'generic');		
			}
		} else {
			$this->tpl['node_method'] = (get('node') == 'add' ? 'add' : 'edit');
			if (get('node') != 'add') {
				$t = $db->get('id, name', 'nodes', "id = ".intval(get('node')));
				$this->tpl['node_name'] = $t[0]['name'];
				$this->tpl['node_id'] = $t[0]['id'];
				
				$this->tpl['table_ip_ranges'] = $construct->table($this->table_ip_ranges(), __FILE__);
                $this->tpl['table_ip_ranges_v6'] = $construct->table($this->table_ip_ranges_v6(), __FILE__);
				$this->tpl['table_dns'] = $construct->table($this->table_dns(), __FILE__);
				$this->tpl['table_nameservers'] = $construct->table($this->table_nameservers(), __FILE__);
				$this->tpl['table_links'] = $construct->table($this->table_links(), __FILE__);
				$t = $db->get('id, ssid', 'links', "node_id = ".intval(get('node'))." AND type = 'ap'");
				foreach( (array) $t as $key => $value) {
					$this->tpl['table_links_ap'][$value['ssid']] = $construct->table($this->table_links_ap($value['id']), __FILE__);
				}
				$this->tpl['table_subnets'] = $construct->table($this->table_subnets(), __FILE__);
				$this->tpl['table_ipaddr'] = $construct->table($this->table_ipaddr(), __FILE__);
				$this->tpl['table_services'] = $construct->table($this->table_services(), __FILE__);
				$this->tpl['table_nodesettingschanges'] = $construct->table($this->table_nodesettingschanges(), __FILE__);
				$this->tpl['table_photosview'] = $construct->table($this->table_photosview(), __FILE__);
				if ($this->has_owner_access())
					$this->tpl['link_node_delete'] = self_ref(array('action' => 'delete'));
				$this->tpl['link_node_view'] = make_ref('/nodes', array('node' => get('node')));
				$this->tpl['link_req_cclass'] = make_ref('/node_editor/range', array('node' => get('node')));
				$this->tpl['link_req_v6_cclass'] = make_ref('/node_editor/range_v6', array('node' => get('node')));
				$this->tpl['link_req_dns_for'] = make_ref('/node_editor/dnszone', array('type' => 'forward', 'node' => get('node'), 'zone' => 'add'));
				$this->tpl['link_req_dns_rev'] = make_ref('/node_editor/dnszone', array('type' => 'reverse', 'node' => get('node'), 'zone' => 'add'));
				$this->tpl['link_nameserver_add'] = make_ref('/node_editor/dnsnameserver', array('node' => get('node'), 'nameserver' => 'add'));
				$this->tpl['link_link_add'] = make_ref('/node_editor/link', array('node' => get('node'), 'link' => 'add'));
				$this->tpl['link_subnet_add'] = make_ref('/node_editor/subnet', array('node' => get('node'), 'subnet' => 'add'));
				$this->tpl['link_ipaddr_add'] = make_ref('node_editor/ipaddr', array('node' => get('node'), 'ipaddr' => 'add'));
				$this->tpl['link_services_add'] = make_ref('/node_editor/services', array('node' => get('node'), 'service' => 'add'));
				$this->tpl['link_nodesettingschanges_add'] = make_ref('/node_editor/nodesettingschanges', array('node' => get('node'), 'nodesettingschanges' => 'add'));

			}
			$this->tpl['link_map_pickup'] = make_ref('/pickup/map', array("object_lat" => "form_node.elements['nodes__latitude']", "object_lon" => "form_node.elements['nodes__longitude']"));
			return template($this->tpl, __FILE__);
		}
	}

	function output_onpost_form_node() {
		global $construct, $db, $main;
		$form_node = $this->form_node();
		$ret = TRUE;
		if ($main->userdata->privileges['admin'] === TRUE && $_POST['nodes__id'] == '') {
			$form_node->db_data_remove('nodes__id');
		}
		if ($main->userdata->privileges['admin'] === TRUE && $_POST['nodes__name_ns'] != '') {
			$name_ns = validate_name_ns($_POST['nodes__name_ns'], get('node'));
		} else {
			$name_ns = validate_name_ns($_POST['nodes__name'], get('node'));
		}
		$_POST['nodes__latitude'] = str_replace(",", ".", $_POST['nodes__latitude']);
		$_POST['nodes__longitude'] = str_replace(",", ".", $_POST['nodes__longitude']);
		if (!isset($_POST['users_nodes__user_id'])) { $_POST['users_nodes__user_id'] = array(); }
		
		if (get('node') != 'add') {
			$old_v = $db->get('name, area_id', 'nodes', "id = ".intval(get('node')));
			if ($old_v[0]['name'] != $_POST['nodes__name']) {
				$name_ns = validate_name_ns($_POST['nodes__name'], get('node'));
			}
		}
		
		$ret = $ret && $form_node->db_set(array('name_ns' => $name_ns), "nodes", "id", intval(get('node')));
		if ($ret && $main->userdata->privileges['admin'] === TRUE && get('node') != 'add' && get('node') != $_POST['nodes__id']) {
			$db->set('dns_nameservers', array('node_id' => $_POST['nodes__id']), "node_id = ".intval(get('node')));
			$db->set('dns_zones', array('node_id' => $_POST['nodes__id']), "node_id = ".intval(get('node')));
			$db->set('ip_addresses', array('node_id' => $_POST['nodes__id']), "node_id = ".intval(get('node')));
			$db->set('ip_ranges', array('node_id' => $_POST['nodes__id']), "node_id = ".intval(get('node')));
            $db->set('ip_ranges_v6', array('node_id' => $_POST['nodes__id']), "node_id = ".intval(get('node')));
			$db->set('nodes_services', array('node_id' => $_POST['nodes__id']), "node_id = '".get('node')."'");
			$db->set('links', array('node_id' => $_POST['nodes__id']), "node_id = ".intval(get('node')));
			$db->set('links', array('peer_node_id' => $_POST['nodes__id']), "peer_node_id = ".intval(get('node')));
			$db->set('photos', array('node_id' => $_POST['nodes__id']), "node_id = ".intval(get('node')));
			$db->set('subnets', array('node_id' => $_POST['nodes__id']), "node_id = ".intval(get('node')));
			$db->set('subnets', array('client_node_id' => $_POST['nodes__id']), "client_node_id = ".intval(get('node')));
			$db->set('users_nodes', array('node_id' => $_POST['nodes__id']), "node_id = ".intval(get('node')));
			$ins_id = $_POST['nodes__id'];
		} else {
			$ins_id = (get('node')=='add' ? $db->insert_id : intval(get('node')));
		}
		if ($ret && ($this->has_owner_access() || get('node')=='add')) {
			$ret = $ret && $form_node->db_set_multi(array(), "users_nodes", "node_id", $ins_id);
			if ($_POST['user_id_owner'] != '') {
				$ret = $ret && $db->del('users_nodes', '', "user_id = '".$_POST['user_id_owner']."' AND node_id = '".$ins_id."'");
				$ret = $ret && $db->add('users_nodes', array("user_id" => $_POST['user_id_owner'], "node_id" => $ins_id, 'owner' => 'Y'));
			}
		}
		if ($ret) {
			$main->message->set_fromlang('info', (get('node') == 'add'?'insert':'edit').'_success', self_ref(array("node" => $ins_id)));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}
	
	function output_onpost_table_ip_ranges() {
		global $db, $main;
		$ret = TRUE;
		$ret = $ret && $db->set("ip_ranges", array('delete_req' => 'N'), "node_id = ".intval(get('node')));
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->set("ip_ranges", array('delete_req' => 'Y'), "id = '".intval($value)."' AND node_id =  ".intval(get('node')));
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'update_success', self_ref());
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}
        
        function output_onpost_table_ip_ranges_v6() {
		global $db, $main;
		$ret = TRUE;
		$ret = $ret && $db->set("ip_ranges_v6", array('delete_req' => 'N'), "node_id = ".intval(get('node')));
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->set("ip_ranges_v6", array('delete_req' => 'Y'), "id = '".intval($value)."' AND node_id =  ".intval(get('node')));
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'update_success', self_ref());
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}
        
	function output_onpost_table_dns() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("dns_zones, dns_zones_nameservers", 
						'dns_zones 
							LEFT JOIN dns_zones_nameservers ON dns_zones.id = dns_zones_nameservers.zone_id', 
						"dns_zones.id = '".intval($value)."' AND dns_zones.node_id =  ".intval(get('node')));
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', self_ref());
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

	function output_onpost_table_nameservers() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("dns_nameservers, dns_zones_nameservers", 
						'dns_nameservers 
							LEFT JOIN dns_zones_nameservers ON dns_nameservers.id = dns_zones_nameservers.nameserver_id', 
						"dns_nameservers.id = '".intval($value)."' AND dns_nameservers.node_id =  ".intval(get('node')));
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', self_ref());
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

	function output_onpost_table_links() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("links, links2, subnets", 
						'links 
							LEFT JOIN links AS links2 ON links.id = links2.peer_ap_id
							LEFT JOIN subnets ON links.id = subnets.link_id', 
						"links.id = '".intval($value)."' AND links.node_id = ".intval(get('node')));
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', self_ref());
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

	function output_onpost_table_links_ap() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("links", '', "id = '".intval($value)."' AND node_id = ".intval(get('node')));
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', self_ref());
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

	function output_onpost_table_subnets() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("subnets", '', "id = '".intval($value)."' AND node_id = ".intval(get('node')));
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', self_ref());
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

	function output_onpost_table_ipaddr() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("ip_addresses", '', "id = '".intval($value)."' AND node_id = ".intval(get('node')));
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', self_ref());
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}
	
	function output_onpost_table_services() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("nodes_services", '', "id = '".intval($value)."' AND node_id = ".intval(get('node')));
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', self_ref());
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}
	
	function output_onpost_table_photosview() {
		global $vars, $db, $main;
		if (isset($_POST['id'])) {
			foreach( (array) $_POST['id'] as $key => $value) {
				$db->del("photos", '', "id = '".intval($value)."' AND node_id = ".intval(get('node')));
				if ($db->affected_rows > 0 ) {
					$uploaddir = $vars['folders']['photos'];
					$filename = 'photo-'.$value.".*";
					delfile(ROOT_PATH.$uploaddir.$filename);
					$filename = 'photo-'.$value."-*.*";
					delfile(ROOT_PATH.$uploaddir.$filename);
				}
			}
		}
		foreach( (array) array('N','NE','E','SE','S','SW','W','NW', 'PANORAMIC') as $value) {
			if (isset($_FILES[$value]['tmp_name'])) {
				if (!imagecreatefromjpeg($_FILES[$value]['tmp_name'])) continue;
				$db->add("photos", array('node_id' => intval(get('node')), 'type' => 'view', 'view_point' => $value, 'info' => $_POST['info-'.$value]));
				$ins_id = $db->insert_id;
				$uploaddir = $vars['folders']['photos'];
				$filename = 'photo-'.$ins_id.'.jpg';
				$filename_s = 'photo-'.$ins_id.'-s.jpg';
				if (@move_uploaded_file($_FILES[$value]['tmp_name'], ROOT_PATH.$uploaddir.$filename) === FALSE) {
					$db->del("photos", '', "id = '".$ins_id."'");
					$main->message->set_fromlang("error", "upload_file_failed");
					return;
				}
				if ($value == 'PANORAMIC') {
					$image_s = resizeJPG(ROOT_PATH.$uploaddir.$filename, 600, 200);
				} else {
					$image_s = resizeJPG(ROOT_PATH.$uploaddir.$filename, 200, 200);
				}
				imagejpeg($image_s, ROOT_PATH.$uploaddir.$filename_s);
			} elseif ($_POST['info-'.$value] != '') {
				$db->set("photos", array('info' => $_POST['info-'.$value]), "node_id = ".intval(get('node'))." AND view_point = '".$value."'");
			}
		}
		$main->message->set_fromlang('info', 'update_success', self_ref());
	}

}

