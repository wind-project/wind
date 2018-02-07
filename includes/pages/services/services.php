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

class services {

	var $tpl;
	
	function services() {
		
	}
	
	function form_search_services() {
		global $db;
		$form_search_services = new form(array('FORM_NAME' => 'form_search_services'));
		$form_search_services->db_data('nodes_services.service_id, nodes.id, nodes.name');
		$form_search_services->db_data_enum('nodes_services.service_id', $db->get("id AS value, title AS output", "services", "", "", "title ASC"));
		$form_search_services->db_data_search();
		return $form_search_services;
	}

	function table_services() {
		global $construct, $db, $lang;
		$form_search_services = $this->form_search_services();
		$where = $form_search_services->db_data_where();
		$table_services = new table(array('TABLE_NAME' => 'table_services', 'FORM_NAME' => 'table_services'));
		$table_services->db_data(
			'services.title, nodes.name AS nodes__name, nodes.id AS nodes__id, ip_addresses.ip, ip_addresses.ipv6, nodes_services.url, nodes_services.info, nodes_services.date_in, nodes_services.status, IFNULL(nodes_services.protocol, services.protocol) AS protocol, IFNULL(nodes_services.port, services.port) AS port',
			'nodes_services
			LEFT JOIN nodes on nodes_services.node_id = nodes.id
			LEFT JOIN services on nodes_services.service_id = services.id
			LEFT JOIN ip_addresses ON ip_addresses.id = nodes_services.ip_id',
			$where,
			'',
			"nodes_services.date_in DESC");
		$table_services->db_data_search($form_search_services);
		foreach( (array) $table_services->data as $key => $value) { echo $key;
			if ($key != 0) { 
				if ($table_services->data[$key]['ip']) {
					$table_services->data[$key]['ip'] = long2ip($table_services->data[$key]['ip']);
                                        $table_services->data[$key]['ipv6'] = @inet_ntop($table_services->data[$key]['ipv6']);
                                        $table_services->data[$key]['ip'] .= $table_services->data[$key]['ipv6'];
					if ($table_services->data[$key]['protocol'] && $table_services->data[$key]['port']) {
						$table_services->data[$key]['ip'] .= ' ('.$lang['db']['nodes_services__protocol-'.$table_services->data[$key]['protocol']].'/'.$table_services->data[$key]['port'].')';
					}
				}
				$table_services->data[$key]['nodes__name'] .= " (#".$table_services->data[$key]['nodes__id'].")";
				$table_services->info['LINK']['nodes__name'][$key] = make_ref('/nodes', array("node" => $table_services->data[$key]['nodes__id']));
				$table_services->info['LINK']['services__title'][$key] = htmlspecialchars($table_services->data[$key]['url']);
			}
		}
		$table_services->db_data_translate('nodes_services__status');
		$table_services->db_data_remove('nodes__id','nodes_services__id', 'url', 'protocol', 'port');
		return $table_services;
	}

	function output() {
		global $main, $construct;
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name']))
			return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));

		$this->tpl['form_search_services'] = $construct->form($this->form_search_services(), __FILE__);
		$this->tpl['table_services'] = $construct->table($this->table_services(), __FILE__);
		return template($this->tpl, __FILE__);
	}

}

?>