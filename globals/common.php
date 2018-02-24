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

if (file_exists(ROOT_PATH."/install")) {
	die("WiND error: Please delete \"install/\" folder if you have completed installation ...");
}
if (!file_exists(ROOT_PATH."config/config.php")) {
	die("WiND error: Please make config/config.php file ...");
}

include_once(ROOT_PATH."globals/vars.php");
include_once(ROOT_PATH."config/config.php");
$vars = array_merge_recursive($vars, $config);
include_once($vars['templates']['path'].$vars['templates']['default'].'/config.php');
$vars = array_merge($vars, $template_config);
include_once(ROOT_PATH."globals/ipv6subnetcalculator.php");
include_once(ROOT_PATH."globals/functions.php");

$php_start = getmicrotime();

include_once(ROOT_PATH."globals/classes/mysql.php");
include_once(ROOT_PATH."globals/classes/construct.php");
include_once(ROOT_PATH."globals/classes/form.php");
include_once(ROOT_PATH."globals/classes/table.php");

if (!file_exists($vars['smarty']['class'])) {
	die("WiND error: Cannot find Smarty lib. Please check config.php ...");
}
include_once($vars['smarty']['class']);

if ($vars['template']['version'] < $vars['info']['min_template_version']
		|| $vars['template']['version'] > $vars['info']['version']) {
	die("WiND error: Template version does not match.");
}

$smarty = new Smarty;
$smarty->template_dir = $vars['templates']['path'].$vars['templates']['default'].'/';
$smarty->plugins_dir = array($vars['templates']['path'].$vars['templates']['default'].'/plugins/', 'plugins');
$smarty->compile_dir = $vars['templates']['compiled_path'].$vars['templates']['default'].'/';
$smarty->register_modifier('stripslashes', 'stripslashes');
reset_smarty();

$construct = new construct;

if ($vars['mail']['smtp'] != '') {
	ini_set('SMTP', $vars['mail']['smtp']);
	ini_set('smtp_port', $vars['mail']['smtp_port']);
}

$db = new mysql($vars['db']['server'], $vars['db']['username'], $vars['db']['password'], $vars['db']['database']);

if ($db->error) {
	die("WiND MySQL database error: $db->error_report");
}

?>
