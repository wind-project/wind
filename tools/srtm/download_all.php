#!/usr/bin/env php
<?php

/**
 * Returns absolute path to srtm direactory based on configuration.
 * @return string
 */
function get_srtm_directory() {
	global $config;

	$srtm_directory = $config['srtm']['path'];
	if ($srtm_directory[0] != '/') {
		// It is relative folder so we have to resolve relatively
		// to website root
		
		$srtm_directory = dirname(__FILE__) . '/../../' . $srtm_directory;
	}
	
	return $srtm_directory;
}

/**
 * Get bounds from configuration file
 */
function get_bounds() {
	global $config;
	return $config['gmap']['bounds'];
}


/**
 * Get all SRTM regions
 */
function get_regions() {
	return array(
			'Africa',
			'Australia',
			'Eurasia',
			'Islands',
			'North_America',
			'South_America'
	);
}

/**
 * Get the list with all SRTM files to be downloaded 
 */
function srtm_files($bound_sw, $bound_ne) {
	// Calculate needed files
	$needed_files = array();
	
	for($lat = floor($bound_sw['lat']); $lat <= ceil($bound_ne['lat']);$lat += 1) {
		// Clamp
		if ($lat > 90)
			$lat = -90;
		for($lon = floor($bound_sw['lon']); $lon <= ceil($bound_ne['lon']);$lon += 1) {
			// clamp
			if ($lon > 180)
				$lon = -180;
				
			$fname = srtm::get_filename($lat, $lon);
			$needed_files[$fname] = array(
					'exists' => file_exists(get_srtm_directory() . "/" . $fname),
					'lat' => $lat,
					'lon' => $lon
			);
		}
	}
	return $needed_files;
}

/**
 * Download srtm files for a specific latitude and longitude.
 * @param int $lat
 * @param int $lng
 */
function download_srtm_for($lat, $lon) {
	global $config;
	$base_url = 'http://dds.cr.usgs.gov/srtm/version2_1/SRTM3/';
	$srtm_directory = get_srtm_directory() . "/";
	$fname = srtm::get_filename($lat, $lon);
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
			die("Cannot unzip file \"" . $srtm_directory . $zip_fname . "\"\n");
		}
		while($e = zip_read($zip)) {
			if (zip_entry_name($e) !== $fname)
				continue;
				
			zip_entry_open($zip, $e, "r");
	
			$uncompressed = zip_entry_read($e, zip_entry_filesize($e));
			file_put_contents($srtm_directory . $fname, $uncompressed);
			zip_close($zip);
			unlink($srtm_directory . $zip_fname);
			return true;
		}
	}
	die("Cannot find tile for {$lat},{$lon}\" in any region.\n");
}

//-------------------------------------------------------------------------
// STEP 1: System validation

//## Check php capabilities
if (!extension_loaded('zip') || !function_exists('zip_open')) {
	die("You need \"zip\" extension to download srtm files.\n");
}

//## Configuration checks
$config_file = dirname(__FILE__) . '/../../config/config.php';

if (! file_exists($config_file)) {
	die("Cannot find configuration file.\n");
}
require($config_file);

require_once dirname(__FILE__) . '/../../globals/classes/srtm.php';

//## SRTM path checks
if (! is_dir(get_srtm_directory())) {
	die("SRTM path (".get_srtm_directory().") does not exists.\n");
}

if (! is_writable(get_srtm_directory())) {
	die("SRTM path (".get_srtm_directory().") is not writable.\n");
}
print ("System is OK.\n");

//-------------------------------------------------------------------------
// STEP 2: Bounds checkings
$bounds = get_bounds();
$bound_sw = array('lat' => floatval($bounds['min_latitude']), 'lon' => floatval($bounds['min_longitude']));
$bound_ne = array('lat' => floatval($bounds['max_latitude']), 'lon' => floatval($bounds['max_longitude']));

if ($bound_sw['lat'] == $bound_ne['lat']) {
	die("North and south boundaries have same value of latitude\n");
}
if ($bound_sw['lon'] == $bound_ne['lon']) {
	die("West and east boundaries have same value of longitude\n");
}
print ("South West boundary at " . $bound_sw['lat'] . ",  ". $bound_sw['lon'] . "\n");
print ("North East boundary at " . $bound_ne['lat'] . ",  ". $bound_ne['lon'] . "\n");


//-------------------------------------------------------------------------
// STEP 3: Download files
foreach(srtm_files($bound_sw, $bound_ne) as $fname => $info) {
	print $fname . " ";
	
	// Skip existing
	if ($info['exists']) {
		print "SKIP (already exists)\n";
		continue;
	}
	print "downloading... ";
	
	if (download_srtm_for($info['lat'], $info['lon'])) {
		print "OK\n";
	}
}
print "Download of all needed srtm files, finshed succesfully!\n";