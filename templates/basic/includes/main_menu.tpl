{*
 * WiND - Wireless Nodes Database
 * Basic HTML Template
 *
 * Copyright (C) 2005 Konstantinos Papadimitriou <vinilios@cube.gr>
 * Copyright (C) 2009 Vasilis Tsiligiannis <b_tsiligiannis@silverton.gr>
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
					<td class="table-small-menu-text"><a href="{$link_home}" class="menu-link">{$lang.home}</a></td>
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
					<td class="table-search-menu-text"><img src="templates/basic/images/search_nodes.gif" width="34" height="28" alt="{$lang.all_nodes}" />&nbsp;<a href="{$link_allnodes}">{$lang.all_nodes}</a></td>
			  	</tr>
			  	<tr>
					<td class="table-search-menu-text"><img src="templates/basic/images/search_dns.gif" width="36" height="32" alt="{$lang.all_zones}" />&nbsp;<a href="{$link_alldnszones}">{$lang.all_zones}</a></td>
			  	</tr>
			  	<tr>
					<td class="table-search-menu-text"><img src="templates/basic/images/search_ip.gif" width="33" height="32" alt="{$lang.all_ranges}" />&nbsp;<a href="{$link_allranges}">{$lang.all_ranges}</a></td>
				</tr>
				<tr>
					<td class="table-search-menu-text"><img src="templates/basic/images/services.gif" width="33" height="32" alt="{$lang.all_services}" />&nbsp;<a href="{$link_allservices}">{$lang.all_services}</a></td>
		  		</tr>
			  	<tr>
					<td class="table-search-menu-text">
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-search-menu">
							<tr>
								<td><img src="templates/basic/images/search.gif" width="32" height="32" alt="{$lang.quick_search}" /></td>
								<td style="font-size: 12px;">
									<form name="search" method="get" action="?">
									{include file="generic/qs.tpl" qs=$query_string}
									<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-main">
										<tr>
											<td style="font-size: 12px;" width="100%">&nbsp;{$lang.quick_search} <a href="javascript:document.search.submit()"><img src="templates/basic/images/submit1.png" alt="{$lang.submit}" /></a></td>
										</tr>
										<tr>
											<td>
												<div>
												<input type="text" id="q" name="q" autocomplete="off" onkeydown="" onfocus="hover('',this.value);" onkeyup="hover(event.keyCode,this.value);"  onblur="setTimeout('hideSearch()',500); hov=0;" />
												</div>
												<div align="left" id="searchResult" name="searchResult" style="font-family:Arial; font-size:12px; background-color: white; border:#000000 dashed 1px; padding:0px; display: none; position: absolute; width: 150px;"></div>
											</td>
										</tr>
									</table>
									</form>
								</td>
							</tr>
						</table>
					</td>
			  	</tr>
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
					<td colspan="2" class="quick-login-title">{$lang.statistics}</td>
			  	</tr>
			  	<tr>
					<td rowspan="5" class="quick-login-text"><img src="templates/basic/images/stats.png" width="48" height="48" alt="{$lang.statistics}" /></td>
					<td class="quick-login-text">{$stats_nodes_active}/{$stats_nodes_total} <span style="color: black;">{$lang.active_nodes|lower}</span></td>
			  	</tr>
			  	<tr>
					<td class="quick-login-text">{$stats_backbone} <span style="color: black;">{$lang.backbone_nodes|lower}</span></td>
			  	</tr>
			  	<tr>
					<td class="quick-login-text">{$stats_links} <span style="color: black;">{$lang.links|lower}</span></td>
			  	</tr>
			  	<tr>
					<td class="quick-login-text">{$stats_aps} <span style="color: black;">{$lang.aps|lower}</span></td>
			  	</tr>
			  	<tr>
					<td class="quick-login-text">{$stats_services_active}/{$stats_services_total} <span style="color: black;">{$lang.active_services|lower}</span></td>
			  </tr>
			  	<tr>
					<td colspan="2" class="table-middle-left-pad"></td>
			  	</tr>
			</table>
        </td>
	</tr>

   {if $logged==TRUE}

   <tr>
		<td class="search-menu">
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-mynodes">
				<tr>
					<td rowspan="2" class="table-mynodes-image" ><img src="templates/basic/images/node.gif" alt="{$lang.mynodes}" /></td>
					<td class="table-mynodes-title">{$lang.mynodes}</td>
				</tr>
				<tr>
					<td class="table-mynodes-link">|<a href="{$link_addnode}">{$lang.node_add}</a>|</td>
				</tr>
			</table>
			<table width="100%"  border="0" cellpadding="0" cellspacing="0">
			{section name=row loop=$mynodes}
			{if $smarty.section.row.index is not even}
				<tr class="table-form-row2">
			{else}
				<tr class="table-form-row1">
			{/if}
					<td class="table-form-title"><img src="templates/basic/images/node-small.png" alt="{$lang.mynodes}" />&nbsp;<a href="{$mynodes[row].url}">{$mynodes[row].name|escape} (#{$mynodes[row].id})</a>&nbsp;<a href="{$mynodes[row].url_view}"><img src="templates/basic/images/submit1.png" alt="{$lang.node}" /></a></td>
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
					<td class="table-mynodes-image" ><img src="templates/basic/images/admin.gif" alt="{$lang.admin_panel}" /></td><td class="table-mynodes-title" >{$lang.admin_panel}</td>
				</tr>
				<tr class="table-form-row1">
					<td colspan="2" class="table-form-title"><img src="templates/basic/images/node-small.png" alt="{$lang.nodes}" />&nbsp;<a href="{$link_admin_nodes}">{$lang.nodes}</a></td>
				</tr>
				<tr class="table-form-row1">
					<td colspan="2" class="table-form-title"><img src="templates/basic/images/user-small.png" alt="{$lang.users}" />&nbsp;<a href="{$link_admin_users}">{$lang.users}</a></td>
				</tr>
				<tr class="table-form-row1">
					<td colspan="2" class="table-form-title"><img src="templates/basic/images/services-small.png" alt="{$lang.services}" />&nbsp;<a href="{$link_admin_nodes_services}">{$lang.services}</a></td>
				</tr>
				<tr class="table-form-row1">
					<td colspan="2" class="table-form-title"><img src="templates/basic/images/services-small.png" alt="{$lang.services_categories}" />&nbsp;<a href="{$link_admin_services}">{$lang.services_categories}</a></td>
				</tr>
				<tr class="table-form-row1">
					<td colspan="2" class="table-form-title"><img src="templates/basic/images/regions-small.png" alt="{$lang.regions}" />&nbsp;<a href="{$link_admin_regions}">{$lang.regions}</a></td>
				</tr>
				<tr class="table-form-row1">
					<td colspan="2" class="table-form-title"><img src="templates/basic/images/areas-small.png" alt="{$lang.areas}" />&nbsp;<a href="{$link_admin_areas}">{$lang.areas}</a></td>
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
					<td class="table-mynodes-image" ><img src="templates/basic/images/admin.gif" alt="{$lang.hostmaster_panel}" /></td><td class="table-mynodes-title" >{$lang.hostmaster_panel}</td>
				</tr>
				{if $link_ranges != ''}
				<tr class="table-form-row1">
					<td colspan="2" class="table-form-title"><img src="templates/basic/images/node-small.png" alt="{$lang.ip_ranges}" />&nbsp;<a href="{$link_ranges}">{$lang.ip_ranges}</a></td>
				</tr>
				<tr>
					<td colspan="2" class="menu-small-links">{include file="generic/link.tpl" link=$link_ranges_waiting content="$ranges_waiting `$lang.waiting`"} {include file="generic/link.tpl" link=$link_ranges_req_del content="$ranges_req_del `$lang.for_deletion`"}</td>
				</tr>
				{/if}
				{if $link_dnszones != ''}
				<tr class="table-form-row1">
					<td colspan="2" class="table-form-title"><img src="templates/basic/images/dns-small.png" alt="{$lang.dns_zones}" />&nbsp;<a href="{$link_dnszones}">{$lang.dns_zones}</a></td>
				</tr>
				<tr>
					<td colspan="2" class="menu-small-links">{include file="generic/link.tpl" link=$link_dnszones_waiting content="$dnszones_waiting `$lang.waiting`"}</td>
				</tr>
				{/if}
				{if $link_dnsnameservers != ''}
				<tr class="table-form-row1">
					<td colspan="2" class="table-form-title"><img src="templates/basic/images/nameserver.gif" alt="{$lang.dns_nameservers}" />&nbsp;<a href="{$link_dnsnameservers}">{$lang.dns_nameservers}</a></td>
				</tr>
				<tr>
					<td colspan="2" class="menu-small-links">{include file="generic/link.tpl" link=$link_dnsnameservers_waiting content="$dnsnameservers_waiting `$lang.waiting`"}</td>
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
