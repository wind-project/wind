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


if (get('subpage') != '') {
	include_once(ROOT_PATH."includes/pages/gearth/gearth_".get('subpage').".php");
} else {
	include_once(ROOT_PATH."includes/pages/gearth/gearth_main.php");
}

class gearth {

	var $tpl;
	var $page;
	
	function gearth() {
		if (get('subpage') != '') {
			$p = "gearth_".get('subpage');
			$this->page = new $p;
		} else {
			$this->page = new gearth_main;
		}
	}
	
	function output() {
		return $this->page->output();
	}

}

?>
