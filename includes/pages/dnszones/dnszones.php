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

class dnszones {

	var $tpl;
	
	function dnszones() {
		
	}
	
	function form_search_dns() {
		$form_search_dns = new form(array('FORM_NAME' => 'form_search_dns'));
		$form_search_dns->db_data('dns_zones.type, dns_zones.name, dns_zones.status');
		$form_search_dns->db_data_search();
		return $form_search_dns;
	}

	function table_dns() {
		global $construct, $db, $vars;
		$form_search_dns = $this->form_search_dns();
		if (substr($form_search_dns->data[1]['value'], -strlen(".".$vars['dns']['root_zone'])) == ".".$vars['dns']['root_zone']) {
			$form_search_dns->data[1]['value'] = substr($form_search_dns->data[1]['value'], 0, -strlen(".".$vars['dns']['root_zone']));
		}
		$where = $form_search_dns->db_data_where(array("dns_zones__name" => "starts_with"));
		$table_dns = new table(array('TABLE_NAME' => 'table_dns', 'FORM_NAME' => 'table_dns'));

		$table_dns->db_data(
			'dns_zones.id AS dns_zones__id, dns_zones.name AS dns_zones__name, dns_zones.type, dns_zones.date_in, dns_zones.status, nodes.name AS nodes__name, nodes.id AS nodes__id',
			'dns_zones
			LEFT JOIN nodes ON dns_zones.node_id = nodes.id',
			$where,
			"",
			"dns_zones.status ASC, dns_zones.type ASC, dns_zones.name ASC");
		$table_dns->db_data_search($form_search_dns);
		for($i=1;$i<count($table_dns->data);$i++) {
			if (isset($table_dns->data[$i])) {
				$table_dns->data[$i]['nodes__name'] .= " (#".$table_dns->data[$i]['nodes__id'].")";
				if ($table_dns->data[$i]['type'] == 'forward') $table_dns->data[$i]['dns_zones__name'] .= ".".$vars['dns']['root_zone'];
				$table_dns->info['EDIT'][$i] = makelink(array("page" => "nodes", "node" => $table_dns->data[$i]['nodes__id']));
			}
		}
		$table_dns->info['EDIT_COLUMN'] = 'nodes__name';
		$table_dns->db_data_remove('dns_zones__id', 'type', 'nodes__id');
		$table_dns->db_data_translate('dns_zones__status');
		return $table_dns;
	}

	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['form_search_dns'] = $construct->form($this->form_search_dns(), __FILE__);
		$this->tpl['table_dns'] = $construct->table($this->table_dns(), __FILE__);
		return template($this->tpl, __FILE__);
	}

}

?>