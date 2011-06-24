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
<p class="description">Supply information about the community that this installation targets at.
</p>

<?php
$step_result = true;
// Process input
$def_values = array_merge(array(
	'email' => '',
	'name' => '',
	'short_name' => ''
	),$_SESSION['config']['community']);
if (is_method_post()) {
	$step_result = 'auto';
	$def_values = array_merge($def_values, $_POST);
	
	// Validation
	if (empty($def_values['name'])) {
		show_error('You need to define your community name.');
		$step_result= false;
	} if (empty($def_values['short_name'])) {
		show_error('You need to define an acronym of the name');
		$step_result= false;
	}
	
	if ($step_result) {
		$_SESSION['config']['community'] = $def_values;
	}
}

// Show form on GET and POST(error)
if ((!is_method_post()) || !$step_result){
	$step_result = false;
?>
<div class="form">
<form method="post">
	<ul class="fields">
		<li>
			<label>
			<span>Community Name <small>(full name)</small></span>
			<input type="text" name="name" value="<?php echo $def_values['name']; ?>">
			</label>
		</li>
		<li>
			<label>
			<span>Community Name <small>(acronym)</small></span>
			<input type="text" name="short_name" value="<?php echo $def_values['short_name']; ?>">
			</label>
		</li>
		<li>
			<label>
			<span>Contact email</span>
			<input type="text" name="email" value="<?php echo $def_values['email']; ?>">
			</label>
		</li>
	</ul>
	<div class="buttons">
		<input type="submit" value="Continue" class="continue">
	</div>
</form>
</div>
<?php
}

return $step_result;