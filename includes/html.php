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

include_once($root_path."includes/head.php");
include_once($root_path."includes/body.php");

class html {
	
	var $tpl;
	var $head;
	var $body;
	var $do_format = FALSE;
	
	function html() {
		$this->head = new head;
		$this->body = new body;		
	}
	
	function format_html($html) {
		$spliter = "  ";
		$offset = 0;
		$tabs = 0;
		while (($pos = strpos($html, "<", $offset)) !== false) {
			if ($pos-$offset > 0) $ret .= substr($html, $offset, $pos-$offset)."\n".str_repeat($spliter, $tabs);
			$offset = strpos($html, ">", $pos);
			if (substr($html, $pos+1, 1) == "/") {
				$offset++;
				$tabs--;
				$ret = substr($ret, 0, -strlen($spliter));
				$ret .= substr($html, $pos, $offset-$pos)."\n".str_repeat($spliter, $tabs);				
			} else {
				if (substr($html, $pos+1, 1) == "!" || substr($html, $pos+1, 1) == "?" || substr($html, $offset-1, 1) == "/") {
					$offset++;
					$ret .= substr($html, $pos, $offset-$pos)."\n".str_repeat($spliter, $tabs);
				} else {
					$offset++;
					$tabs++;
					$ret .= substr($html, $pos, $offset-$pos)."\n".str_repeat($spliter, $tabs);				
				}
			}
		}
		if ($pos-$offset > 0) $ret .= substr($html, $offset, $pos-$offset)."\n".str_repeat($spliter, $tabs);
		if ($ret == "") $ret = $html;
		return $ret;
	}
	
	function output() {
		$this->tpl['head'] = $this->head->output();
		$this->tpl['body'] = $this->body->output();
		$this->tpl['body_tags'] = $this->body->tags;
		$ret = template($this->tpl, __FILE__);
		return ($this->do_format?$this->format_html($ret):$ret);
	}
	
}

?>