<?php
/*
* WiND - Wireless Nodes Database
*
* Copyright (C) 2006 John Kolovos <cirrus@awmn.net>
* Copyright (C) 2011 Vasilis Tsiligiannis <b_tsiligiannis@silverton.gr>
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

class gearth_download {

	var $tpl;

	function gearth_download() {
	}

	function output() {
		global $db, $lang, $vars, $tl, $php_start;
		$desc= "";
		$bb = "";
		$clients = "";
		$ap = "";
		$selected = "";
		$links_bb = "";
		$links_clients = "";
		$unlinked = "";
		if (get('node') != '') {
			$node = $db->get('latitude, longitude', 'nodes', "id = ".intval(get('node')));
			$node = $node[0];
		}

		if (get('node') != '') $having .= ($having!=''?' OR ':'')."id = ".intval(get('node'));
		if (get('node2') != '') $having .= ($having!=''?' OR ':'')."id = ".intval(get('node2'));
		if (get('show_p2p') == 1) $having .= ($having!=''?' OR ':'').'total_p2p > 0';
		if (get('show_aps') == 1) $having .= ($having!=''?' OR ':'').'total_aps > 0';
		if (get('show_clients') == 1) $having .= ($having!=''?' OR ':'').'(total_p2p = 0 AND total_aps = 0 AND total_client_on_ap > 0)';
		if (get('show_unlinked') == 1) $having .= ($having!=''?' OR ':'').'(total_p2p = 0 AND total_aps = 0 AND total_client_on_ap = 0)';
		if ($having != '') $nodes = $db->get(
		'nodes.id, nodes.latitude, nodes.longitude, nodes.name AS nodes__name, areas.name AS areas__name, COUNT(DISTINCT p2p.id) AS total_p2p, COUNT(DISTINCT aps.id) AS total_aps, COUNT(DISTINCT clients.id) AS total_clients, COUNT(DISTINCT client_ap.id) AS total_client_on_ap',
		'nodes
			LEFT JOIN areas ON nodes.area_id = areas.id
			LEFT JOIN links AS p2p_t ON nodes.id = p2p_t.node_id
			LEFT JOIN links AS p2p ON p2p.type = "p2p" AND p2p_t.peer_node_id = p2p.node_id AND p2p.peer_node_id = p2p_t.node_id
			LEFT JOIN links AS aps ON nodes.id = aps.node_id AND aps.type = "ap"
			LEFT JOIN links AS client_ap ON p2p_t.type = "client" AND client_ap.type = "ap" AND p2p_t.peer_ap_id = client_ap.id
			LEFT JOIN links AS clients ON p2p_t.type = "ap" AND clients.type = "client" AND clients.peer_ap_id = p2p_t.id
			INNER JOIN users_nodes ON nodes.id = users_nodes.node_id
			LEFT JOIN users ON users.id = users_nodes.user_id',
			"users.status = 'activated'",
			'nodes.id' .
			($having!=''?' HAVING '.$having:''));

			foreach ((array) $nodes as $key => $value) {
				$xml2 = "<Placemark>";
				$xml2 .= "<description>";
				$xml2 .= $lang['db']['nodes__id'].": ".$value['id']."<br />";
				$xml2 .= htmlspecialchars($value['areas__name'], ENT_COMPAT, $lang['charset'])."<br />";
				if ($value['total_p2p'] != 0) $xml2 .= $lang['backbone']." ".$lang['links'].": ".$value['total_p2p']."<br />";
				if ($value['total_aps'] != 0) {
					if($value['total_aps'] = 1) $xml2 .= $lang['ap'].": ".$value['total_aps']."<br />";
					else  $xml2 .= $lang['aps'].": ".$value['total_aps']."<br />";
				}
				if ($value['total_clients'] != 0) $xml2 .= $lang['clients'].": ".$value['total_clients']."<br />";
				$xml2 .= "<a href=\"".$vars['site']['url'].makelink(array("page" => "nodes", "node" => $value['id'], "show_map" => "no"))."\">".$lang['node_page']."</a><br />";
				$xml2 .= "</description>";
				$xml2 .= "<name>".htmlspecialchars($value['nodes__name'], ENT_COMPAT, $lang['charset'])."</name>\n";
				$xml2 .= "<LookAt>\n";
				$xml2 .= "<longitude>".$value['longitude']."</longitude>\n";
				$xml2 .= "<latitude>".$value['latitude']."</latitude>\n";
				$xml2 .= "<range>1600</range>\n";
				$xml2 .= "</LookAt>\n";
				$xml2 .= "<Point>\n";
				//add height sta coordinates
				$xml2 .= "<coordinates>".$value['longitude'].",".$value['latitude'].",0</coordinates>\n";
				$xml2 .= "</Point>\n";
				$xml2 .= "<Style>\n";
				$xml2 .= "<IconStyle>\n";
				if ($value['id'] == get('node')) {
					$xml2 .= "<scale>0.6</scale>\n";
					$xml2 .= "<Icon>\n";
					$xml2 .= "<href>".$vars['site']['url']."templates/basic/images/gmap/mm_50_grey.png</href>\n";
					$xml2 .= "</Icon>\n";
					$xml2 .= "</IconStyle>\n";
					$xml2 .= "</Style>\n";
					$xml2 .= "</Placemark>\n";
					$selected_node['longitude'] = $value['longitude'];
					$selected_node['latitude'] = $value['latitude'];
					$selected_node['name'] = $value['nodes__name'];
					$selected_node['id'] = $value['id'];
					$selected .= $xml2;
				} elseif ($value['id'] == get('node2')) {
					$xml2 .= "<scale>0.6</scale>\n";
					$xml2 .= "<Icon>\n";
					$xml2 .= "<href>".$vars['site']['url']."templates/basic/images/gmap/mm_50_grey.png</href>\n";
					$xml2 .= "</Icon>\n";
					$xml2 .= "</IconStyle>\n";
					$xml2 .= "</Style>\n";
					$xml2 .= "</Placemark>\n";
					$selected2_node['longitude'] = $value['longitude'];
					$selected2_node['latitude'] = $value['latitude'];
					$selected2_node['name'] = $value['nodes__name'];
					$selected2_node['id'] = $value['id'];
					$selected2 = $xml2;
				} elseif ($value['total_aps'] != 0 ) {
					$xml2 .= "<scale>0.6</scale>\n";
					$xml2 .= "<Icon>\n";
					$xml2 .= "<href>".$vars['site']['url']."templates/basic/images/gmap/mm_50_green.png</href>\n";
					$xml2 .= "</Icon>\n";
					$xml2 .= "</IconStyle>\n";
					$xml2 .= "</Style>\n";
					if(isset($selected2))
						$xml2 .= "<visibility>0</visibility>\n";
					else
						$xml2 .= "<visibility>1</visibility>\n";
					$xml2 .= "</Placemark>\n";
					$ap .= $xml2;
				} elseif ($value['total_p2p'] != 0 ) {
					$xml2 .= "<scale>0.6</scale>\n";
					$xml2 .= "<Icon>\n";
					$xml2 .= "<href>".$vars['site']['url']."templates/basic/images/gmap/mm_50_orange.png</href>\n";
					$xml2 .= "</Icon>\n";
					$xml2 .= "</IconStyle>\n";
					$xml2 .= "</Style>\n";
					if(isset($selected2))
						$xml2 .= "<visibility>0</visibility>\n";
					else
						$xml2 .= "<visibility>1</visibility>\n";
					$xml2 .= "</Placemark>\n";
					$bb .= $xml2;
				} elseif ($value['total_client_on_ap'] != 0) {
					$xml2 .= "<scale>0.4</scale>\n";
					$xml2 .= "<Icon>\n";
					$xml2 .= "<href>".$vars['site']['url']."templates/basic/images/gmap/mm_20_blue.png</href>\n";
					$xml2 .= "</Icon>\n";
					$xml2 .= "</IconStyle>\n";
					$xml2 .= "</Style>\n";
					if(isset($selected2))
						$xml2 .= "<visibility>0</visibility>\n";
					else
						$xml2 .= "<visibility>1</visibility>\n";
					$xml2 .= "</Placemark>\n";
					$clients .= $xml2;
				} else {
					$xml2 .= "<scale>0.4</scale>\n";
					$xml2 .= "<Icon>\n";
					$xml2 .= "<href>".$vars['site']['url']."templates/basic/images/gmap/mm_20_red.png</href>\n";
					$xml2 .= "</Icon>\n";
					$xml2 .= "</IconStyle>\n";
					$xml2 .= "</Style>\n";
					$xml2 .= "<visibility>0</visibility>\n";
					$xml2 .= "</Placemark>\n";
					$unlinked .= $xml2;
				}
				unset($xml2);
			}
			unset($nodes);
			if (get('show_links_p2p') == 1) $where .= ($where!=''?' OR ':'')."p2p.type = 'p2p'";
			if (get('show_clients') == 1 && get('show_links_client') == 1) $where .= ($where!=''?' OR ':'')."clients.type = 'client'";
			if ($where != '') $links = $db->get(
			'n1.id AS node1_id, n1.name AS node1_name, IFNULL(n_p2p.id, n_clients.id) AS node2_id, IFNULL(n_p2p.name, n_clients.name) AS node2_name, IFNULL(p2p.id, clients.id) AS id, IFNULL(p2p.type, clients.type) AS type, n1.latitude AS n1_lat, n1.longitude AS n1_lon, IFNULL(n_p2p.latitude, n_clients.latitude) AS n2_lat, IFNULL(n_p2p.longitude, n_clients.longitude) AS n2_lon, l1.status AS l1_status, IFNULL(p2p.status, clients.status) AS l2_status',
			'links AS l1 ' .
			"LEFT JOIN links AS p2p ON (l1.id < p2p.id AND l1.type = 'p2p' AND p2p.type = 'p2p' AND l1.node_id = p2p.peer_node_id AND p2p.node_id = l1.peer_node_id) " .
			"LEFT JOIN links AS clients ON (l1.type = 'ap' AND clients.type = 'client' AND l1.id = clients.peer_ap_id) " .
			"LEFT JOIN nodes AS n1 ON l1.node_id = n1.id " .
			"LEFT JOIN nodes AS n_p2p ON p2p.node_id = n_p2p.id " .
			"LEFT JOIN nodes AS n_clients ON clients.node_id = n_clients.id",
			($where!=''?'('.$where.')':'')." HAVING n1_lat IS NOT NULL AND n1_lon IS NOT NULL AND n2_lat IS NOT NULL AND n2_lon IS NOT NULL"
			);

			foreach ((array) $links as $key => $value) {
				if(($value['l1_status']!='active' || $value['l2_status']!='active'?'inactive':'active')=='active') {
					$xml2 = "<Placemark>\n";
					$xml2 .= "<name>".htmlspecialchars($value['node1_name'])." (#".$value['node1_id'].") - ".htmlspecialchars($value['node2_name'])." (#".$value['node2_id'].")</name>\n";
					
					if(isset($selected2))
						$xml2 .= "<visibility>0</visibility>\n";
					else
						$xml2 .= "<visibility>1</visibility>\n";
					$xml2 .= "<Style>\n";
					$xml2 .= "<LineStyle>\n";
					if($value['type'] == "p2p")
					$xml2 .= "<color>ff00aa00</color>\n";
					elseif ($value['type'] == "client")
					$xml2 .= "<color>ffd60000</color>\n";
					$xml2 .= "<width>3.5</width>\n";
					$xml2 .= "</LineStyle>\n";
					$xml2 .= "<PolyStyle>\n";
					$xml2 .= "<color>7f00ff00</color>\n";
					$xml2 .= "</PolyStyle>\n";
					$xml2 .= "</Style>\n";
					$xml2 .= "<LineString>\n";
					$xml2 .= "<extrude>0</extrude>\n";
					$xml2 .= "<tessellate>0</tessellate>\n";
					$xml2 .= "<altitudeMode>clampedToGround</altitudeMode>\n";
					$xml2 .= "<coordinates>\n";
					$xml2 .= $value['n1_lon'].",".$value['n1_lat'].",0\n";
					$xml2 .= $value['n2_lon'].",".$value['n2_lat'].",0\n";
					$xml2 .= "</coordinates>\n";
					$xml2 .= "</LineString>\n";
					$xml2 .= "</Placemark>\n";
					if($value['type'] == "p2p")
						$links_bb .= $xml2;
					elseif ($value['type'] == "client")
						$links_clients .= $xml2;
				}
				unset($xml2);
			}

			unset($links);

			$xml = "<?xml version='1.0' encoding='".$lang['charset']."'?>\n";
			$xml .= "<kml xmlns='http://earth.google.com/kml/2.0'>\n";
			$xml .= "<Folder>\n";
			$xml .= "<name>".$lang['title_small']."</name>\n";
			$xml .= "<open>1</open>\n";
			$xml .= "<description>".$lang['all_nodes']."</description>\n";
			$xml .= "<LookAt>\n";
			if($selected_node['latitude'] != "") {
				$xml .= "<longitude>".$selected_node['longitude']."</longitude>\n";
				$xml .= "<latitude>".$selected_node['latitude']."</latitude>\n";
				$xml .= "<range>1600</range>\n";
			} else {
				$long = str_replace(",",".",($vars['gmap']['bounds']['max_longitude'] + $vars['gmap']['bounds']['min_longitude'])/2);
				$lat = str_replace(",",".",($vars['gmap']['bounds']['max_latitude'] + $vars['gmap']['bounds']['min_latitude'])/2);
				$xml .= "<longitude>".$long."</longitude>\n";
				$xml .= "<latitude>".$lat."</latitude>\n";
				$xml .= "<range>40000</range>\n";
			}
			$xml .= "</LookAt>\n";
			if($selected != "") {
				$xml .= $selected;
				if(isset($selected2)) {
					$xml .= $selected2;
					$xml .= "<Placemark>\n";
					$xml .= "<name>".htmlspecialchars($selected_node['name'])." (#".$selected_node['id'].") - ".htmlspecialchars($selected2_node['name'])." (#".$selected2_node['id'].")</name>\n";
					$xml .= "<visibility>1</visibility>\n";
					$xml .= "<Style>\n";
					$xml .= "<LineStyle>\n";
					$xml .= "<width>5</width>\n";
					$xml .= "</LineStyle>\n";
					$xml .= "<PolyStyle>\n";
					$xml .= "<color>7f00ff00</color>\n";
					$xml .= "</PolyStyle>\n";
					$xml .= "</Style>\n";
					$xml .= "<LineString>\n";
					$xml .= "<extrude>0</extrude>\n";
					$xml .= "<tessellate>0</tessellate>\n";
					$xml .= "<altitudeMode>clampedToGround</altitudeMode>\n";
					$xml .= "<coordinates>\n";
					$xml .= $selected_node['longitude'].",".$selected_node['latitude'].",0\n";
					$xml .= $selected2_node['longitude'].",".$selected2_node['latitude'].",0\n";
					$xml .= "</coordinates>\n";
					$xml .= "</LineString>\n";
					$xml .= "</Placemark>\n";
				}
			}
			$xml .= "<Folder>\n";
			$xml .= "<name>".$lang['nodes']."</name>\n";
			$xml .= "<Folder>\n";
			$xml .= "<name>".$lang['backbone']."</name>\n";
			$xml .= "<open>0</open>\n";
			if(isset($selected2))
				$xml .= "<visibility>0</visibility>\n";
			else
				$xml .= "<visibility>1</visibility>\n";
			$xml .= $bb;
			unset($bb);
			$xml .= "</Folder>\n";
			$xml .= "<Folder>\n";
			$xml .= "<name>".$lang['aps']."</name>\n";
			$xml .= "<open>0</open>\n";
			if(isset($selected2))
				$xml .= "<visibility>0</visibility>\n";
			else
				$xml .= "<visibility>1</visibility>\n";
			$xml .= $ap;
			unset($ap);
			$xml .= "</Folder>\n";
			if (get('show_clients') == 1) {
				$xml .= "<Folder>\n";
				$xml .= "<name>".$lang['clients']."</name>\n";
				$xml .= "<visibility>0</visibility>\n";
				$xml .= "<open>0</open>\n";
				$xml .= $clients;
				unset($clients);
				$xml .= "</Folder>\n";
			}
			if($unlinked!="") {
				$xml .= "<Folder>\n";
				$xml .= "<name>".$lang['unlinked']."</name>\n";
				$xml .= "<visibility>0</visibility>\n";
				$xml .= "<open>0</open>\n";
				$xml .= $unlinked;
				unset($unlinked);
				$xml .= "</Folder>\n";
			}
			$xml .= "</Folder>";
			if (get('show_links_p2p') == 1) {
				$xml .= "<Folder>\n";
				$xml .= "<name>".$lang['links']."</name>\n";
				$xml .= "<Folder>\n";
				$xml .= "<name>".$lang['backbone']."</name>\n";
				$xml .= "<open>0</open>\n";
				if(isset($selected2))
					$xml .= "<visibility>0</visibility>\n";
				else
					$xml .= "<visibility>1</visibility>\n";
				$xml .= $links_bb;
				unset($links_bb);
				$xml .= "</Folder>\n";
				if (get('show_clients') == 1 && get('show_links_client') == 1) {
					$xml .= "<Folder>\n";
					$xml .= "<name>".$lang['clients']."</name>\n";
					$xml .= "<open>0</open>\n";
					if(isset($selected2))
						$xml .= "<visibility>0</visibility>\n";
					else
						$xml .= "<visibility>1</visibility>\n";
					$xml .= $links_clients;
					unset($links_clients);
					$xml .= "</Folder>\n";
				}
				$xml .= "</Folder>\n";

			}
			$xml .= "<ScreenOverlay>\n";
  			$xml .= "<name>WiND Logo</name>\n";
  			$xml .= "<drawOrder>99</drawOrder>\n";
  			$xml .= "<Icon>\n";
    		$xml .= "<href>".$vars['site']['url']."templates/basic/images/windlogo_watermark.png</href>";
  			$xml .= "</Icon>\n";
  			$xml .= "<overlayXY x=\"0\" y=\"1\" xunits=\"fraction\" yunits=\"fraction\"/>\n";
  			$xml .= "<screenXY x=\"0\" y=\"1\" xunits=\"fraction\" yunits=\"fraction\"/>\n";
			$xml .= "</ScreenOverlay>\n";
			$xml .= "<ScreenOverlay>\n";
  			$xml .= "<name>Legend</name>\n";
  			$xml .= "<drawOrder>99</drawOrder>\n";
  			$xml .= "<Icon>\n";
  			if($lang['iso639'] == "en")
    			$xml .= "<href>".$vars['site']['url']."templates/basic/images/legend_en.png</href>";
    		elseif($lang['iso639'] == "el")
    			$xml .= "<href>".$vars['site']['url']."templates/basic/images/legend.png</href>";
  			$xml .= "</Icon>\n";
  			$xml .= "<overlayXY x=\"0\" y=\"0\" xunits=\"fraction\" yunits=\"fraction\" />\n";
  			$xml .= "<screenXY x=\"0\" y=\"14\" xunits=\"fraction\" yunits=\"pixels\" />\n";
			$xml .= "</ScreenOverlay>\n";
			$xml .= "</Folder>\n";
			$xml .= "</kml>\n";
			$time = getmicrotime() - $php_start;
			$xml .= "<!-- time taken to compile: ".$time."-->";
			$xml .= "<!-- Geneterated by WiND -->";

			header("Expires: 0");
			header("Content-Disposition: attachment; filename=".$lang['title_small'].".kml");
			header("Content-type: application/vnd.google-earth.kml; charset=".$lang['charset']);
			echo $xml;
			exit;


	}

}

?>
