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
{include assign=help file=generic/help.tpl help="users_`$user_method`"}
{assign var=t value="user_`$user_method`"}

{if $link_user_delete}
	{include assign=user_delete file=generic/button.tpl class="btn btn-danger btn-sm" glyph="remove" content="`$lang.delete`" href=$link_user_delete confirm=TRUE}
{/if}
{include file=generic/page-title.tpl title="`$lang.$t`" right="`$user_delete` `$help`"}


{$form_user}