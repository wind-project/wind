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
{include file=generic/page-title.tpl title="`$lang.nameserver_edit`"}
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-page">
<tr>
<td class="table-page-pad">
{include assign=nameserver_delete file=generic/link.tpl content="`$lang.delete`" link=$link_nameserver_delete confirm=TRUE}
{include file=generic/title1.tpl title="`$lang.nameserver_edit`" right="$nameserver_delete" content=$form_nameserver}
</td>
</tr>
<tr>
<td class="table-page-pad">
{include file=generic/title1.tpl title="`$lang.node_info`" content=$table_node_info}
</td>
</tr>
<tr>
<td class="table-page-pad">
{include file=generic/title1.tpl title="`$lang.users_info`" content=$table_user_info}
</td>
</tr>
<tr>
<td class="table-page-pad">
{include file=generic/title1.tpl title="`$lang.links`" content=$table_links}
</td>
</tr>
<tr>
<td class="table-page-pad">
{include file=generic/title1.tpl title="`$lang.dns_zones`" content=$table_dns}
</td>
</tr>
</table>