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


{include assign=help file=generic/help.tpl help=nodes_search}
{include file=generic/page-title.tpl title="`$lang.all_nodes`" right="$help"}
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-page">
{if $skip_map!='yes'}
	<tr>
		<td class="table-page-split">

		<div id="map" class="map" style="width: 1000px; height: 350px;" > </div>
		<script type="text/javascript" src="{$js_dir}/map.js" > </script>
		<script src="http://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
		{literal}
		<script type="text/javascript">
			// Load map
			map = new NetworkMap('map', {/literal} '{$link_nodesjson_url}' {literal},{
				{/literal}
				'bound_sw' : [ {$bounds.min_latitude}, {$bounds.min_longitude}],
				'bound_ne' : [ {$bounds.max_latitude}, {$bounds.max_longitude}]
				{literal}
			});
			nodeFilter = new NetworkMapUiNodeFilter(map);
		</script>
		{/literal}
		</td>
	</tr>
{/if}
	<tr>
		<td class="table-page-split">
			{include file=generic/title1.tpl title="`$lang.nodes_search`" content=$form_search_nodes}
		</td>
	</tr>
	<tr>
		<td class="table-page-pad">
			{include file=generic/title2.tpl title="`$lang.nodes_found`" content=$table_nodes}
		</td>
	</tr>
</table>
