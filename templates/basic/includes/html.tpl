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
<!doctype html>
<html lang="{$lang.iso639}">
<head>
	<meta charset="{$lang.charset}"/>
	<script type="text/javascript" src="{$js_dir}/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="{$js_dir}/jquery-ui-1.10.3.custom.min.js"></script>
	<script type="text/javascript" src="{$js_dir}/ui.js"></script>
	{$head}
	<link href="{$css_dir}jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" />
	<link href="{$css_dir}styles.css" rel="stylesheet" type="text/css" />
	<link rel="icon" type="image/png" href="templates/basic/images/favicon_32.png" />

	
</head>
<body{foreach from=$body_tags item=item key=key} {$key}="{$item}"{/foreach}>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
{$body}
</body>
</html>