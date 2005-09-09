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

class mynodes_range {

	var $tpl;
	
	function mynodes_range() {
		
	}
	
	function calculate_next_range() {
		global $db;
		$range = 256;
		$data2 = $db->get("areas.id AS area_id, ip_start, ip_end",
					"areas
					INNER JOIN nodes ON nodes.area_id = areas.id AND nodes.id = '".get('node')."'");
		$area_id = $data2[0]['area_id'];
		$area_ip_start = $data2[0]['ip_start'];
		$area_ip_end = $data2[0]['ip_end'];
		
		$data = $db->get("ip_ranges.ip_start AS ip_start, ip_ranges.ip_end AS ip_end, areas.ip_start AS area_ip_start, areas.ip_end AS area_ip_end",
					"ip_ranges
					INNER JOIN nodes ON nodes.id = ip_ranges.node_id
					INNER JOIN areas ON nodes.area_id = areas.id",
					"areas.ip_start <= ip_ranges.ip_start AND areas.ip_end >= ip_ranges.ip_end AND areas.id = '".$area_id."'", "" , "ip_end ASC");
		
		if (count($data) == 0) {
			$ret['ip_start'] = $area_ip_start;
			$ret['ip_end'] = $area_ip_start+$range-1;
		} elseif ($data[count($data)-1]['ip_end']+$range <= $area_ip_end) {
			$ret['ip_start'] = $data[count($data)-1]['ip_end']+1;
			$ret['ip_end'] = $data[count($data)-1]['ip_end']+$range;
		} else {
			for ($start = $area_ip_start; $start <= $area_ip_end; $start=$start+$range) {
				$end = $start+$range-1;
				$flag = TRUE;
				for($i=count($data)-1;$i>=0;$i--) {
					if (($start >= $data[$i]['ip_start'] && $start <= $data[$i]['ip_end'])
						|| ($end >= $data[$i]['ip_start'] && $end <= $data[$i]['ip_end'])) {
						$flag = FALSE;
						break;
					}
				}
				if ($flag) {
					$ret['ip_start'] = $start;
					$ret['ip_end'] = $end;
					break;
				}
			}
		}
		return $ret;
	}
	
	function form_getrange() {
		global $db;
		$form_getrange = new form(array('FORM_NAME' => 'form_getrange'));
		$form_getrange->db_data('ip_ranges.info');
		return $form_getrange;
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct, $db;
		$this->tpl['form_getrange'] = $construct->form($this->form_getrange(), __FILE__);
		$this->tpl['node_id'] = get('node');
		$this->tpl['node_name'] = $db->get('name', 'nodes', "id = '".get('node')."'");
		$this->tpl['node_name'] = $this->tpl['node_name'][0]['name'];
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_getrange() {
		global $main, $db;
		$t = $db->get('area_id', 'nodes', "id = '".get('node')."'");
		if ($t[0]['area_id'] == '') {
			$main->message->set_fromlang('error', 'nodes_no_area_id');
			return;
		}
		$form_getrange = $this->form_getrange();
		$nextr = $this->calculate_next_range();
		$status = "pending";
		$ret = TRUE;
		$ret = $form_getrange->db_set(array("node_id" => get('node'), "ip_start" => $nextr['ip_start'], "ip_end" => $nextr['ip_end'], "status" => $status));
		if ($ret) {
			$main->message->set_fromlang('info', 'request_range_success', makelink(array("page" => "mynodes", "node" => get('node'))));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>