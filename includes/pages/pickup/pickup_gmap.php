<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
 * Copyright (C) 2010 Vasilis Tsiligiannis <b_tsiligiannis@silverton.gr>
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

class pickup_gmap {

	var $tpl;
	
	function pickup_gmap() {
		
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct, $main, $vars;
		$main->header->hide = TRUE;
		$main->menu->hide = TRUE;
		$main->footer->hide = TRUE;
		$this->tpl['gmap_key_ok'] = include_gmap(htmlspecialchars("?page=gmap&subpage=pickup_js&object_lat=".stripslashes(get('object_lat'))."&object_lon=".stripslashes(get('object_lon'))));
		return template($this->tpl, __FILE__);
	}

}

?>