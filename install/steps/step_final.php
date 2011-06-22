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

// Create configuration content
$config_content= "<?php\n"
	. "\$config = " . var_export($_SESSION['config'], true) . ";\n";
if (!@file_put_contents($_GLOBALS['root_path'] . '/config/config.php', $config_content)) {
	show_error('Cannot write configuration at "<strong>config\config.php</strong>. Check file permissions.');
} else {
?>
<div class="finish"><em>You have succesfully finished installing WiND!</em>
<p>In order to <a href="<?php echo surl('/../'); ?>">view</a> the site, You have to <strong>remove folder "install"</strong>, eitherwise WiND will prevent you from normal
operation.</p>
<p>Don't forget that you can further parametrize WiND by directly editing <strong>config/config.php</strong>.
You can find a documented configuration sample at <strong>config-sample/config.php</strong></p>
</div>

<?php 
}
