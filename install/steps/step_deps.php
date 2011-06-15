<?php

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