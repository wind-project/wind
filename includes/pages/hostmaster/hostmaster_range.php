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

class hostmaster_range {

	var $tpl;
	
	function hostmaster_range() {
		
	}
	
	function form_range() {
		global $construct, $db, $vars;
		$form_range = new form(array('FORM_NAME' => 'form_range'));
		$form_range->db_data('ip_ranges.ip_start, ip_ranges.ip_end, ip_ranges.subnetmask, ip_ranges.info, ip_ranges.status');
		$form_range->db_data_values("ip_ranges", "id", get('iprange'));
		$form_range->data[0]['value'] = long2ip($form_range->data[0]['value']);
		$form_range->data[1]['value'] = long2ip($form_range->data[1]['value']);
		$tmp = $db->get('users.email, users_nodes.owner', 'users, users_nodes, ip_ranges', "users_nodes.user_id = users.id AND users_nodes.node_id = ip_ranges.node_id AND ip_ranges.id = '".get("iprange")."'");
		foreach( (array) $tmp as $key => $value) {
			$form_range->info['email_all'] .= $value['email'].', ';
			if ($value['owner'] == 'Y') $form_range->info['email_owner'] .= $value['email'].', ';
		}
		$form_range->info['email_all'] = substr($form_range->info['email_all'], 0, -2);
		$form_range->info['email_owner'] = substr($form_range->info['email_owner'], 0, -2);
		$t = $db->get('nodes.id, nodes.name', 'nodes, ip_ranges', "ip_ranges.node_id = nodes.id AND ip_ranges.id = '".get('iprange')."'");
		$form_range->info['node_name'] = $t[0]['name'];
		$form_range->info['node_id'] = $t[0]['id'];
		return $form_range;
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['form_range'] = $construct->form($this->form_range(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_range() {
		global $construct, $main, $db;
		$form_range = $this->form_range();
		$range = get('iprange');
		$ret = TRUE;
		$_POST['ip_ranges__ip_start'] = ip2long($_POST['ip_ranges__ip_start']);
		$_POST['ip_ranges__ip_end'] = ip2long($_POST['ip_ranges__ip_end']);
		$ret = $form_range->db_set(array(),
								"ip_ranges", "id", $range);
		if ($_POST['sendmail'] == 'Y') {
			$_POST['email_to'] = str_replace(";", ", ", $_POST['email_to']);
			if ($ret) $ret = $ret && sendmail($_POST['email_to'], $_POST['email_subject'], $_POST['email_body']);
		}
		if ($ret) {
			$main->message->set_fromlang('info', 'insert_success', makelink("", TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>