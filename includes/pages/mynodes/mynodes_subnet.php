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
		global $db, $vars;
		$form_subnet = new form(array('FORM_NAME' => 'form_subnet'));
		$form_subnet->db_data('subnets.ip_start, subnets.ip_end, subnets.type, subnets.link_id, subnets.client_node_id');
		$links = $db->get("links.id AS value, IF(links.type = 'ap', CONCAT(links.type, ' - ', links.ssid), CONCAT(links.type, ' - ', nodes.name, ' (#',links.peer_node_id, ')')) AS output",
							"links
							LEFT JOIN nodes ON links.peer_node_id = nodes.id",
							"(links.type = 'ap' OR links.type = 'p2p') AND node_id = '".get('node')."'");
		$form_subnet->db_data_enum('subnets.link_id', $links);
		$form_subnet->db_data_enum('subnets.client_node_id', $db->get("id AS value, name AS output", "nodes"));
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
		$ret = $form_subnet->db_set(array('date_in' => date_now(), 'node_id' => get('node')),
								"subnets", "id", $subnet);
		
		if ($ret) {
			$main->message->set_fromlang('info', 'insert_success', makelink("", TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>