<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005-2014 	by WiND Contributors (see AUTHORS.txt)
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

class admin_areas_area {

	var $tpl;
	
	function admin_areas_area() {
		
	}
	
	function form_area() {
		global $db, $vars;
		$form_area = new form(array('FORM_NAME' => 'form_area'));
		$form_area->db_data('areas.id, areas.region_id, areas.name, areas.ip_start, areas.ip_end, areas.v6net, areas.v6prefix, areas.info');
		$form_area->db_data_enum('areas.region_id', $db->get("id AS value, name AS output", "regions"));
		$form_area->db_data_values("areas", "id", get('area'));
		if (get('area') != 'add') {
			$form_area->data[3]['value'] = long2ip($form_area->data[3]['value']);
			$form_area->data[4]['value'] = long2ip($form_area->data[4]['value']);
                        $form_area->data[5]['value'] = inet_ntop($form_area->data[5]['value']); 
		}
		$form_area->db_data_remove('areas__id');
		return $form_area;
	}
	
	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['area_method'] = (get('area') == 'add' ? 'add' : 'edit' );
		$this->tpl['form_area'] = $construct->form($this->form_area(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_area() {
		global $construct, $main, $db;
		$form_area = $this->form_area();
		$area = get('area');
		$ret = TRUE;
		$_POST['areas__ip_start'] = ip2long($_POST['areas__ip_start']);
		$_POST['areas__ip_end'] = ip2long($_POST['areas__ip_end']);
        $_POST['areas__v6net'] = inet_pton($_POST['areas__v6net']);
		$ret = $form_area->db_set(array(),
								"areas", "id", get('area'));
		
		if ($ret) {
			$main->message->set_fromlang('info', 'insert_success', make_ref('/admin/areas'));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
                $dat = $db->get("areas.id AS id", "areas", "areas.name = '".$_POST['areas__name']."'", "" , "name ASC LIMIT 1");
                $areaid = $dat[0]['id'];
		$ipv6net = inet_ntop($_POST['areas__v6net']); 
                $ipv6net = explode(':',$ipv6net,4); 
               	if ($ipv6net{2} == '') { $ipv6net{2} = '0000'; }
		$ipv6net{3} = '0000';
		for($i=0;$i<65536;$i=$i+256) {
                        $ipv6net{3} = dechex($i);
                        $ipv6net{4} = ':'; 
                	$ipv6net2 = implode(':',$ipv6net);
                        $ret2 = $db->add("ipv6_node_repos", array("v6net" => inet_pton($ipv6net2), "area_id" => $areaid));
			if ($ret2) {
                        	$main->message->set_fromlang('info', 'insert_success', make_ref('/admin/areas'));
        		} else {
                		$main->message->set_fromlang('error', 'generic');		
                        }
		}
	}

}

?>
