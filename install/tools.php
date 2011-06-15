<?php

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