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

class startup {

	var $tpl;
	
	function startup() {
		
	}
	
	function output() {
		global $vars;
		if (file_exists(ROOT_PATH."config/startup.html"))
			$this->tpl['startup_html'] = file_get_contents(ROOT_PATH."config/startup.html");
		$this->tpl['wind_version'] = format_version($vars['info']['version']);
		$this->tpl['community_name'] = $vars['community']['name'];
		$this->tpl['community_short_name'] = $vars['community']['short_name'];
		return template($this->tpl, __FILE__);
	}

}
