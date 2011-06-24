<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
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

class gmap_js {
	
	var $tpl;

	function output() {
		global $db, $lang, $vars;
		
		if (get('node') != '') {
			$node = $db->get('latitude, longitude', 'nodes', "id = ".intval(get('node')));
			$this->tpl['center_latitude'] = $node[0]['latitude'];
			$this->tpl['center_longitude'] = $node[0]['longitude'];
			$this->tpl['zoom'] = 17 - 2;
		} else {
			$t = $db->get('MIN(latitude) AS min_lat, MIN(longitude) AS min_lon, MAX(latitude) AS max_lat, MAX(longitude) AS max_lon',
							'nodes
							INNER JOIN users_nodes ON nodes.id = users_nodes.node_id
							LEFT JOIN users ON users.id = users_nodes.user_id',
							"users.status = 'activated'".
							" AND nodes.latitude >= ".str_replace(",", ".", $vars['gmap']['bounds']['min_latitude']).
							" AND nodes.latitude <= ".str_replace(",", ".", $vars['gmap']['bounds']['max_latitude']).
							" AND nodes.longitude >= ".str_replace(",", ".", $vars['gmap']['bounds']['min_longitude']).
							" AND nodes.longitude <= ".str_replace(",", ".", $vars['gmap']['bounds']['max_longitude']).
							" AND nodes.latitude IS NOT NULL AND nodes.longitude IS NOT NULL");
							
			if ($t[0]['min_lat'] != '' && $t[0]['min_lon'] != '' &&
					$t[0]['max_lat'] != '' && $t[0]['max_lon'] != '') {
				$max_lat = $t[0]['max_lat'];
				$min_lat = $t[0]['min_lat'];
				$max_lon = $t[0]['max_lon'];
				$min_lon = $t[0]['min_lon'];
			} else {
				$max_lat = $vars['gmap']['bounds']['max_latitude'];
				$min_lat = $vars['gmap']['bounds']['min_latitude'];
				$max_lon = $vars['gmap']['bounds']['max_longitude'];
				$min_lon = $vars['gmap']['bounds']['min_longitude'];
			}
			$this->tpl['center_latitude'] = ($max_lat + $min_lat) / 2;
			$this->tpl['center_longitude'] = ($max_lon + $min_lon) / 2;
			$this->tpl['center_latitude'] = str_replace(",", ".", $this->tpl['center_latitude']);
			$this->tpl['center_longitude'] = str_replace(",", ".", $this->tpl['center_longitude']);

			$this->tpl['max_latitude'] = str_replace(",", ".", $max_lat);
			$this->tpl['max_longitude'] = str_replace(",", ".", $max_lon);
			$this->tpl['min_latitude'] = str_replace(",", ".", $min_lat);
			$this->tpl['min_longitude'] = str_replace(",", ".", $min_lon);
			
		}
		$this->tpl['link_xml_page'] = makelink(array("page" => "gmap", "subpage" => "xml", "node" => get('node')), FALSE, TRUE, FALSE);
		$this->tpl['maps_available'] = $vars['gmap']['maps_available'];
		
		echo template($this->tpl, __FILE__);
		exit;
	}

}

