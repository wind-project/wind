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
{$main_menu_content}

{if $logged==TRUE}

	{if $is_admin === TRUE || $is_hostmaster === TRUE }
	
	{if $ranges_waiting != 0 || $ranges_req_del != 0 || $dnszones_waiting != 0 || $dnsnameservers_waiting != 0}
	<div class="hostmaster toolbox gadget">
		<span class="title">
			<span class="text">{$lang.hostmaster_panel}</span>
		</span>
		<ul class="menu">
		{if $link_ranges != '' && ($ranges_waiting != 0 || $ranges_req_del != 0)}
			<li>
				<img src="{$img_dir}/node-small.png" alt="{$lang.ip_ranges}" />
				<a href="{$link_ranges}">{$lang.ip_ranges}</a>
			</li>

			{if $ranges_waiting != 0}
				<li>
				<a class="btn btn-info btn-sm" href="{$link_ranges_waiting}">
					<span class="badge">{$ranges_waiting}</span> {$lang.waiting}</a>
				</li>
			{/if}
			{if $ranges_req_del != 0}
				<li>
				<a class="btn btn-warning btn-sm" href="{$link_ranges_req_del}">
					<span class="badge">{$ranges_req_del}</span> {$lang.waiting}</a>
				</li>
			</li>
			{/if}
		{/if}
		{if $link_ranges_v6 != '' && ($ranges_v6_waiting != 0 || $ranges_v6_req_del != 0)}
			<li>
				<img src="{$img_dir}/node-small.png" alt="{$lang.ip_ranges}" />
				<a href="{$link_ranges_v6}">{$lang.ip_ranges_v6}</a>
			</li>

			{if $ranges_v6_waiting != 0}
				<li>
				<a class="btn btn-info btn-sm" href="{$link_ranges_v6_waiting}">
					<span class="badge">{$ranges_v6_waiting}</span> {$lang.waiting}</a>
				</li>
			{/if}
			{if $ranges_v6_req_del != 0}
				<li>
				<a class="btn btn-warning btn-sm" href="{$link_ranges_v6_req_del}">
					<span class="badge">{$ranges_v6_req_del}</span> {$lang.waiting}</a>
				</li>
			</li>
			{/if}
		{/if}
		{if $link_dnszones != '' && $dnszones_waiting != 0}
			<li>
				<img src="{$img_dir}/dns-small.png" alt="{$lang.dns_zones}" />
				<a href="{$link_dnszones}">{$lang.dns_zones}</a>
			</li>
			
			{if $dnszones_waiting != 0}
				<li>
				<a class="btn btn-success btn-sm" href="{$link_dnszones_waiting}">
					<span class="badge">{$dnszones_waiting}</span> {$lang.waiting}</a>
				</li>
			{/if}
			
		
		{/if}
		{if $link_dnsnameservers != '' && $dnsnameservers_waiting != 0}
			<li>
				<img src="{$img_dir}/nameserver.gif" alt="{$lang.dns_nameservers}" />
				<a href="{$link_dnsnameservers}">{$lang.dns_nameservers}</a>
			</li>
			
			{if $dnsnameservers_waiting != 0}
				<li>
				<a class="btn btn-success btn-sm" href="{$link_dnsnameservers_waiting}">
					<span class="badge">{$dnsnameservers_waiting}</span> {$lang.waiting}</a>
				</li>
			{/if}
			
		{/if}
		</ul>
	</div>
	{/if}

	{/if}

	<div class="node_editor toolbox gadget">
		<span class="title">			
			<span class="text">{$lang.mynodes}</span>
		</span>
		
		<ul class="menu node-list">
		{section name=row loop=$node_editor}
			<li>
				<a href="{$node_editor[row].url_view|escape}">{$node_editor[row].name|escape} <small class="node-id">#{$node_editor[row].id}</small></a>
			</li>
		{/section}
		<li class="add">
			<a class="btn btn-default btn-xs btn-success" href="{$link_addnode}"><span class="glyphicon glyphicon-plus-sign"></span> {$lang.node_add}</a>
		</li>
		</ul>
	</div>

{/if}

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