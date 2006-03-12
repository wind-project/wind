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

class admin_regions_region {

	var $tpl;
	
	function admin_regions_region() {
		
	}
	
	function form_region() {
		global $db, $vars;
		$form_region = new form(array('FORM_NAME' => 'form_region'));
		$form_region->db_data('regions.id, regions.name, regions.ip_start, regions.ip_end, regions.info');
		$form_region->db_data_values("regions", "id", get('region'));
		if (get('region') != 'add') {
			$form_region->data[2]['value'] = long2ip($form_region->data[2]['value']);
			$form_region->data[3]['value'] = long2ip($form_region->data[3]['value']);
		}
		$form_region->db_data_remove('regions__id');
		return $form_region;
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['region_method'] = (get('region') == 'add' ? 'add' : 'edit' );
		$this->tpl['form_region'] = $construct->form($this->form_region(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_region() {
		global $construct, $main, $db;
		$form_region = $this->form_region();
		$region = get('region');
		$ret = TRUE;
		$_POST['regions__ip_start'] = ip2long($_POST['regions__ip_start']);
		$_POST['regions__ip_end'] = ip2long($_POST['regions__ip_end']);
		$ret = $form_region->db_set(array(),
								"regions", "id", get('region'));
		
		if ($ret) {
			$main->message->set_fromlang('info', 'insert_success', makelink(array("page" => "admin", "subpage" => "regions")));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>
