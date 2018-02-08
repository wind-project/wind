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

/**
 * @brief Check if the current request is made by an ajax script
 */
function is_ajax_request() {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
			&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
	{
		return true;
	} else {
		return false;
	}
}

/**
 * @brief Get a title for the current user based on username, name and surname.
 * If it is possible it will prefer "name surname" otherwise it will fallback
 * to username
 */
function get_user_title() {
	global $main;
	
	if (!$main->userdata->logged)
		return "Anonymous";
	
	$title_tokens = array();
	
	// Try to get tokens from name surname
	if (! empty($main->userdata->info['name']))
		$title_tokens[] = $main->userdata->info['name'];
	if (! empty($main->userdata->info['surname']))
		$title_tokens[] = $main->userdata->info['surname'];
	
	// If we didn't find any token we add username
	if (empty($title_tokens)){
		$title_tokens[] = $main->userdata->info['username'];
	}
	
	return implode(" ", $title_tokens); 
}

/**
 * @brief Get the raw query string 
 * @return string The raw url query string with any escape character included.
 */
function get_query_string() {
	if (isset($_SERVER['QUERY_STRING'])){
		return $_SERVER['QUERY_STRING'];
	} else {
		return '';
	}
}

/**
 * @brief Get query string as an array
 * @return array An associative array with all parameters
 */
function get_query_string_array() {
	if (get_query_string() == '')
		return array();
	
	$params = array();
	foreach(explode('&', get_query_string()) as $param_token) {
		// Split params tokens in two
		$param_parts = explode('=', $param_token, 2);
		// Url decode parameter parts
		array_walk($param_parts, function(& $val){
			$val = urldecode($val);
		});
		if (count($param_parts) == 2) {
			$params[$param_parts[0]] = urldecode($param_parts[1]);
		} else {
			$params[$param_parts[0]] = true;
		}
	}
	return $params;
}

/**
 * @brief Get the relative resource path that user requested
 * @param string $default the string to return if no path is given by the user
 * @return string the path of the user to return.
 */
function get_path($default = ''){
	return isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:$default;
}

/**
 * @brief Get a specific level of the requested resource path.
 * @param int $level The path level to request. 1 is the leftmost.
 * @param string $default the string to return if path level not found
 * @return string the path of the user to return.
 */
function get_path_level($level, $default = null){
	$path = explode('/', get_path());
	if (empty($path[$level]))
		return $default;
	return $path[$level];
}

/**
 * @brief Get a request parameter from query string.
 * Depending the type of the key it will try to do sanitization and security
 * checking. Specifically for 'page' and 'subpage' it will check first that it exists.
 * @param string $key The key of the entry to fethch
 * @return Ambigous <string, unknown>
 */
