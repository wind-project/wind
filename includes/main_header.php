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

class header {
	
	var $hide=FALSE;
	var $tpl;
	
	function form_login() {
		$form_login = new form(array('FORM_NAME' => 'form_login'));
		$form_login->db_data('users.username, users.password');
		return $form_login;
	}
	
	function output() {
		global $main, $construct, $vars, $lang;
		
		if ($this->hide)
			return;
		if (file_exists(ROOT_PATH.'config/mylogo.png')) {
			$this->tpl['mylogo'] = TRUE;
			$this->tpl['mylogo_dir'] = ROOT_PATH.'config/';
		}
		$this->tpl['link_home'] = make_ref('/');
		$this->tpl['link_login_form'] = make_ref('/users/loginform');
		$this->tpl['link_logout'] = make_ref('/users', array('action' => 'logout'));
		$this->tpl['current_language'] = $vars['info']['current_language'];
		$this->tpl['search_url'] = make_ref('/search');
		foreach($vars['language']['enabled'] as $key => $value) {
			if ($value) {
				$this->tpl['languages'][$key]['name'] = ($lang['languages'][$key]==''?$key:$lang['languages'][$key]);
				$this->tpl['languages'][$key]['link'] = self_ref(array("session_lang" => $key));
			}
		}
		
		if ($main->userdata->logged) {
			$this->tpl['logged'] = $main->userdata->logged; 
			$this->tpl['logged_username'] = isset($main->userdata->info['username'])?$main->userdata->info['username']:"";
			$this->tpl['logged_title'] = get_user_title();
			$this->tpl['link_user_profile'] = make_ref('/users', array("user" => $main->userdata->user));;
		} else {
			$this->tpl['link_register'] = make_ref('/users', array("user" => "add"));
			$this->tpl['link_restore_password'] = make_ref('/users', array("action" => "restore"));
			$this->tpl['link_register'] = make_ref('/users', array("user" => "add"));
		}
		return template($this->tpl, __FILE__);
	}
	
}

?>