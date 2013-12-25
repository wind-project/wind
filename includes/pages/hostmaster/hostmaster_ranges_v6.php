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

class hostmaster_ranges_v6 {

	var $tpl;
	
	function hostmaster_ranges_v6() {
		
	}
	
	function form_search_ranges_v6() {
		global $construct, $db;
		$form_search_ranges_v6 = new form(array('FORM_NAME' => 'form_search_ranges_v6'));
		$form_search_ranges_v6->data = array("0" => array("Field" => "ipv6", "fullField" => "ipv6"));
		$form_search_ranges_v6->db_data('ip_ranges_v6.status, ip_ranges_v6.delete_req, nodes.id, nodes.name');
		array_push($form_search_ranges_v6->data, array('Compare' => 'numeric', 'Field' => 'total_active_p2p', 'fullField' => 'total_active_p2p'));
		array_push($form_search_ranges_v6->data, array('Compare' => 'numeric', 'Field' => 'total_active_aps', 'fullField' => 'total_active_aps'));
		$form_search_ranges_v6->db_data_search();
		return $form_search_ranges_v6;
	}

	function table_ip_ranges_v6() {
		global $construct, $db, $lang;
		$form_search_ranges_v6 = $this->form_search_ranges_v6();
		$where = $form_search_ranges_v6->db_data_where(array('ipv6' => 'exclude', 'nodes__name' => 'starts_with', "total_active_p2p" => 'exclude', "total_active_aps" => 'exclude'));
		$table_ip_ranges_v6 = new table(array('TABLE_NAME' => 'table_ip_ranges_v6', 'FORM_NAME' => 'table_ip_ranges_v6'));
		$where = ($where !=''?"(".$where.") AND ":"");
		if ($form_search_ranges_v6->data[0]['value'] != '') {
			$where .= "(";
			$s_ranges = ip_to_ranges($form_search_ranges_v6->data[0]['value']);
			foreach ($s_ranges as $s_range) {
				$where .= "(ip_ranges_v6.v6net BETWEEN ".ip2long($s_range['min'])." AND ".ip2long($s_range['max']).") OR ";
			}
			$where = substr($where, 0, -4).") AND ";
		}
		if ($where!='') $where = substr($where, 0, -5);
		$having = $form_search_ranges_v6->db_data_where(array('ip' => 'exclude', 'ip_ranges__status' => 'exclude', 'ip_ranges__delete_req' => 'exclude', 'nodes__id' => 'exclude', 'nodes__name' => 'exclude'));
		$table_ip_ranges_v6->db_data(
			'ip_ranges_v6.id, 
				"" AS ip_range_v6, 
				ip_ranges_v6.v6net, 
				ip_ranges_v6.date_in, 
				ip_ranges_v6.status, 
				ip_ranges_v6.delete_req, 
				COUNT(DISTINCT p2p.id) AS total_active_p2p, 
				COUNT(DISTINCT aps.id) AS total_active_aps, 
				"" AS total_active_peers',
			'ip_ranges_v6 ' .
			'LEFT JOIN nodes ON ip_ranges_v6.node_id = nodes.id 
				LEFT JOIN links ON ip_ranges_v6.node_id = links.node_id AND links.status = "active" 
				LEFT JOIN links AS p2p ON links.type = "p2p" 
					AND links.peer_node_id = p2p.node_id 
					AND p2p.type = "p2p" 
					AND p2p.peer_node_id = links.node_id 
					AND p2p.status = "active" 
				LEFT JOIN links as aps ON links.type = "ap" 
					AND links.id = aps.id',
			$where,
			"ip_ranges_v6.id".
			($having!=''?' HAVING ('.$having.')':""),
			"ip_ranges_v6.date_in DESC, ip_ranges_v6.status ASC");
		$table_ip_ranges_v6->db_data_search($form_search_ranges_v6);
		foreach( (array) $table_ip_ranges_v6->data as $key => $value) {
			if ($key != 0) {
				$table_ip_ranges_v6->data[$key]['v6net'] = inet_ntop($table_ip_ranges_v6->data[$key]['v6net']);
			}
		}
		$table_ip_ranges_v6->db_data_multichoice('ip_ranges_v6', 'id');
		for($i=1;$i<count($table_ip_ranges_v6->data);$i++) {
			if (isset($table_ip_ranges_v6->data[$i])) {
				$table_ip_ranges_v6->data[$i]['total_active_peers'] = ($table_ip_ranges_v6->data[$i]['total_active_p2p']>0?$table_ip_ranges_v6->data[$i]['total_active_p2p']." ".$lang['backbones_abbr']:"").($table_ip_ranges_v6->data[$i]['total_active_aps']>0?" + ".$table_ip_ranges_v6->data[$i]['total_active_aps']." ".$lang['aps_abbr']:"");
				$table_ip_ranges_v6->info['EDIT'][$i] = makelink(array("page" => "hostmaster", "subpage" => "range_v6", "iprange_v6" => $table_ip_ranges_v6->data[$i]['id']));
			}
		}
		$table_ip_ranges_v6->info['EDIT_COLUMN'] = 'ip_range';
		$table_ip_ranges_v6->info['MULTICHOICE_LABEL'] = 'delete';
		$table_ip_ranges_v6->db_data_remove('ip_range_v6', 'id', 'total_active_p2p', 'total_active_aps');
		$table_ip_ranges_v6->db_data_translate('ip_ranges_v6__status', 'ip_ranges_v6__delete_req');
		return $table_ip_ranges_v6;
	}

	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['form_search_ranges_v6'] = $construct->form($this->form_search_ranges_v6(), __FILE__);
		$this->tpl['table_ranges_v6'] = $construct->table($this->table_ip_ranges_v6(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_table_ip_ranges_v6() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("ip_ranges_v6", '', "id = '".$value."'");
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>