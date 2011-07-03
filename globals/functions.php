<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
 * Copyright (C) 2009-2010 Vasilis Tsiligiannis <b_tsiligiannis@silverton.gr>
 * Copyright (C) 2011 K. Paliouras <squarious@gmail.com>
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

function redirect($url, $sec=0, $exit=TRUE) {
	global $main;
	$sec = (integer)($sec);
	if ($main->message->show && $main->message->forward != $url) {
		if ($main->message->forward == '') $main->message->forward = $url;
		return;
	}
	if (@preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) || @preg_match('/Safari/', $_SERVER['HTTP_USER_AGENT']) || $sec>0) {
		header("Refresh: $sec; URL=".html_entity_decode($url));
		$main->html->head->add_meta("$sec; url=$url", "", "refresh");
	} else {
		header("Location: ".html_entity_decode($url));		
	}
	if ($exit && !$main->message->show) {
		exit;
	}
}

function get_qs($htmlspecialchars=TRUE) {
	$ret = "";
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$ret = $_SERVER['QUERY_STRING'];
	} else {
		$ret = $_POST['query_string'];
	}
	return ($htmlspecialchars?htmlspecialchars($ret):$ret);
}

function get($key) {
	global $page_admin, $main;
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$ret = "";
		if (isset($_GET[$key])) {
		    $ret = $_GET[$key];
		}		
	} else {
		parse_str($_POST['query_string'], $output);
		$ret = "";
		if (isset($output[$key])) {
		    $ret = $output[$key];
		}
	}
	switch ($key) {
		case 'page':
			$valid_array = getdirlist(ROOT_PATH."includes/pages/");
			array_unshift($valid_array, 'startup');
			break;
		case 'subpage':
			$valid_array = getdirlist(ROOT_PATH."includes/pages/".get('page').'/', FALSE, TRUE);
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
	}
	if (isset($valid_array) && !in_array($ret, $valid_array)) $ret = $valid_array[0];
	return $ret;
}

function getdirlist($dirName, $dirs=TRUE, $files=FALSE) { 
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
	if(get('show_map') == "no") $o = array_merge($o,array("show_map" => "no"));
	if ($cur_qs == TRUE) {
		parse_str(get_qs(FALSE), $qs);
		$o = array_merge($o, $qs);
	}
	if ($cur_gs_vars == TRUE) {
		$o = array_merge($o, (array)$qs_vars);
	}
	$o = array_merge($o, (array)$extra);
	return ($htmlspecialchars?htmlspecialchars('?'.query_str($o)):'?'.query_str($o));
}

