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

if (!file_exists($root_path."config.php")) {
	die("WiND error: Please make config.php file ...");
}
include_once($root_path."config.php");
include_once($root_path."globals/vars.php");
$vars = array_merge($config, $vars);
include_once($root_path."globals/functions.php");
include_once($root_path."globals/classes/mysql.php");
include_once($root_path."globals/classes/construct.php");
include_once($root_path."globals/classes/form.php");
include_once($root_path."globals/classes/table.php");
if (!file_exists($vars['smarty']['class'])) {
	die("WiND error: Cannot find Smarty lib. Please check config.php ...");
}
include_once($vars['smarty']['class']);

$construct = new construct;

$db = new mysql($vars['db']['server'], $vars['db']['username'], $vars['db']['password'], $vars['db']['database']);

if ($db->error) {
	die("WiND MySQL database error: $db->error_report");
}

$smarty = new Smarty;
$smarty->template_dir = $vars['templates']['path'].$vars['templates']['default'].'/';
$smarty->compile_dir = $vars['templates']['compiled_path'].$vars['templates']['default'].'/';
reset_smarty();

if ($vars['mail']['smtp'] != '') {
	ini_set('SMTP', $vars['mail']['smtp']);
	ini_set('smtp_port', $vars['mail']['smtp_port']);
}

//INCLUDE LANGUAGE
if (get('lang') != '') {
	$tl = get('lang');
} elseif ($_SESSION['lang'] != '') {
	$tl = $_SESSION['lang'];
} else {
	$tl = $vars['language']['default'];
}
include_once($root_path."globals/language/".$tl.".php");

?>