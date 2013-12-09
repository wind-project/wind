{*
 * WiND - Wireless Nodes Database
 * Basic HTML Template
 *
 * Copyright (C) 2005 Konstantinos Papadimitriou <vinilios@cube.gr>
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
		Powered by: <a target="_blank" href="http://wind.cube.gr/"><b>WiND  v{$wind_version}</b></a><br />
		&copy; 2005-2013 <a target="_blank" href="http://wind.cube.gr/wiki/Team">WiND development team</a>
	</div>
</div>