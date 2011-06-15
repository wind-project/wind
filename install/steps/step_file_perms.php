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