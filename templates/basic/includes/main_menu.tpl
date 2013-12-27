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
<ul class="main-menu menu gadget">
	<li>
		<a href="{$link_allnodes}">
		<img src="templates/basic/images/search_nodes.gif" alt="{$lang.all_nodes}" />
		{$lang.all_nodes}</a>
	</li>
	<li>
		<a href="{$link_alldnszones}">
		<img src="templates/basic/images/search_dns.gif" alt="{$lang.all_zones}" />
		{$lang.all_zones}</a>
  	</li>
  	<li><a href="{$link_allranges}">
		<img src="templates/basic/images/search_ip.gif" alt="{$lang.all_ranges}" />
		{$lang.all_ranges}</a>
	</li>
	<li>
		<a href="{$link_allservices}">
		<img src="templates/basic/images/services.gif" alt="{$lang.all_services}" />
		{$lang.all_services}</a>
	</li>
</ul>

<div class="statistics gadget">
	<span class="title">{$lang.statistics}</span>
	
  	<ul class="statistics">
		<li>
			<span class="quantity">{$stats_nodes_active}/{$stats_nodes_total}</span>
			<span class="desc">{$lang.active_nodes|lower}</span>
		</li>
	  	<li>
	  		<span class="quantity">{$stats_backbone}</span>
	  		<span class="desc">{$lang.backbone_nodes|lower}</span>
	  	</li>
	  	<li>
	  		<span class="quantity">{$stats_links}</span>
	  		<span class="desc">{$lang.links|lower}</span>
	  	</li>
	  	<li>
			<span class="quantity">{$stats_aps}</span>
			<span class="desc">{$lang.aps|lower}</span>
	  	</li>
	  	<li>
			<span class="quantity">{$stats_services_active}/{$stats_services_total}</span>
			<span class="desc">{$lang.active_services|lower}</span>
		</li>
	</ul>
</div>

{if $logged==TRUE}

	<div class="mynodes toolbox gadget">
		<span class="title">			
			<span class="text">{$lang.mynodes}</span>
		</span>
		
		<ul class="menu nodes-list">
		{section name=row loop=$mynodes}
		{if $smarty.section.row.index is not even}
			<li>
		{else}
			<li>
		{/if}
				<a href="{$mynodes[row].url_view}">{$mynodes[row].name|escape} (#{$mynodes[row].id})</a>
			</li>
		{/section}
		<li class="add">
			<a class="button" href="{$link_addnode}">{$lang.node_add}</a>
		</li>
		</ul>
	</div>

					
	{if $is_admin === TRUE}
		<div class="administration toolbox gadget">
			<span class="title">
				<span class="text">{$lang.admin_panel}</span>
			</span>
			<ul class="menu">
				<li>
					<img src="templates/basic/images/node-small.png" alt="{$lang.nodes}" />
					<a href="{$link_admin_nodes}">{$lang.nodes}</a>
				</li>
				<li>
					<img src="templates/basic/images/user-small.png" alt="{$lang.users}" />
					<a href="{$link_admin_users}">{$lang.users}</a>
				</li>
				<li>
					<img src="templates/basic/images/services-small.png" alt="{$lang.services}" />
					<a href="{$link_admin_nodes_services}">{$lang.services}</a>
				</li>
				<li>
					<img src="templates/basic/images/services-small.png" alt="{$lang.services_categories}" />
					<a href="{$link_admin_services}">{$lang.services_categories}</a>
				</li>
				<li>
					<img src="templates/basic/images/regions-small.png" alt="{$lang.regions}" />
					<a href="{$link_admin_regions}">{$lang.regions}</a>
				</li>
				<li>
					<img src="templates/basic/images/areas-small.png" alt="{$lang.areas}" />
					<a href="{$link_admin_areas}">{$lang.areas}</a>
				</li>
			</ul>
		</div>

	{/if}
					
	{if $is_admin === TRUE || $is_hostmaster === TRUE}
					
	<div class="hostmaster toolbox gadget">
		<span class="title">
			<span class="text">{$lang.hostmaster_panel}</span>
		</span>
		<ul class="menu">
		{if $link_ranges != ''}
			<li>
				<img src="templates/basic/images/node-small.png" alt="{$lang.ip_ranges}" />
				<a href="{$link_ranges}">{$lang.ip_ranges}</a>
			</li>
			<li>
			{if $ranges_waiting != 0}
			<a class="button" href="{$link_ranges_waiting}"><em>{$ranges_waiting}</em> {$lang.waiting}</a>
			{/if}
			{if $ranges_req_del != 0}
				<a class="button" href="{$link_ranges_req_del}"><em>{$ranges_req_del}</em> {$lang.for_deletion}</a>
			{/if}
			</li>
		{/if}
		{if $link_dnszones != ''}
			<li>
				<img src="templates/basic/images/dns-small.png" alt="{$lang.dns_zones}" />
				<a href="{$link_dnszones}">{$lang.dns_zones}</a>
			</li>
			<li>
			{if $dnszones_waiting != 0}
				<a class="button" href="{$link_dnszones_waiting}"><em>{$dnszones_waiting}</em> {$lang.waiting}</a>
			{/if}
			</li>
		
		{/if}
		{if $link_dnsnameservers != ''}
			<li>
				<img src="templates/basic/images/nameserver.gif" alt="{$lang.dns_nameservers}" />
				<a href="{$link_dnsnameservers}">{$lang.dns_nameservers}</a>
			</li>
			<li>
				{if $dnsnameservers_waiting != 0}
					<a class="button" href="{$link_dnsnameservers_waiting}"><em>{$dnsnameservers_waiting}</em> {$lang.waiting}</a>
				{/if}
			</li>
		{/if}
		</ul>
	</div>

	{/if}

{/if}

