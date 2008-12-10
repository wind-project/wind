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
	
	function main() {
		$this->html = new html;
		$this->userdata = new userdata;
		$this->message = new message;
		$this->header = new header;
		$this->center = new center;
		$this->footer = new footer;
		$this->menu = new menu;
	}
	
	function output() {
		global $lang;
		
		if (get('session_lang') != '') $_SESSION['lang'] = get('session_lang');
		if (isset($this->userdata->info)) {
		    language_set($this->userdata->info['language']);
		}
		else {
		    language_set();
		}
		
		// Reload user info from database using SET NAMES (workaround)
		$this->userdata->load_info();
		
		$this->html->head->add_title($lang['site_title']);
		$this->html->head->add_meta("text/html; charset=".$lang['charset'], "", "Content-Type");
		header("Content-Type: text/html; charset=".$lang['charset']);
		
		$this->html->body->tpl['center'] = $this->center->output();
		$this->html->body->tpl['menu'] = $this->menu->output();
		$this->html->body->tpl['header'] = $this->header->output();
		$this->html->body->tpl['footer'] = $this->footer->output();
		if ($this->message->show) $this->html->body->tpl['message'] = $this->message->output();
		
		return $this->html->output();
	}
	
}

?>
