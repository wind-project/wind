{*
 * WiND - Wireless Nodes Database
 * Basic HTML Template
 *
 * Copyright (C) 2006 John Kolovos <cirrus@awmn.net>
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

<table cellpadding="0" cellspacing="0" width="100%">
{if $ip_search}
	{section name=ip loop=$ip_search}
	<tr {if $widget=="0"}onclick="window.location.href='{$ip_search[ip].href}'" onmouseover="hover('mouse',this)"{else}onclick="open_url('{$url}{$ip_search[ip].href}');" onmouseover="this.style.background='orange';" onmouseout="this.style.background='transparent';" style="cursor: pointer;"{/if} style="width: 100%">
		<td>{$ip_search[ip].ip_start}</td>
		<td align="right">(#{$ip_search[ip].id})</td>
	</tr>
	{sectionelse}
		<tr style="width: 100%">
			<td><i>{$lang.not_found}</i></td>
		</tr>
	{/section}
{elseif $dns_search}
	{section name=zone loop=$dns_search}
	<tr {if $widget=="0"}onclick="window.location.href='{$dns_search[zone].href}'" onmouseover="hover('mouse',this)"{else}onclick="open_url('{$url}{$dns_search[zone].href}');" onmouseover="this.style.background='orange';" onmouseout="this.style.background='transparent';" style="cursor: pointer;"{/if} style="width: 100%">
		<td>{$dns_search[zone].name}</td>
		<td align="right">(#{$dns_search[zone].id})</td>
	</tr>
	{sectionelse}
		<tr style="width: 100%">
			<td><i>{$lang.not_found}</i></td>
		</tr>
	{/section}
{else}
	{section name=node loop=$nodes_search}
	<tr {if $widget=="0"}onclick="window.location.href='{$nodes_search[node].href}'" onmouseover="hover('mouse',this)"{else}onclick="open_url('{$url}{$nodes_search[node].href}');" onmouseover="this.style.background='orange';" onmouseout="this.style.background='transparent';" style="cursor: pointer;"{/if} style="width: 100%">
		<td>{$nodes_search[node].name}</td>
		<td align="right">(#{$nodes_search[node].id})</td>
	</tr>
	{sectionelse}
		<tr style="width: 100%">
			<td><i>{$lang.not_found}</i></td>
		</tr>
	{/section}
{/if}
</table>