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
{$main_menu_content}

{if $logged==TRUE}

	<div class="node_editor toolbox gadget">
		<span class="title">			
			<span class="text">{$lang.mynodes}</span>
		</span>
		
		<ul class="menu nodes-list">
		{section name=row loop=$node_editor}
		{if $smarty.section.row.index is not even}
			<li>
		{else}
			<li>
		{/if}
				<a href="{$node_editor[row].url_view}">{$node_editor[row].name|escape} (#{$node_editor[row].id})</a>
			</li>
		{/section}
		<li class="add">
			<a class="button" href="{$link_addnode}">{$lang.node_add}</a>
		</li>
		</ul>
	</div>
					
	{if $is_admin === TRUE || $is_hostmaster === TRUE}
					
	<div class="hostmaster toolbox gadget">
		<span class="title">
			<span class="text">{$lang.hostmaster_panel}</span>
		</span>
		<ul class="menu">
		{if $link_ranges != ''}
			<li>
				<img src="{$img_dir}/node-small.png" alt="{$lang.ip_ranges}" />
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
				<img src="{$img_dir}/dns-small.png" alt="{$lang.dns_zones}" />
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
				<img src="{$img_dir}/nameserver.gif" alt="{$lang.dns_nameservers}" />
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