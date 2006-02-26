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

include_once(ROOT_PATH."includes/head.php");
include_once(ROOT_PATH."includes/body.php");

class html {
	
	var $tpl;
	var $head;
	var $body;
	
	function html() {
		$this->head = new head;
		$this->body = new body;		
	}
	
	function output() {
		$this->tpl['head'] = $this->head->output();
		$this->tpl['body'] = $this->body->output();
		$this->tpl['body_tags'] = $this->body->tags;
		$ret = template($this->tpl, __FILE__);
		return $ret;
	}
	
}

?>