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

class hostmaster_dnszones {

	var $tpl;
	
	function hostmaster_dnszones() {
		
	}
	
	function form_search_dns() {
		$form_search_dns = new form(array('FORM_NAME' => 'form_search_dns'));
		$form_search_dns->db_data('dns_zones.type, dns_zones.name, dns_zones.status, nodes.id, nodes.name');
		$form_search_dns->db_data_search();
		return $form_search_dns;
	}

	function table_dns() {
		global $construct, $db, $vars;
		$form_search_dns = $this->form_search_dns();
		$where = $form_search_dns->db_data_where(array("dns_zones__name" => "starts_with", 'nodes__name' => 'starts_with'));
		$table_dns = new table(array('TABLE_NAME' => 'table_dns', 'FORM_NAME' => 'table_dns'));

		$table_dns->db_data(
			'dns_zones.id, dns_zones.name, dns_zones.type, dns_zones.date_in, dns_zones.status',
			'dns_zones ' .
			'LEFT JOIN nodes ON dns_zones.node_id = nodes.id',
			$where,
			"",
			"dns_zones.date_in DESC, dns_zones.status ASC");
		$table_dns->db_data_search($form_search_dns);
		$table_dns->db_data_multichoice('dns_zones', 'id');
		for($i=1;$i<count($table_dns->data);$i++) {
			if (isset($table_dns->data[$i])) {
				if ($table_dns->data[$i]['type'] == 'forward') $table_dns->data[$i]['name'] .= ".".$vars['dns']['root_zone'];
				$table_dns->info['EDIT'][$i] = make_ref('/hostmaster/dnszone', array("zone" => $table_dns->data[$i]['id']));
			}
		}
		$table_dns->info['EDIT_COLUMN'] = 'name';
		$table_dns->info['MULTICHOICE_LABEL'] = 'delete';
		$table_dns->db_data_remove('id', 'type');
		$table_dns->db_data_translate('dns_zones__status');
		return $table_dns;
	}

	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['form_search_dns'] = $construct->form($this->form_search_dns(), __FILE__);
		$this->tpl['table_dns'] = $construct->table($this->table_dns(), __FILE__);
		$this->tpl['link_schema'] = make_ref('/hostmaster/dnszones_schema');
		return template($this->tpl, __FILE__);
	}

	function output_onpost_table_dns() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("dns_zones, dns_zones_nameservers", 
						'dns_zones 
							LEFT JOIN dns_zones_nameservers ON dns_zones.id = dns_zones_nameservers.zone_id', 
						"dns_zones.id = '".intval($value)."'");
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', self_ref());
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>