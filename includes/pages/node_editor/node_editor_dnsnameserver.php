<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005-2013 	by WiND Contributors (see AUTHORS.txt)
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

class node_editor_dnsnameserver {

	var $tpl;
	
	function __construct() {
		
	}
	
	function form_nameserver() {
		global $db, $vars;
		$form_nameserver = new form(array('FORM_NAME' => 'form_nameserver'));
		$form_nameserver->db_data('dns_nameservers.name'.(get('nameserver') == 'add'?", dns_nameservers.ip":""));
		$form_nameserver->db_data_values("dns_nameservers", "id", get('nameserver'));
		return $form_nameserver;
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['nameserver_method'] = (get('nameserver') == 'add' ? 'add' : 'edit' );
		$this->tpl['form_nameserver'] = $construct->form($this->form_nameserver(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_nameserver() {
		global $construct, $main, $db;
		$form_nameserver = $this->form_nameserver();
		$nameserver = get('nameserver');
		if (get('nameserver') == 'add') {
			$_POST['dns_nameservers__ip'] = ip2long($_POST['dns_nameservers__ip']);
		}
		$f['node_id'] = intval(get('node'));
		$ret = TRUE;
		$ret = $form_nameserver->db_set($f,
								"dns_nameservers", "id", $nameserver);
		
		if ($ret) {
			$main->message->set_fromlang('info', (get('zone') == 'add'?'request_dnsnameserver_success':'edit_success'), make_ref("/node_editor", array("node" => intval(get('node')))));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>