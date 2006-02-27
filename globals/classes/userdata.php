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

class userdata {
	
	var $logged=FALSE;
	var $user='';
	var $info;
	var $privileges;
	
	#CONFIG
	var $users_table = "users";
	var $primary_key = "id";
	var $username_key = "username";
	var $password_key = "password";
	var $info_keys = "username, name, surname, date_in, last_visit, last_session, status, language";
	var $last_session_key = "last_session";
	var $last_visit_key = "last_visit";
	
	function userdata() {
		session_start();
		if (isset($_SESSION['userdata'][$this->primary_key])) {
			$this->logged = TRUE;
			$this->user = $_SESSION['userdata'][$this->primary_key];
			$this->refresh_session();
		} else {
			if (isset($_COOKIE['userdata'][$this->primary_key])) {
				$uid = $_COOKIE['userdata'][$this->primary_key];
				$p_md5 = $_COOKIE['userdata'][$this->password_key];
				if ($this->check_login($uid, $p_md5, TRUE)) {
					$this->logged = TRUE;
					$this->user = $uid;
					$_SESSION['userdata'][$this->primary_key] = $uid;
					$this->reset_visit();
					$this->refresh_session();
				} else {
					$this->logged = FALSE;
				}
			} else {
				$this->logged = FALSE;			
			}
		}
		$this->load_info();
	}
	
	function load_info() {
		if ($this->logged) {
			global $db;
			$get_res = $db->get($this->info_keys, $this->users_table, $this->primary_key." = '$this->user'");		
			$this->info = $get_res[0];
			
			// EDIT HERE
			$get_res = $db->get('type', 'rights', "user_id = '$this->user'");		
			foreach( (array) $get_res as $key => $value) {
				$this->privileges[$value['type']] = TRUE;
			}
			//
			
		} else {
			unset($this->info);
			unset($this->privileges);
		}
	}
	
	function login($username, $password, $save = FALSE) {
		$this->logout();
		if ($this->check_login($username, md5($password))) {
			global $db;
			$get_res = $db->get($this->primary_key, $this->users_table, $this->username_key." = '$username'");
			$uid = $get_res[0][$this->primary_key];
			$this->logged = TRUE;
			$this->user = $uid;
			$_SESSION['userdata'][$this->primary_key] = $uid;
			$this->reset_visit();
			$this->refresh_session();
			if ($save) {
				cookie('userdata['.$this->primary_key.']', $uid);
				cookie('userdata['.$this->password_key.']', md5($password));
			}
		}
		$this->load_info();
		return $this->logged;
	}
	
	function logout() {
		if ($this->logged) {
			cookie('userdata['.$this->primary_key.']', '');
			cookie('userdata['.$this->password_key.']', '');
			$this->logged = FALSE;
			$this->user = '';
			session_destroy();
		}
		$this->load_info();
	}
	
	function check_login($username, $password, $user_pk = FALSE) {
		global $db;
		$get_res = $db->get($this->password_key, $this->users_table, ($user_pk?$this->primary_key:$this->username_key)." = '$username'");
		if (isset($get_res[0][$this->password_key]) && $password == $get_res[0][$this->password_key]) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function reset_visit($uid="") {
		if ($uid == "") $uid = $this->user;
		global $db;
		$ret = $db->get($this->last_session_key, $this->users_table, $this->primary_key." = '$uid'");
		$ret = $ret[0];
		$db->set($this->users_table, array($this->last_visit_key => $ret[$this->last_session_key]), $this->primary_key." = '$uid'", FALSE);
	}
	
	function refresh_session($uid="") {
		if ($uid == "") $uid = $this->user;
		global $db;
		$db->set($this->users_table, array($this->last_session_key => date_now()), $this->primary_key." = '$uid'", FALSE);
	}

}

?>