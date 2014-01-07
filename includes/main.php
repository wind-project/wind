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

include_once(ROOT_PATH."includes/html.php");
include_once(ROOT_PATH."globals/classes/userdata.php");
include_once(ROOT_PATH."globals/classes/message.php");
include_once(ROOT_PATH."includes/main_header.php");
include_once(ROOT_PATH."includes/main_center.php");
include_once(ROOT_PATH."includes/main_footer.php");
include_once(ROOT_PATH."includes/main_menu.php");

class main {
	
	var $html;
	var $userdata;
	var $message;
	var $header;
	var $center;
	var $footer;
	var $menu;
	
	function __construct() {
		global $lang;
		
		$this->userdata = new userdata();
		
		if (get('session_lang') != '')
			$_SESSION['lang'] = get('session_lang');
		if (isset($this->userdata->info)) {
			language_set($this->userdata->info['language']);
		}
		else {
			language_set();
		}
		
		// Reload user info from database using SET NAMES (workaround)
		$this->userdata->load_info();
		
	}
	
	function output() {
		global $lang;
		
		// Construct HTML Elements
		$this->html = new html();
		$this->message = new message();
		$this->header = new header();
		$this->center = new center();
		$this->footer = new footer();
		$this->menu = new menu();
		
		$this->html->head->add_title($lang['site_title']);
		header("Content-Type: text/html; charset=".$lang['charset']);
		
		$this->html->body->tpl['center'] = $this->center->output();
		$this->html->body->tpl['menu'] = $this->menu->output();
		$this->html->body->tpl['header'] = $this->header->output();
		$this->html->body->tpl['footer'] = $this->footer->output();
		if ($this->message->show)
			$this->html->body->tpl['message'] = $this->message->output();
		
		return $this->html->output();
	}
	
}

