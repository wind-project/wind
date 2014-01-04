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
{include assign=help file=generic/help.tpl help=ranges_search}
{include file=generic/page-title.tpl title="`$lang.all_ranges`" right="$help"}
{include file=generic/filter.tpl title="`$lang.ip_ranges_search`" content=$form_search_ranges}
{include file=generic/section-level2.tpl title="`$lang.ip_ranges_found`" content=$table_ranges}
