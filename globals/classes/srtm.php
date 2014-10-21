<?php
/*
 * WiND - Wireless Nodes Database
 * 
 * Copyright (C) 2005-2014 	by WiND Contributors (see AUTHORS.txt)
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
 * Class to handle SRTM Data
 */
class srtm {
	
	var $data_path;
	
	function __construct($data_path='') {
		$this->data_path = $data_path;
	}
	
        public static function get_filename($lat, $lon) {
                $ll = srtm::get_lat_long_adjustments($lat, $lon);
                //print_R($ll);
                //always return filename with positive numbers (eg S-33 -> S33)
                return $ll['lat_dir'] . sprintf("%02.0f", abs((integer)($lat+$ll['lat_adj'])))
                  .$ll['lon_dir'].sprintf("%03.0f", abs((integer)($lon+$ll['lon_adj']))).'.hgt';
        }

        function get_lat_long_adjustments($lat,$lon) {
          if ($lat < 0) {
            $r['lat_dir'] = 'S';
            $r['lat_adj'] = 1;
          } else {
            $r['lat_dir'] = 'N';
            $r['lat_adj'] = 0;
          }
          if ($lon < 0) {
            $r['lon_dir'] = 'W';
            $r['lon_adj'] = 1;
          } else {
            $r['lon_dir'] = 'E';
            if ($r['lat_dir'] == 'S') {
              $r['lon_adj'] = -1;
            } else {
              $r['lon_adj'] = 0;
            }
          }
          return $r;
        }

        function get_elevation($lat, $lon, $round=TRUE) {

		$filename = $this->data_path.$this->get_filename($lat,$lon);

		if ($lat === '' || $lon === '' || !file_exists($filename)) return FALSE;

		$file = fopen($filename, 'r');

		$ll = $this->get_lat_long_adjustments($lat,$lon);
		$lat_dir = $ll['lat_dir'];
		$lat_adj = $ll['lat_adj'];
		$lon_dir = $ll['lon_dir'];
		$lon_adj = $ll['lon_adj'];
		$y = $lat;
		$x = $lon;

		$offset = ( (integer)(($x - (integer)$x + $lon_adj) * 1200)
			* 2 + (1200 - (integer)(($y - (integer)$y + $lat_adj) * 1200)) 
			* 2402 );
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
