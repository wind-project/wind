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
		
		if ($this->hide) return;
		if (file_exists(ROOT_PATH.'config/mylogo.png')) {
			$this->tpl['mylogo'] = TRUE;
			$this->tpl['mylogo_dir'] = ROOT_PATH.'config/';
		}
		$this->tpl['link_home'] = makelink(array());
		
		$this->tpl['current_language'] = $vars['info']['current_language'];
		foreach($vars['language']['enabled'] as $key => $value) {
			if ($value) {
				$this->tpl['languages'][$key]['name'] = ($lang['languages'][$key]==''?$key:$lang['languages'][$key]);
				$this->tpl['languages'][$key]['link'] = makelink(array("session_lang" => $key), TRUE);
			}
		}
		
		if ($main->userdata->logged) {
			$this->tpl['logged'] = $main->userdata->logged;
			$this->tpl['logged_username'] = isset($main->userdata->info['username'])?$main->userdata->info['username']:"";
			$this->tpl['link_logout'] = makelink(array("page" => "users", "action" => "logout"));
			$this->tpl['link_user_profile'] = makelink(array("page" => "users", "user" => $main->userdata->user));;
		} else {
			$this->tpl['form_login'] = $construct->form($this->form_login(), __FILE__);
			$this->tpl['link_register'] = makelink(array("page" => "users", "user" => "add"));
			$this->tpl['link_restore_password'] = makelink(array("page" => "users", "action" => "restore"));
			$this->tpl['link_register'] = makelink(array("page" => "users", "user" => "add"));
		}
		return template($this->tpl, __FILE__);
	}
	
}

?>