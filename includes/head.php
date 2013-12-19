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