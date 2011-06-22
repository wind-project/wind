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
 
?>
<p class="description">Some folders must be writtable by the script itself.
If any check fails, then make the folder writable by web server process and retry.</p>
<?php
$step_result = true;

$writable_dir = array(
	'/files/photos',
	'/files/srtm',
	'/templates/_compiled',
	'/templates/_compiled/basic',
	'/config',	
);

$overwritable = array(
	'/config/config.php'
);

function result_list_item($result, $dir) {
	global $step_result;
	$result_text = result_text($result);
	echo "<li class=\"$result_text\"> Permissions for \"<strong>$dir</strong>\"  <span class=\"result\">{$result_text}</span></li>";
	if (!$result)
		$step_result = false;
}


echo '<ul class="checks">';
foreach($writable_dir as $dir) {
	$fdir = $_GLOBALS['root_path'] . '/' . $dir;
	$result = is_dir($fdir) && is_writable($fdir);
	result_list_item($result, $dir);
}
foreach($overwritable as $dir) {
	$fdir = $_GLOBALS['root_path'] . '/' . $dir;
	$result = !file_exists($fdir) || is_writable($fdir);
	result_list_item($result, $dir);
}
echo '</ul>';

if (!$step_result) {
	show_error('You must first fix file permissions and then continue.');
	return false;
}

return $step_result;