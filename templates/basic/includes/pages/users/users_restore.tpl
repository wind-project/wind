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
{if $form_restore != ''}
{include assign=help file=generic/help.tpl help=users_restore_password_recover}
{include file=generic/page-title.tpl title="`$lang.password_recover`" right="$help"}
{include file=generic/section-level2.tpl title="`$lang.user_info`" content=$form_restore}
{elseif $form_change_password != ''}
{include assign=help file=generic/help.tpl help=users_restore_password_change}
{include file=generic/page-title.tpl title="`$lang.password_change`" right="$help"}
{include file=generic/section-level2.tpl title="`$lang.password_change`" content=$form_change_password}
{/if}