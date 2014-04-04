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

ini_set('max_execution_time', 300);
header('Content-Type: application/json');

require_once dirname(__FILE__) . '/../globals/classes/srtm.php';

if (!isset($_GET['lat']) || !isset($_GET['lng']))
	return;
	
$base_url = 'http://dds.cr.usgs.gov/srtm/version2_1/SRTM3/';
$srtm_directory = dirname(__FILE__) . '/../files/srtm/';
$fname = srtm::get_filename(new LatLon((int)$_GET['lat'], (int)$_GET['lng']));
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