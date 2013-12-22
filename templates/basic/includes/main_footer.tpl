{*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005-2013 	by WiND Contributors (see AUTHORS.txt)
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
 *}
<div class="footer">
	<div class="technologies">
		<a href="http://www.php.net/"><img src="{$img_dir}logo-php.gif" alt="PHP Hypertext Preprocessor" /></a>
		<a href="http://www.mysql.com/"><img src="{$img_dir}logo-mysql.gif" alt="MySQL database server" /></a>
		<a href="http://smarty.php.net/"><img src="{$img_dir}logo-smarty.gif" alt="smarty template engine" /></a>
	</div>
	<div class="info">
		PHP time: {$php_time|round:3} s<br />MySQL time: {$mysql_time|round:3} s{if $debug_mysql}<br />Debug: <a href="{$debug_mysql}" target="debug">MySQL</a>{/if}
	</div>
	<div class="credits">
		Powered by: <a target="_blank" href="https://github.com/wind-project/wind"><b>WiND  v{$wind_version}</b></a><br />
		&copy; 2005-2013 <a target="_blank" href="https://github.com/wind-project/wind/wiki/Team">WiND Contributors</a>
	</div>
</div>