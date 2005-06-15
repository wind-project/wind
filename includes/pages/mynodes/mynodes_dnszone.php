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

class mynodes_dnszone {

	var $tpl;
	
	function mynodes_dnszone() {
		
	}
	
	function form_zone() {
		global $construct, $db, $vars;
		$form_zone = new form(array('FORM_NAME' => 'form_zone'));
		$form_zone->db_data((get('zone')=='add'?'dns_zones.name, dns_zones.info, ':'').'dns_zones_nameservers.nameserver_id');
		if (get('zone')=='add') {
			if (get('type') == 'reverse') {
				$ipr = $db->get("ip_start, ip_end",
						"ip_ranges",
						"node_id = '".get('node')."'");
				foreach( (array) $ipr as $key => $value) {
					$ipr[$key]['ip_start'] = long2ip($value['ip_start']);
					$ipr[$key]['ip_end'] = long2ip($value['ip_end']);
					$ipr[$key]['value'] = reverse_zone_from_ip($ipr[$key]['ip_start']);
					$ipr[$key]['output'] = $ipr[$key]['value']." [".$ipr[$key]['ip_start'].' - '.$ipr[$key]['ip_end']."]";
				}
				$form_zone->db_data_enum('dns_zones.name', $ipr);
			} else {
				$form_zone->data[0]['value'] = $db->get('name_ns', 'nodes', "id = '".get('node')."'");
				$form_zone->data[0]['value'] = $form_zone->data[0]['value'][0]['name_ns'];
			}
		}

		$ns = $db->get("ns.id AS value, ns.ip AS ip, IF(ns.name IS NOT NULL, CONCAT(ns.name, '.', n.name_ns), n.name_ns) AS name",
				"dns_nameservers AS ns, nodes AS n",
				"ns.node_id = n.id");
		foreach( (array) $ns as $key => $value) {
			$ns[$key]['name'] = strtolower($value['name'].".".$vars['dns']['ns_zone']);
			$ns[$key]['ip'] = long2ip($value['ip']);
			$ns[$key]['output'] = $ns[$key]['name'].' ['.$ns[$key]['ip'].']';
		}
		$form_zone->db_data_enum('dns_zones_nameservers.nameserver_id', $ns, TRUE);
		$form_zone->db_data_values_multi("dns_zones_nameservers", "zone_id", get('zone'), 'nameserver_id');
		return $form_zone;
	}

	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['dnszone_method'] = (get('zone') == 'add' ? 'request_'.get('type') : 'edit' );
		$this->tpl['form_zone'] = $construct->form($this->form_zone(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_zone() {
		global $construct, $main, $db;
		$form_zone = $this->form_zone();
		$ret = TRUE;
		$f = array();
		if (get('zone') == 'add') {
			$f = array('dns_zones.status' => 'pending', 'dns_zones.type' => get('type'), 'dns_zones.date_in' => date_now(), "dns_zones.node_id" => get('node'));
			$ret = $form_zone->db_set($f,
									"dns_zones", "id", get('zone'));
		}
		$ins_id = (get('zone')=='add' ? $db->insert_id : get('zone'));
		$ret = $ret && $form_zone->db_set_multi(array(), "dns_zones_nameservers", "zone_id", $ins_id);

		if ($ret) {
			$main->message->set_fromlang('info', 'request_dnszone_success', makelink("", TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>