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

class hostmaster_range_v6 {

	var $tpl;
	
	function hostmaster_range_v6() {
		
	}
	
	function form_range_v6() {
		global $construct, $db, $vars, $main;
		$form_range_v6 = new form(array('FORM_NAME' => 'form_range_v6'));
		$form_range_v6->db_data('ip_ranges_v6.info, ip_ranges_v6.status');
		$form_range_v6->db_data_values("ip_ranges_v6", "id", get('v6net_id'));
		$tmp = $db->get('users.email, users_nodes.owner', 'users, users_nodes, ip_ranges_v6', "users_nodes.user_id = users.id AND users_nodes.node_id = ip_ranges_v6.node_id AND ip_ranges_v6.id = '".get("v6net_id")."'");
		if (!isset($form_range->info['email_all'])) $form_range_v6->info['email_all']= '';
		if (!isset($form_range->info['email_owner'])) $form_range_v6->info['email_owner'] = '';
		foreach( (array) $tmp as $key => $value) {
			$form_range_v6->info['email_all'] .= $value['email'].', ';
			if ($value['owner'] == 'Y') $form_range_v6->info['email_owner'] .= $value['email'].', ';
		}
		$form_range_v6->info['email_all'] = substr($form_range_v6->info['email_all'], 0, -2);
		$form_range_v6->info['email_owner'] = substr($form_range_v6->info['email_owner'], 0, -2);
		$t = $db->get('nodes.id, nodes.name', 'nodes, ip_ranges_v6', "ip_ranges_v6.node_id = nodes.id AND ip_ranges_v6.id = '".get('v6net_id')."'");
		$form_range_v6->info['node_name'] = $t[0]['name'];
		$form_range_v6->info['node_id'] = $t[0]['id'];
		$form_range_v6->info['hostmaster_username'] = $main->userdata->info['username'];
		$form_range_v6->info['hostmaster_name'] = $main->userdata->info['name'];
		$form_range_v6->info['hostmaster_surname'] = $main->userdata->info['surname'];
		return $form_range_v6;
	}
	
	function table_node_info() {
		global $db;
		$table_node_info = new table(array('TABLE_NAME' => 'table_node_info'));
		$table_node_info->db_data(
			'nodes.name AS nodes__name, nodes.id, nodes.date_in, nodes.info, areas.name AS areas__name, regions.name AS regions__name',
			'ip_ranges_v6 ' .
			'LEFT JOIN nodes ON ip_ranges_v6.node_id = nodes.id
			LEFT JOIN areas ON nodes.area_id = areas.id
			LEFT JOIN regions ON areas.region_id = regions.id',
			"ip_ranges_v6.id = '".get('v6net_id')."'");
		for($i=1;$i<count($table_node_info->data);$i++) {
			if (isset($table_node_info->data[$i])) {
				$table_node_info->data[$i]['nodes__name'] .= " (#".$table_node_info->data[$i]['id'].")";
				$table_node_info->info['EDIT'][$i] = makelink(array("page" => "mynodes", "node" => $table_node_info->data[$i]['id']));
			}
		}
		$table_node_info->info['EDIT_COLUMN'] = 'nodes__name';
		$table_node_info->db_data_remove('id');
		return $table_node_info;
	}

	function table_user_info() {
		global $db;
		$table_user_info = new table(array('TABLE_NAME' => 'table_user_info'));
		$table_user_info->db_data(
			'users.id, users.username, users_nodes.owner, users.surname, users.name, users.name, users.email, users.phone, users.info',
			'ip_ranges_v6 ' .
			'LEFT JOIN users_nodes ON users_nodes.node_id = ip_ranges_v6.node_id 
			LEFT JOIN users ON users_nodes.user_id = users.id',
			"ip_ranges_v6.id = '".get('v6net_id')."'",
			'',
			'users_nodes.owner ASC');
		for($i=1;$i<count($table_user_info->data);$i++) {
			if (isset($table_user_info->data[$i])) {
				$table_user_info->info['EDIT'][$i] = makelink(array("page" => "users", "user" => $table_user_info->data[$i]['id']));
			}
		}
		$table_user_info->info['EDIT_COLUMN'] = 'username';
		$table_user_info->db_data_remove('id');
		$table_user_info->db_data_translate('users_nodes__owner');
		return $table_user_info;
	}

