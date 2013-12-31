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
{if $node_method == 'add'}
	{include assign=help file=generic/help.tpl help=node_editor_add}
	{assign var=t value="`$lang.node_add`"}
	{else}
	{include assign=help file=generic/help.tpl help=node_editor}
	{assign var=t value="`$lang.node` $node_name (#$node_id)"|escape}
	{include assign="view" file="generic/link.tpl" link=$link_node_view content="`$lang.node_view`"}
	{if $link_node_delete}
		{include assign="t1" file="generic/link.tpl" link=$link_node_delete content="`$lang.node_delete`" confirm=TRUE}
	{/if}
{/if}
{include file=generic/page-title.tpl title="$t" right="$help"}
<div class="editor node-editor tabbed">
	<ul>
		<li><a href="#tab-info">{$lang.node_info}</a></li>
		{if $node != 'add'}
		<li><a href="#tab-links">{$lang.links}</a></li>
		<li><a href="#tab-network">{$lang.network}</a></li>
		<li><a href="#tab-services">{$lang.services}</a></li>
		<li><a href="#tab-myview">{$lang.myview}</a></li>
		{/if}
	</ul>
 
<div id="tab-info">
	{include assign="t2" file="generic/link.tpl" content="`$lang.find_coordinates`" 
		onclick="javascript: picker = new LocationPicker($('input[name=nodes__latitude]'), $('input[name=nodes__longitude]')); return false; "}
	{include file=generic/section-level2.tpl title="`$lang.node_info` $t2" right="$view $t1" content=$form_node}
</div>

{if $node != 'add'}
	<div id="tab-network">
		{include assign="t1" file="generic/link.tpl" link=$link_req_cclass content="`$lang.ip_range_request`"}
		{include file=generic/section-level3.tpl title="`$lang.ip_ranges` $t1" content=$table_ip_ranges}
		
		{include assign="t1" file="generic/link.tpl" link=$link_subnet_add content="`$lang.subnet_add`"}
		{include file=generic/section-level3.tpl title="`$lang.subnets` $t1" content=$table_subnets}
		
		{include assign="t1" file="generic/link.tpl" link=$link_ipaddr_add content="`$lang.ip_address_add`"}
		{include file=generic/section-level3.tpl title="`$lang.ip_addresses` $t1" content=$table_ipaddr}
		
		{include assign="t1" file="generic/link.tpl" link=$link_req_dns_for content="`$lang.dnszone_request_forward`"}
		{include assign="t2" file="generic/link.tpl" link=$link_req_dns_rev content="`$lang.dnszone_request_reverse`"}
		{include file=generic/section-level3.tpl title="`$lang.dns_zones` $t1 $t2" content=$table_dns}
		
		{include assign="t1" file="generic/link.tpl" link=$link_nameserver_add content="`$lang.nameserver_add`"}
		{include file=generic/section-level3.tpl title="`$lang.dns_nameservers` $t1" content=$table_nameservers}
	</div>
	<div id="tab-links">
		{include assign="t1" file="generic/link.tpl" link=$link_link_add content="`$lang.link_add`"}
		{include file=generic/section-level3.tpl title="`$lang.links` $t1" content=$table_links}
		
		{foreach key=key item=item from=$table_links_ap}
		{include file=generic/section-level3.tpl title="`$lang.ap` $key"|escape content=$item}
		{/foreach}
	</div>
	
	<div id="tab-services">
		{include assign="t1" file="generic/link.tpl" link=$link_services_add content="`$lang.services_add`"}
		{include file=generic/section-level3.tpl title="`$lang.services` $t1" content=$table_services}
	</div>
	
	<div id="tab-myview">
		{include file=generic/section-level3.tpl title="`$lang.myview`" content=$table_photosview}
	</div>
{/if}
</div>

{literal}
<script type="text/javascript">
$(function(){
	$('.tabbed').tabs();
});
</script>
{/literal}