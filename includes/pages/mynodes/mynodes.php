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

if (get('subpage') != '') include_once($root_path."includes/pages/mynodes/mynodes_".get('subpage').".php");

class mynodes {

	var $tpl;
	var $page;
	
	function mynodes() {
		if (get('subpage') != '') {
			$p = "mynodes_".get('subpage');
			$this->page = new $p;
		}
	}
	
	function has_owner_access() {
		global $db, $main;
		if ($main->userdata->privileges['admin']===TRUE) return TRUE;
		
		if ($db->cnt("users_nodes", "user_id = '".$main->userdata->user."' AND node_id = '".get('node')."' AND owner = 'Y'") > 0) return TRUE;
		
		return FALSE;
	}
	
	function form_node() {
		global $db, $main;
		$form_node = new form(array('FORM_NAME' => 'form_node'));
		$form_node->db_data('nodes.name, nodes.area_id, nodes.latitude, nodes.longitude, nodes.elevation, nodes.info'.($this->has_owner_access() || get('node') == 'add'?', users_nodes.user_id, users_nodes.user_id':''));
		if ($this->has_owner_access() || get('node') == 'add') {
			$form_node->data[6]['Field'] = 'user_id_owner';
			$form_node->data[6]['fullField'] = 'user_id_owner';
			$form_node->data[6]['Type'] = 'pickup';
			$form_node->data[6]['Pickup_url'] = makelink(array("page" => "pickup", "subpage" => "users", "object" => "form_node.user_id_owner"));
			//$form_node->data[6]['Null'] = 'YES';
			//$form_node->db_data_enum('user_id_owner', $db->get("id AS value, username AS output", "users"));
			if (get('node') == 'add') {
				$form_node->data[6]['Type_Pickup'] = $db->get("users.id AS value, users.username AS output", "users", "users.id = '".$main->userdata->user."'");
			} else {
				$form_node->data[6]['Type_Pickup'] = $db->get("users.id AS value, users.username AS output", "users_nodes, users", "users.id = users_nodes.user_id AND users_nodes.node_id = '".get('node')."' AND users_nodes.owner = 'Y'");			
			}
			$form_node->data[6]['Type_Pickup'] = $form_node->data[6]['Type_Pickup'][0];
			$form_node->data[7]['Type'] = 'pickup_multi';
			$form_node->data[7]['Pickup_url'] = makelink(array("page" => "pickup", "subpage" => "users", "object" => "form_node.elements['users_nodes__user_id[]']"));
			$form_node->data[7]['Null'] = 'YES';
			$form_node->data[7]['Type_Pickup'] = $db->get("users.id AS value, users.username AS output", "users_nodes, users", "users.id = users_nodes.user_id AND users_nodes.node_id = '".get('node')."' AND users_nodes.owner != 'Y'");			
		}
		
		if ($main->userdata->privileges['admin'] === TRUE) $form_node->db_data('nodes.id, nodes.name_ns');
		$form_node->db_data_enum('nodes.area_id', $db->get("id AS value, name AS output", "areas"));
		$form_node->db_data_values("nodes", "id", get('node'));
		return $form_node;
	}
	
