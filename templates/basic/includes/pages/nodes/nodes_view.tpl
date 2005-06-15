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
{include file=generic/page-title.tpl title="`$lang.node` `$node.name` (#`$node.id`)" right="$help"}
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-page">
<tr>
<td class="table-page-split">
{include assign=t1 file="includes/pages/nodes/node_info.tpl"}
{include file="generic/title3.tpl" title="`$lang.node_info`" content="$t1"}
{include file="generic/title4.tpl" title="`$lang.db.nodes__info`" content="`$node.info`"|nl2br}
{include file="generic/title5.tpl" title="`$lang.ip_ranges`" content="`$table_ip_ranges`"}
{include file="generic/title5.tpl" title="`$lang.dns_zones`" content="`$table_dns`"}
{include file="generic/title5.tpl" title="`$lang.dns_nameservers`" content="`$table_nameservers`"}
</td>
<td class="table-page-split">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="500" height="500" id="main" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="map/flash/main.swf" />
<param name="menu" value="false" />
<param name="quality" value="high" />
<param name="wmode" value="opaque" />
<param name="bgcolor" value="#ffffff" />
<embed src="map/flash/main.swf" menu="false" quality="high" wmode="opaque" bgcolor="#ffffff" width="500" height="500" name="main" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
<div align="center">{include file=generic/link.tpl link="map/flash/main.html" content="`$lang.new_window`" target="_blank"}</div>
</td>
</tr>
<tr>
<td colspan="2" class="table-page-pad">
{include file=generic/title2.tpl title="`$lang.links`" content=$table_links_p2p}
</td>
</tr>
<tr>
<td colspan="2" class="table-page-pad">
{include file=generic/title2.tpl title="`$lang.mynetwork`" content=$table_ipaddr_subnets}
</td>
</tr>
<tr>
<td colspan="2" class="table-page-pad">
{include assign=t file=includes/pages/nodes/myview.tpl}
{include file=generic/title2.tpl title="`$lang.myview`" content=$t}
</td>
</tr>
</table>
