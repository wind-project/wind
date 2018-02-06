{*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005-2014 	by WiND Contributors (see AUTHORS.txt)
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
{include assign=range_delete file=generic/button.tpl class="btn-danger btn-sm" glyph=remove
	content="`$lang.delete`" href=$link_range_delete confirm=TRUE}
{include file=generic/page-title.tpl title="`$lang.ip_range_v6_edit`" right="`$delete_link`"}

{$form_range_v6}
{include file=generic/section-level2.tpl title="`$lang.node_info`" content=$table_node_info}
{include file=generic/section-level2.tpl title="`$lang.users_info`" content=$table_user_info}
{include file=generic/section-level2.tpl title="`$lang.links`" content=$table_links}
{include file=generic/section-level2.tpl title="`$lang.ip_ranges_v6`" content=$table_ip_ranges_v6}
