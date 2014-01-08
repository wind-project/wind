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

class admin_services_service {

	var $tpl;
	
	function admin_services_service() {
		
	}
	
	function form_services() {
		global $db, $vars;
		$form_services = new form(array('FORM_NAME' => 'form_services'));
		$form_services->db_data('services.id, services.title, services.protocol, services.port');
		$form_services->db_data_values("services", "id", get('service'));
		$form_services->db_data_remove('services__id');
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
		$ret = $form_services->db_set(array(),
								"services", "id", get('service'));
		
		if ($ret) {
			$main->message->set_fromlang('info', 'insert_success', make_ref('/admin/services'));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>
