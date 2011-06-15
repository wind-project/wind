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

/**
 * Class to handle SRTM Data
 */
class srtm {
	
	var $data_path;
	
	function __construct($data_path='') {
		$this->data_path = $data_path;
	}
	
	public static function get_filename($lat, $lon) {
		if ($lat < 0) {
			$lat_dir = 'S';
			$lat_adj = 1;
		} else {
			$lat_dir = 'N';
			$lat_adj = 0;
		}
		if ($lon < 0) {
			$lon_dir = 'W';
			$lon_adj = 1;
		} else {
			$lon_dir = 'E';
			$lon_adj = 0;
		}
		
		return $lat_dir . sprintf("%02.0f", (integer)($lat+$lat_adj)).$lon_dir.sprintf("%03.0f", (integer)($lon+$lon_adj)).'.hgt';
	}
	
	function get_elevation($lat, $lon, $round=TRUE) {
		if ($lat < 0) {
			$lat_dir = 'S';
			$lat_adj = 1;
		} else {
			$lat_dir = 'N';
			$lat_adj = 0;
		}
		if ($lon < 0) {
			$lon_dir = 'W';
			$lon_adj = 1;
		} else {
			$lon_dir = 'E';
			$lon_adj = 0;
		}
		$y = $lat;
		$x = $lon;
		
		$filename = $this->data_path.$lat_dir.sprintf("%02.0f", (integer)($lat+$lat_adj)).$lon_dir.sprintf("%03.0f", (integer)($lon+$lon_adj)).'.hgt';
		if ($lat === '' || $lon === '' || !file_exists($filename)) return FALSE;
		
		$file = fopen($filename, 'r');
		$offset = ( (integer)(($x - (integer)$x + $lon_adj) * 1200) * 2 + (1200 - (integer)(($y - (integer)$y + $lat_adj) * 1200)) * 2402 );
		fseek($file, $offset);
		$h1 = bytes2int(strrev(fread($file, 2)));
		$h2 = bytes2int(strrev(fread($file, 2)));
		fseek($file, $offset-2402);
		$h3 = bytes2int(strrev(fread($file, 2)));
		$h4 = bytes2int(strrev(fread($file, 2)));
		fclose($file);
	
		$m = max($h1, $h2, $h3, $h4);
		for($i=1;$i<=4;$i++) {
			$c = 'h'.$i;
			if ($$c == -32768)
				$$c = $m;
		}
	
		$fx = ($lon - ((integer)($lon * 1200) / 1200)) * 1200;
		$fy = ($lat - ((integer)($lat * 1200) / 1200)) * 1200;
	
		// normalizing data
		$elevation = ($h1 * (1 - $fx) + $h2 * $fx) * (1 - $fy) + ($h3 * (1 - $fx) + $h4 * $fx) * $fy;
		if ($round)
			$elevation = round($elevation);
		return $elevation;
	}

}

function bytes2int($val) {
	$t = unpack("s", $val);
	$ret = $t[1];
	return $ret;
}

?>
