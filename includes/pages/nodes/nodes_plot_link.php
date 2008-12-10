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
 
include_once(ROOT_PATH.'globals/classes/geocalc.php');
$geocalc = new geocalc();

include_once(ROOT_PATH.'globals/classes/srtm.php');
$srtm = new srtm($vars['srtm']['path']);

class nodes_plot_link {

	var $tpl;

	function nodes_plot_link() {
		
	}

	function output() {
		global $main, $db, $geocalc, $srtm;
		$main->header->hide = TRUE;
		$main->menu->hide = TRUE;
		$main->footer->hide = TRUE;
		$this->tpl['a_node'] = (isset($_POST['a_node'])?$_POST['a_node']:get('a_node'));
		if ($this->tpl['a_node'] != '') {
			$a_node_data = $db->get('id, name, latitude, longitude, elevation', 'nodes', "id = '".$this->tpl['a_node']."'");
			$a_node_data = $a_node_data[0];
			$this->tpl['a_node_output'] = $a_node_data['name'].' (#'.$a_node_data['id'].')';
		}
		$this->tpl['b_node'] = (isset($_POST['b_node'])?$_POST['b_node']:get('b_node'));
		if ($this->tpl['b_node'] != '') {
			$b_node_data = $db->get('id, name, latitude, longitude, elevation', 'nodes', "id = '".$this->tpl['b_node']."'");
			$b_node_data = $b_node_data[0];
			$this->tpl['b_node_output'] = $b_node_data['name'].' (#'.$b_node_data['id'].')';
		}
		
		if ($this->tpl['a_node'] != '' && $this->tpl['b_node'] != '') {
			$this->tpl['a_node_azimuth'] = $geocalc->GCAzimuth($a_node_data['latitude'], $a_node_data['longitude'], $b_node_data['latitude'], $b_node_data['longitude']);
			$this->tpl['b_node_azimuth'] = $geocalc->GCAzimuth($b_node_data['latitude'], $b_node_data['longitude'], $a_node_data['latitude'], $a_node_data['longitude']);
			$this->tpl['a_node_geo_elevation'] = $srtm->get_elevation($a_node_data['latitude'], $a_node_data['longitude']); 
			$this->tpl['b_node_geo_elevation'] = $srtm->get_elevation($b_node_data['latitude'], $b_node_data['longitude']);
			$this->tpl['a_node_elevation'] = $a_node_data['elevation']; 
			$this->tpl['b_node_elevation'] = $b_node_data['elevation']; 

			$a_node_total_elevation = $this->tpl['a_node_geo_elevation'] + $this->tpl['a_node_elevation']; 
			$b_node_total_elevation = $this->tpl['b_node_geo_elevation'] + $this->tpl['b_node_elevation']; 
			
			$this->tpl['distance'] = $geocalc->GCDistance($a_node_data['latitude'], $a_node_data['longitude'], $b_node_data['latitude'], $b_node_data['longitude']);
			if ($this->tpl['distance'] != 0) {
				$this->tpl['a_node_tilt'] = rad2deg(atan(($b_node_total_elevation - $a_node_total_elevation) / ($this->tpl['distance'] * 1000)));
				$this->tpl['b_node_tilt'] = rad2deg(atan(($a_node_total_elevation - $b_node_total_elevation) / ($this->tpl['distance'] * 1000)));
			}
			else { 	// For links between nodes in the same place but with different elevations (e.g. link between rooftop and floor)
				// FIXME: plotlink function of geoimage class does not plot anything in that (admitedly rare) case, but perhaps it should(?)
				$sign = 0;
				$elev = $b_node_total_elevation - $a_node_total_elevation;
				if ($elev != 0) $sign = ($elev>0)?1:-1;
				$this->tpl['a_node_tilt'] = ($elev!=0?$sign:0) * 90;
				$this->tpl['b_node_tilt'] = -($this->tpl['a_node_tilt']);
			}
			$this->tpl['distance'] = sqrt( pow($this->tpl['distance'] * 1000, 2) + pow( abs($a_node_total_elevation - $b_node_total_elevation), 2 ) ) / 1000;
			$this->tpl['gearth'] = makelink(array("page" => "gearth", "subpage" => "download", "node" => get('a_node'), "node2" => get('b_node'), "show_p2p" => "1", "show_aps" => "1", "show_clients" => "1", "show_unlinked" => "1", "show_links_p2p" => "1", "show_links_client" => "1"));
			$this->tpl['frequency'] = (integer)(isset($_POST['frequency'])?$_POST['frequency']:2450);
			if ($this->tpl['frequency'] <= 0) $this->tpl['frequency'] = 2450;
			$frequency = $this->tpl['frequency'] * 1000000;
			$c = 299792.458; // light speed in km
			$this->tpl['fsl'] = 20 * log10(4 * pi() * $this->tpl['distance'] * ($frequency / $c));
			
			$this->tpl['plot_image'] = makelink(array("page" => "nodes", "subpage" => "plot", "a_node" => $this->tpl['a_node'], "b_node" => $this->tpl['b_node'], "frequency" => $this->tpl['frequency']));
		}
		
		$this->tpl['hidden_qs'] = get_qs();
		return template($this->tpl, __FILE__);
	}

}

?>