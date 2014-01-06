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
		$table_ip_ranges_v6 = new table(array('TABLE_NAME' => 'table_ip_ranges_v6', 'FORM_NAME' => 'table_ip_ranges_v6'));
		$table_ip_ranges_v6->db_data(
			'ipv6_node_repos.v6net AS v6net, ip_ranges_v6.id AS v6net_id, ip_ranges_v6.date_in, ip_ranges_v6.status, ip_ranges_v6.delete_req' , 
			'ip_ranges_v6, ipv6_node_repos ' ,
			'ipv6_node_repos.id = ip_ranges_v6.v6net_id' , 
			"ip_ranges_v6.id" ,
			"ip_ranges_v6.date_in DESC, ip_ranges_v6.status ASC");
		$table_ip_ranges_v6->db_data_search($form_search_ranges_v6);
		foreach( (array) $table_ip_ranges_v6->data as $key => $value) {
			if ($key != 0) {
				$table_ip_ranges_v6->data[$key]['v6net'] = inet_ntop($table_ip_ranges_v6->data[$key]['v6net']);
			}
		}
		$table_ip_ranges_v6->db_data_multichoice('ip_ranges_v6', 'v6net_id');
		for($i=1;$i<count($table_ip_ranges_v6->data);$i++) {
			if (isset($table_ip_ranges_v6->data[$i])) {
				$table_ip_ranges_v6->info['EDIT'][$i] = makelink(array("page" => "hostmaster", "subpage" => "range_v6", "v6net_id" => $table_ip_ranges_v6->data[$i]['v6net_id']));
			}
		}
		$table_ip_ranges_v6->info['EDIT_COLUMN'] = 'v6net';
		$table_ip_ranges_v6->info['MULTICHOICE_LABEL'] = 'delete';
		$table_ip_ranges_v6->db_data_remove('v6net_id');
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
                        $ret1 = TRUE;
                        $ret1 = $db->get('v6net_id','ip_ranges_v6',"ip_ranges_v6.id = '".$value."'");
                        $ret = $ret && $db->del("ip_ranges_v6", '', "id = '".$value."'");
                        $ret2 = TRUE;
                        $ret2 = $ret2 && $db->set("ipv6_node_repos", array('node_id' => '0'), "id = '".$ret1[0]['v6net_id']."'");
                }
                if ($ret && $ret2) {
                        $main->message->set_fromlang('info', 'delete_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>