	function table_links() {
		global $db;
		$table_links = new table(array('TABLE_NAME' => 'table_links', 'FORM_NAME' => 'table_links'));
		$table_links->db_data(
			'links.id, links.type, "" AS peer, links.peer_node_id, n_p.name AS peer_node_name, n_c.name AS peer_ap_nodename, n_c.id AS peer_ap_nodeid, l_c.ssid AS peer_ap_ssid, links.ssid, links.status AS links__status, l_p.status AS l_p__status, l_c.status AS l_c__status',
			'links
			LEFT JOIN ip_ranges_v6 ON ip_ranges_v6.node_id = links.node_id
			LEFT JOIN links AS l_p ON links.peer_node_id = l_p.node_id AND links.node_id = l_p.peer_node_id
			LEFT JOIN nodes AS n_p ON links.peer_node_id = n_p.id
			LEFT JOIN links AS l_c ON links.peer_ap_id = l_c.id
			LEFT JOIN nodes AS n_c ON l_c.node_id = n_c.id',
			"ip_ranges_v6.id = '".get('v6net_id')."' AND (links.type != 'p2p' OR l_p.node_id IS NOT NULL)",
			"",
			"links.type ASC, links.date_in ASC");
		for($i=1;$i<count($table_links->data);$i++) {
			if (isset($table_links->data[$i])) {
				if ($table_links->data[$i]['type'] == 'p2p') {
					$table_links->data[$i]['peer'] = $table_links->data[$i]['peer_node_name']." (#".$table_links->data[$i]['peer_node_id'].")";
					$table_links->data[$i]['links__status'] = ($table_links->data[$i]['l_p__status']=="inactive"?"inactive":$table_links->data[$i]['links__status']);
				}
				if ($table_links->data[$i]['type'] == 'client') {
					$table_links->data[$i]['peer'] = $table_links->data[$i]['peer_ap_nodename']." (#".$table_links->data[$i]['peer_ap_nodeid'].")";
					$table_links->data[$i]['ssid'] = $table_links->data[$i]['peer_ap_ssid'];
					$table_links->data[$i]['links__status'] = ($table_links->data[$i]['l_c__status']=="inactive"?"inactive":$table_links->data[$i]['links__status']);
				}				
			}
		}
		$table_links->db_data_remove('id', 'peer_node_id', 'peer_node_name', 'peer_ap_nodename', 'peer_ap_nodeid', 'peer_ap_ssid', 'l_c__status', 'l_p__status');
		$table_links->db_data_translate('links__type', 'links__status');
		return $table_links;
	}
	
	function table_ip_ranges_v6() {
		global $db;
		$table_ip_ranges_v6 = new table(array('TABLE_NAME' => 'table_ip_ranges_v6', 'FORM_NAME' => 'table_ip_ranges_v6'));
		$table_ip_ranges_v6->db_data(
			'ipv6_node_repos.v6net AS v6net, ip_ranges_v6.date_in, ip_ranges_v6.status',
			'ip_ranges_v6, ipv6_node_repos ' .
			'',
			"ip_ranges_v6.id = '".get('v6net_id')."' and ipv6_node_repos.node_id = ip_ranges_v6.node_id",
			"",
			"ip_ranges_v6.date_in ASC");
		foreach( (array) $table_ip_ranges_v6->data as $key => $value) {
			if ($key != 0) {
				$table_ip_ranges_v6->data[$key]['v6net'] = inet_ntop($table_ip_ranges_v6->data[$key]['v6net']);
			}
		}
		//$table_ip_ranges_v6->db_data_remove('');
		$table_ip_ranges_v6->db_data_translate('ip_ranges_v6__status');
		return $table_ip_ranges_v6;
	}

	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct,$db,$main;
		if(get('action') === "delete")
		{
                        $ret1->db_data(
			'ipv6_node_repos.id AS id',
			'ip_ranges_v6, ipv6_node_repos ' .
			'',
			"ip_ranges_v6.id = '".get('v6net_id')."' and ipv6_node_repos.node_id = ip_ranges_v6.node_id",
			"",
			"ASC");
                        
			$ret = $db->del("ip_ranges_v6", '', "id = '".get('v6net_id')."'");
                        $ret2 = TRUE;
                        $ret2 = $ret2 && $db->set("ipv6_node_repos", array('node_id' => '0'), "id = '".$ret1[0]['v6net_id']."'");
                        if ($ret && $ret2) {
				$main->message->set_fromlang('info', 'delete_success', makelink(array("page" => "hostmaster", "subpage" => "ranges_v6")));
			} else {
				$main->message->set_fromlang('error', 'generic');		
			}
			return ;
		}
		$this->tpl['form_range_v6'] = $construct->form($this->form_range_v6(), __FILE__);
		$this->tpl['table_node_info'] = $construct->table($this->table_node_info(), __FILE__);
		$this->tpl['table_user_info'] = $construct->table($this->table_user_info(), __FILE__);
		$this->tpl['table_links'] = $construct->table($this->table_links(), __FILE__);
		$this->tpl['table_ip_ranges_v6'] = $construct->table($this->table_ip_ranges_v6(), __FILE__);
		$this->tpl['link_range_delete'] = makelink (array("action" => "delete"),TRUE);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_range_v6() {
		global $construct, $main, $db;
		$form_range_v6 = $this->form_range_v6();
		$range_v6 = get('v6net_id');
		$ret = TRUE;
		$ret = $form_range_v6->db_set(array(), "ip_ranges_v6", "id", $range_v6);
		if ($_POST['sendmail'] == 'Y') {
			$_POST['email_to'] = str_replace(";", ", ", $_POST['email_to']);
			if ($ret) $ret = $ret && sendmail(stripslashes($_POST['email_to']), stripslashes($_POST['email_subject']), stripslashes($_POST['email_body']), '', '', TRUE);
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'edit_success', makelink(array("page" => "hostmaster", "subpage" => "ranges_v6")));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>