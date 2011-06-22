<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2011 K. Paliouras <squarious _at gmail [dot] com>
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

$step_result = true;

/**
 * Function to check WiND dependencies 
 */
function check_wind_dependencies() {	
	$dependancies = array();
	
	// PHP Version
	$phpversion = explode('.', phpversion());
	$dependancies['PHP Version >= 5.0'] = $phpversion[0] >= 5;
	
	// MySQL Support
	$dependancies['PHP-MySQL extension'] = (extension_loaded('mysql') && function_exists('mysql_connect'));
	
	// GD Library
	$dependancies['PHP-GD extension'] = (extension_loaded('gd') && function_exists('gd_info'));
	
	return $dependancies;
}

?>
<p class="description">
WiND depends on various subsystems. This ensures that all subsystems exist and support all needed features.</p>
<ul class="checks dependencies">
<?php 
foreach(check_wind_dependencies() as $dep => $result) {
	$result_text = result_text($result);
	echo "<li class=\"{$result_text}\" >$dep <span class=\"result\">{$result_text}</span></li>";
	if (!$result)
		$step_result = false;
}
?>  
</ul>
<?php 
if (!$step_result) {
	show_error('You must first fix dependencies and then continue');	
	return false;
}
return $step_result;