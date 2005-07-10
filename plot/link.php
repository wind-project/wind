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

include $plot_path."elevation.php";
include $plot_path."../globals/classes/geocalc.php";

class elevation {
	var $lat;
	var $log;

	function elevation($lat, $log) {
		$this->lat = $lat;
		$this->log = $log;
	}		
}

function plotlink($width, $height, $point_a, $point_b, $antenna_a=0, $antenna_b=0) {
	$gc = new geocalc();
	$distance = $gc->GCDistance($point_a->lat, $point_a->log, $point_b->lat, $point_b->log) * 1000;

	$image = imagecreate($width, $height);
	$ground_pad = $height * (1 / 20);
	$sky_pad = $height * (1 / 20);
	$left_pad = 0;
	$right_pad = 0;
	
	$width = $width - $left_pad - $right_pad;
	
	$color_sky = ImageColorAllocate($image, 99, 200, 248);
	$color_ground = ImageColorAllocate($image, 177, 125, 86);
	$color_antenna = ImageColorAllocate($image, 0, 0, 0);
	$color_sea = ImageColorAllocate($image, 0, 0, 200);
	$black = ImageColorAllocate($image, 0, 0, 0);
	$color_link_on = ImageColorAllocate($image, 57, 187, 77);
	$color_link_off = ImageColorAllocate($image, 211, 97, 97);
	
	$step_lat = ($point_b->lat - $point_a->lat) / ($width - 1);
	$step_log = ($point_b->log - $point_a->log) / ($width - 1);
	for ($i=0;$i<$width;$i++) {
		$elevations[$i] = get_elevation($point_a->lat + $step_lat * $i, $point_a->log + $step_log * $i, FALSE);
		if ($point_a->lat == '' || $point_a->log == '' || $point_b->lat == '' || $point_b->log == '' || $elevations[$i] === FALSE) {
			imagestring ($image, 5, 10, 10, "Data error!", $black);
			return $image;
		}
		if ($elevations[$i] < -32000) {
			$elevations[$i] = $elevations[$i-1];
		}
	}
	$max_el = max($elevations) + max($antenna_a, $antenna_b);
	$min_el = min($elevations);
	
	$step_elevation = ($max_el - $min_el) / ($height - $ground_pad - $sky_pad);
	
	//$step_elevation = $distance / $width; //step_elevation for real distances plotting
	
	$antenna_a_se = $antenna_a / $step_elevation;
	$antenna_b_se = $antenna_b / $step_elevation;
	
	for ($i=0;$i<$width;$i++) {
		//GROUND
		$pixels_el = ($elevations[$i] - $min_el) / $step_elevation;
		$y1 = $height - 1 - $ground_pad - $pixels_el;
		$y2 = $height - 1;
		imagelinethick($image, $left_pad + $i, $y1, $left_pad + $i, $y2, $color_ground);
		
		//SEA
		if ($elevations[$i] < 0) {
			$pixels_el = (0 - $min_el) / $step_elevation;
			$y2 = $y1;
			$y1 = $height - 1 - $ground_pad - $pixels_el;
			imagelinethick($image, $left_pad + $i, $y1, $left_pad + $i, $y2, $color_sea);
		}
		
		//ANTENNA A
		if ($i ==0) {
			$ant_a = $y1 - $antenna_a_se;
			imagelinethick($image, $left_pad + $i, $y1, $left_pad + $i, $ant_a, $color_antenna, 2);
		}
		
		//ANTENNA B
		if ($i == $width-2) { 
			$ant_b = $y1 - $antenna_b_se;
			imagelinethick($image, $left_pad + $i, $y1, $left_pad + $i, $ant_b, $color_antenna, 2);
		}
	}
	
	$color_link = $color_link_on;
	for ($i=0;$i<$width;$i++) {
		if (imagecolorat($image, $left_pad + $i, $ant_a + $i * ($ant_b - $ant_a) / ($width - 1)) == $color_ground) {
			$color_link = $color_link_off;
			break;
		}
	}
	imagelinethick($image, $left_pad + 0, $ant_a, $left_pad + $width - 1, $ant_b, $color_link, 2);

	//FRESNEL ZONE
	$freq = 2400;
	for ($i=1;$i<$width-1;$i++) {
		$d1 = ($i / $width) * $distance;
		if ( (integer)($i / 2) % 2 == 0) { // dashed line
			$fresnel = 17.32 * sqrt(($d1*($distance-$d1)) / ($freq * $distance));
			imagesetpixel($image, $left_pad + $i, ($ant_a + $i * ($ant_b - $ant_a) / ($width - 1)) + $fresnel / $step_elevation, $color_link);
			imagesetpixel($image, $left_pad + $i, ($ant_a + $i * ($ant_b - $ant_a) / ($width - 1)) - $fresnel / $step_elevation, $color_link);
		}
		
		$fresnel06 = 0.6 * 17.32 * sqrt(($d1*($distance-$d1)) / ($freq * $distance));
		imagesetpixel($image, $left_pad + $i, ($ant_a + $i * ($ant_b - $ant_a) / ($width - 1)) + $fresnel06 / $step_elevation, $color_link);
		imagesetpixel($image, $left_pad + $i, ($ant_a + $i * ($ant_b - $ant_a) / ($width - 1)) - $fresnel06 / $step_elevation, $color_link);
	}
	
	return $image;
}

function imagelinethick($image, $x1, $y1, $x2, $y2, $color, $thick = 1) 
{
   /* this way it works well only for orthogonal lines
   imagesetthickness($image, $thick);
   return imageline($image, $x1, $y1, $x2, $y2, $color);
   */
   if ($thick == 1) {
       return imageline($image, $x1, $y1, $x2, $y2, $color);
   }
   $t = $thick / 2 - 0.5;
   if ($x1 == $x2 || $y1 == $y2) {
       return imagefilledrectangle($image, round(min($x1, $x2) - $t), round(min($y1, $y2) - $t), round(max($x1, $x2) + $t), round(max($y1, $y2) + $t), $color);
   }
   $k = ($y2 - $y1) / ($x2 - $x1); //y = kx + q
   $a = $t / sqrt(1 + pow($k, 2));
   $points = array(
       round($x1 - (1+$k)*$a), round($y1 + (1-$k)*$a),
       round($x1 - (1-$k)*$a), round($y1 - (1+$k)*$a),
       round($x2 + (1+$k)*$a), round($y2 - (1-$k)*$a),
       round($x2 + (1-$k)*$a), round($y2 + (1+$k)*$a),
   );    
   imagefilledpolygon($image, $points, 4, $color);
   return imagepolygon($image, $points, 4, $color);
}

?>