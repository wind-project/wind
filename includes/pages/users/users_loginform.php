<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
 * Copyright (C) 2009 Vasilis Tsiligiannis <b_tsiligiannis@silverton.gr>
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



class loginform{
	var $tpl;
	
	function output() {
		global $lang;
		
		$this->tpl['lang'] = $lang;
		$this->tpl['link_restore_password'] = makelink(array("page" => "users", "action" => "restore"));
		$this->tpl['form_submit_url'] = makelink(array("page" => "users", "subpage" => "loginform"));
		return template($this->tpl, __FILE__);
		exit;
	}
	

}

?>
