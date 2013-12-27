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
{include file=generic/page-title.tpl title="`$lang.node` `$node.name` (#`$node.id`)"|escape right="$help"}
<table class="table-page">
<tr>
	<td class="table-page-split">
		{include assign=t1 file="includes/pages/nodes/node_info.tpl"}
		{if $edit_node}{include assign=ed file="generic/link.tpl" content="`$lang.edit_node`" link=$edit_node}{/if}
		{include file="generic/title3.tpl" title="`$lang.node_info` $ed" content="$t1"}
		{include file="generic/title4.tpl" title="`$lang.db.nodes__info`" content="`$node.info`"|escape|nl2br}
		{include file="generic/title5.tpl" title="`$lang.ip_ranges`" content="`$table_ip_ranges`"}
                {include file="generic/title5.tpl" title="`$lang.ip_ranges_v6`" content="`$table_ip_ranges_v6`"}
		{include file="generic/title5.tpl" title="`$lang.dns_zones`" content="`$table_dns`"}
		{include file="generic/title5.tpl" title="`$lang.dns_nameservers`" content="`$table_nameservers`"}
		<br />
		<div align="center">{include file=generic/link.tpl content="`$lang.node_plot_link`" onclick="javascript: t = window.open('$link_plot_link', 'popup_plot_link', 'width=600,height=420,toolbar=0,resizable=1,scrollbars=1'); t.focus(); return false;"}</div>
	</td>
	<td class="table-page-split">
		<div id="map" class="map" style="width: 600px; height: 500px;" > </div>
	</td>
	
</tr>
<tr>
<td colspan="2" class="table-page-pad">
{foreach from=$table_links_ap item=ap}
	{assign var=aps value="`$aps``$ap`"}
{/foreach}
{include file=generic/title2.tpl title="`$lang.links`" content="`$table_links_p2p``$aps`"}
</td>
</tr>
<tr>
<td colspan="2" class="table-page-pad">
{include file=generic/title2.tpl title="`$lang.mynetwork`" content=$table_ipaddr_subnets}
</td>
</tr>
<tr>
<td colspan="2" class="table-page-pad">
{include file=generic/title2.tpl title="`$lang.services`" content=$table_services}
</td>
</tr>
<tr>
<td colspan="2" class="table-page-pad">
{include assign=t file=includes/pages/nodes/myview.tpl}
{include file=generic/title2.tpl title="`$lang.myview`" content=$t}
</td>
</tr>
</table>
