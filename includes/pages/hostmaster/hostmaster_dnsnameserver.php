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
		return $table_node_info;
	}

	function table_user_info() {
		global $db;
		$table_user_info = new table(array('TABLE_NAME' => 'table_user_info'));
		$table_user_info->db_data(
			'users_nodes.owner, users.username, users.surname, users.name, users.name, users.email, users.phone, users.info',
			'dns_nameservers ' .
			'LEFT JOIN users_nodes ON users_nodes.node_id = dns_nameservers.node_id 
			LEFT JOIN users ON users_nodes.user_id = users.id',
			"dns_nameservers.id = '".get('nameserver')."'",
			'',
			'users_nodes.owner ASC');
		$table_user_info->db_data_translate('users_nodes__owner');
		return $table_user_info;
	}

	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['form_nameserver'] = $construct->form($this->form_nameserver(), __FILE__);
		$this->tpl['table_node_info'] = $construct->table($this->table_node_info(), __FILE__);
		$this->tpl['table_user_info'] = $construct->table($this->table_user_info(), __FILE__);
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