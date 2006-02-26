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

class message {
	
	var $show;
	var $title;
	var $message;
	var $image;
	var $forward;
	var $forward_sec;
	var $template='constructors/message.tpl';
	var $tpl;
	
	function message() {

	}

	function set_fromlang($type, $message, $forward="", $image="", $hide_menu="", $override=FALSE) {
		global $lang;
		$this->set($lang['message'][$type][$message]['title'], $lang['message'][$type][$message]['body'], $forward, $image, $hide_menu, $override);
	}
	
	function set($title, $message, $forward="", $image="", $hide_menu="", $override=FALSE) {
		global $main;
		if ($this->show == TRUE && !$override) return FALSE;
		$this->show = TRUE;
		$this->title = $title;
		$this->message = $message;
		if ($forward != '') $this->forward = $forward;
		if ($image != '') $this->image = $image;
		if ($hide_menu !== "") $main->menu->hide = $hide_menu;
	}
	
	function output() {
		global $vars, $design, $smarty, $lang;
		
		if (isset($this->forward)) {
			$sec = (isset($this->forward_sec)?$this->forward_sec:$vars['message']['delay']);
			redirect($this->forward, $sec, FALSE);
		}
		
		$this->tpl['title'] = $this->title;
		$this->tpl['message'] = $this->message;
		$this->tpl['image'] = $this->image;
		$this->tpl['forward'] = $this->forward;
		$this->tpl['forward_text'] = $lang['forward_text'];
		return template($this->tpl, $this->template);
	}	
	
}

?>