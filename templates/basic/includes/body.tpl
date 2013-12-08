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
<table class="main">
  {if $header != ''}
  <tr>
    <td {if $menu != ''}colspan="2" {/if}class="header">{$header}</td>
  </tr>
  {/if}
  
  <tr>
  {if $menu != ''}
    <td class="middle">{$menu}</td>
  {/if}
    
    
    <td class="table-middle-right-td">
	<table class="middle-right">
  	{if $menu != ''}
		<tr>
			<td class="quick-login">
			{if $logged}
				{include file="includes/main_menu_logged.tpl"}
			{else}
				{$form_login}
			{/if}
			</td>
			<td nowrap="nowrap" class="quick-login-field">
				{foreach key=key item=item from=$languages}
				<a href="{$item.link}"><img alt="{$item.name}" src="{$img_dir}flags/{$key}.gif" /></a> 
				{/foreach}
			</td>
		</tr>
	  {/if}
		<tr>
			<td class="main-page" colspan="2">
    			{if $message==''}
					{$center}
    			{else}
    				<table width="100%" border="0" cellpadding="50" cellspacing="0">
    					<tr>
    						<td align="center">
    							{$message}
    						</td>
    					</tr>
    				</table>
    			{/if}
			</td>
		</tr>
	</table>
	
	</td>
</tr>
    
  {if $footer != ''}
  <tr>
    <td {if $menu != ''}colspan="2" {/if}class="table-main-td-footer">{$footer}</td>
  </tr>
  {/if}
</table>