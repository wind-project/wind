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

class ranges_allocation {

	var $tpl;
	
	function ranges_allocation() {
		
	}
	
	function form_search_ranges() {
		global $construct, $db;
		$form_search_ranges = new form(array('FORM_NAME' => 'form_search_ranges'));
		$form_search_ranges->data = array("0" => array("Field" => "ip", "fullField" => "ip"));
		$form_search_ranges->db_data('areas.status, ip_ranges.delete_req');
		$form_search_ranges->db_data_search();
		return $form_search_ranges;
	}

	function table_areas() {
		global $construct, $db;
		$table_areas = new table(array('TABLE_NAME' => 'table_areas', 'FORM_NAME' => 'table_areas'));
		$table_areas->db_data(
			'"" AS ip_range, areas.v6net, areas.v6prefix, areas.name AS areas__name, regions.name AS regions__name, areas.ip_start, areas.ip_end',
			'areas
			LEFT JOIN regions ON areas.region_id = regions.id',
			"",
			"",
			"areas.ip_start ASC");
		foreach( (array) $table_areas->data as $key => $value) {
			if ($key != 0) {
				$table_areas->data[$key]['ip_start'] = long2ip($table_areas->data[$key]['ip_start']);
				$table_areas->data[$key]['ip_end'] = long2ip($table_areas->data[$key]['ip_end']);
				$table_areas->data[$key]['ip_range'] = $table_areas->data[$key]['ip_start']." - ".$table_areas->data[$key]['ip_end'];
                                $table_areas->data[$key]['v6net'] = @inet_ntop($table_areas->data[$key]['v6net']);
			}
		}
		$table_areas->db_data_remove('ip_start', 'ip_end');
		return $table_areas;
	}

	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['table_areas'] = $construct->table($this->table_areas(), __FILE__);
		return template($this->tpl, __FILE__);
	}

}

?>