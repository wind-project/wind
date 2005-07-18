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

class hostmaster_dnszone {

	var $tpl;
	
	function hostmaster_dnszone() {
		
	}
	
	function form_zone() {
		global $db, $vars;
		$form_zone = new form(array('FORM_NAME' => 'form_zone'));
		$form_zone->db_data('dns_zones.name, dns_zones.info, dns_zones_nameservers.nameserver_id, dns_zones.status');
		$form_zone->db_data_values("dns_zones", "id", get('zone'));
		
		$form_zone->db_data_pickup("dns_zones_nameservers.nameserver_id", "dns_nameservers", $db->get('dns_nameservers.id AS value, CONCAT(dns_nameservers.name, ".", nodes.name_ns, ".", "'.$vars['dns']['ns_zone'].'") AS output', "dns_zones_nameservers, dns_nameservers, nodes", "dns_nameservers.node_id = nodes.id AND dns_nameservers.id = dns_zones_nameservers.nameserver_id AND dns_zones_nameservers.zone_id = '".get('zone')."'"), TRUE);

		$tmp = $db->get('users.email, users_nodes.owner', 'users, users_nodes, dns_zones', "users_nodes.user_id = users.id AND users_nodes.node_id = dns_zones.node_id AND dns_zones.id = '".get("zone")."'");
		foreach( (array) $tmp as $key => $value) {
			$form_zone->info['email_all'] .= $value['email'].', ';
			if ($value['owner'] == 'Y') $form_zone->info['email_owner'] .= $value['email'].', ';
		}
		$form_zone->info['email_all'] = substr($form_zone->info['email_all'], 0, -2);
		$form_zone->info['email_owner'] = substr($form_zone->info['email_owner'], 0, -2);
		$t = $db->get('nodes.id, nodes.name', 'nodes, dns_zones', "dns_zones.node_id = nodes.id AND dns_zones.id = '".get('zone')."'");
		$form_zone->info['node_name'] = $t[0]['name'];
		$form_zone->info['node_id'] = $t[0]['id'];
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
		return $table_node_info;
	}

	function table_user_info() {
		global $db;
		$table_user_info = new table(array('TABLE_NAME' => 'table_user_info'));
		$table_user_info->db_data(
			'users_nodes.owner, users.username, users.surname, users.name, users.name, users.email, users.phone, users.info',
			'dns_zones ' .
			'LEFT JOIN users_nodes ON users_nodes.node_id = dns_zones.node_id 
			LEFT JOIN users ON users_nodes.user_id = users.id',
			"dns_zones.id = '".get('zone')."'",
			'',
			'users_nodes.owner ASC');
		$table_user_info->db_data_translate('users_nodes__owner');
		return $table_user_info;
	}

	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct, $db;
		$this->tpl['form_zone'] = $construct->form($this->form_zone(), __FILE__);
		$this->tpl['table_node_info'] = $construct->table($this->table_node_info(), __FILE__);
		$this->tpl['table_user_info'] = $construct->table($this->table_user_info(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_zone() {
		global $construct, $main, $db;
		$form_zone = $this->form_zone();
		$ret = TRUE;
		$ret = $form_zone->db_set(array(),
								"dns_zones", "id", get('zone'));
		
		$ret = $ret && $form_zone->db_set_multi(array(), "dns_zones_nameservers", "zone_id", get('zone'));		

		if ($_POST['sendmail'] == 'Y') {
			$_POST['email_to'] = str_replace(";", ", ", $_POST['email_to']);
			if ($ret) $ret = $ret && sendmail($_POST['email_to'], $_POST['email_subject'], $_POST['email_body']);
		}
		
		if ($ret) {
			$main->message->set_fromlang('info', 'edit_success', makelink(array("page" => "hostmaster", "subpage" => "dnszones")));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>