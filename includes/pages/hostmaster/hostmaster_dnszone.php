<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
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

class hostmaster_dnszone {

	var $tpl;
	
	function hostmaster_dnszone() {
		
	}
	
	function form_zone() {
		global $db, $vars, $main;
		$form_zone = new form(array('FORM_NAME' => 'form_zone'));
		$form_zone->db_data('dns_zones.name, dns_zones.info, dns_zones_nameservers.nameserver_id, dns_zones.status');
		$form_zone->db_data_values("dns_zones", "id", get('zone'));
		
		$form_zone->db_data_pickup("dns_zones_nameservers.nameserver_id", "dns_nameservers", $db->get('dns_nameservers.id AS value, CONCAT(dns_nameservers.name, ".", nodes.name_ns, ".", "'.$vars['dns']['ns_zone'].'") AS output', "dns_zones_nameservers, dns_nameservers, nodes", "dns_nameservers.node_id = nodes.id AND dns_nameservers.id = dns_zones_nameservers.nameserver_id AND dns_zones_nameservers.zone_id = '".get('zone')."'"), TRUE);

		$tmp = $db->get('users.email, users_nodes.owner', 'users, users_nodes, dns_zones', "users_nodes.user_id = users.id AND users_nodes.node_id = dns_zones.node_id AND dns_zones.id = '".get("zone")."'");
		if (!isset($form_zone->info['email_all'])) $form_zone->info['email_all'] = '';
		if (!isset($form_zone->info['email_owner'])) $form_zone->info['email_owner'] = '';
		foreach( (array) $tmp as $key => $value) {
			$form_zone->info['email_all'] .= $value['email'].', ';
			if ($value['owner'] == 'Y') $form_zone->info['email_owner'] .= $value['email'].', ';
		}
		$form_zone->info['email_all'] = substr($form_zone->info['email_all'], 0, -2);
		$form_zone->info['email_owner'] = substr($form_zone->info['email_owner'], 0, -2);
		$t = $db->get('nodes.id, nodes.name', 'nodes, dns_zones', "dns_zones.node_id = nodes.id AND dns_zones.id = '".get('zone')."'");
		$form_zone->info['node_name'] = $t[0]['name'];
		$form_zone->info['node_id'] = $t[0]['id'];
		$form_zone->info['hostmaster_username'] = $main->userdata->info['username'];
		$form_zone->info['hostmaster_name'] = $main->userdata->info['name'];
		$form_zone->info['hostmaster_surname'] = $main->userdata->info['surname'];
		$t = $db->get('type', 'dns_zones', "id = '".get('zone')."'");
		if ($t[0]['type'] == 'forward') $form_zone->data[0]['value'] .= ".".$vars['dns']['root_zone'];
		return $form_zone;
	}
	
	function table_node_info() {
		global $db;
		$table_node_info = new table(array('TABLE_NAME' => 'table_node_info'));
		$table_node_info->db_data(
			'nodes.name AS nodes__name, nodes.id, nodes.date_in, nodes.info, areas.name AS areas__name, regions.name AS regions__name',
			'dns_zones ' .
			'LEFT JOIN nodes ON dns_zones.node_id = nodes.id
			LEFT JOIN areas ON nodes.area_id = areas.id
			LEFT JOIN regions ON areas.region_id = regions.id',
			"dns_zones.id = '".get('zone')."'");
		for($i=1;$i<count($table_node_info->data);$i++) {
			if (isset($table_node_info->data[$i])) {
				$table_node_info->data[$i]['nodes__name'] .= " (#".$table_node_info->data[$i]['id'].")";
				$table_node_info->info['EDIT'][$i] = makelink(array("page" => "mynodes", "node" => $table_node_info->data[$i]['id']));
			}
		}
		$table_node_info->info['EDIT_COLUMN'] = 'nodes__name';
		$table_node_info->db_data_remove('id');
		return $table_node_info;
	}

