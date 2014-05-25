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

class node_editor_nodesettingschanges {

	var $tpl;
	function __construct() {
		
	}
	
	function node_editor_nodesettingschanges() {
		
	}
	
	function form_nodesettingschanges() {
		global $main, $db, $vars, $lang;
		$form_nodesettingschanges = new form(array('FORM_NAME' => 'form_nodesettingschanges'));
		
		$form_nodesettingschanges->db_data('node_settings_changes.uid, node_settings_changes.node_id, node_settings_changes.dateline, node_settings_changes.changemade, node_settings_changes.changemenu, node_settings_changes.reason, node_settings_changes.comment');
		$form_nodesettingschanges->data[1]['value']= intval(get('node'));
		$uid=$main->userdata->user;
     		$form_nodesettingschanges->data[0]['value']= $uid;
		$form_nodesettingschanges->data[2]['value']= date("Y-m-d H:i:s");	

		return $form_nodesettingschanges;
	}

	function output() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		global $construct;
		$this->tpl['nodesettingschanges_method'] = (get('nodesettingschange') == 'add' ? 'add' : 'edit' );
		$this->tpl['form_nodesettingschanges'] = $construct->form($this->form_nodesettingschanges(), __FILE__);
		return template($this->tpl, __FILE__);
	}
	
	function output_onpost_form_nodesettingschanges() {
		global $construct, $main, $db;
		$form_nodesettingschanges = $this->form_nodesettingschanges();
		#$nameserver = get('nameserver');
		#if (get('nameserver') == 'add') {
		#	$_POST['dns_nameservers__ip'] = ip2long($_POST['dns_nameservers__ip']);
		#}
		$f['node_id'] = intval(get('node'));
		$ret = TRUE;
		$ret = $form_nodesettingschanges->db_set(array(),
								"node_settings_changes", "id", $nodesettingschanges);
		#$ret = $form_nameserver->db_set($f,
		#						"dns_nameservers", "id", $nameserver);
		
		if ($ret) {
				$main->message->set_fromlang('info', 'insert_success', make_ref('/node_editor', array("node" => $_POST['node_settings_changes__node_id'])));
				#log_admin_action($nodes,"#nodesetttingschange#".get('node'),get('id'), "node_setttings_changes", "insert_success");#@#
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>
