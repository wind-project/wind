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
 
$plot_path = $root_path."plot/";
include_once $root_path."plot/elevation.php";
include_once($root_path.'globals/classes/geocalc.php');

class nodes_plot_link {

	var $tpl;

	function nodes_plot_link() {
		
	}

	function output() {
		global $main, $db;
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
			$gc = new GeoCalc();
			$this->tpl['a_node_azimuth'] = $gc->GCAzimuth($a_node_data['latitude'], $a_node_data['longitude'], $b_node_data['latitude'], $b_node_data['longitude']);
			$this->tpl['b_node_azimuth'] = $gc->GCAzimuth($b_node_data['latitude'], $b_node_data['longitude'], $a_node_data['latitude'], $a_node_data['longitude']);
			$this->tpl['a_node_elevation'] = get_elevation($a_node_data['latitude'], $a_node_data['longitude']) + $a_node_data['elevation']; 
			$this->tpl['b_node_elevation'] = get_elevation($b_node_data['latitude'], $b_node_data['longitude']) + $b_node_data['elevation']; 
			$frequency = 2400000000;
			$c = 299792.458; // light speed in km
			$this->tpl['distance'] = $gc->GCDistance($a_node_data['latitude'], $a_node_data['longitude'], $b_node_data['latitude'], $b_node_data['longitude']);
			$this->tpl['fsl'] = 20 * log10(4 * pi() * $this->tpl['distance'] * ($frequency / $c));
			$this->tpl['a_node_tilt'] = rad2deg(atan(($this->tpl['b_node_elevation'] - $this->tpl['a_node_elevation']) / ($this->tpl['distance'] * 1000)));
			$this->tpl['b_node_tilt'] = rad2deg(atan(($this->tpl['a_node_elevation'] - $this->tpl['b_node_elevation']) / ($this->tpl['distance'] * 1000)));
		}
		
		$this->tpl['hidden_qs'] = get_qs();
		return template($this->tpl, __FILE__);
	}

}

?>