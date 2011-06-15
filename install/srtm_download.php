<?php
ini_set('max_execution_time', 300);
header('Content-Type: application/json');

require_once dirname(__FILE__) . '/../globals/classes/srtm.php';

if (!isset($_GET['lat']) || !isset($_GET['lng']))
	return;
	
$base_url = 'http://dds.cr.usgs.gov/srtm/version2_1/SRTM3/';
$srtm_directory = dirname(__FILE__) . '/../files/srtm/';
$fname = srtm::get_filename((int)$_GET['lat'], (int)$_GET['lng']);
$zip_fname = $fname . '.zip';
$regions = array(
	'Africa',
	'Australia',
	'Eurasia',
	'Islands',
	'North_America',
	'South_America'
);

/*
 * Search file in all regions
 */
foreach($regions as $region) {

	if (!($srtm_data = @file_get_contents($base_url . '/' . $region .'/' . $zip_fname)))
		continue;
	
	file_put_contents($srtm_directory . $zip_fname, $srtm_data);
	if (!($zip = zip_open($srtm_directory . $zip_fname))){
		echo json_encode(array('result' => '500', 'error' => 'cannot unzip'));
		return;
	}
	while($e = zip_read($zip)) {
		if (zip_entry_name($e) !== $fname)
			continue;
			
		zip_entry_open($zip, $e, "r");
		
		$uncompressed = zip_entry_read($e, zip_entry_filesize($e));
		file_put_contents($srtm_directory . $fname, $uncompressed);
		zip_close($zip);
		unlink($srtm_directory . $zip_fname);
		echo json_encode(array('result' => 'ok'));
		return;
	}
}

echo json_encode(array('result' => '404'));
return;