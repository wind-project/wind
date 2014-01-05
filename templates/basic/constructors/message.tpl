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
{if $image != ''}
	{html_image file=$image}
{/if}
{if $forward != ''}
	{assign var=f value="<br /><br /><div align=\"center\"><a href=\"$forward\">$forward_text</a></div>"}
{/if}
{if $type == "error"}
	{assign var=panel_type value="panel-danger"}
{else}
	{assign var=panel_type value="panel-info"}
{/if}
<div class="message message-{$type} panel panel-default {$panel_type}">
	<div class="panel-heading">
		<h2 class="panel-title">{$title}</h2>
	</div>

	<div class="panel-body">
		{$message|nl2br}
		{$f}
	</div>

</div>