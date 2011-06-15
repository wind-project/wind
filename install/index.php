<?php
require_once dirname(__FILE__) . '/tools.php';
header('Content-Type: text/html;charset=utf-8;');

installation_session();

/*
 * Step initialization and calculation
 */
$steps = array(
	'welcome' => 'Platform installer',
	'deps' => 'Dependencies',
	'file_perms' => 'File permissions',
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
	<link rel="stylesheet" href="install.css">
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false" ></script>
	<script src="http://google-maps-utility-library-v3.googlecode.com/svn/tags/keydragzoom/2.0.5/src/keydragzoom_packed.js" type="text/javascript"></script>
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