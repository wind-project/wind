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

class gmap_fullmap {

	var $tpl;
	
	function gmap() {

	}
	
	function output() {
		global $main, $vars;
		$main->menu->hide = true;
		$main->html->head->add_script("text/javascript", "http://maps.google.com/maps?file=api&v=1&key=".$vars['gmap']['keys'][$_SERVER['SERVER_NAME']]);
		$main->html->head->add_script("text/javascript", "?page=gmap&subpage=js&node=".get('node'));
		$main->html->head->add_extra(
			'<style type="text/css">
    			v\:* {
      			behavior:url(#default#VML);
    			}
    		</style>');
    	
		$main->html->body->tags['onload'] = "gmap_onload()";
		return template($this->tpl, __FILE__);
	}

}

?>