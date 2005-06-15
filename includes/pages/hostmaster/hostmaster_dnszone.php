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
		$ns = $db->get("ns.id AS value, ns.ip AS ip, IF(ns.name IS NOT NULL, CONCAT(ns.name, '.', n.name_ns), n.name_ns) AS name",
				"dns_nameservers AS ns, nodes AS n",
				"ns.node_id = n.id");
		foreach( (array) $ns as $key => $value) {
			$ns[$key]['name'] = strtolower($value['name'].".".$vars['dns']['ns_zone']);
			$ns[$key]['ip'] = long2ip($value['ip']);
			$ns[$key]['output'] = $ns[$key]['name'].' ['.$ns[$key]['ip'].']';
		}
		$form_zone->db_data_enum('dns_zones_nameservers.nameserver_id', $ns, TRUE);
		$form_zone->db_data_values("dns_zones", "id", get('zone'));
		$form_zone->db_data_values_multi("dns_zones_nameservers", "zone_id", get('zone'), 'nameserver_id');

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
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct, $db;
		$this->tpl['form_zone'] = $construct->form($this->form_zone(), __FILE__);
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
			$main->message->set_fromlang('info', 'edit_success', makelink("", TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>