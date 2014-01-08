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

if (get('subpage') != '') include_once(ROOT_PATH."includes/pages/hostmaster/hostmaster_".get('subpage').".php");

class hostmaster {

	var $tpl;
	var $page;
	
	function __construct() {
		if (get('subpage') != '') {
			$p = "hostmaster_".get('subpage');
			$this->page = new $p;
		} else {
			redirect(make_ref('/hostmaster/ranges'));
		}
		
		
	}
	
	function output() {
		global $main, $lang;
		$hostmaster_entry = $main->menu->main_menu->getRootEntry()->getChild('hostmaster');
		$hostmaster_entry->createLink($lang['ip_ranges'], make_ref('/hostmaster/ranges'));
		$hostmaster_entry->createLink($lang['ip_ranges_v6'], make_ref('/hostmaster/ranges_v6'));
		$hostmaster_entry->createLink($lang['dns_zones'], make_ref('/hostmaster/dnszones'));
		$hostmaster_entry->createLink($lang['db']['schema'], make_ref('/hostmaster/dnszones_schema'));
		$hostmaster_entry->createLink($lang['dns_nameservers'], make_ref('/hostmaster/dnsnameservers'));
		
		return $this->page->output();
	}

}

?>
