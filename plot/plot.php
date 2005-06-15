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

include "link.php";

set_time_limit(120);

$width = (integer)$_GET['width'];
$height = (integer)$_GET['height'];
$a_lat = (float)$_GET['a_lat'];
$a_log = (float)$_GET['a_log'];
$b_lat = (float)$_GET['b_lat'];
$b_log = (float)$_GET['b_log'];
$a_ant = (float)$_GET['a_ant'];
$b_ant = (float)$_GET['b_ant'];
if ($width == 0) $width = 600;
if ($height == 0) $height = 300;


$point_b = new elevation(37.991, 23.7645); //john70

$point_a = new elevation(37.979, 23.7689); // ngia
$point_a = new elevation(37.9926, 23.771); // winner
$point_a = new elevation(38.0389, 23.7004); //nikpet
$point_a = new elevation(38.002, 23.7642); //bliz
$point_b = new elevation(37.99330, 23.77420); // thista

$point_a = new elevation($a_lat, $a_log);
$point_b = new elevation($b_lat, $b_log);

$image = plotlink($width, $height, $point_a, $point_b, $a_ant, $b_ant);

header('Content-type: image/png');
imagepng($image);

?>