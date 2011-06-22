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
<p class="description"> WiND depends on external information about the elevation of the ground. These data are
distributed freely by NASA and they are called SRTM. The installer will download the needed files for you. 
</p>
<?php 

require_once dirname(__FILE__) . '/../../globals/classes/srtm.php';

// Calculate needed files
$needed_files = array();
$bounds = $_SESSION['config']['gmap']['bounds'];

for($lat = floor($bounds['min_latitude']); $lat <= ceil($bounds['max_latitude']);$lat += 1) {
	// Clamp
	if ($lat > 90)
		$lat = -90;
	for($lng = floor($bounds['min_longitude']); $lng <= ceil($bounds['max_longitude']);$lng += 1) {
		// clamp
		if ($lng > 180)
			$lng = -180;
			
		$fname = srtm::get_filename($lat, $lng);
		$needed_files[$fname] = array(
			'exists' => file_exists(dirname(__FILE__) . '/../../files/srtm/' . $fname),
			'lat' => $lat,
			'lng' => $lng
		);
	}
}

$web_folders = array(
	'Africa',
	'Australia',
	'Eurasia',
	'Islands',
	'North_America',
	'South_America'
);

if (!extension_loaded('zip') || !function_exists('zip_open')) {
	show_error('You need <strong>"zip"</strong> extension to download srtm files.');
	return true;
}

echo '<ul class="srtm">';
foreach($needed_files as $fname => $data) {
	echo '<li data-lat="' . $data['lat']. '" data-lng="' . $data['lng']. '" class="' . ($data['exists']?'existing':'missing') .'">' 
		. '<span>'. $fname . '</span></li>';
}
echo '</ul>';
echo '<div style="clear: both;"> </div>';
?>
<script type="text/javascript">
$(document).ready(function(){
	total_downloads = 0;

	function updateDownloadStatus(){
		if (total_downloads) {			
			$('.continue a').html(' <small>('+ total_downloads +')</small> Skip >');
		} else {
			$('.continue a').text(' Continue >');
		}
	}
	
	$(document).ajaxSend(function(){
		total_downloads += 1;
		updateDownloadStatus();
	});

	$(document).ajaxComplete(function(){
		total_downloads -= 1;
		updateDownloadStatus();
	});

	
	$('ul.srtm li.missing').each(function(){
		var lat = $(this).data('lat');
		var lng = $(this).data('lng');
		var li = $(this);

		li.addClass('downloading');
		$.get('srtm_download.php?lat=' + lat +'&lng=' + lng, function(resp){
			if ((typeof(resp.result) != 'undefined') && (resp['result'] == 'ok')) {
				li.removeClass('missing');
				li.addClass('existing');
			} else {
				li.addClass('error');
			}
			li.removeClass('downloading');
		});
	});
});
</script>
<?php 
return true;