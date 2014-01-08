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
 
?>
<p class="description"><a target="_blank" href="http://www.smarty.net/">SMARTY</a> is used for generating HTML content and it is a mandatory dependency.
WiND depends on <strong>Smarty v2.X</strong>, please visit <a target="_blank" href="http://www.smarty.net/download">download section</a> and get the latest of 2.X series.
</p>

<?php
$step_result = true;
// Process input
$def_values = array('smarty_path' => $_SESSION['config']['smarty']['class']);
if (is_method_post()) {
	$step_result = 'auto';
	$def_values = array_merge($def_values, $_POST);
	
	// Validation
	if (substr($def_values['smarty_path'], - strlen('Smart.class.php') - 1) != 'Smarty.class.php') {
		show_error('We need the path of <strong>Smarty.class.php</strong> file.');
		$step_result= false;
	} if (!file_exists($def_values['smarty_path'])) {
		show_error('Cannot find  <strong>Smarty.class.php</strong> at "'.$def_values['smarty_path'].'".');
		$step_result= false;
	}
	
	if ($step_result) {
		$_SESSION['config']['smarty']['class'] = $def_values['smarty_path'];
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
			<span>Absolute path to Smarty.class.php</span>
			<input type="text" name="smarty_path" value="<?php echo $def_values['smarty_path']; ?>">
			</label>
		</li>
	</ul>
	<div class="buttons">
		<button type="submit" class="continue">Continue</button>
	</div>
</form>
</div>
<?php
}

return $step_result;