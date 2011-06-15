<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
 * Copyright (C) 2009 Vasilis Tsiligiannis <b_tsiligiannis@silverton.gr>
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

if (get('area') != '') include_once(ROOT_PATH."includes/pages/admin/admin_areas_area.php");

class admin_areas {

	var $tpl;
	var $page;
	
	function admin_areas() {
		if (get('area') != '') {
			$p = "admin_areas_area";
			$this->page = new $p;
		}		
	}
	
	function table_areas() {
		global $construct, $db, $main;
		$table_areas = new table(array('FORM_NAME' => 'table_areas', 'TABLE_NAME' => 'table_areas'));
		$table_areas->db_data(
			'areas.id, areas.name AS areas__name, areas.ip_start, areas.ip_end, areas.info, regions.name AS regions__name',
			'areas ' .
			'LEFT JOIN regions ON regions.id = areas.region_id',
			"",
			"",
			"areas.ip_start ASC");
		for($i=1;$i<count($table_areas->data);$i++) {
			if (isset($table_areas->data[$i])) {
				$table_areas->data[$i]['ip_start'] = long2ip($table_areas->data[$i]['ip_start']);
				$table_areas->data[$i]['ip_end'] = long2ip($table_areas->data[$i]['ip_end']);
				$table_areas->info['EDIT'][$i] = makelink(array("page" => "admin", "subpage" => "areas", "area" => $table_areas->data[$i]['id']));
			}
		}
		$table_areas->info['EDIT_COLUMN'] = 'areas__name';
		$table_areas->db_data_multichoice('region', 'id');
		$table_areas->info['MULTICHOICE_LABEL'] = 'delete';
		$table_areas->db_data_remove('id');
		return $table_areas;
	}
	
	function output() {
		if (get('area') != '') {
			return $this->page->output();
		} else {
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
			global $construct;
			$this->tpl['link_area_add'] = makelink(array('page' => 'admin', 'subpage' => 'areas', 'area' => 'add'));
			$this->tpl['table_areas'] = $construct->table($this->table_areas(), __FILE__);
			return template($this->tpl, __FILE__);
		}
	}

	function output_onpost_table_areas() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("areas", '', "id = '".$value."'");
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>