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

class mynodes_subnet {

	var $tpl;
	
	function mynodes_subnet() {
		
	}
	
	function form_subnet() {
		global $db, $vars, $lang;
		$form_subnet = new form(array('FORM_NAME' => 'form_subnet'));
		$form_subnet->db_data('subnets.ip_start, subnets.ip_end, subnets.type, subnets.link_id, subnets.client_node_id');
		$links = $db->get('links.id AS value, links.type, links.ssid, nodes.name, links.peer_node_id, "" AS output',
							"links
							LEFT JOIN nodes ON links.peer_node_id = nodes.id",
							"(links.type = 'ap' OR links.type = 'p2p') AND node_id = ".intval(get('node')),
							"",
							"links.type ASC, links.date_in ASC");
		foreach ( (array) $links as $key => $value) {
			$links[$key]['output'] .= $lang['db']['links__type-'.$value['type']].' - ';
			if ($value['type'] == 'ap') {
				$links[$key]['output'] .= $links[$key]['ssid'];
			}
			if ($value['type'] == 'p2p') {
				$links[$key]['output'] .= $links[$key]['name'].' (#'.$links[$key]['peer_node_id'].')';
			}
		}
		$form_subnet->db_data_enum('subnets.link_id', $links);

		$clients = $db->get('cl_n.id AS value, ap_l.ssid, cl_n.name, cl_n.id, "" AS output',
							"links AS cl_l " .
							"LEFT JOIN links AS ap_l ON cl_l.peer_ap_id = ap_l.id
							LEFT JOIN nodes AS ap_n ON ap_l.node_id = ap_n.id " .
							"LEFT JOIN nodes AS cl_n ON cl_l.node_id = cl_n.id",
							"cl_l.type = 'client' AND ap_l.type = 'ap' AND ap_l.node_id = ".intval(get('node')),
							"",
							"ap_l.date_in ASC, cl_l.date_in ASC");
		foreach ( (array) $clients as $key => $value) {
			$clients[$key]['output'] = '['.$lang['db']['links__type-ap'].' '.$clients[$key]['ssid'].'] - '.$clients[$key]['name'].' (#'.$clients[$key]['id'].')';
		}
		$form_subnet->db_data_enum('subnets.client_node_id', $clients);

		$form_subnet->db_data_values("subnets", "id", get('subnet'));
		if (get('subnet') != 'add') {
			$form_subnet->data[0]['value'] = long2ip($form_subnet->data[0]['value']);
			$form_subnet->data[1]['value'] = long2ip($form_subnet->data[1]['value']);
		}
		return $form_subnet;
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['subnet_method'] = (get('subnet') == 'add' ? 'add' : 'edit' );
		$this->tpl['form_subnet'] = $construct->form($this->form_subnet(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_subnet() {
		global $main, $db;
		$form_subnet = $this->form_subnet();
		$subnet = get('subnet');
		$ret = TRUE;
		$_POST['subnets__ip_start'] = ip2long($_POST['subnets__ip_start']);
		$_POST['subnets__ip_end'] = ip2long($_POST['subnets__ip_end']);
		if ($_POST['subnets__type'] == 'link') {
			if ($db->cnt(
				'',
				'ip_ranges',
				"node_id = ".intval(get('node'))." AND ip_ranges.ip_start <= '".$_POST['subnets__ip_start']."' AND ip_ranges.ip_end >= '".$_POST['subnets__ip_start']."' " .
						"AND ip_ranges.ip_start <= '".$_POST['subnets__ip_end']."' AND ip_ranges.ip_end >= '".$_POST['subnets__ip_end']."'") == 0) {
					$main->message->set_fromlang('error', 'subnet_backbone_no_ip_range');
					return;
				}
		}
		$ret = $form_subnet->db_set(array('node_id' => intval(get('node'))),
								"subnets", "id", $subnet);
		
		if ($ret) {
			$main->message->set_fromlang('info', 'insert_success', makelink(array("page" => "mynodes", "node" => get('node'))));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>