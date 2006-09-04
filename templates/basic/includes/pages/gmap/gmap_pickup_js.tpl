{*
 * WiND - Wireless Nodes Database
 * Basic HTML Template
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
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
{literal}
var map;
var marker;
var marker_point;

function gmap_onload() {
	if (GBrowserIsCompatible()) {
		{/literal}
		{foreach from=$maps_available item=map_enabled key=map_name}
			{if $map_enabled===true}
				{if $map_types != null}
					{assign var=map_types value="`$map_types`,"}
				{/if}
				{assign var=map_types value="`$map_types` G_`$map_name`_MAP"}
			{/if}
		{/foreach}
		{literal}
		var map_types = [{/literal}{$map_types|upper}{literal}];
		map = new GMap2(document.getElementById("map"));
		if(map_types.length > 1)
			map.addControl(new GMapTypeControl());
		map.addControl(new GLargeMapControl());
		if (window.opener.document.{/literal}{$object_lat}{literal}.value != '' && window.opener.document.{/literal}{$object_lon}{literal}.value != '') {
			var center = new GLatLng(window.opener.document.{/literal}{$object_lat}{literal}.value, window.opener.document.{/literal}{$object_lon}{literal}.value);
			var zoom = 16;
			marker = new GMarker(center);
			marker_point = center;
		} else {
			var center = new GLatLng({/literal}{$center_latitude}{literal}, {/literal}{$center_longitude}{literal});
			var bound_sw = new GLatLng({/literal}{$min_latitude|default:$center_latitude}{literal},{/literal}{$min_longitude|default:$center_longitude}{literal});
			var bound_ne = new GLatLng({/literal}{$max_latitude|default:$center_latitude}{literal},{/literal}{$max_longitude|default:$center_longitude}{literal});
			var bounds = new GLatLngBounds(bound_sw, bound_ne);
			var zoom = map.getBoundsZoomLevel(bounds);

		}
		map.setCenter(center, zoom, G_{/literal}{$maps_available.default|upper}{literal}_MAP);
		GEvent.addListener(map, 'click', function(overlay, point) {
			if (overlay) {
				map.removeOverlay(overlay);
			} else if (point) {
				if (marker) map.removeOverlay(marker);
				marker = new GMarker(point);
				marker_point = point;
				var html = '<div style="padding-right: 15px; white-space: nowrap; text-align:left; font-size:10px;">{/literal}{$lang.db.nodes__latitude}{literal}: ' + (Math.round(marker_point.y * 1000000)/1000000) + '<br />' + '{/literal}{$lang.db.nodes__longitude}{literal}: ' + (Math.round(marker_point.x * 1000000)/1000000) + '<br /><br />' + '<a href="" onclick="window.opener.pickup_value(window.opener.document.{/literal}{$object_lat|escape:"quotes"}{literal}, Math.round(marker_point.y * 1000000) / 1000000); window.opener.pickup_value(window.opener.document.{/literal}{$object_lon|escape:"quotes"}{literal}, Math.round(marker_point.x * 1000000)/1000000); window.close(); return false;">{/literal}{$lang.select_the_coordinates}{literal}</a></div>';
				map.addOverlay(marker);
				marker.openInfoWindowHtml(html);
		}
		});
		if (marker) map.addOverlay(marker);
	}
}

{/literal}
