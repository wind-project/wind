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

class pickup_links_ap {

	var $tpl;
	
	function pickup_links_ap() {
		
	}
	
	function form_search_links_ap() {
		global $db;
		$form_search_links_ap = new form(array('FORM_NAME' => 'form_search_links_ap'));
		$form_search_links_ap->db_data('links.ssid, nodes.id, nodes.name, areas.id, regions.id');
		$form_search_links_ap->db_data_enum('areas.id', $db->get("id AS value, name AS output", "areas"));
		$form_search_links_ap->db_data_enum('regions.id', $db->get("id AS value, name AS output", "regions"));
		$form_search_links_ap->db_data_search();
		return $form_search_links_ap;
	}

	function table_links_ap() {
		global $construct, $db, $main, $lang;
		$form_search_links_ap = $this->form_search_links_ap();
		$where = $form_search_links_ap->db_data_where(array("links__ssid" => "starts_with", "nodes__name" => "starts_with"));
		$table_links_ap = new table(array('TABLE_NAME' => 'table_links_ap'));
		$table_links_ap->db_data(
			'links.id AS links__id, links.ssid, nodes.id AS nodes__id, nodes.name AS nodes__name, areas.name AS areas__name',
			'links ' .
			'INNER JOIN nodes ON links.node_id = nodes.id ' .
			'LEFT JOIN areas ON nodes.area_id = areas.id ' .
			'LEFT JOIN regions ON areas.region_id = regions.id',
			"links.type = 'ap'".($where!=''?' AND ('.$where.')':""),
			"",
			"nodes.id ASC");
		$table_links_ap->db_data_search($form_search_links_ap);
		for($i=1;$i<count($table_links_ap->data);$i++) {
			if (isset($table_links_ap->data[$i])) {
				if ($table_links_ap->data[$i]['ssid'] == '') {
					$table_links_ap->data[$i]['ssid'] = $lang['null'];
				}
				$table_links_ap->data[$i]['nodes__name'] .= " (#".$table_links_ap->data[$i]['nodes__id'].")";
				$table_links_ap->info['PICKUP_VALUE'][$i] = $table_links_ap->data[$i]['links__id'];
				$table_links_ap->info['PICKUP_OUTPUT'][$i] = $table_links_ap->data[$i]['nodes__name']." [".$lang['db']['links__ssid'].": ".$table_links_ap->data[$i]['ssid']."]";
			}
		}
		$table_links_ap->info['PICKUP_COLUMN'] = 'ssid';
		$table_links_ap->info['PICKUP_OBJECT'] = stripslashes(get('object'));
		$table_links_ap->db_data_remove('links__id', 'nodes__id');
		return $table_links_ap;
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct, $main;
		$main->header->hide = TRUE;
		$main->menu->hide = TRUE;
		$main->footer->hide = TRUE;
		$this->tpl['form_search_links_ap'] = $construct->form($this->form_search_links_ap(), __FILE__);
		$this->tpl['table_links_ap'] = $construct->table($this->table_links_ap(), __FILE__);
		return template($this->tpl, __FILE__);
	}

}

?>