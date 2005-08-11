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
var nodes = Array();
var links = Array();
var markers = Array();
var polylines = Array();

function gmap_onload() {
if (GBrowserIsCompatible()) {
  map = new GMap(document.getElementById("map"));
  map.centerAndZoom(new GPoint({/literal}{$node.longitude}{literal}, {/literal}{$node.latitude}{literal}), 4);
  map.addControl(new GLargeMapControl());
  map.setMapType(G_SATELLITE_TYPE);
  GEvent.addListener(map, "moveend", gmap_reload);
var request = GXmlHttp.create();
request.open("GET", "{/literal}{$link_xml_page}{literal}", true);
request.onreadystatechange = function() {
  if (request.readyState == 4) {
    var xmlDoc = request.responseXML;
    nodes = xmlDoc.documentElement.getElementsByTagName("node");
    links = xmlDoc.documentElement.getElementsByTagName("link");
  	gmap_reload();
  }
}
request.send(null);
}
}

function gmap_reload() {
		
	var bounds = map.getBoundsLatLng();
	var ch_p2p = document.getElementsByName("p2p")[0];
	var ch_aps = document.getElementsByName("aps")[0];
	var ch_clients = document.getElementsByName("clients")[0];
	var ch_unlinked = document.getElementsByName("unlinked")[0];
  for (var i = 0; i < nodes.length; i++) {
    if (markers[i] == undefined &&
    	((nodes[i].getAttribute("total_p2p") > 0 && ch_p2p.checked == true) || (nodes[i].getAttribute("total_aps") > 0 && ch_aps.checked == true) || (nodes[i].getAttribute("total_client_on_ap") > 0 && ch_clients.checked == true) || (nodes[i].getAttribute("total_p2p") == 0 && nodes[i].getAttribute("total_client_on_ap") == 0 && ch_unlinked.checked == true)) &&
    	nodes[i].getAttribute("latitude") >= bounds.minY && nodes[i].getAttribute("latitude") <= bounds.maxY && nodes[i].getAttribute("longitude") >= bounds.minX && nodes[i].getAttribute("longitude") <= bounds.maxX) {
	    var point = new GPoint(nodes[i].getAttribute("longitude"), nodes[i].getAttribute("latitude"));
		var html = "<div style=\"font-size:12px;font-weight:bold;\">" + nodes[i].getAttribute("name") + " (#" + nodes[i].getAttribute("id") + ")</div><br />" +
				"<div style=\"font-size:10px;\">" +
				"{/literal}{$lang.links}{literal}: " + nodes[i].getAttribute("total_p2p") + " (+" + nodes[i].getAttribute("total_aps") + " {/literal}{$lang.aps}{literal})" + "<br />" +
				"{/literal}{$lang.clients}{literal}: " + nodes[i].getAttribute("total_clients") + "<br /><br />" +
				"<a href=\"" + nodes[i].getAttribute("url") + "\">{/literal}{$lang.node_page}{literal}</a></div>";
	    markers[i] = createMarker(point, html);
	    map.addOverlay(markers[i]);
    }
  }
  for (var i = 0; i < links.length; i++) {
    if ( polylines[i] == undefined && 
    	((links[i].getAttribute("type") == "p2p" && ch_p2p.checked == true) || (links[i].getAttribute("type") == "client" && ch_clients.checked == true)) &&
    	 ((links[i].getAttribute("lat1") >= bounds.minY && links[i].getAttribute("lat1") <= bounds.maxY && links[i].getAttribute("lon1") >= bounds.minX && links[i].getAttribute("lon1") <= bounds.maxX) || 
    	 (links[i].getAttribute("lat2") >= bounds.minY && links[i].getAttribute("lat2") <= bounds.maxY && links[i].getAttribute("lon2") >= bounds.minX && links[i].getAttribute("lon2") <= bounds.maxX)) ) {
		polylines[i] = new GPolyline([new GPoint(links[i].getAttribute("lon1"), links[i].getAttribute("lat1")), new GPoint(links[i].getAttribute("lon2"), links[i].getAttribute("lat2"))], links[i].getAttribute("color"), (links[i].getAttribute("type")=="p2p"?3:1));
		map.addOverlay(polylines[i]);
    }
  }
}
function gmap_refresh() {
	map.clearOverlays();
	markers = Array();
	polylines = Array();
	gmap_reload();
}
function createMarker(point, html) {
  var marker = new GMarker(point);

  GEvent.addListener(marker, "click", function() {
    marker.openInfoWindowHtml(html);
  });

  return marker;
}
{/literal}