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

class nodes_contact {

	var $tpl;
	
	function nodes_contact() {
		
	}
	
	function form_contact() {
		global $db, $vars, $main;
		$form_contact = new form(array('FORM_NAME' => 'form_contact'));
		$t = $db->get('username, email', 'users', "id = '".$main->userdata->user."'");
		$form_contact->info['from_username'] = $t[0]['username'];
		$form_contact->info['from_email'] = $t[0]['email'];
		return $form_contact;
	}

	function output() {
		global $construct, $db, $main;
		$main->header->hide = TRUE;
		$main->menu->hide = TRUE;
		$main->footer->hide = TRUE;
		if (!$main->userdata->logged) {
			$main->message->set_fromlang('error', 'not_logged_in');
			return;
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		$this->tpl['form_contact'] = $construct->form($this->form_contact(), __FILE__);
		$t = $db->get('id, name', 'nodes', "id = ".intval(get('node')));
		$this->tpl['node_name'] = $t[0]['name'];
		$this->tpl['node_id'] = $t[0]['id'];
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_contact() {
		global $construct, $main, $db, $lang;
		$main->header->hide = TRUE;
		$main->menu->hide = TRUE;
		$main->footer->hide = TRUE;
		$from = $db->get('username, email', 'users', "id = '".$main->userdata->user."'");
		$to_db = $db->get('email', 'users INNER JOIN users_nodes ON users_nodes.user_id = users.id', "users_nodes.node_id = ".intval(get('node')).($_POST['email_to_type']=='owner'?" AND users_nodes.owner = 'Y'":""));
		$node = $db->get('name, id', 'nodes', "id = ".intval(get('node')));
		$to = array();
		for($i=0;$i<count($to_db);$i++) {
			array_push($to, $to_db[$i]['email']);
		}
		$to = implode(', ', $to);
		$subject = $lang['email']['node_contact']['subject_prefix'].stripslashes($_POST['email_subject']).$lang['email']['node_contact']['subject_suffix'];
		$body = $lang['email']['node_contact']['body_prefix'].stripslashes($_POST['email_body']).$lang['email']['node_contact']['body_suffix'];
		$body = str_replace("##username##", $from[0]['username'], $body);
		$body = str_replace("##node_name##", $node[0]['name'], $body);
		$body = str_replace("##node_id##", $node[0]['id'], $body);
		$ret = @sendmail($to, $subject, $body, $from[0]['username'], $from[0]['email'], TRUE);

		if ($ret) {
			$main->message->set_fromlang('info', 'message_sent');
		} else {
			$main->message->set_fromlang('error', 'generic');		
		}
	}

}

?>