	function table_user_info() {
		global $db;
		$table_user_info = new table(array('TABLE_NAME' => 'table_user_info'));
		$table_user_info->db_data(
			'users.id, users.username, users_nodes.owner, users.surname, users.name, users.name, users.email, users.phone, users.info',
			'dns_zones ' .
			'LEFT JOIN users_nodes ON users_nodes.node_id = dns_zones.node_id 
			LEFT JOIN users ON users_nodes.user_id = users.id',
			"dns_zones.id = '".get('zone')."'",
			'',
			'users_nodes.owner ASC');
		for($i=1;$i<count($table_user_info->data);$i++) {
			if (isset($table_user_info->data[$i])) {
				$table_user_info->info['EDIT'][$i] = makelink(array("page" => "users", "user" => $table_user_info->data[$i]['id']));
			}
		}
		$table_user_info->info['EDIT_COLUMN'] = 'username';
		$table_user_info->db_data_remove('id');
		$table_user_info->db_data_translate('users_nodes__owner');
		return $table_user_info;
	}

	function table_links() {
		global $db;
		$table_links = new table(array('TABLE_NAME' => 'table_links', 'FORM_NAME' => 'table_links'));
		$table_links->db_data(
			'links.id, links.type, "" AS peer, links.peer_node_id, n_p.name AS peer_node_name, n_c.name AS peer_ap_nodename, n_c.id AS peer_ap_nodeid, l_c.ssid AS peer_ap_ssid, links.ssid, links.status AS links__status, l_p.status AS l_p__status, l_c.status AS l_c__status',
			'links
			LEFT JOIN dns_zones ON dns_zones.node_id = links.node_id
			LEFT JOIN links AS l_p ON links.peer_node_id = l_p.node_id AND links.node_id = l_p.peer_node_id
			LEFT JOIN nodes AS n_p ON links.peer_node_id = n_p.id
			LEFT JOIN links AS l_c ON links.peer_ap_id = l_c.id
			LEFT JOIN nodes AS n_c ON l_c.node_id = n_c.id',
			"dns_zones.id = '".get('zone')."' AND (links.type != 'p2p' OR l_p.node_id IS NOT NULL)",
			"",
			"links.type ASC, links.date_in ASC");
		for($i=1;$i<count($table_links->data);$i++) {
			if (isset($table_links->data[$i])) {
				if ($table_links->data[$i]['type'] == 'p2p') {
					$table_links->data[$i]['peer'] = $table_links->data[$i]['peer_node_name']." (#".$table_links->data[$i]['peer_node_id'].")";
					$table_links->data[$i]['links__status'] = ($table_links->data[$i]['l_p__status']=="inactive"?"inactive":$table_links->data[$i]['links__status']);
				}
				if ($table_links->data[$i]['type'] == 'client') {
					$table_links->data[$i]['peer'] = $table_links->data[$i]['peer_ap_nodename']." (#".$table_links->data[$i]['peer_ap_nodeid'].")";
					$table_links->data[$i]['ssid'] = $table_links->data[$i]['peer_ap_ssid'];
					$table_links->data[$i]['links__status'] = ($table_links->data[$i]['l_c__status']=="inactive"?"inactive":$table_links->data[$i]['links__status']);
				}				
			}
		}
		$table_links->db_data_remove('id', 'peer_node_id', 'peer_node_name', 'peer_ap_nodename', 'peer_ap_nodeid', 'peer_ap_ssid', 'l_c__status', 'l_p__status');
		$table_links->db_data_translate('links__type', 'links__status');
		return $table_links;
	}
	
	function table_ip_ranges() {
		global $db;
		$table_ip_ranges = new table(array('TABLE_NAME' => 'table_ip_ranges', 'FORM_NAME' => 'table_ip_ranges'));
		$table_ip_ranges->db_data(
			'"" AS ip_range, ip_ranges.ip_start, ip_ranges.ip_end, ip_ranges.date_in, ip_ranges.status',
			'ip_ranges ' .
			'LEFT JOIN dns_zones ON dns_zones.node_id = ip_ranges.node_id',
			"dns_zones.id = '".get('zone')."'",
			"",
			"ip_ranges.date_in ASC");
		foreach( (array) $table_ip_ranges->data as $key => $value) {
			if ($key != 0) {
				$table_ip_ranges->data[$key]['ip_start'] = long2ip($table_ip_ranges->data[$key]['ip_start']);
				$table_ip_ranges->data[$key]['ip_end'] = long2ip($table_ip_ranges->data[$key]['ip_end']);
				$table_ip_ranges->data[$key]['ip_range'] = $table_ip_ranges->data[$key]['ip_start']." - ".$table_ip_ranges->data[$key]['ip_end'];
			}
		}
		$table_ip_ranges->db_data_remove('ip_start', 'ip_end');
		$table_ip_ranges->db_data_translate('ip_ranges__status');
		return $table_ip_ranges;
	}

