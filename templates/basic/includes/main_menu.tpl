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
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-middle-left">
	  <tr>
		<td class="small-menu">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			  <tr bgcolor="#FFFFFF">
				<td class="table-small-menu-text"><a href="/" class="menu-link">{$lang.home}</a></td>
			  </tr>
		  
		  
	{if $logged==TRUE}

			  <tr bgcolor="#FFFFFF">
				<td class="table-small-menu-text"><a href="{$link_edit_profile}" class="menu-link">{$lang.edit_profile}</a></td>
			  </tr>
			  <tr bgcolor="#FFFFFF">
				<td class="table-small-menu-text"><a href="{$link_logout}" class="menu-link">{$lang.log_out}</a></td>
			  </tr>
		
	{else}
	
			  <tr bgcolor="#FFFFFF">
				<td class="table-small-menu-text">{$lang.login}</td>
			  </tr>
			  <tr bgcolor="#FFFFFF">
				<td class="table-small-menu-text"><a href="{$link_register}" class="menu-link">{$lang.register}</a></td>
			  </tr>
			  <tr bgcolor="#FFFFFF">
				<td class="table-small-menu-text"><a href="{$link_restore_password}" class="menu-link">{$lang.password_recover}</a></td>
			  </tr>

		
	 {/if}            
			  <tr>
				<td class="table-middle-left-pad"></td>
			  </tr>
			</table>
	  </td>
	  </tr>
	  <tr>
		<td class="search-menu">
		<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-search-menu">
		  <tr>
			<td class="table-search-menu-text"><img src="templates/basic/images/search_nodes.gif" width="34" height="28">&nbsp;<a href="{$link_allnodes}">{$lang.all_nodes}</a></td>
		  </tr>
		  <tr>
			<td class="table-search-menu-text"><img src="templates/basic/images/search_dns.gif" width="36" height="32">&nbsp;<a href="{$link_alldnszones}">{$lang.all_zones}</a></td>
		  </tr>
		  <tr>
			<td class="table-search-menu-text"><img src="templates/basic/images/search_ip.gif" width="33" height="32">&nbsp;<a href="{$link_allranges}">{$lang.all_ranges}</a></td>
		  </tr>
		  <tr>
			<td class="table-middle-left-pad"></td>
		  </tr>
		</table>
		</td>
	  </tr>
   {if $logged==TRUE}
          <tr>
            <td class="search-menu">
				<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-search-menu">
				  <tr>
					<td colspan="2" class="quick-login-title">{$lang.user_info}</td>
				  </tr>
				  <tr class="table-form-row2">
					<td class="quick-login-text">{$lang.username}</td>
					<td class="table-form-title">{$username}</td>
				  </tr>
				  <tr class="table-form-row1">
					<td class="quick-login-text">{$lang.registered_since}</td>
					<td class="table-form-title">{$date_in|date_format:"%x"}</td>
				  </tr>
				  <tr class="table-form-row2">
					<td class="quick-login-text">{$lang.name}</td>
					<td class="table-form-title">{$name}</td>
				  </tr>
				  <tr class="table-form-row1">
					<td class="quick-login-text">{$lang.surname}</td>
					<td class="table-form-title">{$surname}</td>
				  </tr>
				  <tr class="table-form-row2">
					<td class="quick-login-text">{$lang.last_visit}</td>
					<td class="table-form-title">{$last_visit|date_format:"%x"}</td>
				  </tr>
				  <tr class="table-form-row1">
					<td colspan="2" class="table-middle-left-pad"></td>
				  </tr>
				</table>
            </td>
          </tr>
		<tr>
		<td class="search-menu">
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-mynodes">
			<tr>
			<td rowspan="2" class="table-mynodes-image" ><img src="templates/basic/images/node.gif"></td>
			<td class="table-mynodes-title">{$lang.mynodes}</td>
			
			<tr><td class="table-mynodes-link">|<a href="{$link_addnode}">{$lang.node_add}</a>|</td></tr>
			</table>
			<table width="100%"  border="0" cellpadding="0" cellspacing="0">
			{section name=row loop=$mynodes}
			{if $smarty.section.row.index is not even}
			<tr class="table-form-row2">
			{else}
			<tr class="table-form-row1">
			{/if}
			<td class="table-form-title"><img src="templates/basic/images/node-small.png">&nbsp;<a href="{$mynodes[row].url}">{$mynodes[row].name} (#{$mynodes[row].id})</a></td>
			</tr>
			{/section}
			<tr>
			<td class="table-middle-left-pad"></td>
			</tr>
			</table>
		</td>
		</tr>
					
	{if $is_admin === TRUE}
					
		<tr>
		<td class="search-menu">
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-mynodes">
			<tr>
			<td class="table-mynodes-image" ><img src="templates/basic/images/admin.gif"></td><td class="table-mynodes-title" >{$lang.admin_panel}</td>
			</tr>
			<tr class="table-form-row1">
			<td colspan="2" class="table-form-title"><img src="templates/basic/images/node-small.png">&nbsp;<a href="{$link_admin_nodes}">{$lang.nodes}</a></td>
			</tr>
			<tr class="table-form-row1">
			<td colspan="2" class="table-form-title"><img src="templates/basic/images/user-small.png">&nbsp;<a href="{$link_admin_users}">{$lang.users}</a></td>
			</tr>
			<tr>
			<td colspan="2" class="table-middle-left-pad"></td>
			</tr>
			</table>
		</td>
		</tr>
	{/if}
					
	{if $is_admin === TRUE || $is_hostmaster === TRUE}
					
		<tr>
		<td class="search-menu">
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-mynodes">
			<tr>
			<td class="table-mynodes-image" ><img src="templates/basic/images/admin.gif"></td><td class="table-mynodes-title" >{$lang.hostmaster_panel}</td>
			</tr>
			{if $link_ranges != ''}
			<tr class="table-form-row1">
			<td colspan="2" class="table-form-title"><img src="templates/basic/images/node-small.png">&nbsp;<a href="{$link_ranges}">{$lang.ip_ranges}</a></td>
			</tr>
			<tr>
			<td colspan="2" class="menu-small-links">{include file="generic/link.tpl" link=$link_ranges_pending content="$ranges_pending `$lang.pending`"} {include file="generic/link.tpl" link=$link_ranges_req_del content="$ranges_req_del `$lang.for_deletion`"}</td>
			</tr>
			{/if}
			{if $link_dnszones != ''}
			<tr class="table-form-row1">
			<td colspan="2" class="table-form-title"><img src="templates/basic/images/dns-small.png">&nbsp;<a href="{$link_dnszones}">{$lang.dns_zones}</a></td>
			</tr>
			<tr>
			<td colspan="2" class="menu-small-links">{include file="generic/link.tpl" link=$link_dnszones_pending content="$dnszones_pending `$lang.pending`"} {include file="generic/link.tpl" link=$link_dnszones_req_del content="$dnszones_req_del `$lang.for_deletion`"}</td>
			</tr>
			{/if}
			{if $link_dnsnameservers != ''}
			<tr class="table-form-row1">
			<td colspan="2" class="table-form-title"><img src="templates/basic/images/nameserver.gif">&nbsp;<a href="{$link_dnsnameservers}">{$lang.dns_nameservers}</a></td>
			</tr>
			<tr>
			<td colspan="2" class="menu-small-links">{include file="generic/link.tpl" link=$link_dnsnameservers_req_del content="$dnsnameservers_pending `$lang.pending`"} {include file="generic/link.tpl" link=$link_dnszones_req_del content="$dnsnameservers_req_del `$lang.for_deletion`"}</td>
			</tr>
			{/if}
			<tr>
			<td colspan="2" class="table-middle-left-pad"></td>
			</tr>
			</table>
		</td>
		</tr>
	{/if}
					
  	{/if}
</table>