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
{include file=generic/page-title.tpl title="`$lang.nameserver_edit`"}
{include file=generic/link.tpl content="`$lang.delete`" link=$link_nameserver_delete confirm=TRUE}
{$form_nameserver}
{include file=generic/section-level3.tpl title="`$lang.node_info`" content=$table_node_info}
{include file=generic/section-level3.tpl title="`$lang.users_info`" content=$table_user_info}
{include file=generic/section-level3.tpl title="`$lang.links`" content=$table_links}
{include file=generic/section-level3.tpl title="`$lang.dns_zones`" content=$table_dns}