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

class head {

	var $tpl;
	
	function add_extra($extra) {
		if (!isset($this->tpl['extra'])) $this->tpl['extra'] = "";
		$this->tpl['extra'] .= $extra;
	}
	
	function add_title($title) {
		$this->tpl['title'] = $title;
	}
	
	function add_base($href, $target="") {
		if (!isset($this->tpl['base'])) $this->tpl['base'] = array();
		array_push($this->tpl['base'], array('href' => $href, 'target' => $target));
	}
	
	function add_link($rel, $type, $href) {
		if (!isset($this->tpl['link'])) $this->tpl['link'] = array();
		array_push($this->tpl['link'], array('rel' => $rel, 'type' => $type, 'href' => $href));
	}
	
	function add_meta($content, $name="", $http_equiv="", $scheme="") {
		if (!isset($this->tpl['meta'])) $this->tpl['meta'] = array();
		array_push($this->tpl['meta'], array('http-equiv' => $http_equiv, 'content' => $content, 'name' => $name, 'scheme' => $scheme));
	}
	
	function add_script($type,$src) {
		if (!isset($this->tpl['script'])) $this->tpl['script'] = array();
		array_push($this->tpl['script'], array('type' => $type, 'src' => $src));
	}
	
	function output() {
		return template($this->tpl, __FILE__);
	}

}

?>