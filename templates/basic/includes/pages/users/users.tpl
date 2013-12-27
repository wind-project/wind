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
{include assign=help file=generic/help.tpl help="users_`$user_method`"}
{assign var=t value="user_`$user_method`"}



{include file=generic/page-title.tpl title="`$lang.$t`" right="$help"}
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-page">
<tr>
<td class="table-page-pad">
{if $link_user_delete}{include assign=user_delete file=generic/link.tpl content="`$lang.delete`" link=$link_user_delete confirm=TRUE}{/if}
{include file=generic/title1.tpl title="`$lang.user_info`" right="$user_delete" content=$form_user}
</td>
</tr>
</table>