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
 
?>
<p class="description">
For the google maps to work, you need <a href="http://code.google.com/apis/maps/signup.html" target="_blank">an API Key</a>.
Each key is binded with a specific domain. WiND supports multiple keys and will choose the most appropriate each time.
If you don't want to use Google maps at the moment, leave it empty.
</p>
<?php

// Process input
$def_values = array();
foreach($_SESSION['config']['gmap']['keys'] as $domain => $key) {
	$def_values[] = array('domain' => (string)$domain, 'key' => (string)$key);
} 
$def_values = array_pad($def_values, 4, array('domain' => '', 'key' => ''));
if (is_method_post()) {
	$step_result = 'auto';
	$def_values = $_POST['gmap'];
	
	if ($step_result) {		
		
		$_SESSION['config']['gmap']['keys'] = array();		
		foreach($def_values as $api) {
			
			if (empty($api['domain']) || empty($api['key']))
				continue;
			$_SESSION['config']['gmap']['keys'][$api['domain']] = $api['key'];
		}
	}
	
}

// Show form on GET and POST(error)
if ((!is_method_post()) || !$step_result){
	$step_result = false;
?>
<div class="form">
<form method="post">
	<ul class="fields">
	<?php for($i = 0 ;$i < 4 ;$i++): ?>
		<li><table width="100%"><tr>
			<td width="30%">
				<label>
					<span>Domain:</span>
					<input name="gmap[<?php echo $i; ?>][domain]" value="<?php echo $def_values[$i]['domain']; ?>" >
				</label>
			</td>
			<td>
				<label>
					<span>Key:</span>
					<input name="gmap[<?php echo $i; ?>][key]" value="<?php echo $def_values[$i]['key']; ?>" >
				</label>
			</td>
			</tr>
			</table>
		</li>
	<?php endfor; ?>				
	</ul>
	<div class="buttons">
		<input class="continue" type="submit" value="Continue">
	</div>
</form>
</div>
<?php 
}

return $step_result;