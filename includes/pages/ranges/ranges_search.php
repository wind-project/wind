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

class ranges_search {

	var $tpl;
	
	function ranges_search() {
		
	}
	
	function form_search_ranges() {
		global $construct, $db;
		$form_search_ranges = new form(array('FORM_NAME' => 'form_search_ranges'));
		$form_search_ranges->data = array("0" => array("Field" => "ip", "fullField" => "ip"));
		$form_search_ranges->db_data('ip_ranges.status');
		$form_search_ranges->db_data_search();
		return $form_search_ranges;
	}

	function table_ip_ranges() {
		global $construct, $db;
		$form_search_ranges = $this->form_search_ranges();
		$where = $form_search_ranges->db_data_where(array('ip' => 'exclude'));
		$table_ip_ranges = new table(array('TABLE_NAME' => 'table_ip_ranges', 'FORM_NAME' => 'table_ip_ranges'));
		$where = ($where !=''?"(".$where.") AND ":"");
		if ($form_search_ranges->data[0]['value'] != '') {
			$where .= "(";
			$s_ranges = ip_to_ranges($form_search_ranges->data[0]['value']);
			foreach ($s_ranges as $s_range) {
				$where .= "(ip_ranges.ip_start BETWEEN ".ip2long($s_range['min'])." AND ".ip2long($s_range['max']).") OR ";
			}
			$where = substr($where, 0, -4).") AND ";
		}
		if ($where!='') $where = substr($where, 0, -5);
		$table_ip_ranges->db_data(
			'"" AS ip_range, ip_ranges.ip_start, ip_ranges.ip_end, ip_ranges.date_in, ip_ranges.status, nodes.name AS nodes__name, nodes.id AS nodes__id',
			'ip_ranges
			LEFT JOIN nodes ON ip_ranges.node_id = nodes.id',
			($where !=''?"(".$where.")":""),
			"",
			"ip_ranges.status ASC, ip_ranges.ip_start ASC");
		$table_ip_ranges->db_data_search($form_search_ranges);
		foreach( (array) $table_ip_ranges->data as $key => $value) {
			if ($key != 0) {
				$table_ip_ranges->data[$key]['ip_start'] = long2ip($table_ip_ranges->data[$key]['ip_start']);
				$table_ip_ranges->data[$key]['ip_end'] = long2ip($table_ip_ranges->data[$key]['ip_end']);
				$table_ip_ranges->data[$key]['ip_range'] = $table_ip_ranges->data[$key]['ip_start']." - ".$table_ip_ranges->data[$key]['ip_end'];
				$table_ip_ranges->data[$key]['nodes__name'] .= " (#".$table_ip_ranges->data[$key]['nodes__id'].")";
				$table_ip_ranges->info['EDIT'][$key] = makelink(array("page" => "nodes", "node" => $table_ip_ranges->data[$key]['nodes__id']));
			}
		}
		$table_ip_ranges->info['EDIT_COLUMN'] = 'nodes__name';
		$table_ip_ranges->db_data_remove('ip_start', 'ip_end', 'nodes__id');
		$table_ip_ranges->db_data_translate('ip_ranges__status');
		return $table_ip_ranges;
	}

	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['link_ranges_search'] = makelink(array("page" => "ranges", "subpage" => "search"));
		$this->tpl['link_ranges_allocation'] = makelink(array("page" => "ranges", "subpage" => "allocation"));
		$this->tpl['form_search_ranges'] = $construct->form($this->form_search_ranges(), __FILE__);
		$this->tpl['table_ranges'] = $construct->table($this->table_ip_ranges(), __FILE__);
		return template($this->tpl, __FILE__);
	}

}

?>