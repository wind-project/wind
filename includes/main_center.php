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

include_once(ROOT_PATH."includes/pages/".get('page')."/".get('page').".php");

class center {

	var $page;
	
	function center() {
		$p = get('page');
		$this->page = new $p;
	}
	
	function security_check() {
		global $main, $db;
		if (isset($main->userdata->privileges['admin']) && $main->userdata->privileges['admin'] === TRUE) return TRUE;
		switch (get('page')) {
			case 'admin':
				return ($main->userdata->privileges['admin'] === TRUE);
				break;
			case 'hostmaster':
				return ($main->userdata->privileges['hostmaster'] === TRUE);
				break;
			case 'mynodes':
				if ($main->userdata->logged === TRUE) {
					if (get('node') == 'add') return TRUE;
					if (get('node') != 'add' && get('action') == 'delete') {
						if ($db->cnt('', "users_nodes", "node_id = ".intval(get('node'))." AND user_id = '".$main->userdata->user."' AND owner = 'Y'") > 0) {
							return TRUE;
						} else {
							return FALSE;
						}
					}
					if ($db->cnt('', "users_nodes", "node_id = ".get('node')." AND user_id = '".$main->userdata->user."'") > 0) return TRUE;
					if (get('subpage') == 'dnszone' && 
						$db->cnt('', "users_nodes, dns_zones", "dns_zones.node_id = users_nodes.node_id AND dns_zones.id = '".get('zone')."' AND users_nodes.user_id = '".$main->userdata->user."'") > 0) return TRUE;
					if (get('subpage') == 'dnsnameserver' && 
						$db->cnt('', "users_nodes, dns_nameservers", "dns_nameservers.node_id = users_nodes.node_id AND dns_nameservers.id = '".get('nameserver')."' AND users_nodes.user_id = '".$main->userdata->user."'") > 0) return TRUE;
				}
				break;
			case 'nodes':
			case 'startup':
			case 'ranges':
			case 'dnszones':
			case 'pickup':
			case 'gmap':
			case 'gearth':
			case 'services':
			case 'search':
				return TRUE;
				break;
			case 'users':
				if (get('user') == 'add') return TRUE;
				if ($main->userdata->logged === TRUE) {
					if (get('action') == 'logout') return TRUE;
					if (get('user') === $main->userdata->user) return TRUE;
				}
				if (get('action') == 'activate') return TRUE;
				if (get('action') == 'restore') return TRUE;
				if (get('subpage') == 'loginform') return TRUE;
				break;
		}
		return FALSE;
	}
	
	function output() {
		global $main;
		if (!$this->security_check()) {
			$main->message->set_fromlang('info', 'no_privilege');
			return;
		}
		return $this->page->output();
	}
	
}

?>
