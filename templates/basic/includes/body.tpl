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
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-main">
  {if $header != ''}
  <tr>
    <td {if $menu != ''}colspan="2" {/if}class="table-main-td-header">{$header}</td>
  </tr>
  {/if}
  
  <tr>
  {if $menu != ''}
    <td class="table-main-td-middle">{$menu}</td>
  {/if}
    
    
    <td class="table-middle-right-td">
	<table border="0" cellpadding="0" cellspacing="0" class="table-middle-right">
  {if $menu != '' && $form_login != ''}
		<tr><td class="quick-login">
		{$form_login}
		</td></tr>
  {/if}
		<tr><td class="main-page">
    {if $message==''}
		{$center}
    {else}
    	{$message}
    {/if}
	</td></tr>
	</table>

</td></tr>
    
  {if $footer != ''}
  <tr>
    <td {if $menu != ''}colspan="2" {/if}class="table-main-td-footer">{$footer}</td>
  </tr>
  {/if}
</table>