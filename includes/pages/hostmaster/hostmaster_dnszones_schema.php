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

class hostmaster_dnszones_schema {

	var $tpl;
	
	function hostmaster_dnszones_schema() {
		
	}
	
	function form_zone_forward() {
		global $vars;
		$form_zone_forward = new form(array('FORM_NAME' => 'form_zone_forward'));
		$form_zone_forward->data[0]['fullField'] = 'schema'; 
		$form_zone_forward->data[0]['Field'] = 'schema';
		$form_zone_forward->data[0]['Type'] = 'text';
		$form_zone_forward->data[0]['value'] = file_get_contents($vars['dns']['forward_zone_schema']);
		return $form_zone_forward;
	}

	function form_zone_reverse() {
		global $vars;
		$form_zone_reverse = new form(array('FORM_NAME' => 'form_zone_reverse'));
		$form_zone_reverse->data[0]['fullField'] = 'schema'; 
		$form_zone_reverse->data[0]['Field'] = 'schema';
		$form_zone_reverse->data[0]['Type'] = 'text';
		$form_zone_reverse->data[0]['value'] = file_get_contents($vars['dns']['reverse_zone_schema']);
		return $form_zone_reverse;
	}

	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct, $vars, $main;
		if (!file_exists($vars['dns']['forward_zone_schema']) || !file_exists($vars['dns']['reverse_zone_schema'])) {
			$main->message->set_fromlang('error', 'schema_files_missing');
			return;
		}
		$this->tpl['form_zone_forward'] = $construct->form($this->form_zone_forward(), __FILE__);
		$this->tpl['form_zone_reverse'] = $construct->form($this->form_zone_reverse(), __FILE__);
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_zone_forward() {
		global $db, $main, $vars;
		$ret = FALSE;
		
		$f = fopen($vars['dns']['forward_zone_schema'], "w");
		if (fwrite($f, $_POST['schema']) !== FALSE) $ret = TRUE;
		fclose($f);
		
		if ($ret) {
			$main->message->set_fromlang('info', 'edit_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

	function output_onpost_form_zone_reverse() {
		global $db, $main, $vars;
		$ret = FALSE;
		
		$f = fopen($vars['dns']['reverse_zone_schema'], "w");
		if (fwrite($f, $_POST['schema']) !== FALSE) $ret = TRUE;
		fclose($f);
		
		if ($ret) {
			$main->message->set_fromlang('info', 'edit_success', makelink("",TRUE));
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>