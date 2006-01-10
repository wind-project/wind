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
  map = new GMap(document.getElementById("map"));
  if (window.opener.document.{/literal}{$object_lat}{literal}.value != '' &&
  			window.opener.document.{/literal}{$object_lon}{literal}.value != '') {
	  var center = new GPoint(window.opener.document.{/literal}{$object_lon}{literal}.value, window.opener.document.{/literal}{$object_lat}{literal}.value);
	  var zoom = 0; 
	  marker = new GMarker(center);
	  marker_point = center;
  } else {
	  var center = new GPoint({/literal}{$center_longitude}{literal}, {/literal}{$center_latitude}{literal});
	  var span = new GSize((({/literal}{$max_longitude|default:0}{literal})-({/literal}{$min_longitude|default:0}{literal})),(({/literal}{$max_latitude|default:0}{literal})-({/literal}{$min_latitude|default:0}{literal}))); 
	  var zoom = map.spec.getLowestZoomLevel(center, span, map.viewSize); 
  }
  map.centerAndZoom(center, zoom);
  map.addControl(new GLargeMapControl());
  map.setMapType(G_SATELLITE_TYPE);
	GEvent.addListener(map, 'click', function(overlay, point) {
	  if (overlay) {
	    map.removeOverlay(overlay);
	  } else if (point) {
	    if (marker) map.removeOverlay(marker);
	    marker = new GMarker(point);
	    marker_point = point;
		var html = '<div style="padding-right: 15px; white-space: nowrap; text-align:left; font-size:10px;">{/literal}{$lang.db.nodes__latitude}{literal}: ' + (Math.round(marker_point.y * 100000)/100000) + '<br />' + '{/literal}{$lang.db.nodes__longitude}{literal}: ' + (Math.round(marker_point.x * 100000)/100000) + '<br /><br />' + '<a href="" onclick="window.opener.pickup_value(window.opener.document.{/literal}{$object_lat|escape:"quotes"}{literal}, Math.round(marker_point.y * 100000) / 100000); window.opener.pickup_value(window.opener.document.{/literal}{$object_lon|escape:"quotes"}{literal}, Math.round(marker_point.x * 100000)/100000); window.close(); return false;">{/literal}{$lang.select_the_coordinates}{literal}</a></div>';
	    map.addOverlay(marker);
	    marker.openInfoWindowHtml(html);
	  }
	});
  if (marker) map.addOverlay(marker);
}
}

{/literal}