	function table_ip_ranges() {
		global $db;
		$table_ip_ranges = new table(array('TABLE_NAME' => 'table_ip_ranges', 'FORM_NAME' => 'table_ip_ranges'));
		$table_ip_ranges->db_data(
			'ip_ranges.id, "" AS ip_range, ip_ranges.ip_start, ip_ranges.ip_end, ip_ranges.date_in, ip_ranges.status, ip_ranges.delete_req',
			'ip_ranges',
			'ip_ranges.node_id = '.get('node'));
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
			'dns_zones.id, dns_zones.name, dns_zones.date_in, dns_zones.status, dns_zones.delete_req, dns_zones.type',
			'dns_zones',
			'dns_zones.node_id = '.get('node'));
		$table_dns->db_data_multichoice('dns_zones', 'id');
		$table_dns->db_data_multichoice_checked('delete_req', 'Y');
		for($i=1;$i<count($table_dns->data);$i++) {
			if (isset($table_dns->data[$i])) {
				if ($table_dns->data[$i]['type'] == 'forward') $table_dns->data[$i]['name'] .= ".".$vars['dns']['root_zone'];
				$table_dns->info['EDIT'][$i] = makelink(array("page" => "mynodes", "subpage" => "dnszone", "zone" => $table_dns->data[$i]['id']));
			}
		}
		$table_dns->info['EDIT_COLUMN'] = 'name';
		$table_dns->info['MULTICHOICE_LABEL'] = 'delete_request';
		$table_dns->db_data_remove('id', 'delete_req', 'type');
		$table_dns->db_data_translate('dns_zones__status');
		return $table_dns;
	}

	function table_nameservers() {
		global $db, $vars;
		$table_nameservers = new table(array('TABLE_NAME' => 'table_nameservers', 'FORM_NAME' => 'table_nameservers'));
		$table_nameservers->db_data(
			'dns_nameservers.id, dns_nameservers.name, dns_nameservers.ip, dns_nameservers.date_in, dns_nameservers.status, nodes.name_ns AS nodes_name_ns, dns_nameservers.delete_req',
			'dns_nameservers, nodes',
			"nodes.id = '".get('node')."' AND dns_nameservers.node_id = nodes.id");
		foreach( (array) $table_nameservers->data as $key => $value) {
			if ($key != 0) {
				$table_nameservers->data[$key]['ip'] = long2ip($table_nameservers->data[$key]['ip']);
				$table_nameservers->data[$key]['name'] = strtolower(($table_nameservers->data[$key]['name']!=''?$table_nameservers->data[$key]['name'].".":"").$table_nameservers->data[$key]['nodes_name_ns'].".".$vars['dns']['ns_zone']);
			}
		}
		$table_nameservers->db_data_multichoice('dns_nameservers', 'id');
		$table_nameservers->db_data_multichoice_checked('delete_req', 'Y');
		for($i=1;$i<count($table_nameservers->data);$i++) {
			if (isset($table_nameservers->data[$i])) {
				$table_nameservers->info['EDIT'][$i] = makelink(array("page" => "mynodes", "subpage" => "dnsnameserver", "nameserver" => $table_nameservers->data[$i]['id']));
			}
		}
		$table_nameservers->info['EDIT_COLUMN'] = 'name';
		$table_nameservers->info['MULTICHOICE_LABEL'] = 'delete_request';
		$table_nameservers->db_data_remove('id', 'nodes_name_ns', 'delete_req');
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
			"links.node_id = '".get('node')."'");
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
				$table_links->info['EDIT'][$i] = makelink(array("page" => "mynodes", "subpage" => "link", 'node' => get('node'), "link" => $table_links->data[$i]['id']));
			}
		}
		$table_links->info['EDIT_COLUMN'] = 'peer';
		$table_links->info['MULTICHOICE_LABEL'] = 'delete';
		$table_links->db_data_remove('id', 'peer_node_id', 'peer_node_name', 'peer_ap_nodename', 'peer_ap_nodeid', 'peer_ap_ssid');
		$table_links->db_data_translate('links__type', 'links__status');
		return $table_links;
	}
	
	function table_links_ap($id) {
		global $db;
		$table_links = new table(array('TABLE_NAME' => 'table_links_ap_'.$id, 'FORM_NAME' => 'table_links_ap_'.$id));
		$table_links->db_data(
			'links.id, links.type, "" AS peer, links.node_id, nodes.name, links.status',
			'links
			LEFT JOIN nodes ON links.node_id = nodes.id',
			"links.type = 'client' AND links.peer_ap_id = '".$id."'");
		$table_links->db_data_multichoice('links', 'id');
		for($i=1;$i<count($table_links->data);$i++) {
			if (isset($table_links->data[$i])) {
				$table_links->data[$i]['peer'] = $table_links->data[$i]['name']." (#".$table_links->data[$i]['node_id'].")";
				$table_links->info['EDIT'][$i] = makelink(array("page" => "mynodes", "subpage" => "link", 'node' => $table_links->data[$i]['node_id'], "link" => $table_links->data[$i]['id']));
			}
		}
		$table_links->info['EDIT_COLUMN'] = 'peer';
		$table_links->info['MULTICHOICE_LABEL'] = 'delete';
		$table_links->db_data_remove('id', 'node_id', 'name');
		$table_links->db_data_translate('links__type', 'links__status');
		return $table_links;
	}

	function table_subnets() {
		global $construct, $db;
		$table_subnets = new table(array('TABLE_NAME' => 'table_subnets', 'FORM_NAME' => 'table_subnets'));
		$table_subnets->db_data(
			'subnets.id, "" AS subnet, subnets.ip_start, subnets.ip_end, subnets.type, "" AS peer, n_l.name AS link_node_name, n_l.id AS link_node_id, n_c.name AS client_node_name, n_c.id AS client_node_id',
			'subnets
			LEFT JOIN links ON links.id = subnets.link_id
			LEFT JOIN nodes AS n_l ON n_l.id = links.peer_node_id
			LEFT JOIN nodes AS n_c ON n_c.id = client_node_id',
			'subnets.node_id = '.get('node'));
		foreach( (array) $table_subnets->data as $key => $value) {
			if ($key != 0) {
				$table_subnets->data[$key]['ip_start'] = long2ip($table_subnets->data[$key]['ip_start']);
				$table_subnets->data[$key]['ip_end'] = long2ip($table_subnets->data[$key]['ip_end']);
				$table_subnets->data[$key]['subnet'] = $table_subnets->data[$key]['ip_start']." - ".$table_subnets->data[$key]['ip_end'];
				if ($table_subnets->data[$key]['type'] == 'link') {
					$table_subnets->data[$key]['peer'] = $table_subnets->data[$key]['link_node_name']." (#".$table_subnets->data[$key]['link_node_id'].")";
				}
				if ($table_subnets->data[$key]['type'] == 'client') {
					$table_subnets->data[$key]['peer'] = $table_subnets->data[$key]['client_node_name']." (#".$table_subnets->data[$key]['client_node_id'].")";
				}
			}
		}
		$table_subnets->db_data_multichoice('subnets', 'id');
		for($i=1;$i<count($table_subnets->data);$i++) {
			if (isset($table_subnets->data[$i])) {
				$table_subnets->info['EDIT'][$i] = makelink(array("page" => "mynodes", "subpage" => "subnet", 'node' => get('node'), "subnet" => $table_subnets->data[$i]['id']));
			}
		}
		$table_subnets->info['EDIT_COLUMN'] = 'subnet';
		$table_subnets->info['MULTICHOICE_LABEL'] = 'delete';
		$table_subnets->db_data_remove('id', 'ip_start', 'ip_end', 'link_node_name', 'link_node_id', 'client_node_name', 'client_node_id');
		$table_subnets->db_data_translate('subnets__type');
		return $table_subnets;
	}

	function table_ipaddr() {
		global $construct, $db;
		$table_ipaddr = new table(array('TABLE_NAME' => 'table_ipaddr', 'FORM_NAME' => 'table_ipaddr'));
		$table_ipaddr->db_data(
			'ip_addresses.id, ip_addresses.hostname, ip_addresses.ip, ip_addresses.mac, ip_addresses.type, ip_addresses.always_on',
			'ip_addresses',
			'ip_addresses.node_id = '.get('node'));
		foreach( (array) $table_ipaddr->data as $key => $value) {
			if ($key != 0) {
				$table_ipaddr->data[$key]['ip'] = long2ip($table_ipaddr->data[$key]['ip']);
			}
		}
		$table_ipaddr->db_data_multichoice('ip_addresses', 'id');
		for($i=1;$i<count($table_ipaddr->data);$i++) {
			if (isset($table_ipaddr->data[$i])) {
				$table_ipaddr->info['EDIT'][$i] = makelink(array("page" => "mynodes", "subpage" => "ipaddr", 'node' => get('node'), "ipaddr" => $table_ipaddr->data[$i]['id']));
			}
		}
		$table_ipaddr->info['EDIT_COLUMN'] = 'hostname';
		$table_ipaddr->info['MULTICHOICE_LABEL'] = 'delete';
		$table_ipaddr->db_data_remove('id');
		$table_ipaddr->db_data_translate('ip_addresses__type', 'ip_addresses__always_on');
		return $table_ipaddr;
	}

	function table_photosview() {
		global $db, $vars;
		$table_photosview = new table(array('TABLE_NAME' => 'table_photosview', 'FORM_NAME' => 'table_photosview'));
		$table_photosview->db_data(
			'photos.id, photos.date_in, photos.view_point, photos.info',
			'photos',
			'photos.node_id = '.get('node'));
		$i=1;
		$t[0] = $table_photosview->data[0];
		$t[0]['photo'] = 'photo';
		foreach( (array) array('N','NE','E','SE','S','SW','W','NW', 'PANORAMIC') as $value) {
			foreach( (array) $table_photosview->data as $key => $valuek) {
				if ($table_photosview->data[$key]['view_point'] == $value) {$p = $key; break;}
				unset($p);
			}
			if ($table_photosview->data[$p]['view_point'] == $value) {
				$table_photosview->data[$p]['photo'] = $vars['folders']['photos'].'photo-'.$table_photosview->data[$p]['id'].'-s.jpg';
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
		if (get('subpage') != '') return $this->page->output();
		if (strstr($_POST['form_name'], 'table_links_ap') !== FALSE) return $this->output_onpost_table_links_ap();
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct, $main, $db;
		$this->tpl['form_node'] = $construct->form($this->form_node(), __FILE__);
		$this->tpl['node'] = get('node');
		if (get('action') == 'delete') {
			if ($db->del('nodes', "id = '".get('node')."'")) { 
				$main->message->set_fromlang('info', 'delete_success', makelink());
			} else {
				$main->message->set_fromlang('error', 'generic');		
			}
		} else {
			$this->tpl['node_method'] = (get('node') == 'add' ? 'add' : 'edit');
			if (get('node') != 'add') {
				$t = $db->get('id, name', 'nodes', "id = '".get('node')."'");
				$this->tpl['node_name'] = $t[0]['name'];
				$this->tpl['node_id'] = $t[0]['id'];
				
				$this->tpl['table_ip_ranges'] = $construct->table($this->table_ip_ranges(), __FILE__);
				$this->tpl['table_dns'] = $construct->table($this->table_dns(), __FILE__);
				$this->tpl['table_nameservers'] = $construct->table($this->table_nameservers(), __FILE__);
				$this->tpl['table_links'] = $construct->table($this->table_links(), __FILE__);
				$t = $db->get('id, type', 'links', "node_id = '".get('node')."'");
				foreach( (array) $t as $key => $value) {
					if ($value['type'] == 'ap') $this->tpl['table_links_ap'][$value['id']] = $construct->table($this->table_links_ap($value['id']), __FILE__);
				}
				$this->tpl['table_subnets'] = $construct->table($this->table_subnets(), __FILE__);
				$this->tpl['table_ipaddr'] = $construct->table($this->table_ipaddr(), __FILE__);
				$this->tpl['table_photosview'] = $construct->table($this->table_photosview(), __FILE__);
				if ($this->has_owner_access()) $this->tpl['link_node_delete'] = makelink(array('action' => 'delete'), TRUE);
				$this->tpl['link_req_cclass'] = makelink(array('page' => 'mynodes', 'subpage' => 'range', 'node' => get('node')));
				$this->tpl['link_req_dns_for'] = makelink(array('page' => 'mynodes', 'subpage' => 'dnszone', 'type' => 'forward', 'node' => get('node'), 'zone' => 'add'));
				$this->tpl['link_req_dns_rev'] = makelink(array('page' => 'mynodes', 'subpage' => 'dnszone', 'type' => 'reverse', 'node' => get('node'), 'zone' => 'add'));
				$this->tpl['link_nameserver_add'] = makelink(array('page' => 'mynodes', 'subpage' => 'dnsnameserver', 'node' => get('node'), 'nameserver' => 'add'));
				$this->tpl['link_link_add'] = makelink(array('page' => 'mynodes', 'subpage' => 'link', 'node' => get('node'), 'link' => 'add'));
				$this->tpl['link_subnet_add'] = makelink(array('page' => 'mynodes', 'subpage' => 'subnet', 'node' => get('node'), 'subnet' => 'add'));
				$this->tpl['link_ipaddr_add'] = makelink(array('page' => 'mynodes', 'subpage' => 'ipaddr', 'node' => get('node'), 'ipaddr' => 'add'));
			}
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
			$name_ns = $_POST['nodes__name_ns'];
		} else {
			$name_ns = validate_name_ns($_POST['nodes__name'], get('node'));
		}
		$_POST['nodes__latitude'] = str_replace(",", ".", $_POST['nodes__latitude']);
		$_POST['nodes__longitude'] = str_replace(",", ".", $_POST['nodes__longitude']);
		if (!isset($_POST['users_nodes__user_id'])) { $_POST['users_nodes__user_id'] = array(); }
		
		if (get('node') != 'add') {
			$old_v = $db->get('name, area_id', 'nodes', "id = '".get('node')."'");
			if ($old_v[0]['name'] != $_POST['nodes__name'] && 
					$db->cnt('dns_nameservers', "node_id = '".get('node')."'") > 0) {
				$main->message->set_fromlang('error', 'nodes_field_name', makelink("",TRUE));
				return;
			}
			if ($old_v[0]['area_id'] != $_POST['nodes__area_id'] && 
					$db->cnt('ip_ranges', "node_id = '".get('node')."'") > 0) {
				$main->message->set_fromlang('error', 'nodes_field_area_id', makelink("",TRUE));
				return;
			}
		}
		
		$ret = $ret && $form_node->db_set(array('date_in' => date_now(), 'name_ns' => $name_ns), "nodes", "id", get('node'));
		if ($ret && $main->userdata->privileges['admin'] === TRUE && get('node') != 'add' && get('node') != $_POST['nodes__id']) {
			$db->set('dns_nameservers', array('node_id' => $_POST['nodes__id']), "node_id = '".get('node')."'");
			$db->set('dns_zones', array('node_id' => $_POST['nodes__id']), "node_id = '".get('node')."'");
			$db->set('ip_addresses', array('node_id' => $_POST['nodes__id']), "node_id = '".get('node')."'");
			$db->set('ip_ranges', array('node_id' => $_POST['nodes__id']), "node_id = '".get('node')."'");
			$db->set('links', array('node_id' => $_POST['nodes__id']), "node_id = '".get('node')."'");
			$db->set('links', array('peer_node_id' => $_POST['nodes__id']), "peer_node_id = '".get('node')."'");
			$db->set('photos', array('node_id' => $_POST['nodes__id']), "node_id = '".get('node')."'");
			$db->set('subnets', array('node_id' => $_POST['nodes__id']), "node_id = '".get('node')."'");
			$db->set('subnets', array('client_node_id' => $_POST['nodes__id']), "client_node_id = '".get('node')."'");
			$db->set('users_nodes', array('node_id' => $_POST['nodes__id']), "node_id = '".get('node')."'");
			$ins_id = $_POST['nodes__id'];
		} else {
			$ins_id = (get('node')=='add' ? $db->insert_id : get('node'));
		}
		if ($ret && ($this->has_owner_access() || get('node')=='add')) {
			$ret = $ret && $form_node->db_set_multi(array(), "users_nodes", "node_id", $ins_id);
			if ($_POST['user_id_owner'] != '') {
				$ret = $ret && $db->del('users_nodes', "user_id = '".$_POST['user_id_owner']."' AND node_id = '".$ins_id."'");
				$ret = $ret && $db->add('users_nodes', array("user_id" => $_POST['user_id_owner'], "node_id" => $ins_id, 'owner' => 'Y'));
			}
		}
		if ($ret) {
			$main->message->set_fromlang('info', (get('node') == 'add'?'insert':'edit').'_success', makelink(array("node" => $ins_id),TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}
	
	function output_onpost_table_ip_ranges() {
		global $db, $main;
		$ret = TRUE;
		$ret = $ret && $db->set("ip_ranges", array('delete_req' => 'N'), "node_id = '".get('node')."'");
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->set("ip_ranges", array('delete_req' => 'Y'), "id = '".$value."'");
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'update_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

	function output_onpost_table_dns() {
		global $db, $main;
		$ret = TRUE;
		$ret = $ret && $db->set("dns_zones", array('delete_req' => 'N'), "node_id = '".get('node')."'");
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->set("dns_zones", array('delete_req' => 'Y'), "id = '".$value."'");
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'update_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

	function output_onpost_table_nameservers() {
		global $db, $main;
		$ret = TRUE;
		$ret = $ret && $db->set("dns_nameservers, ip_ranges, nodes", array('dns_nameservers.delete_req' => 'N'), "dns_nameservers.ip >= ip_ranges.ip_start AND dns_nameservers.ip <= ip_ranges.ip_end AND ip_ranges.node_id = '".get('node')."' AND ip_ranges.node_id = nodes.id");
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->set("dns_nameservers", array('delete_req' => 'Y'), "id = '".$value."'");
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'update_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

	function output_onpost_table_links() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("links", "id = '".$value."'");
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

	function output_onpost_table_links_ap() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("links", "id = '".$value."'");
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

	function output_onpost_table_subnets() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("subnets", "id = '".$value."'");
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

	function output_onpost_table_ipaddr() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("ip_addresses", "id = '".$value."'");
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}
	
	function output_onpost_table_photosview() {
		global $root_path, $vars, $db, $main;
		foreach( (array) $_POST['id'] as $key => $value) {
			$db->del("photos", "id = '".$value."'");
			$uploaddir = $vars['folders']['photos'];
			$filename = 'photo-'.$value.".*";
			delfile($root_path.$uploaddir.$filename);
			$filename = 'photo-'.$value."-*.*";
			delfile($root_path.$uploaddir.$filename);
		}
		foreach( (array) array('N','NE','E','SE','S','SW','W','NW', 'PANORAMIC') as $value) {
			if ($_FILES[$value]['tmp_name'] != '') {
				if (@!imagecreatefromjpeg($_FILES[$value]['tmp_name'])) continue;
				$db->add("photos", array('date_in' => date_now(), 'node_id' => get('node'), 'type' => 'view', 'view_point' => $value, 'info' => $_POST['info-'.$value]));
				$ins_id = $db->insert_id;
				$uploaddir = $vars['folders']['photos'];
				$filename = 'photo-'.$ins_id.'.jpg';
				$filename_s = 'photo-'.$ins_id.'-s.jpg';
				if (@move_uploaded_file($_FILES[$value]['tmp_name'], $root_path.$uploaddir.$filename) === FALSE) {
					$db->del("photos", "id = '".$ins_id."'");
					$main->message->set_fromlang("error", "upload_file_failed");
					return;
				}
				if ($value == 'PANORAMIC') {
					$image_s = resizeJPG($root_path.$uploaddir.$filename, 600, 200);
				} else {
					$image_s = resizeJPG($root_path.$uploaddir.$filename, 200, 200);
				}
				imagejpeg($image_s, $root_path.$uploaddir.$filename_s);
			} elseif ($_POST['info-'.$value] != '') {
				$db->set("photos", array('info' => $_POST['info-'.$value]), "node_id = '".get('node')."' AND view_point = '".$value."'");
			}
		}
		$main->message->set_fromlang('info', 'update_success', makelink("",TRUE));
	}

}

?>
