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

if (get('service') != '') include_once(ROOT_PATH."includes/pages/admin/admin_services_service.php");

class admin_services {

	var $tpl;
	var $page;

	function admin_services() {
		if (get('service') != '') {
			$p = "admin_services_service";
			$this->page = new $p;
		}
	}
	
	function table_services() {
		global $construct, $db, $main;
		$table_services = new table(array('TABLE_NAME' => 'table_services', 'FORM_NAME' => 'table_services'));
		$table_services->db_data(
			'services.id, services.title, services.protocol, services.port',
			'services',
			'',
			'',
			"services.title ASC");
		foreach( (array) $table_services->data as $key => $value) {
			if ($key != 0) {
				$table_services->info['EDIT'][$key] = makelink(array("page" => "admin", "subpage" => "services", "service" => $table_services->data[$key]['id']));
			}
		}
		$table_services->info['EDIT_COLUMN'] = 'title';
		$table_services->db_data_translate('services__protocol');
		$table_services->db_data_multichoice('services', 'id');
		$table_services->info['MULTICHOICE_LABEL'] = 'delete';
		$table_services->db_data_remove('id');
		return $table_services;
	}
	
	function output() {
		global $construct;
		if (get('service') != '') {
			return $this->page->output();
		} else {
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
			$this->tpl['link_services_categories_add'] = makelink(array('page' => 'admin', 'subpage' => 'services', 'service' => 'add'));
			$this->tpl['table_services'] = $construct->table($this->table_services(), __FILE__);
			return template($this->tpl, __FILE__);
		}
	}

	function output_onpost_table_services() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("services", '', "id = '".$value."'");
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', makelink("", true));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>
