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
<table border="0" cellspacing="0" cellpadding="0" class="table-d1">
<tr>
<td rowspan="2" class="table-d1-side">&nbsp;</td>
<td class="table-d1-title-text" >{assign var=t value="links__type-"|cat:$data.1.links__type}{$lang.db.$t} [ {$data.1.links__ssid|escape} ]</td>
<td rowspan="2" class="table-d1-side2">&nbsp;</td>
</tr>
<tr>
<td class="table-d1-text1">
		<table border="0" cellpadding="0" cellspacing="6" class="table-form">
		<tr class="table-form-row1">
		<td class="table-node-link-info"><img src="{$img_dir}node.gif" width="32" height="32" alt="{$lang.db.peer}" /></td>
		<td class="table-node-link-info" width="33%">

<table class="table-form">
<tr>
	<td class="table-node-key2">{$lang.db.links__type}</td>
	<td class="table-node-value2">{assign var=t value="links__type-"|cat:$data.1.links__type}{$lang.db.$t}</td>
</tr>
<tr>
	<td class="table-node-key2">{$lang.db.links__status}</td>
	<td class="{if $data.1.links__status == 'active'}link-up{else}link-down{/if}">{assign var=t value="links__status-"|cat:$data.1.links__status}{$lang.db.$t}</td>
</tr>
<tr>
	<td class="table-node-key2">{$lang.db.links__date_in}</td>
	<td class="table-node-value2">{$data.1.links__date_in|date_format:"%x"}</td>
</tr>
<tr>
	<td class="table-node-key2">{$lang.db.links__protocol}</td>
	<td class="table-node-value2">{$data.1.links__protocol|escape}</td>
</tr>
<tr>
	<td class="table-node-key2">{$lang.db.links__ssid}</td>
	<td class="table-node-value2">{$data.1.links__ssid|escape}</td>
</tr>
<tr>
	<td class="table-node-key2">{$lang.db.links__channel}</td>
	<td class="table-node-value2">{$data.1.links__channel|escape}</td>
</tr>
<tr>
	<td class="table-node-key2">{$lang.db.links__equipment}</td>
	<td class="table-node-value2">{$data.1.links__equipment|escape|nl2br}</td>
</tr>
</table>
		</td>
		<td class="table-node-link-info" width="33%">
		<table class="table-form">
		<tr><td colspan="2" class="table-node-key2">{$lang.clients}</td></tr>
		{if $data.1.c_node_id != ''}
			{section name=c loop=$data start=1}
				<tr><td class="table-node-value2"><a href="{$extra_data.EDIT[c]}">{$data[c].c_node_name|escape} (#{$data[c].c_node_id})</a></td><td class="{if $data[c].c_status == 'active'}link-up{else}link-down{/if}">{assign var=t value="links__status-"|cat:$data[c].c_status}{$lang.db.$t}</td></tr>
			{/section}
		{/if}
		</table>
		</td>
		<td class="table-node-link-info" width="33%" height="100%">
		{include file="generic/title4.tpl" title="`$lang.db.links__info`" content="`$data.1.links__info`"|escape|nl2br}
		</td>
		</tr>
		</table>
</td>
</tr>
</table>