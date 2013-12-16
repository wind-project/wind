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
<div id="map" style="width: 100%; height: 80vh;"></div>
<script type="text/javascript" src="{$js_dir}map.js" > </script>
{literal}
<script type="text/javascript">
$(function(){
	// Make map fullscreen
	var fixHeight = function(){
		$('#map').height($('.main-page').height());
	}
	fixHeight();	// First Call;
	$(window).resize(fixHeight);
	
	// Load map
	map = new NetworkMap('map', {/literal} '{$link_nodesjson_url}' {literal},{
		{/literal}
		'bound_sw' : [ {$bounds.min_latitude}, {$bounds.min_longitude}],
		'bound_ne' : [ {$bounds.max_latitude}, {$bounds.max_longitude}]
		{literal}
	});
	nodeFilter = new NetworkMapUiNodeFilter(map);
});
{/literal}
 </script>