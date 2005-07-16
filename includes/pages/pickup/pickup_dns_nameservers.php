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

class pickup_dns_nameservers {

	var $tpl;
	
	function pickup_dns_nameservers() {
		
	}
	
	function form_search_nameservers() {
		global $db;
		$form_search_nameservers = new form(array('FORM_NAME' => 'form_search_nameservers'));
		$form_search_nameservers->db_data('nodes.id, nodes.name, areas.id, regions.id');
		$form_search_nameservers->db_data_enum('areas.id', $db->get("id AS value, name AS output", "areas"));
		$form_search_nameservers->db_data_enum('regions.id', $db->get("id AS value, name AS output", "regions"));
		$form_search_nameservers->db_data_search();
		return $form_search_nameservers;
	}

	function table_nameservers() {
		global $construct, $db, $main, $vars;
		$form_search_nameservers = $this->form_search_nameservers();
		$where = $form_search_nameservers->db_data_where(array("nodes__name" => "starts_with"));
		$table_nameservers = new table(array('TABLE_NAME' => 'table_nameservers'));
		$table_nameservers->db_data(
			'dns_nameservers.id, dns_nameservers.name, nodes.id AS nodes__id, nodes.name AS nodes__name, nodes.name_ns AS nodes__name_ns, areas.name AS areas__name',
			'dns_nameservers, nodes, areas, regions',
			'dns_nameservers.node_id = nodes.id AND nodes.area_id = areas.id AND areas.region_id = regions.id'.($where!=''?' AND ('.$where.')':""),
			"",
			"nodes.id ASC");
		$table_nameservers->db_data_search($form_search_nameservers);
		for($i=1;$i<count($table_nameservers->data);$i++) {
			if (isset($table_nameservers->data[$i])) {
				$table_nameservers->data[$i]['nodes__name'] .= " (#".$table_nameservers->data[$i]['nodes__id'].")";
				$table_nameservers->data[$i]['name'] .= ".".$table_nameservers->data[$i]['nodes__name_ns'].".".$vars['dns']['ns_zone'];
				$table_nameservers->info['PICKUP_VALUE'][$i] = $table_nameservers->data[$i]['id'];
				$table_nameservers->info['PICKUP_OUTPUT'][$i] = $table_nameservers->data[$i]['name'];
			}
		}
		$table_nameservers->info['PICKUP_COLUMN'] = 'name';
		$table_nameservers->info['PICKUP_OBJECT'] = stripslashes(get('object'));
		$table_nameservers->db_data_remove('id', 'nodes__id', 'nodes__name_ns');
		return $table_nameservers;
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct, $main;
		$main->header->hide = TRUE;
		$main->menu->hide = TRUE;
		$main->footer->hide = TRUE;
		$this->tpl['form_search_nameservers'] = $construct->form($this->form_search_nameservers(), __FILE__);
		$this->tpl['table_nameservers'] = $construct->table($this->table_nameservers(), __FILE__);
		return template($this->tpl, __FILE__);
	}

}

?>