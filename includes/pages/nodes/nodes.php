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

if (get('subpage') != '') {
	include_once(ROOT_PATH."includes/pages/nodes/nodes_".get('subpage').".php");
} else {
	if (get('node') != '') {
		include_once(ROOT_PATH."includes/pages/nodes/nodes_view.php");
	} else {
		include_once(ROOT_PATH."includes/pages/nodes/nodes_search.php");
	}
}

class nodes {

	var $tpl;
	var $page;
	
	function nodes() {
		if (get('subpage') != '') {
			$p = "nodes_".get('subpage');
			$this->page = new $p;
		} else {
			if (get('node') != '') {
				$this->page = new nodes_view;
			} else {
				$this->page = new nodes_search;
			}
		}
	}
	
	function output() {
		return $this->page->output();
	}

}

?>