function query_str($params) {
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
	$smarty->clear_all_assign();
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

function is8bit($str) {
	for($i=0; $i <= strlen($str); $i++)
		if(ord($str{$i}) >> 7)   
			return TRUE;
	return FALSE;
}

function sendmail($to, $subject, $body, $from_name='', $from_email='', $cc_to_sender=FALSE) {
	global $vars, $lang;
	$subject = mb_encode_mimeheader($subject, $lang['charset'], 'B', "\n");
	if (empty($from_email)) {
		$from_name = $vars['mail']['from_name'];
		$from_email = $vars['mail']['from'];
	}
	$from_name = mb_encode_mimeheader($from_name, $lang['charset'], 'B', "\n");
	if ($from_name == $from_email) {
		$from = $from_email;
	} else {
		$from = $from_name.' <'.$from_email.'>';
	}
	$headers = "From: $from\n";
	if ($cc_to_sender) $headers .= "Cc: $from\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= 'Content-Type: text/plain; charset='.$lang['charset']."\n";
	$headers .= 'Content-Transfer-Encoding: '.(is8bit($body) ? '8bit' : '7bit');
	return @mail($to, $subject, $body, $headers);
}

function ip_to_ranges($ip, $ret_null=TRUE) {
	if ($ip == '' && $ret_null === TRUE) return array();
	$t = explode(".", $ip, 4);
	for ($i=0;$i<=3;$i++) {
		if (isset($t[$i]) && $t[$i] != '' && $i != 3) $t[$i] = $t1[$i] = $t2[$i] = (integer)($t[$i]);
		else {
			$t1[$i] = 0;
			$t2[$i] = 255;
		}
	}
	$ret[] = array("min" => implode(".", $t1), "max" => implode(".", $t2));
	$p = count($t) - 1;
	if ($p <= 2 && $t[$p] != 0) {
		$d = 2 - intval(log10($t[$p]));
		for ($i=1;$i<=$d;$i++) {
			$t1[$p] = $t[$p] * pow(10,$i);
			if ($t1[$p] > 255) continue;
			$t2[$p] = $t1[$p] + pow(10,$i) - 1;
			if ($t2[$p] > 255) $t2[$p] = 255;
			$ret[] = array("min" => implode(".", $t1), "max" => implode(".", $t2));
		}
	}
	return $ret;
}

function generate_account_code() {
	$ret = '';
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

function validate_zone($name) {
	$name = str_replace("_", "-", $name);
	$name = strtolower($name);
	if (preg_match('/^((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)*([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])|)$/', $name) == 0) return NULL;
	return $name;
}

function validate_name_ns($name, $node) {
	global $db;
	$name = str_replace("_", "-", $name);
	$name = strtolower($name);
	$allowchars = 'abcdefghijklmnopqrstuvwxyz0123456789-';
	$ret = '';
	for ($i=0; $i<strlen($name); $i++) {
		$char = substr($name, $i, 1);
		if (strstr($allowchars, $char) !== FALSE) $ret .= $char;
	}
	if ($ret == '') $ret = 'noname';
	$i=2;
	$extension = '';
	do {
		$cnt = $db->cnt('', 'nodes', "name_ns = '".$ret.$extension."' AND id != '".$node."'");
		if ($cnt > 0) {
			$extension = "-".$i;
			$i++;
		}
	} while ($cnt > 0);
	return ($extension != '' ? $ret.$extension : $ret);
}

function is_ip($ip, $full_ip=TRUE) {
	$ip_ex = explode(".", $ip, 4);
	if ($ip == '') return FALSE;
	for ($i=0;$i<count($ip_ex);$i++) {
		if ($i == count($ip_ex)-1 && $ip_ex[$i] == '') continue;
		if (!is_numeric($ip_ex[$i]) || $ip_ex[$i] < 0 || $ip_ex[$i] > 255) return FALSE; 
	}
	return ($full_ip?(count($ip_ex)==4):TRUE);
}

function include_gmap($javascript) {
	global $main, $vars, $lang;
	
	
	$serve_host = strtolower($_SERVER['SERVER_NAME']);
	$serve_path = $serve_host.$_SERVER['PHP_SELF'];
	$gmap_key = false;
	
	// Loop around all keys to find the most appropriate	
	foreach($vars['gmap']['keys'] as $key_path => $key) {
		$key_path = strtolower($key_path);
		
		// remove prefixed http://
		if (substr($key_path, 0, 7) == 'http://') {
			$path = substr($key_path, 7);
		} else if (substr($key_path, 0, 8) == 'https://') {
			$path = substr($key_path, 8);
		}
		
		
		// If host name is not the same then false
		if (substr($key_path, 0, strlen($serve_host)) != $serve_host)
			continue;

		// Compare if server_path includes $key_path 
		if (substr($serve_path, 0, strlen($key_path)) != $key_path)
			continue;
		
		$gmap_key = $key;
	}
	$script_params = array(
		'file' => 'api',
		'v' => $vars['gmap']['api'],
		'hl=' => $lang["iso639"]
	);
	if ($gmap_key !== false)
		$script_params['key'] = $gmap_key;
	$main->html->head->add_script("text/javascript",
		htmlspecialchars("http://{$vars['gmap']['server']}/maps?" .
			http_build_query($script_params)
		)
	);
	$main->html->head->add_script("text/javascript", $javascript);
	$main->html->head->add_extra(
		'<style type="text/css">
			v\:* {
  			behavior:url(#default#VML);
			}
		</style>');
	
	if(!$main->html->body->tags['onload']) {
		$main->html->body->tags['onload']="gmap_onload();";
	} else {
		$main->html->body->tags['onload'].="gmap_onload();";
	}
	$main->html->body->tags['onunload'] = "GUnload()"; //added to reduce IE memory leaks
	return TRUE;
}

function getmicrotime(){ 
	list($usec, $sec) = explode(" ",microtime()); 
	return ((float)$usec + (float)$sec); 
} 

function array_multimerge($array1, $array2) {
	if (is_array($array2) && count($array2)) {
		foreach ($array2 as $k => $v) {
			if (is_array($v) && count($v)) {
				$array1[$k] = array_multimerge($array1[$k], $v);
			} else {
				$array1[$k] = $v;
			}
		}
	} else {
		$array1 = $array2;
	}
	
	return $array1;
}

function language_set($language='', $force=FALSE) {
	global $vars, $db, $lang;
	if ($force) {
		$tl = $language;
	} elseif (get('lang') != '') {
		$tl = get('lang');
	} elseif (isset($_SESSION['lang']) && $_SESSION['lang'] != '') {
		$tl = $_SESSION['lang'];
	} elseif ($language != '') {
		$tl = $language;
	} else {
		$tl = $vars['language']['default'];
	}
	
	if ($vars['language']['enabled'][$tl] === TRUE && 
			file_exists(ROOT_PATH."globals/language/".$tl.".php")) {

		include_once(ROOT_PATH."globals/language/".$tl.".php");
		if (file_exists(ROOT_PATH."config/language/".$tl."_overwrite.php")) {
			include_once(ROOT_PATH."config/language/".$tl."_overwrite.php");
			$lang = array_multimerge($lang, $lang_overwrite);
		}
		// Set-up mbstring's internal encoding (mainly for supporting UTF-8)
		mb_internal_encoding($lang['charset']);
		
		// Set-up NAMES on database system
		if($vars['db']['version']>=4.1)
			$db->query("SET NAMES '".$lang['mysql_charset']."'");

	} else {

		if ($tl == $_SESSION['lang']) unset($_SESSION['lang']);
		die("WiND error: Selected language not found.");

	}
}

function url_fix ($url, $default_prefix="http://") {
	if($url == "") {
		return;
	}
	// Windows shares (samba) check
	if (substr(stripslashes($url), 0, 2) == '\\\\') {
		return 'file://'.str_replace('\\', '/', substr(stripslashes($url), 2));
	}
	// Insert default prefix
	if (strpos($url, '://') === FALSE) {
		return $default_prefix.$url;
	}
	return $url;
	
}

function replace_sql_wildcards($str) {
	$str = str_replace("*", "%", $str);
	$str = str_replace("?", "_", $str);
	return $str;
}

function format_version($version_array) {
	$str = '';
	foreach ($version_array as $dig) {
		$glue =  is_numeric($dig)? '.' : '-';
		$str .= empty($str)?$dig:$glue . $dig;
	}
	return $str;	
}
