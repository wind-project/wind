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

class menu {
	
	var $tpl;
	var $hide=FALSE;
	
	function form_login() {
		$form_login = new form(array('FORM_NAME' => 'form_login'));
		$form_login->db_data('users.username, users.password');
		return $form_login;
	}

	function output() {
		if ($this->hide) return;
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct, $main, $db;
		$this->tpl['logged'] = $main->userdata->logged;
		$this->tpl['form_login'] = $construct->form($this->form_login(), __FILE__);
		$main->html->dody->tpl['form_login'] = $this->tpl['form_login'];
		if ($main->userdata->logged) {
			$this->tpl = array_merge($this->tpl, $main->userdata->info);
			$this->tpl['mynodes'] = $db->get('nodes.id, nodes.name', 'nodes INNER JOIN users_nodes ON nodes.id = users_nodes.node_id', "users_nodes.user_id = '".$main->userdata->user."'");
			foreach( (array) $this->tpl['mynodes'] as $key => $value) {
				$this->tpl['mynodes'][$key]['url'] = makelink(array("page" => "mynodes", "node" => $this->tpl['mynodes'][$key]['id']));
			}
			$this->tpl['link_addnode'] = makelink(array("page" => "mynodes", "node" => "add"));
			$this->tpl['link_edit_profile'] = makelink(array("page" => "users", "user" => $main->userdata->user));
			if ($main->userdata->privileges['admin'] === TRUE) {
				$this->tpl['is_admin'] = TRUE;
				$this->tpl['link_admin_nodes'] = makelink(array("page" => "admin", "subpage" => "nodes"));
				$this->tpl['link_admin_users'] = makelink(array("page" => "admin", "subpage" => "users"));
			}
			if ($main->userdata->privileges['admin'] === TRUE || $main->userdata->privileges['hostmaster'] === TRUE) {
				$this->tpl['is_hostmaster'] = TRUE;

				$this->tpl['link_dnsnameservers'] = makelink(array("page" => "hostmaster", "subpage" => "dnsnameservers"));
				$this->tpl['link_dnsnameservers_pending'] = makelink(array("page" => "hostmaster", "subpage" => "dnsnameservers", "form_search_nameservers_search" => serialize(array("dns_nameservers__status" => "pending"))));
				$this->tpl['dnsnameservers_pending'] = $db->cnt('', "dns_nameservers", "status = 'pending'");
				$this->tpl['link_dnsnameservers_req_del'] = makelink(array("page" => "hostmaster", "subpage" => "dnsnameservers", "form_search_nameservers_search" => serialize(array("dns_nameservers__delete_req" => "Y"))));
				$this->tpl['dnsnameservers_req_del'] = $db->cnt('', "dns_nameservers", "delete_req = 'Y'");

				$this->tpl['link_dnszones'] = makelink(array("page" => "hostmaster", "subpage" => "dnszones"));
				$this->tpl['link_dnszones_pending'] = makelink(array("page" => "hostmaster", "subpage" => "dnszones", "form_search_dns_search" => serialize(array("dns_zones__status" => "pending"))));
				$this->tpl['dnszones_pending'] = $db->cnt('', "dns_zones", "status = 'pending'");
				$this->tpl['link_dnszones_req_del'] = makelink(array("page" => "hostmaster", "subpage" => "dnszones", "form_search_dns_search" => serialize(array("dns_zones__delete_req" => "Y"))));
				$this->tpl['dnszones_req_del'] = $db->cnt('', "dns_zones", "delete_req = 'Y'");

				$this->tpl['link_ranges'] = makelink(array("page" => "hostmaster", "subpage" => "ranges"));
				$this->tpl['link_ranges_pending'] = makelink(array("page" => "hostmaster", "subpage" => "ranges", "form_search_ranges_search" => serialize(array("ip_ranges__status" => "pending"))));
				$this->tpl['ranges_pending'] = $db->cnt('', "ip_ranges", "status = 'pending'");
				$this->tpl['link_ranges_req_del'] = makelink(array("page" => "hostmaster", "subpage" => "ranges", "form_search_ranges_search" => serialize(array("ip_ranges__delete_req" => "Y"))));
				$this->tpl['ranges_req_del'] = $db->cnt('', "ip_ranges", "delete_req = 'Y'");
			}
		}
		$this->tpl['link_allnodes'] = makelink(array("page" => "nodes"));
		$this->tpl['link_allranges'] = makelink(array("page" => "ranges", "subpage" => "search"));
		$this->tpl['link_alldnszones'] = makelink(array("page" => "dnszones"));
		$this->tpl['link_restore_password'] = makelink(array("page" => "users", "action" => "restore"));
		$this->tpl['link_register'] = makelink(array("page" => "users", "user" => "add"));
		$this->tpl['link_logout'] = makelink(array("page" => "users", "action" => "logout"));
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_login() {
		global $main;
		if ($main->userdata->login($_POST['users__username'], $_POST['users__password'])) {
			if ($main->userdata->info['status'] == 'pending') {
				$main->message->set_fromlang('info', 'activation_required');
				$main->userdata->logout();
			} else {
				$main->message->set_fromlang('info', 'login_success', makelink());
			}
		} else {
			$main->message->set_fromlang('error', 'login_failed', makelink("", TRUE));
		}
	}
	
}

?>