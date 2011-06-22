<?php
/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2011 K. Paliouras <squarious _at gmail [dot] com>
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


$_GLOBALS['root_path'] = dirname(__FILE__) . '/../';

//! Create an absolute url for static content
function surl($relative)
{
    return (dirname($_SERVER['SCRIPT_NAME']) != '/'? dirname($_SERVER['SCRIPT_NAME']):'') . $relative;
}

function abs_surl($absolute)
{
	$scheme = (isset($_SERVER['HTTPS']))?'https':'http';
	return "$scheme://{$_SERVER['HTTP_HOST']}" . $absolute;
}

//! Return textual represenetation of result.
function result_text($result)
{
	return (!$result?'fail':'success');
}


function show_error($message)
{
	echo "<div class=\"error\">$message</div>";
}

//! Check if request method is port
function is_method_post()
{
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function installation_session()
{
	/*
	 * Begin session
	 */
	session_start();
	define('ROOT_PATH', './');
	if (!isset($_SESSION['config'])) {
		require_once(dirname(__FILE__) . '/../config-sample/config.php');
		$_SESSION['config'] = $config;
	
		// Add url staf
		$_SESSION['config']['site']['domain'] = $_SERVER['HTTP_HOST'];
		
		$absolute = explode('/', surl('/'));
		array_splice($absolute, -2);
		$absolute = implode('/', $absolute ) . '/';
		$_SESSION['config']['site']['url'] = abs_surl($absolute );	
	}
}

function get_next_step($steps, $current)
{
	$step_keys = array_keys($steps);
	$step_current_index = array_search($current, $step_keys);
	return isset($step_keys[$step_current_index + 1])?$step_keys[$step_current_index + 1]:null;
}