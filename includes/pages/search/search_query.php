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

class search_query {

	var $tpl;
	
	function search_query() {
		
	}
	
	function output() {
		global $db, $vars;
		$q = get('q');
		if(strrpos($q, "#")!==false && intval(substr(strrchr($q,'#'),1))!=0) {
			$q = intval(substr(strrchr($q,'#'),1));
		}
		if (is_numeric($q) && strpos($q, ".") === FALSE) {
			$path = '/nodes';
			$qs = array('node' => $q);
		} elseif ($db->cnt('', 'nodes', "name = '".$q."'") == 1) {
			$node = $db->get('id', 'nodes', "name = '".$q."'");
			$path = '/nodes';
			$qs = array('node' => $node[0]['id']);
		} elseif (is_ip($q, FALSE)) {
			$path = '/ranges/search';
			$qs = array("form_search_ranges_search" => serialize(array("ip" => $q)));
		} elseif (substr($q, -strlen(".".$vars['dns']['root_zone'])) == ".".$vars['dns']['root_zone']) {
			$path = '/dnszones';
			$qs = array("form_search_dns_search" => serialize(array("dns_zones__name" => $q)));
		} else {
			$path = '/nodes';
			$qs = array("form_search_nodes_search" => serialize(array("nodes__name" => $q)));
				
		}
		redirect( make_ref($path, $qs) );
	}

}

?>