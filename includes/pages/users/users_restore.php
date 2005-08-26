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

class users_restore {

	var $tpl;
	
	function users_restore() {
		
	}

	function form_restore() {
		global $main;
		$form_restore = new form(array('FORM_NAME' => 'form_restore'));
		$form_restore->db_data('users.username, users.email');
		return $form_restore;
	}
	
	function form_change_password() {
		global $main;
		$form_change_password = new form(array('FORM_NAME' => 'form_change_password'));
		$form_change_password->db_data('users.password, users.password');
		$form_change_password->data[1]['Field'] .= '_c';
		$form_change_password->data[1]['fullField'] .= '_c';
		return $form_change_password;
	}

	function output() {
		global $construct;
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && method_exists($this, 'output_onpost_'.$_POST['form_name'])) return call_user_func(array($this, 'output_onpost_'.$_POST['form_name']));
		if (get('user') != '' && get('account_code') != '') {
			$this->tpl['form_change_password'] = $construct->form($this->form_change_password(), __FILE__);
		} else {
			$this->tpl['form_restore'] = $construct->form($this->form_restore(), __FILE__);
		}
		return template($this->tpl, __FILE__);
	}

	function output_onpost_form_restore() {
		global $main, $db, $vars, $lang;
		
		$t = $db->get('id, account_code', 'users', "username = '".$_POST['users__username']."' AND email = '".$_POST['users__email']."'");
		if ($t[0]['id'] != '') {
			if ($t[0]['account_code'] == '') {
				$t[0]['account_code'] = generate_account_code();
				$data['account_code'] = $t[0]['account_code'];
				$db->set('users', $data, "id = '".$t[0]['id']."'");
			}
			$subject = $lang['email']['user_restore']['subject'];
			$subject = str_replace('##username##', $_POST['users__username'], $subject);
			$body = $lang['email']['user_restore']['body'];
			$body = str_replace('##username##', $_POST['users__username'], $body);
			$body = str_replace('##act_link##', $vars['site']['url']."?page=users&user=".$t[0]['id']."&action=restore&account_code=".$t[0]['account_code'], $body);
			$ret = sendmail($_POST['users__email'], $subject, $body);
			if ($ret) {
				$main->message->set_fromlang('info', 'restore_success');
			} else {
				$main->message->set_fromlang('error', 'generic');		
			}
		} else {
			$main->message->set_fromlang('error', 'login_failed');
		}
	}
	
	function output_onpost_form_change_password() {
		global $main, $db;
		if ($db->cnt('', 'users', "account_code IS NOT NULL AND account_code = '".get('account_code')."' AND id = '".get('user')."'") == 1) {
			if ($_POST['users__password'] == $_POST['users__password_c'] && $_POST['users__password'] != '') {
				$ret = $db->set('users', array("status" => "activated", "account_code" => generate_account_code(), "password" => md5($_POST['users__password'])), "id = '".get('user')."'");
				
				if ($ret) {
					$main->message->set_fromlang('info', 'password_restored', makelink());
				} else {
					$main->message->set_fromlang('error', 'generic');		
				}
			} else {
				$main->message->set_fromlang('error', 'password_not_match');					
			}
		} else {
			$main->message->set_fromlang('error', 'generic');
		}
	}
	
}

?>