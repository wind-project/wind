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

class node_editor_subnet_v6 {

	var $tpl;

	function __construct() {
	}

	function form_subnet_v6() {
		global $db, $vars, $lang;
		$form_subnet = new form(array('FORM_NAME' => 'form_subnet_v6'));
		$form_subnet->db_data('subnets_v6.v6net, subnets_v6.v6prefix, subnets_v6.ipv6_end, subnets_v6.type, subnets_v6.link_id, subnets_v6.client_node_id');
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
		$form_subnet->db_data_enum('subnets_v6.link_id', $links);

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
		$form_subnet->db_data_enum('subnets_v6.client_node_id', $clients);

		$form_subnet->db_data_values("subnets_v6", "id", get('subnet'));
		if (get('subnet_v6') != 'add') {
			$form_subnet->data[0]['value'] = @inet_ntop($form_subnet->data[0]['value']);
			$form_subnet->data[2]['value'] = @inet_ntop($form_subnet->data[2]['value']);
		}
		return $form_subnet;
	}

	function output() {
		global $construct;
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name']))
			return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));

		$this->tpl['subnet_v6_method'] = (get('subnet_v6') == 'add' ? 'add' : 'edit' );
		$this->tpl['form_subnet_v6'] = $construct->form($this->form_subnet_v6(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_subnet_v6() {
		global $main, $db;
		$form_subnet = $this->form_subnet_v6();
		$subnet = get('subnet_v6');
		$ret = TRUE;
		//$_POST['subnets_v6__v6net'] = @inet_ntop(@inet_pton($_POST['subnets_v6__v6net']));
		$ipv6_calc = ipv6_calc($_POST['subnets_v6__v6net'],$_POST['subnets_v6__v6prefix']);
		$_POST['subnets_v6__v6net'] = @inet_pton($ipv6_calc['ipv6_start']);
		$_POST['subnets_v6__ipv6_end'] = @inet_pton($ipv6_calc['ipv6_end']);
		if ($_POST['subnets__type'] == 'link') {
			if ($db->cnt(
				'',
				'ip_ranges_v6',
				"node_id = ".intval(get('node'))." AND ip_ranges_v6.v6net <= '".$_POST['subnets_v6__v6net']."' AND ip_ranges_v6.ipv6_end >= '".$_POST['subnets_v6__v6net']."' " .
						"AND ip_ranges_v6.v6net <= '".$_POST['subnets_v6__ipv6_end']."' AND ip_ranges_v6.ipv6_end >= '".$_POST['subnets_v6__ipv6_end']."'") == 0) {
					$main->message->set_fromlang('error', 'subnet_backbone_no_ip_range');
					return;
				}
		}
		$ret = $form_subnet->db_set(array('node_id' => intval(get('node'))), "subnets_v6", "id", $subnet);

		if ($ret) {
			$main->message->set_fromlang('info', 'insert_success', make_ref('/node_editor', array("node" => get('node'))));
		} else {
			$main->message->set_fromlang('error', 'generic');
		}
	}

}

?>
