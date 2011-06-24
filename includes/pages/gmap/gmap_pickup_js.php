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

class gmap_pickup_js {
	
	var $tpl;

	function gmap_pickup_js() {
		
	}
	
	function output() {
		global $db, $lang, $vars;
		
		$max_lat = $vars['gmap']['bounds']['max_latitude'];
		$min_lat = $vars['gmap']['bounds']['min_latitude'];
		$max_lon = $vars['gmap']['bounds']['max_longitude'];
		$min_lon = $vars['gmap']['bounds']['min_longitude'];

		$this->tpl['max_latitude'] = str_replace(",", ".", $max_lat);
		$this->tpl['max_longitude'] = str_replace(",", ".", $max_lon);
		$this->tpl['min_latitude'] = str_replace(",", ".", $min_lat);
		$this->tpl['min_longitude'] = str_replace(",", ".", $min_lon);

		$this->tpl['center_latitude'] = ($max_lat + $min_lat) / 2;
		$this->tpl['center_longitude'] = ($max_lon + $min_lon) / 2;
		$this->tpl['center_latitude'] = str_replace(",", ".", $this->tpl['center_latitude']);
		$this->tpl['center_longitude'] = str_replace(",", ".", $this->tpl['center_longitude']);
		
		$this->tpl['object_lat'] = stripslashes(get('object_lat'));
		$this->tpl['object_lon'] = stripslashes(get('object_lon'));
		
		$this->tpl['maps_available'] = $vars['gmap']['maps_available'];
		
		echo template($this->tpl, __FILE__);
		exit;
	}

}