	function table_dns() {
		global $db, $vars;
		$table_dns = new table(array('TABLE_NAME' => 'table_dns', 'FORM_NAME' => 'table_dns'));
		$table_dns->db_data(
			'dns_zones.id, dns_zones.name, dns_zones.date_in, dns_zones.status, dns_zones.type',
			'dns_zones ' .
			'LEFT JOIN dns_zones AS t_dns_zones ON t_dns_zones.node_id = dns_zones.node_id',
			't_dns_zones.id = '.get('zone'),
			"",
			"dns_zones.type ASC, dns_zones.date_in ASC");
		for($i=1;$i<count($table_dns->data);$i++) {
			if (isset($table_dns->data[$i])) {
				if ($table_dns->data[$i]['type'] == 'forward') $table_dns->data[$i]['name'] .= ".".$vars['dns']['root_zone'];
				$table_dns->info['EDIT'][$i] = makelink(array("page" => "hostmaster", "subpage" => "dnszone", "zone" => $table_dns->data[$i]['id'], "node" => intval(get('node'))));
			}
		}
		$table_dns->info['EDIT_COLUMN'] = 'name';
		$table_dns->db_data_remove('id', 'type');
		$table_dns->db_data_translate('dns_zones__status');
		return $table_dns;
	}

	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct, $db, $main;
		if(get('action') === "delete")
		{
			$ret = $db->del("dns_zones, dns_zones_nameservers", 
					'dns_zones 
						LEFT JOIN dns_zones_nameservers ON dns_zones.id = dns_zones_nameservers.zone_id', 
					"dns_zones.id = '".get('zone')."'");
			if ($ret) {
				$main->message->set_fromlang('info', 'delete_success', makelink(array("page" => "hostmaster", "subpage" => "dnszones")));
			} else {
				$main->message->set_fromlang('error', 'generic');		
			}
			return ;
		}
		$this->tpl['form_zone'] = $construct->form($this->form_zone(), __FILE__);
		$this->tpl['table_node_info'] = $construct->table($this->table_node_info(), __FILE__);
		$this->tpl['table_user_info'] = $construct->table($this->table_user_info(), __FILE__);
		$this->tpl['table_links'] = $construct->table($this->table_links(), __FILE__);
		$this->tpl['table_ip_ranges'] = $construct->table($this->table_ip_ranges(), __FILE__);
		$this->tpl['table_dns'] = $construct->table($this->table_dns(), __FILE__);
		$this->tpl['link_dnszone_delete'] = makelink (array("action" => "delete"),TRUE);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_zone() {
		global $construct, $main, $db, $vars;
		if (substr($_POST['dns_zones__name'], -strlen($vars['dns']['root_zone'])-1) == ".".$vars['dns']['root_zone']) {
			$_POST['dns_zones__name'] = substr($_POST['dns_zones__name'], 0, -strlen($vars['dns']['root_zone'])-1);
		}
		$form_zone = $this->form_zone();
		$ret = TRUE;
		$ret = $form_zone->db_set(array(),
								"dns_zones", "id", get('zone'));
		
		$ret = $ret && $form_zone->db_set_multi(array(), "dns_zones_nameservers", "zone_id", get('zone'));		

		if ($_POST['sendmail'] == 'Y') {
			$_POST['email_to'] = str_replace(";", ", ", $_POST['email_to']);
			if ($ret) $ret = $ret && sendmail(stripslashes($_POST['email_to']), stripslashes($_POST['email_subject']), stripslashes($_POST['email_body']), '', '', TRUE);
		}
		
		if ($ret) {
			$main->message->set_fromlang('info', 'edit_success', makelink(array("page" => "hostmaster", "subpage" => "dnszones")));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>