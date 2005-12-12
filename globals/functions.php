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

function pvar($var) {
	if (is_array($var)) {
		$ret .= '<ul>';
		while(list($key) = each($var)) {
			if (is_array($var[$key])) {
				$ret .= '<li>'.$key.pvar($var[$key]).'</li>';
			} else {
				$ret .= '<li>'.$key.' = '.$var[$key].'</li>';
			}
		}
		$ret .= '</ul>';		
		return $ret;
	} else {
		return $var;
	}
}

function redirect($url, $sec=0, $exit=TRUE) {
	global $main;
	$sec = (integer)($sec);
	if ($main->message->show && $main->message->forward != $url) {
		if ($main->message->forward == '') $main->message->forward = $url;
		return;
	}
	if (@preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) || $sec>0) {
		header("Refresh: $sec; URL=".html_entity_decode($url));
		global $main;
		$main->html->head->add_meta("$sec; url=$url", "", "refresh");
	} else {
		header("Location: ".html_entity_decode($url));		
	}
	if ($exit && !$main->message->show) {
		exit;
	}
}

function get_qs() {
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		return $_SERVER['QUERY_STRING'];
	} else {
		return $_POST['query_string'];
	}
}

function get($key) {
	global $page_admin, $main, $root_path;
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$ret = $_GET[$key];
	} else {
		parse_str($_POST['query_string'], $output);
		$ret = $output[$key];
	}
	switch ($key) {
		case 'page':
			$valid_array = getdirlist($root_path."includes/pages/");
			array_unshift($valid_array, 'startup');
			break;
		case 'subpage':
			$valid_array = getdirlist($root_path."includes/pages/".get('page').'/', FALSE, TRUE);
			for ($key=0;$key<count($valid_array);$key++) {
				$valid_array[$key] = basename($valid_array[$key], '.php');
				if (substr($valid_array[$key], 0, strlen(get('page'))+1) != get('page').'_') {
					array_splice($valid_array, $key, 1);
					$key--;
				} else {
					$valid_array[$key] = substr($valid_array[$key], strlen(get('page'))+1);
				}
			}
			array_unshift($valid_array, '');
			break;
		case 'lang':
			$valid_array = getdirlist($root_path."globals/language/", FALSE, TRUE);
			for ($key=0;$key<count($valid_array);$key++) {
				$valid_array[$key] = basename($valid_array[$key], '.php');
			}
			array_unshift($valid_array, '');
			break;
	}
	if (isset($valid_array) && !in_array($ret, $valid_array)) $ret = $valid_array[0];
	return $ret;
}

function getdirlist ($dirName, $dirs=TRUE, $files=FALSE) { 
	$d = dir($dirName);
	$a = array();
	while($entry = $d->read()) { 
		if ($entry != "." && $entry != "..") { 
			if (is_dir($dirName."/".$entry)) { 
				if ($dirs==TRUE) array_push($a, $entry); 
			} else { 
				if ($files==TRUE) array_push($a, $entry); 
			} 
		} 
	} 
	$d->close();
	return $a;
} 

function makelink($extra="", $cur_qs=FALSE, $cur_gs_vars=TRUE, $htmlspecialchars=TRUE) {
	global $qs_vars;
	$o = array();
	if ($cur_qs == TRUE) {
		parse_str(get_qs(), $qs);
		$o = array_merge($o, $qs);
	}
	if ($cur_gs_vars == TRUE) {
		$o = array_merge($o, $qs_vars);
	}
	$o = array_merge($o, $extra);
	return ($htmlspecialchars?htmlspecialchars('?'.query_str($o)):'?'.query_str($o));
}

function query_str ($params) {
   $str = '';
   foreach( (array) $params as $key => $value) {
   		if ($value == '') continue;
	   $str .= (strlen($str) < 1) ? '' : '&';
	   $str .= $key . '=' . rawurlencode($value);
   }
   return ($str);
}

function cookie($name, $value) {
	global $vars;
	$expire = time() + $vars['cookies']['expire'];
	return setcookie($name, $value, $expire, "/");
}

function date_now() {
      return date("Y-m-d H:i:s");
 }
 
function message($arg) {
	global $lang;
	$mes = $lang['message'][func_get_arg(0)][func_get_arg(1)][func_get_arg(2)];
	for ($i=3;$i<func_num_args();$i++) {
		$par = func_get_arg($i);
		$mes = str_replace('%'.($i-2).'%', $par, $mes);
	}
	return $mes;
}

function lang($arg) {
	global $lang;
	$mes = $lang[func_get_arg(0)];
	for ($i=1;$i<func_num_args();$i++) {
		$par = func_get_arg($i);
		$mes = str_replace('%'.($i).'%', $par, $mes);
	}
	return $mes;
}

function template($assign_array, $file) {
	global $smarty;
	$path_parts = pathinfo($file);
	if (substr(strrchr($file, "."), 1) != "tpl") {
		$tpl_file = 'includes'.substr($path_parts['dirname'], strpos($path_parts['dirname'], 'includes') + 8)."/".basename($path_parts['basename'], '.'.$path_parts['extension']).'.tpl';
	} else {
		$tpl_file = $file;
	}
	reset_smarty();
	$smarty->assign($assign_array);
	return $smarty->fetch($tpl_file);
}

