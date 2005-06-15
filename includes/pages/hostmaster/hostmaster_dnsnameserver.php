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
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['form_nameserver'] = $construct->form($this->form_nameserver(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_nameserver() {
		global $construct, $main, $db;
		$form_nameserver = $this->form_nameserver();
		$_POST['dns_nameservers__ip'] = ip2long($_POST['dns_nameservers__ip']);
		$ret = $form_nameserver->db_set(array(),
							"dns_nameservers", "id", get('nameserver'));
		
		if ($ret) {
			$main->message->set_fromlang('info', 'edit_success', makelink("", TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>