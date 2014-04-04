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


/**
 * @brief A Class for managing latitude and longtitude coordinates
 */
class LatLon {
	
	/**
	 * @brief The latitude in decimal format
	 * @param float $lat
	 */
	public $lat;
	
	/**
	 * @brief The longtitude in decimal format
	 * @param float $lot
	 */
	public $lon;
	
	/**
	 * @brief Construct a new coordinates object
	 * @param float $lat
	 * @param float $lon
	 */
	public function __construct($lat, $lon) {
		$this->lat = $lat;
		$this->lon = $lon;
	}
	
	/**
	 * @brief Normalize coordinates
	 */
	public function normalize() {
		if ($this->lon > 180)
			$this->lon -= 360;
	}
	
	/**
	 * @brief Check if this coordinates coorespond souther
	 * of the equator
	 * @return boolean
	 */
	public function is_south() {
		$this->normalize();
		return ($this->lat <= 0);
	}
	
	/**
	 * @brief Check if this coordinates coorespond northen
	 * of the equator
	 * @return boolean
	 */
	public function is_north() {
		$this->normalize();
		return ($this->lat > 0);
	}
	
	/**
	 * @brief Check if this coordinates coorespond eastward
	 * of the Prime Meridian
	 * @return boolean
	 */
	public function is_east() {
		$this->normalize();
		return ($this->lon >= 0);
	}
	
	/**
	 * @brief Check if this coordinates coorespond westward
	 * of the Prime Meridian
	 * @return boolean
	 */
	public function is_west() {
		$this->normalize();
		return ($this->lon < 0);
	}
	
}

/**
 * @brief Class to handle SRTM Data
 */
class srtm {
	
	var $data_path;
	
	function __construct($data_path='') {
		$this->data_path = $data_path;
	}
	
	public static function get_filename(LatLon $latlon) {
		if ($latlon->is_south()) {
			$lat_dir = 'S';
			$lat_adj = 1;
		} else {
			$lat_dir = 'N';
			$lat_adj = 0;
		}
		if ($latlon->is_west()) {
			$lon_dir = 'W';
			$lon_adj = 1;
		} else {
			$lon_dir = 'E';
			$lon_adj = 0;
		}
		
		return $lat_dir
			. sprintf("%02d", (integer)(abs($latlon->lat)+$lat_adj))
			. $lon_dir
			. sprintf("%03d", (integer)(abs($latlon->lon)+$lon_adj)).'.hgt';
	}
	
	function get_elevation(LatLon $latlon, $round=TRUE) {

		$lat_adj = (integer)$latlon->is_south();
		$lon_adj = (integer)$latlon->is_west();
		
		$y = abs($latlon->lat);
		$x = abs($latlon->lon);
		
		$filename = $this->data_path . $this->get_filename($latlon);
		if (!file_exists($filename)) {
			error_log("file not found '". $filename);
			return FALSE;
		}
		
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
	
		$fx = ($latlon->lon - ((integer)($latlon->lon * 1200) / 1200)) * 1200;
		$fy = ($latlon->lat - ((integer)($latlon->lat * 1200) / 1200)) * 1200;
	
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