function reset_smarty() {
	global $smarty, $lang;
	$smarty->clear_all_assign;
	$smarty->assign_by_ref('lang', $lang);
	$smarty->assign('tpl_dir', $smarty->template_dir);
	$smarty->assign('img_dir', $smarty->template_dir."images/");
	$smarty->assign('css_dir', $smarty->template_dir."css/");
	$smarty->assign('js_dir', $smarty->template_dir."scripts/javascripts/");
}

function delfile($str) 
{ 
   foreach( (array) glob($str) as $fn) { 
	   unlink($fn); 
   } 
} 

function resizeJPG($filename, $width, $height) {

	list($width_orig, $height_orig) = getimagesize($filename);
	
	if ($width && ($width_orig < $height_orig)) {
	   $width = ($height / $height_orig) * $width_orig;
	} else {
	   $height = ($width / $width_orig) * $height_orig;
	}

   // Resample
	$image_p = imagecreatetruecolor($width, $height);
	$image = imagecreatefromjpeg($filename);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	return $image_p;
}

function reverse_zone_from_ip($ip) {
	global $vars;
	$ret = explode(".", $ip);
	$ret = $ret[2].".".$ret[1].".".$ret[0].".".$vars['dns']['reverse_zone'];
	return $ret;
}

function sendmail($to, $subject, $body, $from="") {
	global $vars;
	$headers  = 'From: ' . ($from==""?$vars['mail']['from_name']." <".$vars['mail']['from'].">":$from) . "\n";
	$headers .= 'Content-Type: text/plain; charset='.$lang['charset']."\n";
	return @mb_send_mail($to, $subject, $body, $headers);
}

function sendmail_fromlang($to, $message) {
	global $lang;
	return sendmail($to, $lang['email'][$message]['subject'], $lang['email'][$message]['body']);
}

function correct_ip($ip, $ret_null=TRUE) {
	if ($ip == '' && $ret_null === TRUE) return '';
	$t = explode(".", $ip, 4);
	for ($i=0;$i<4;$i++) {
		$t[$i] = (integer)($t[$i]);
	}
	return implode(".", $t);
}

function generate_account_code() {
	for ($i=1;$i<=20;$i++) {
		$ret .= rand(0, 9);
	}
	return $ret;
}

function translate($field, $section='') {
	global $lang;
	if ($section == '') {
		$t = $lang[$field];
	} else {
		$t = $lang[$section][$field];
	}
	return ($t == '' ? $field : $t);
}

function validate_name_ns($name, $node) {
	global $db;
	$name = str_replace("_", "-", $name);
	$name = strtolower($name);
	$allowchars = 'abcdefghijklmnopqrstuvwxyz0123456789-';
	for ($i=0; $i<strlen($name); $i++) {
		$char = substr($name, $i, 1);
		if (strstr($allowchars, $char) !== FALSE) $ret .= $char;
	}
	if ($ret == '') $ret = 'noname';
	$i=2;
	do {
		$cnt = $db->cnt('', 'nodes', "name_ns = '".$ret.$extension."' AND id != '".$node."'");
		if ($cnt > 0) {
			$extension = "-".$i;
			$i++;
		}
	} while ($cnt > 0);
	return ($extension != '' ? $ret.$extension : $ret);
}

function is_ip ($ip, $full_ip=TRUE) {
	$ip_ex = explode(".", $ip, 4);
	if ($ip == '') return FALSE;
	for ($i=0;$i<count($ip_ex);$i++) {
		if ($i == count($ip_ex)-1 && $ip_ex[$i] == '') continue;
		if (!is_numeric($ip_ex[$i]) || $ip_ex[$i] < 0 || $ip_ex[$i] > 255) return FALSE; 
	}
	return ($full_ip?(count($ip_ex)==4):TRUE);
}

function include_gmap($javascript) {
	global $main, $vars;
	$dirname = dirname($_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
	$gmap_key = $vars['gmap']['keys'][$dirname];
	if ($gmap_key == '') $gmap_key = $vars['gmap']['keys'][$dirname."/"];
	if ($gmap_key == '') $gmap_key = $vars['gmap']['keys']["http://".$dirname];
	if ($gmap_key == '') $gmap_key = $vars['gmap']['keys']["http://".$dirname."/"];
	if ($gmap_key == '') return FALSE;

	$main->html->head->add_script("text/javascript", "http://".$vars['gmap']['server']."/maps?file=api&v=1&key=".$gmap_key);
	$main->html->head->add_script("text/javascript", $javascript);
	$main->html->head->add_extra(
		'<style type="text/css">
			v\:* {
  			behavior:url(#default#VML);
			}
		</style>');
	
	$main->html->body->tags['onload'] = "gmap_onload()";	
	return TRUE;
}

function getmicrotime(){ 
	list($usec, $sec) = explode(" ",microtime()); 
	return ((float)$usec + (float)$sec); 
} 

?>