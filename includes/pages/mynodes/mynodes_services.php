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

class mynodes_services {

	var $tpl;
	
	function mynodes_services() {
		
	}
	
	function form_services() {
		global $db, $vars;
		$form_services = new form(array('FORM_NAME' => 'form_services'));
		$form_services->db_data(
			'nodes_services.service_id, nodes_services.id, nodes_services.node_id, nodes.id AS nodes__id, nodes_services.ip_id, nodes_services.url, nodes_services.info, nodes_services.status, nodes_services.protocol, nodes_services.port',
			'nodes_services',
			'',
			'',
			"");

		$form_services->db_data_enum('nodes_services.service_id', $db->get("id AS value, title AS output", "services", "", "", "title ASC"));

		$ips = $db->get("ip_addresses.id AS value, ip_addresses.hostname AS hostname, ip_addresses.ip AS ip",
						"ip_addresses " .
						"INNER JOIN subnets ON subnets.node_id = ip_addresses.node_id AND ip_addresses.ip <= subnets.ip_end AND ip_addresses.ip >= subnets.ip_start", 
						"ip_addresses.node_id = ".intval(get('node'))." AND subnets.type = 'local'",
						"subnets.ip_start ASC, ip_addresses.ip ASC");
		foreach ((array) $ips as $key => $value) {
			$ips[$key]['output'] = $ips[$key]['hostname']." [".long2ip($ips[$key]['ip'])."]";
		}
		$form_services->db_data_enum('nodes_services.ip_id', $ips);

		$form_services->db_data_values("nodes_services", "id", get('service'));
		if (get('service') != 'add') {
			$form_services->db_data_pickup('nodes_services.node_id', "nodes", $db->get("nodes_services.node_id AS value, CONCAT(nodes.name, ' (#', nodes.id, ')') AS output", "nodes_services, nodes", "nodes_services.node_id = nodes.id AND nodes_services.id = ".get("service")));
		} else {
			$form_services->db_data_pickup('nodes_services.node_id', "nodes", $db->get("nodes.id AS value, CONCAT(nodes.name, ' (#', nodes.id, ')') AS output", "nodes", "nodes.id = ".get("node")));
		}
		$form_services->db_data_remove('nodes_services__id');
		return $form_services;
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['services_method'] = (get('service') == 'add' ? 'add' : 'edit' );
		$this->tpl['form_services'] = $construct->form($this->form_services(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_services() {
		global $construct, $main, $db;
		$form_services = $this->form_services();
		$service = get('service');
		$ret = TRUE;
		$_POST['nodes_services__url'] = url_fix($_POST['nodes_services__url']);
		$ret = $form_services->db_set(array(),
								"nodes_services", "id", $service);
		
		if ($ret) {
			$main->message->set_fromlang('info', 'insert_success', makelink(array("page" => "mynodes", "node" => $_POST['nodes_services__node_id'])));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>