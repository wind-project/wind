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
<table class="layout">
  {if $header != ''}
  <tr>
    <td {if $menu != ''}colspan="2" {/if}class="header">{$header}</td>
  </tr>
  {/if}
  
  <tr>
  {if $menu != ''}
    <td class="navigation">{$menu}</td>
  {/if}
    
    
    <td class="main">
	<table class="main-content">
		<tr>
			<td class="main-page">
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
    <td {if $menu != ''}colspan="2" {/if}class="footer">{$footer}</td>
  </tr>
  {/if}
</table>