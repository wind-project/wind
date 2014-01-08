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
