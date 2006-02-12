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

class mynodes_ipaddr {

	var $tpl;
	
	function mynodes_ipaddr() {
		
	}
	
	function form_ipaddr() {
		global $db, $vars;
		$form_ipaddr = new form(array('FORM_NAME' => 'form_ipaddr'));
		$form_ipaddr->db_data('ip_addresses.hostname, ip_addresses.ip, ip_addresses.mac, ip_addresses.type, ip_addresses.always_on, ip_addresses.info');
		$form_ipaddr->db_data_values("ip_addresses", "id", get('ipaddr'));
		if (get('ipaddr') != 'add') {
			$form_ipaddr->data[1]['value'] = long2ip($form_ipaddr->data[1]['value']);
		}
		return $form_ipaddr;
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['ip_address_method'] = (get('ipaddr') == 'add' ? 'add' : 'edit' );
		$this->tpl['form_ipaddr'] = $construct->form($this->form_ipaddr(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_ipaddr() {
		global $construct, $main, $db;
		$form_ipaddr = $this->form_ipaddr();
		$ipaddr = get('ipaddr');
		$ret = TRUE;
		$_POST['ip_addresses__ip'] = ip2long($_POST['ip_addresses__ip']);
		$ret = $form_ipaddr->db_set(array('node_id' => intval(get('node'))),
								"ip_addresses", "id", $ipaddr);
		
		if ($ret) {
			$main->message->set_fromlang('info', 'insert_success', makelink(array("page" => "mynodes", "node" => get('node'))));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>