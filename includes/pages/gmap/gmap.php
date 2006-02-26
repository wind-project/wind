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

if (get('subpage') != '') {
	include_once(ROOT_PATH."includes/pages/gmap/gmap_".get('subpage').".php");
} else {
	include_once(ROOT_PATH."includes/pages/gmap/gmap_fullmap.php");
}

class gmap {

	var $tpl;
	var $page;
	
	function gmap() {
		if (get('subpage') != '') {
			$p = "gmap_".get('subpage');
			$this->page = new $p;
		} else {
			$this->page = new gmap_fullmap;
		}
	}
	
	function output() {
		return $this->page->output();
	}

}

?>