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
{if $node_method == 'add'}
	{include assign=help file=generic/help.tpl help=node_editor_add}
	{assign var=t value="`$lang.node_add`"}
	{else}
	{include assign=help file=generic/help.tpl help=node_editor}
	{assign var=t value="`$lang.node` $node_name (#$node_id)"|escape}
	{include assign="view_link" file="generic/button.tpl" class="btn-default btn-sm" glyph=eye-open 
		href=$link_node_view content="`$lang.node_view`"}
	{if $link_node_delete}
		{include assign="delete_link" file="generic/button.tpl" href=$link_node_delete 
			class="btn-danger btn-sm" glyph=remove content="`$lang.node_delete`" confirm=TRUE}
	{/if}
{/if}
{include file=generic/page-title.tpl title="$t" right="$view_link $delete_link $help"}
<div class="editor node-editor tabbed">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-info" data-toggle="tab">{$lang.node_info}</a></li>
		{if $node != 'add'}
		<li><a href="#tab-links" data-toggle="tab">{$lang.links}</a></li>
		<li><a href="#tab-network" data-toggle="tab">{$lang.network}</a></li>
		<li><a href="#tab-services" data-toggle="tab">{$lang.services}</a></li>
		<li><a href="#tab-myview" data-toggle="tab">{$lang.myview}</a></li>
   		<li><a href="#tab-nodesettingschanges" data-toggle="tab">{$lang.nodesettingschanges}</a></li>
		{/if}
	</ul>
 
<div class="tab-content">
<div class="tab-pane active" id="tab-info">

	{include assign="picker" class="btn-info btn-sm" file="generic/button.tpl" glyph="globe" content="`$lang.find_coordinates`" 
		onclick="javascript: picker = new LocationPicker($('input[name=nodes__latitude]'), $('input[name=nodes__longitude]')); return false; "}
	{include file=generic/section.tpl level=2 title="`$lang.node_info`" buttons="$picker" content=$form_node}
</div>

{if $node != 'add'}
	<div class="tab-pane" id="tab-network">
		{include assign="btn_request" file="generic/button.tpl" href=$link_req_cclass content="`$lang.ip_range_request`"
			class="btn-success btn-sm" glyph="envelope"}
			
		{include file=generic/section-level3.tpl title="`$lang.ip_ranges`" buttons="`$btn_request`" content=$table_ip_ranges}
		
		{include assign="btn_add" file="generic/button.tpl" href=$link_subnet_add content="`$lang.subnet_add`"
			class="btn-success btn-sm" glyph="plus-sign"}
		{include file=generic/section-level3.tpl title="`$lang.subnets`" buttons="`$btn_add`" content=$table_subnets}
		
		{include assign="btn_add" file="generic/button.tpl" href=$link_ipaddr_add content="`$lang.ip_address_add`"
			class="btn-success btn-sm" glyph="plus-sign"}
		{include file=generic/section-level3.tpl title="`$lang.ip_addresses`" buttons="`$btn_add`" content=$table_ipaddr}
		
                {include assign="btn_add" file="generic/button.tpl" href=$link_cname_add content="`$lang.ip_cname_add`"
                        class="btn-success btn-sm" glyph="plus-sign"}
                {include file=generic/section-level3.tpl title="`$lang.ip_cnames`" buttons="`$btn_add`" content=$table_cname}

		{include assign="btn_add" file="generic/button.tpl" href=$link_req_v6_cclass content="`$lang.ip_range_v6_request`"
			class="btn-success btn-sm" glyph="plus-sign"}
		{include file=generic/section-level3.tpl title="`$lang.ip_ranges_v6`" buttons="`$btn_add`" content=$table_ip_ranges_v6}
		
		{include assign="btn_req_for" file="generic/button.tpl" href=$link_req_dns_for content="`$lang.dnszone_request_forward`"
			class="btn-success btn-sm" glyph="envelope"}
		{include assign="btn_req_rev" file="generic/button.tpl" href=$link_req_dns_rev content="`$lang.dnszone_request_reverse`"
			class="btn-success btn-sm" glyph="envelope"}
		{include file=generic/section-level3.tpl title="`$lang.dns_zones`" buttons="`$btn_req_for` `$btn_req_rev`" content=$table_dns}
		
		{include assign="btn_add" file="generic/button.tpl" href=$link_nameserver_add content="`$lang.nameserver_add`"
			class="btn-success btn-sm" glyph="plus-sign"}
		{include file=generic/section-level3.tpl title="`$lang.dns_nameservers`" buttons="`$btn_add`" content=$table_nameservers}
	</div>
	<div class="tab-pane" id="tab-links">
		{include assign="btn_add" file="generic/button.tpl" href=$link_link_add content="`$lang.link_add`"
			class="btn-success btn-sm" glyph="plus-sign"}
		{include file=generic/section-level3.tpl title="`$lang.links`" buttons="`$btn_add`" content=$table_links}
		
		{foreach key=key item=item from=$table_links_ap}
		{include file=generic/section-level3.tpl title="`$lang.ap` $key"|escape content=$item}
		{/foreach}
	</div>
	
	<div class="tab-pane" id="tab-services">
		{include assign="btn_add" file="generic/button.tpl" href=$link_services_add content="`$lang.services_add`"
			class="btn-success btn-sm" glyph="plus-sign"}
		{include file=generic/section-level3.tpl title="`$lang.services`" buttons="`$btn_add`" content=$table_services}
	</div>
	
	<div class="tab-pane" id="tab-myview">
		{include file=generic/section-level3.tpl title="`$lang.myview`" content=$table_photosview}
	</div>
    <div class="tab-pane" id="tab-nodesettingschanges">
    	{include assign="btn_add" file="generic/button.tpl" href=$link_nodesettingschanges_add content="`$lang.nodesettingschanges_add`"
          class="btn-success btn-sm" glyph="plus-sign"}
		{include file=generic/section-level3.tpl title="`$lang.nodesettingschanges`" buttons="`$btn_add`" content=$table_nodesettingschanges}
	</div>
    
{/if}
</div>
</div>

{literal}
<script type="text/javascript">
$(function(){
	$('.tabbed').tab();
});
</script>
{/literal}
