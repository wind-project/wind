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