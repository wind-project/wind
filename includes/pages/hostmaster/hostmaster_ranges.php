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

class hostmaster_ranges {

	var $tpl;
	
	function hostmaster_ranges() {
		
	}
	
	function form_search_ranges() {
		global $construct, $db;
		$form_search_ranges = new form(array('FORM_NAME' => 'form_search_ranges'));
		$form_search_ranges->data = array("0" => array("Field" => "ip", "fullField" => "ip"));
		$form_search_ranges->db_data('ip_ranges.status, ip_ranges.delete_req, nodes.id, nodes.name');
		array_push($form_search_ranges->data, array('Compare' => 'numeric', 'Field' => 'total_active_p2p', 'fullField' => 'total_active_p2p'));
		array_push($form_search_ranges->data, array('Compare' => 'numeric', 'Field' => 'total_active_aps', 'fullField' => 'total_active_aps'));
		$form_search_ranges->db_data_search();
		return $form_search_ranges;
	}

	function table_ip_ranges() {
		global $construct, $db, $lang;
		$form_search_ranges = $this->form_search_ranges();
		$where = $form_search_ranges->db_data_where(array('ip' => 'exclude', 'nodes__name' => 'starts_with', "total_active_p2p" => 'exclude', "total_active_aps" => 'exclude'));
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
		$having = $form_search_ranges->db_data_where(array('ip' => 'exclude', 'ip_ranges__status' => 'exclude', 'ip_ranges__delete_req' => 'exclude', 'nodes__id' => 'exclude', 'nodes__name' => 'exclude'));
		$table_ip_ranges->db_data(
			'ip_ranges.id, 
				"" AS ip_range, 
				ip_ranges.ip_start, 
				ip_ranges.ip_end, 
				ip_ranges.date_in, 
				ip_ranges.status, 
				ip_ranges.delete_req, 
				COUNT(DISTINCT p2p.id) AS total_active_p2p, 
				COUNT(DISTINCT aps.id) AS total_active_aps, 
				"" AS total_active_peers',
			'ip_ranges ' .
			'LEFT JOIN nodes ON ip_ranges.node_id = nodes.id 
				LEFT JOIN links ON ip_ranges.node_id = links.node_id AND links.status = "active" 
				LEFT JOIN links AS p2p ON links.type = "p2p" 
					AND links.peer_node_id = p2p.node_id 
					AND p2p.type = "p2p" 
					AND p2p.peer_node_id = links.node_id 
					AND p2p.status = "active" 
				LEFT JOIN links as aps ON links.type = "ap" 
					AND links.id = aps.id',
			$where,
			"ip_ranges.id".
			($having!=''?' HAVING ('.$having.')':""),
			"ip_ranges.date_in DESC, ip_ranges.status ASC");
		$table_ip_ranges->db_data_search($form_search_ranges);
		foreach( (array) $table_ip_ranges->data as $key => $value) {
			if ($key != 0) {
				$table_ip_ranges->data[$key]['ip_start'] = long2ip($table_ip_ranges->data[$key]['ip_start']);
				$table_ip_ranges->data[$key]['ip_end'] = long2ip($table_ip_ranges->data[$key]['ip_end']);
				$table_ip_ranges->data[$key]['ip_range'] = $table_ip_ranges->data[$key]['ip_start']." - ".$table_ip_ranges->data[$key]['ip_end'];
			}
		}
		$table_ip_ranges->db_data_multichoice('ip_ranges', 'id');
		for($i=1;$i<count($table_ip_ranges->data);$i++) {
			if (isset($table_ip_ranges->data[$i])) {
				$table_ip_ranges->data[$i]['total_active_peers'] = ($table_ip_ranges->data[$i]['total_active_p2p']>0?$table_ip_ranges->data[$i]['total_active_p2p']." ".$lang['backbones_abbr']:"").($table_ip_ranges->data[$i]['total_active_aps']>0?" + ".$table_ip_ranges->data[$i]['total_active_aps']." ".$lang['aps_abbr']:"");
				$table_ip_ranges->info['EDIT'][$i] = makelink(array("page" => "hostmaster", "subpage" => "range", "iprange" => $table_ip_ranges->data[$i]['id']));
			}
		}
		$table_ip_ranges->info['EDIT_COLUMN'] = 'ip_range';
		$table_ip_ranges->info['MULTICHOICE_LABEL'] = 'delete';
		$table_ip_ranges->db_data_remove('id', 'ip_start', 'ip_end', 'total_active_p2p', 'total_active_aps');
		$table_ip_ranges->db_data_translate('ip_ranges__status', 'ip_ranges__delete_req');
		return $table_ip_ranges;
	}

	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['form_search_ranges'] = $construct->form($this->form_search_ranges(), __FILE__);
		$this->tpl['table_ranges'] = $construct->table($this->table_ip_ranges(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_table_ip_ranges() {
		global $db, $main;
		$ret = TRUE;
		foreach( (array) $_POST['id'] as $key => $value) {
			$ret = $ret && $db->del("ip_ranges", '', "id = '".$value."'");
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'delete_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>