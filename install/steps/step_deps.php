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

$step_result = true;

/**
 * Function to check WiND dependencies 
 */
function check_wind_dependencies() {	
	$dependancies = array();
	
	// PHP Version
	$phpversion = explode('.', phpversion());
	$dependancies['PHP Version >= 5.3'] = ($phpversion[0] >= 5 && $phpversion[1] >=3);
	
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