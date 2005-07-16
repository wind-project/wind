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
{if $form_restore != ''}
{include assign=help file=generic/help.tpl help=users_restore_password_recover}
{include file=generic/page-title.tpl title="`$lang.password_recover`" right="$help"}
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-page">
<tr>
<td class="table-page-pad">
{include file=generic/title1.tpl title="`$lang.user_info`" content=$form_restore}
</td>
</tr>
</table>
{elseif $form_change_password != ''}
{include assign=help file=generic/help.tpl help=users_restore_password_change}
{include file=generic/page-title.tpl title="`$lang.password_change`" right="$help"}
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-page">
<tr>
<td class="table-page-pad">
{include file=generic/title1.tpl title="`$lang.password_change`" content=$form_change_password}
</td>
</tr>
</table>
{/if}