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

class hostmaster_dnsnameserver {

	var $tpl;
	
	function hostmaster_dnsnameserver() {
		
	}
	
	function form_nameserver() {
		global $db, $vars;
		$form_nameserver = new form(array('FORM_NAME' => 'form_nameserver'));
		$form_nameserver->db_data('dns_nameservers.name, dns_nameservers.ip, dns_nameservers.status');
		$form_nameserver->db_data_values("dns_nameservers", "id", get('nameserver'));
		$form_nameserver->data[1]['value'] = long2ip($form_nameserver->data[1]['value']);
		return $form_nameserver;
	}
	
	function table_node_info() {
		global $db;
		$table_node_info = new table(array('TABLE_NAME' => 'table_node_info'));
		$table_node_info->db_data(
			'nodes.name AS nodes__name, nodes.id, nodes.date_in, nodes.info, areas.name AS areas__name, regions.name AS regions__name',
			'dns_nameservers ' .
			'LEFT JOIN nodes ON dns_nameservers.node_id = nodes.id
			LEFT JOIN areas ON nodes.area_id = areas.id
			LEFT JOIN regions ON areas.region_id = regions.id',
			"dns_nameservers.id = '".get('nameserver')."'");
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
			'dns_nameservers ' .
			'LEFT JOIN users_nodes ON users_nodes.node_id = dns_nameservers.node_id 
			LEFT JOIN users ON users_nodes.user_id = users.id',
			"dns_nameservers.id = '".get('nameserver')."'",
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
			LEFT JOIN dns_nameservers ON dns_nameservers.node_id = links.node_id
			LEFT JOIN links AS l_p ON links.peer_node_id = l_p.node_id AND links.node_id = l_p.peer_node_id
			LEFT JOIN nodes AS n_p ON links.peer_node_id = n_p.id
			LEFT JOIN links AS l_c ON links.peer_ap_id = l_c.id
			LEFT JOIN nodes AS n_c ON l_c.node_id = n_c.id',
			"dns_nameservers.id = '".get('nameserver')."' AND (links.type != 'p2p' OR l_p.node_id IS NOT NULL)",
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
	
	function table_dns() {
		global $db, $vars;
		$table_dns = new table(array('TABLE_NAME' => 'table_dns', 'FORM_NAME' => 'table_dns'));
		$table_dns->db_data(
			'dns_zones.id, dns_zones.name, dns_zones.date_in, dns_zones.status, dns_zones.type',
			'dns_zones ' .
			'INNER JOIN dns_zones_nameservers ON dns_zones_nameservers.zone_id = dns_zones.id',
			'dns_zones_nameservers.nameserver_id = '.get('nameserver'),
			"",
			"dns_zones.type ASC, dns_zones.date_in ASC");
		for($i=1;$i<count($table_dns->data);$i++) {
			if (isset($table_dns->data[$i])) {
				if ($table_dns->data[$i]['type'] == 'forward') $table_dns->data[$i]['name'] .= ".".$vars['dns']['root_zone'];
				$table_dns->info['EDIT'][$i] = makelink(array("page" => "hostmaster", "subpage" => "dnszone", "zone" => $table_dns->data[$i]['id']));
			}
		}
		$table_dns->info['EDIT_COLUMN'] = 'name';
		$table_dns->db_data_remove('id', 'type');
		$table_dns->db_data_translate('dns_zones__status');
		return $table_dns;
	}

	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct,$db,$main;
		if(get('action') === "delete")
		{
			$ret = $db->del("dns_nameservers, dns_zones_nameservers", 
					'dns_nameservers 
						LEFT JOIN dns_zones_nameservers ON dns_nameservers.id = dns_zones_nameservers.nameserver_id', 
					"dns_nameservers.id = '".get('nameserver')."'");
			if ($ret) {
				$main->message->set_fromlang('info', 'delete_success', makelink(array("page" => "hostmaster", "subpage" => "dnsnameservers")));
			} else {
				$main->message->set_fromlang('error', 'generic');		
			}
			return ;
		}
		$this->tpl['form_nameserver'] = $construct->form($this->form_nameserver(), __FILE__);
		$this->tpl['table_node_info'] = $construct->table($this->table_node_info(), __FILE__);
		$this->tpl['table_user_info'] = $construct->table($this->table_user_info(), __FILE__);
		$this->tpl['table_links'] = $construct->table($this->table_links(), __FILE__);
		$this->tpl['table_dns'] = $construct->table($this->table_dns(), __FILE__);
		$this->tpl['link_nameserver_delete'] = makelink (array("action" => "delete"),TRUE);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_nameserver() {
		global $construct, $main, $db;
		$form_nameserver = $this->form_nameserver();
		$_POST['dns_nameservers__ip'] = ip2long($_POST['dns_nameservers__ip']);
		$ret = $form_nameserver->db_set(array(),
							"dns_nameservers", "id", get('nameserver'));
		
		if ($ret) {
			$main->message->set_fromlang('info', 'edit_success', makelink(array("page" => "hostmaster", "subpage" => "dnsnameservers")));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>