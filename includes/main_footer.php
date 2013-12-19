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

class footer {
	
	var $hide=FALSE;

	function output() {
		global $db, $php_start, $main, $vars;
		if ($this->hide) return;
		$this->tpl['php_time'] = getmicrotime() - $php_start;
		$this->tpl['mysql_time'] = $db->total_time;
		$this->tpl['wind_version'] = format_version($vars['info']['version']);
		if (isset($main->userdata->privileges['admin']) && $main->userdata->privileges['admin'] === TRUE && $vars['debug']['enabled'] == TRUE) {
			$this->tpl['debug_mysql'] = ROOT_PATH."debug/mysql.php?".get_qs();
		}
		return template($this->tpl, __FILE__);
	}
	
}
