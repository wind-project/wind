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
			$page = array("page" => "nodes", "node" => $q);
		} elseif ($db->cnt('', 'nodes', "name = '".$q."'") == 1) {
			$node = $db->get('id', 'nodes', "name = '".$q."'");
			$page = array("page" => "nodes", "node" => $node[0]['id']);
		} elseif (is_ip($q, FALSE)) {
			$page = array("page" => "ranges",
						  "subpage" => "search",
						  "form_search_ranges_search" => serialize(array("ip" => $q))
						  );
		} elseif (substr($q, -strlen(".".$vars['dns']['root_zone'])) == ".".$vars['dns']['root_zone']) {
			$page = array("page" => "dnszones",
						  "form_search_dns_search" => serialize(array("dns_zones__name" => $q))
						  );
		} else {
			$page = array("page" => "nodes",
						  "form_search_nodes_search" => serialize(array("nodes__name" => $q))
						  );
		}
		redirect( makelink($page, '', '', FALSE) );
	}

}

?>