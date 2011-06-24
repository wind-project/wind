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

require_once dirname(__FILE__) . '/tools.php';
header('Content-Type: text/html;charset=utf-8;');


installation_session();
ob_start();
/*
 * Step initialization and calculation
 */
$steps = array(
	'welcome' => 'Platform installer',
	'deps' => 'Dependencies',
	'file_perms' => 'File permissions',
	'community' => 'Community Information',
	'smarty' => 'Smarty configuration',
	'dbsetup' => 'Setup database',
	'dbinit' => 'Initialize database',
	'mapbounds' => 'Setup map boundaries',
	'gmap' => 'Google Maps API key',
	'srtm' => 'Nasa SRTM data files',
	'final' => 'Finish');
$step_keys = array_keys($steps);

if (!isset($_GET['step'])) {
	$_SESSION['step'] = $step_current = $step_keys[0]; 
} else {
	$step_current = (!isset($_SESSION['step']) || !in_array($_SESSION['step'], $step_keys))?$step_keys[0]:$_SESSION['step'];
	if ($_GET['step'] == get_next_step($steps, $step_current))
		$_SESSION['step'] = $step_current = get_next_step($steps, $step_current);	
}
$next_step = get_next_step($steps, $step_current);
$step_current_index = array_search($step_current, $step_keys);

?>
<!DOCTYPE html>
<html>
<head>
	<title>WiND - Installation</title>
	<link rel="stylesheet" href="<?php echo surl('/../templates/basic/css/styles_packed.css')?>" >
	<link rel="icon" type="image/png" href="<?php echo surl('/../templates/basic/images/favicon_32.png')?>" / >
	<link rel="stylesheet" href="install.css">
		
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>	
	
</head>
<body>
<div class="header">
<img alt="WiND Logo" src="<?php echo surl('/../templates/basic/images/main_logo.png');?>">
<ul class="steps">
<?php foreach($step_keys as $idx => $sk) {	
	if ($idx < $step_current_index)
		echo '<li class="previous"><span>' . ($idx + 1) . '</span></li>'; 
	else if ($idx ==  $step_current_index)
		echo '<li class="current"><span>' . ($idx + 1) . '</span></li>';
	else
		echo '<li class="next"><span>' . ($idx + 1) . '</span></li>';
}
	
?>
</ul>
<h1>Installation</h1>
</div>
<div id="content">
<?php
	echo "<h2>{$steps[$step_current]}</h2>";
	// Show current step and continue to next one.
	$result = include_once(dirname(__FILE__) . "/steps/step_{$step_current}.php");
		if ($next_step){
		if ($result === 'auto') {
			header("Location: ?step={$next_step}");
			exit;
		} else if($result)
			echo "<span class=\"continue\"><a  href=\"?step={$next_step}\">Continue ></a></span>";
	}
?>
</div>
<div class="footer">
Powered by: <a href="http://wind.cube.gr/"><b>WiND - Wireless Nodes Database project</b></a><br/>
&copy; 2005-2011 <a href="http://wind.cube.gr/wiki/Team">WiND development team</a>
</div>
</body>
</html>

<?php
ob_end_flush(); 
?>