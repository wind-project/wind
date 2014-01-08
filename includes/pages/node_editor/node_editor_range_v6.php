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

class node_editor_range_v6 {

	var $tpl;
	
	function __construct() {
		
	}
	
	function new_range_v6() {
		global $db, $main;
		$data2 = $db->get("nodes.area_id AS area_id",
					"nodes",
					"nodes.id = ".intval(get('node')));
		$area_id = $data2[0]['area_id'];
		
                $data3 = $db->get("ipv6_node_repos.v6net AS v6net, ipv6_node_repos.id AS id",
                                        "ipv6_node_repos",
                                        "ipv6_node_repos.area_id = '".$area_id."' and ipv6_node_repos.node_id = '0'", "" , "id ASC LIMIT 1");

		$ret['id'] = $data3[0]['id'];
		return $ret;
	}
        
	function form_getrange_v6() {
		global $db;
		$form_getrange_v6 = new form(array('FORM_NAME' => 'form_getrange_v6'));
		$form_getrange_v6->db_data('ip_ranges_v6.info');
		return $form_getrange_v6;
	}        
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct, $db;
		$this->tpl['form_getrange_v6'] = $construct->form($this->form_getrange_v6(), __FILE__);
		$this->tpl['node_id'] = get('node');
		$this->tpl['node_name'] = $db->get('name', 'nodes', "id = ".intval(get('node')));
		$this->tpl['node_name'] = $this->tpl['node_name'][0]['name'];
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_getrange_v6() {
		global $main, $db;
		$t = $db->get('area_id', 'nodes', "id = ".intval(get('node')));
		if ($t[0]['area_id'] == '') {
			$main->message->set_fromlang('error', 'nodes_no_area_id');
			return;
		}
		$form_getrange_v6 = $this->form_getrange_v6();
		$nextr = $this->new_range_v6();
		$status = "waiting";
		$ret = TRUE;
		$ret = $form_getrange_v6->db_set(array("node_id" => intval(get('node')), "v6net_id" => $nextr['id'], "status" => $status));
		$ret2 = $db->set("ipv6_node_repos", array('node_id' => intval(get('node'))), 'id = '.$nextr['id']);
		if ($ret && $ret2) {
			$main->message->set_fromlang('info', 'request_range_success', makelink(array("page" => "mynodes", "node" => get('node'))));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}        
}

?>