function get($key) {
	global $page_admin, $main;
	
	$ret = isset($_GET[$key])?$_GET[$key]:"";
	
	switch ($key) {
		case 'page':
			// Try to get page from path info (higher priority)
			if (!is_null(get_path_level(1))){
				$ret= get_path_level(1);
			}
			
			$valid_array = getdirlist(ROOT_PATH."includes/pages/");
			array_unshift($valid_array, 'startup');
			
			break;
		case 'subpage':
			// Try to get page from path info (higher priority)
			if (!is_null(get_path_level(2))){
				$ret= get_path_level(2);
			}
			
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
		case 'node':
			$ret = intval($ret);
			break;
	}
	if (isset($valid_array) && !in_array($ret, $valid_array))
		$ret = $valid_array[0];
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

/**
 * @brief Create an absolute reference for a specific resource
 * @param string $path The path to the resource
 * @param array $params A list of parameters for the resource (query string)
 * @return string The absolute url for this resource.
 */

function make_ref($path, $params = array()) {
	if (!empty($params))
		$path = $path . '?' .  http_build_query($params);
	return url($path);
}

/**
 * @brief Get a link to the current resource
 * @param array $extra A list of extra query parameters for this link (same will be overrided)
 * @return string The absolute url for this resource.
 */

function self_ref($extra_query = array()) {
	$params = array_merge(get_query_string_array(), $extra_query);
	return make_ref(get_path(), $params);
}

/**
 * @brief Create an fully qualified named url for a specific resource
 * @return string $absolute_url The absolute url of the resource
 */
function fqn_url($absolute_url) {

	// Detect scheme
	$scheme = empty($_SERVER['HTTPS'])?'http':'https';

	// Craft fqn url
	$url = "{$scheme}://{$_SERVER['HTTP_HOST']}{$absolute_url}";
	return $url;
}

/**
 * @brief Create an absolute url for a relative dynamic resource
 */
function url($relative) {
	global $vars;
	
	$relative = '/' . ltrim($relative, '/.');	// Normalize path as /something
	if ($vars['site']['short_urls']) {
		return (dirname($_SERVER['SCRIPT_NAME']) != '/'? dirname($_SERVER['SCRIPT_NAME']):'')  . $relative;
	}
	return $_SERVER['SCRIPT_NAME'] . $relative;
}

/**
 * @brief Create an absolute url for a relative static resource
 */
function surl($relative)
{
	$relative = '/' . ltrim($relative, '/.');	// Normalize path as /something
	return (dirname($_SERVER['SCRIPT_NAME']) != '/'? dirname($_SERVER['SCRIPT_NAME']):'') . $relative;
}

/**
 * @brief Create a query string from an associative array
 * @param array $params All params of query string given as key => values
 * @return A prefixed list
 */
function create_query_string($params) {
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
	$smarty->assign('tpl_dir', rtrim(surl($smarty->template_dir)), '/');
	$smarty->assign('img_dir', surl($smarty->template_dir."images"));
	$smarty->assign('css_dir', surl($smarty->template_dir."css"));
	$smarty->assign('js_dir', surl($smarty->template_dir."scripts/javascripts"));
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

function reverse_zone_from_ipv6($ipv6,$prefix) {
        global $vars;
    	$hex = unpack("H*hex", @inet_pton($ipv6));
	$str = strrev($hex['hex']);
	$p = str_split($str);
        $ret = join(".",$p);
        $ret = substr($ret, (128-$prefix)/2);
        $ret = $ret.".".$vars['dns']['reverse_zone_v6'];
	return $ret;
}

function ipv6_calc($address,$len) {
        $calc = new IPV6SubnetCalculator();

        if ($calc->testValidAddress($address))
        {
                $rangedata = $calc->getAddressRange($address, $len);
                $ret = array(
                        'abbr_addr' => $calc->abbreviateAddress($address), // Abbreviated Address 
                        'unabbr_addr' => $calc->unabbreviateAddress($address), //Unabbreviated Address
                        'num_addr' => $calc->getInterfaceCount($len), // Number of IPs
                        'ipv6_start' => $rangedata['start_address'], // Start IP
                        'ipv6_end' => $rangedata['end_address'], // End IP
                        'prefix_addr' => $rangedata['prefix_address'] // Prefix Address
                );
                return $ret;
        } else {
                $ret = array('That is not a valid IPv6 Address');
        }
        die(json_encode($ret));
}

function ipv6_from_ip($ip) {
	global $vars;
	$ret = explode(".", $ip);
	$ret = $vars['ipv6_ula']['v6net'].sprintf('%02X%02X', $ret[1], $ret[2])."::";
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
	$vars['info']['current_language'] = $tl;
	
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

		if ($tl == $_SESSION['lang'])
			unset($_SESSION['lang']);
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

/**
 * Include language tokens in javascript
 */
function include_js_language_tokens() {
	global $lang, $main;
	$language_json = json_encode($lang);
	$main->html->head->add_extra(
			"<script type=\"text/javascript\">
			lang = {$language_json};
			</script>");
}

/**
 * Include map backend dependencies
 */
function include_map_dependencies() {
	global $main, $smarty, $vars;

	// Include needed javascript
	include_js_language_tokens();
	$js_dir = surl($smarty->template_dir . "/scripts/javascripts/");
	if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
		$main->html->head->add_script('text/javascript', 'https://maps.google.com/maps/api/js?v=3&amp;sensor=false');
	} else {
		$main->html->head->add_script('text/javascript', 'http://maps.google.com/maps/api/js?v=3&amp;sensor=false');
	}
	$main->html->head->add_script('text/javascript', "${js_dir}/map.js");
	$main->html->head->add_script('text/javascript', "${js_dir}/openlayers/OpenLayers.js");


	$map_options = array();
	$map_options['bound_sw'] = array($vars['map']['bounds']['min_latitude'], $vars['map']['bounds']['min_longitude']);
	$map_options['bound_ne'] = array($vars['map']['bounds']['max_latitude'], $vars['map']['bounds']['max_longitude']);
	$map_options['topology_url'] = make_ref('/map/json', array("node" => get('node')));
	$map_options_string = json_encode($map_options);

	$main->html->head->add_extra(
			"<script type=\"text/javascript\">
			map_options = ${map_options_string};
			</script>");
}

/**
 * Include map to the output
 * @param element_id The id of the element to render map on.
 * @param picker A flag to show that this is a place picker.
 */
function include_map($element_id) {
	global $main, $smarty, $vars;

	include_map_dependencies();;

	// Include needed javascript
	include_js_language_tokens();
	
	$main->html->head->add_extra(
			"<script type=\"text/javascript\">
			$(function() {
				// Load map
				map = new NetworkMap('${element_id}', map_options);

				controlNodeFilter = new NetworkMapControlNodeFilter(map);
				controlFullScreen = new NetworkMapControlFullScreen(map);
				
			});
			
			
			</script>");
}
