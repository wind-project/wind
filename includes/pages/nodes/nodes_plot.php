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

include_once(ROOT_PATH.'globals/classes/geocalc.php');
$geocalc = new geocalc();

include_once(ROOT_PATH.'globals/classes/srtm.php');
$srtm = new srtm($vars['srtm']['path']);

include_once(ROOT_PATH.'globals/classes/geoimage.php');
$geoimage = new geoimage();

class nodes_plot {

	function nodes_plot() {
		
	}
	
	function output() {
		global $db, $geoimage;
		$a_node = $db->get('latitude, longitude, elevation', 'nodes', "id = '".get('a_node')."'");
		$b_node = $db->get('latitude, longitude, elevation', 'nodes', "id = '".get('b_node')."'");
		$width = (integer)$_GET['width'];
		$height = (integer)$_GET['height'];
		if ($width == 0) $width = 600;
		if ($height == 0) $height = 300;

		$point_a = new coordinate($a_node[0]['latitude'], $a_node[0]['longitude']);
		$point_b = new coordinate($b_node[0]['latitude'], $b_node[0]['longitude']);
		$image = $geoimage->plotlink($width, $height, $point_a, $point_b, (integer)$a_node[0]['elevation'], (integer)$b_node[0]['elevation']);
		
		header('Content-type: image/png');
		imagepng($image);
		exit;
	}

}

?>
