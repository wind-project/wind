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

if (get('region') != '') include_once(ROOT_PATH."includes/pages/admin/admin_regions_region.php");

class admin_regions {

	var $tpl;
	var $page;
	
	function admin_regions() {
		if (get('region') != '') {
			$p = "admin_regions_region";
			$this->page = new $p;
		}		
	}
	
	function table_regions() {
		global $construct, $db, $main;
		$table_regions = new table(array('FORM_NAME' => 'table_regions', 'TABLE_NAME' => 'table_regions'));
		$table_regions->db_data(
			'regions.id, regions.name, regions.ip_start, regions.ip_end, regions.v6net, regions.v6prefix, regions.info',
			'regions',
			"",
			"",
			"ip_start ASC");
		for($i=1;$i<count($table_regions->data);$i++) {
			if (isset($table_regions->data[$i])) {
				$table_regions->data[$i]['ip_start'] = long2ip($table_regions->data[$i]['ip_start']);
				$table_regions->data[$i]['ip_end'] = long2ip($table_regions->data[$i]['ip_end']);
                $table_regions->data[$i]['v6net'] = inet_ntop($table_regions->data[$i]['v6net']); 
				$table_regions->info['EDIT'][$i] = make_ref('/admin/regions', array("region" => $table_regions->data[$i]['id']));
			}
		}
		$table_regions->info['EDIT_COLUMN'] = 'name';
		$table_regions->db_data_multichoice('region', 'id');
		$table_regions->info['MULTICHOICE_LABEL'] = 'delete';
		$table_regions->db_data_remove('id');
		return $table_regions;
	}
	
	function output() {
		if (get('region') != '') {
			return $this->page->output();
		} else {
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
			global $construct;
			$this->tpl['link_region_add'] = make_ref('/admin/regions', array('region' => 'add'));
			$this->tpl['table_regions'] = $construct->table($this->table_regions(), __FILE__);
			return template($this->tpl, __FILE__);
		}
	}

	function output_onpost_table_regions() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("regions", '', "id = '".$value."'");
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', self_ref());
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>