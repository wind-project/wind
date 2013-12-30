<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005-2013 	by WiND Contributors (see AUTHORS.txt)
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


class loginform{
	var $tpl;
	
	function output() {
		global $lang;
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		$this->tpl['lang'] = $lang;
		$this->tpl['link_restore_password'] = make_ref('/users', array("action" => "restore"));
		$this->tpl['form_submit_url'] = make_ref('/users/loginform');
		
		$output = template($this->tpl, __FILE__);
		if (is_ajax_request()) {
			print $output;
			exit;
		} else {
			return $output;
		}
	}
	
	function output_onpost_login() {
		global $main, $lang;
		$result = array();
		if ($main->userdata->login($_POST['username'], $_POST['password'], ((isset($_POST['rememberme']) && $_POST['rememberme']=='Y')?TRUE:FALSE))) {
			if ($main->userdata->info['status'] == 'pending') {
				$result['error'] = $lang['message']['infp']['activation_required'];
				$main->userdata->logout();
			} else {
				$result['success'] = $lang['message']['info']['login_success'];
				$main->message->set_fromlang('info', 'login_success', self_ref());
			}
		} else {
			$result['error'] = $lang['message']['error']['login_failed'];
		}
		
		header('Content-Type: application/json; '.$lang['charset']);
		print json_encode($result);
		exit;
	}

}

?>
