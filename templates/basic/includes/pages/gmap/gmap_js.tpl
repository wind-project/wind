{*
 * WiND - Wireless Nodes Database
 * Basic HTML Template
 *
 * Copyright (C) 2005 Nikolaos Nikalexis <winner@cube.gr>
 * Copyright (C) 2010 Vasilis Tsiligiannis <b_tsiligiannis@silverton.gr>
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
var selected = Array();
var p2p_ap = Array();
var p2p = Array();
var aps = Array();
var clients = Array();
var unlinked = Array();
var links_p2p = Array();
var links_client = Array();
var markers = Array();
var polylines = Array();
var ch_p2p;
var ch_aps;
var ch_clients;
var ch_unlinked;

{/literal}

var icon_green = Array(new GIcon(), new GIcon());
icon_green[0].image = "{$img_dir}gmap/mm_20_green.png";
icon_green[0].shadow = "{$img_dir}gmap/mm_20_shadow.png";
icon_green[0].iconSize = new GSize(12, 20);
icon_green[0].shadowSize = new GSize(22, 20);
icon_green[0].iconAnchor = new GPoint(6, 20);
icon_green[0].infoWindowAnchor = new GPoint(5, 1);

icon_green[1].image = "{$img_dir}gmap/mm_50_green.png";
icon_green[1].shadow = "{$img_dir}gmap/mm_50_shadow.png";
icon_green[1].iconSize = new GSize(20, 34);
icon_green[1].shadowSize = new GSize(37, 34);
icon_green[1].iconAnchor = new GPoint(9, 32);
icon_green[1].infoWindowAnchor = new GPoint(10, 1);

var icon_orange = Array(new GIcon(), new GIcon());
icon_orange[0].image = "{$img_dir}gmap/mm_20_orange.png";
icon_orange[0].shadow = "{$img_dir}gmap/mm_20_shadow.png";
icon_orange[0].iconSize = new GSize(12, 20);
icon_orange[0].shadowSize = new GSize(22, 20);
icon_orange[0].iconAnchor = new GPoint(6, 20);
icon_orange[0].infoWindowAnchor = new GPoint(5, 1);

icon_orange[1].image = "{$img_dir}gmap/mm_50_orange.png";
icon_orange[1].shadow = "{$img_dir}gmap/mm_50_shadow.png";
icon_orange[1].iconSize = new GSize(20, 34);
icon_orange[1].shadowSize = new GSize(37, 34);
icon_orange[1].iconAnchor = new GPoint(9, 32);
icon_orange[1].infoWindowAnchor = new GPoint(10, 1);

var icon_blue = Array(new GIcon(), new GIcon());
icon_blue[0].image = "{$img_dir}gmap/mm_20_blue.png";
icon_blue[0].shadow = "{$img_dir}gmap/mm_20_shadow.png";
icon_blue[0].iconSize = new GSize(12, 20);
icon_blue[0].shadowSize = new GSize(22, 20);
icon_blue[0].iconAnchor = new GPoint(6, 20);
icon_blue[0].infoWindowAnchor = new GPoint(5, 1);

icon_blue[1].image = "{$img_dir}gmap/mm_50_blue.png";
icon_blue[1].shadow = "{$img_dir}gmap/mm_50_shadow.png";
icon_blue[1].iconSize = new GSize(20, 34);
icon_blue[1].shadowSize = new GSize(37, 34);
icon_blue[1].iconAnchor = new GPoint(9, 32);
icon_blue[1].infoWindowAnchor = new GPoint(10, 1);

var icon_red = Array(new GIcon(), new GIcon());
icon_red[0].image = "{$img_dir}gmap/mm_20_red.png";
icon_red[0].shadow = "{$img_dir}gmap/mm_20_shadow.png";
icon_red[0].iconSize = new GSize(12, 20);
icon_red[0].shadowSize = new GSize(22, 20);
icon_red[0].iconAnchor = new GPoint(6, 20);
icon_red[0].infoWindowAnchor = new GPoint(5, 1);

icon_red[1].image = "{$img_dir}gmap/mm_50_red.png";
icon_red[1].shadow = "{$img_dir}gmap/mm_50_shadow.png";
icon_red[1].iconSize = new GSize(20, 34);
icon_red[1].shadowSize = new GSize(37, 34);
icon_red[1].iconAnchor = new GPoint(9, 32);
icon_red[1].infoWindowAnchor = new GPoint(10, 1);

var icon_grey = Array(new GIcon(), new GIcon());
icon_grey[0].image = "{$img_dir}gmap/mm_20_grey.png";
icon_grey[0].shadow = "{$img_dir}gmap/mm_20_shadow.png";
icon_grey[0].iconSize = new GSize(12, 20);
icon_grey[0].shadowSize = new GSize(22, 20);
icon_grey[0].iconAnchor = new GPoint(6, 20);
icon_grey[0].infoWindowAnchor = new GPoint(5, 1);

icon_grey[1].image = "{$img_dir}gmap/mm_50_grey.png";
icon_grey[1].shadow = "{$img_dir}gmap/mm_50_shadow.png";
icon_grey[1].iconSize = new GSize(20, 34);
icon_grey[1].shadowSize = new GSize(37, 34);
icon_grey[1].iconAnchor = new GPoint(9, 32);
icon_grey[1].infoWindowAnchor = new GPoint(10, 1);

{literal}

function gmap_onload() {
	ch_p2p = document.getElementsByName("p2p")[0];
	ch_aps = document.getElementsByName("aps")[0];
	ch_clients = document.getElementsByName("clients")[0];
	ch_unlinked = document.getElementsByName("unlinked")[0];
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
        gmapOptions = {
                mapTypes: [{/literal}{$map_types|upper}{literal}]
        }
        map = new GMap2(document.getElementById("map"), gmapOptions);
        if(gmapOptions.mapTypes.length > 1)
                        map.addControl(new GMapTypeControl());
        map.addControl(new GLargeMapControl());
        //map.addControl(new GOverviewMapControl());
		var center = new GLatLng({/literal}{$center_latitude}{literal},{/literal}{$center_longitude}{literal});
		if ('{/literal}{$zoom}{literal}' != '') {
                        zoom = {/literal}{$zoom|default:0}{literal};
                } else {
			var bound_sw = new GLatLng({/literal}{$min_latitude|default:$center_latitude}{literal},{/literal}{$min_longitude|default:$center_longitude}{literal});
			var bound_ne = new GLatLng({/literal}{$max_latitude|default:$center_latitude}{literal},{/literal}{$max_longitude|default:$center_longitude}{literal});
			var bounds = new GLatLngBounds(bound_sw, bound_ne);
			var zoom = map.getBoundsZoomLevel(bounds);
		}
		map.setCenter(center, zoom, G_{/literal}{$maps_available.default|upper}{literal}_MAP);
		GEvent.addListener(map, "moveend", gmap_reload);
		GEvent.addListener(map, "zoomend", function (oldLevel, newLevel) {
                                        if ((oldLevel <= 17-4 && newLevel > 17-4) ||
                                                (oldLevel > 17-4 && newLevel <= 17-4)) {
                                                        map.clearOverlays();
                                                        markers = Array();
                                                        polylines = Array();
						}
                                                        gmap_reload();
					});
		gmap_refresh();
	}
}

function gmap_reload() {
if (ch_aps.checked == true && ch_clients.checked == true) makePolylines(links_client, "#00ffff", "#ff0000", 2);
if (ch_p2p.checked == true) makePolylines(links_p2p, "#00ff00", "#ff0000", 3);
if (ch_unlinked.checked == true) makeMarkers(unlinked, icon_red, 100);
if (ch_clients.checked == true) makeMarkers(clients, icon_blue, 100);
if (ch_aps.checked == true) makeMarkers(aps, icon_green, 17-4);
if (ch_p2p.checked == true) makeMarkers(p2p, icon_orange, 17-4);
if (ch_p2p.checked == true || ch_aps.checked == true) makeMarkers(p2p_ap, icon_green, 17-4);
makeMarkers(selected, icon_grey, 17-4);

}

function gmap_refresh() {
	var ch_p2p = document.getElementsByName("p2p")[0];
	var ch_aps = document.getElementsByName("aps")[0];
	var ch_clients = document.getElementsByName("clients")[0];
	var ch_unlinked = document.getElementsByName("unlinked")[0];
	if (((ch_p2p.checked == true && p2p.length > 0) || ch_p2p.checked == false) &&
		((ch_aps.checked == true && aps.length > 0) || ch_aps.checked == false) &&
		((ch_clients.checked == true && clients.length > 0) || ch_clients.checked == false) &&
		((ch_unlinked.checked == true && unlinked.length > 0) || ch_unlinked.checked == false)) {
			map.clearOverlays();
			markers = Array();
			polylines = Array();
			gmap_reload();
			return;
	}
	var request = GXmlHttp.create();
	var xml_url = "{/literal}{$link_xml_page}{literal}" +
		(ch_p2p.checked == true && p2p.length == 0?"&show_p2p=1":"") +
		(ch_aps.checked == true && aps.length == 0?"&show_aps=1":"") +
		(ch_clients.checked == true && clients.length == 0?"&show_clients=1":"") +
		(ch_unlinked.checked == true && unlinked.length == 0?"&show_unlinked=1":"") +
		(ch_p2p.checked == true && links_p2p.length == 0?"&show_links_p2p=1":"") +
		(ch_aps.checked == true && ch_clients.checked == true && links_client.length == 0?"&show_links_client=1":"");
	request.open("GET", xml_url, true);
	request.onreadystatechange =
                        function() {
                                if (request.readyState == 4) {
                                        var xmlDoc = request.responseXML;
                                        selected = xmlDoc.documentElement.getElementsByTagName("selected");
                                        if ((ch_p2p.checked == true || ch_aps.checked == true) && p2p_ap.length == 0) p2p_ap = xmlDoc.documentElement.getElementsByTagName("p2p-ap");
                                        if (ch_aps.checked == true && aps.length == 0) aps = xmlDoc.documentElement.getElementsByTagName("ap");
                                        if (ch_p2p.checked == true && p2p.length == 0) p2p = xmlDoc.documentElement.getElementsByTagName("p2p");
                                        if (ch_clients.checked == true && clients.length == 0) clients = xmlDoc.documentElement.getElementsByTagName("client");
                                        if (ch_unlinked.checked == true && unlinked.length == 0) unlinked = xmlDoc.documentElement.getElementsByTagName("unlinked");
                                        if (ch_p2p.checked == true && links_p2p.length == 0) links_p2p = xmlDoc.documentElement.getElementsByTagName("link_p2p");
                                        if (ch_aps.checked == true && ch_clients.checked == true && links_client.length == 0) links_client = xmlDoc.documentElement.getElementsByTagName("link_client");
                                        map.clearOverlays();
                                        markers = Array();
                                        polylines = Array();
                                        gmap_reload();
                                }
                       	}
        request.send(null);

}

function makePolylines(links, color_active, color_inactive, size) {
        var polylines_t = Array();
        var bounds = map.getBounds();
        for (var i = 0; i < links.length; i++) {
                var link_id = links[i].getAttribute("id");
                if (polylines[link_id] != undefined) continue;
                var link_lat1 = parseFloat(links[i].getAttribute("lat1"));
                var link_lon1 = parseFloat(links[i].getAttribute("lon1"));
                var link_lat2 = parseFloat(links[i].getAttribute("lat2"));
                var link_lon2 = parseFloat(links[i].getAttribute("lon2"));
                var l_inbound_1 = bounds.contains(new GLatLng(link_lat1,link_lon1));
		var l_inbound_2 = bounds.contains(new GLatLng(link_lat2,link_lon2));

                if (l_inbound_1 || l_inbound_2) {
                        if (links[i].getAttribute("status") == 'active') {
                                var color = color_active;
                        } else {
                                var color = color_inactive;
                        }
                        var point1 = new GLatLng(link_lat1,link_lon1);
                        var point2 = new GLatLng(link_lat2,link_lon2);
                        var polyline = new GPolyline([point1, point2], color, size);
                        polylines_t.push(polyline);
                        polylines[link_id] = true;
    			map.addOverlay(polyline);
                }
    }
}

function createMarker(point, html, icon) {
        var marker = new GMarker(point, icon);
        GEvent.addListener(marker, "click",
                function() {
                        marker.openInfoWindowHtml(html);
                });

        return marker;
}


function makeMarkers(nodes, icon_image, icon_zoom) {
        var bounds = map.getBounds();
        for (var i = 0; i < nodes.length; i++) {
                var node_id = nodes[i].getAttribute("id");
                var node_lat = nodes[i].getAttribute("lat");
                var node_lon = nodes[i].getAttribute("lon");

                if (markers[node_id] != undefined) continue;

                var inbounds = bounds.contains(new GLatLng(node_lat,node_lon));

                if (inbounds) {
                        var node_name = nodes[i].getAttribute("name");
                        var node_area = nodes[i].getAttribute("area");
                        var node_p2p = nodes[i].getAttribute("p2p") * 1;
                        var node_aps = nodes[i].getAttribute("aps") * 1;
                        var node_client_on_ap = nodes[i].getAttribute("client_on_ap") * 1;
                        var node_clients = nodes[i].getAttribute("clients") * 1;
                        var node_url = nodes[i].getAttribute("url");

                var point = new GLatLng(node_lat,node_lon);
                        var icon; var icon_s;
                        if (map.getZoom() > icon_zoom) {
                                var icon_scale = 1;
                    	} else {
                                var icon_scale = 0;
               		}
                        icon = icon_image[icon_scale];
                        icon_s = icon_image[0];
                        var html = "<div style=\"padding-right: 15px; white-space: nowrap; text-align:left; font-size:12px;font-weight:bold;\"><img src=\"" + icon_s.image + "\" alt=\"\" />" + node_name + " (#" + node_id + ")</div><br />" +
				"<div style=\"padding-right: 15px; white-space: nowrap; text-align:left; font-size:10px;\">" +
				node_area + "<br />" +
                                "{/literal}{$lang.links}{literal}: " + (parseInt(node_p2p) + parseInt(node_client_on_ap)) + " (+" + node_aps + " {/literal}{$lang.aps}{literal})" + "<br />" +
				"{/literal}{$lang.clients}{literal}: " + node_clients + "<br /><br />" +
                                "<a href=\"" + node_url + "\">{/literal}{$lang.node_page}{literal}</a>";
			if(selected[0]) {
			var this_node = selected[0].getAttribute("id");
				if(this_node != node_id) {
					html = html + "<br /><a href=\"\" onclick=\"javascript: t = window.open('?page=nodes&amp;subpage=plot_link&amp;a_node="+ selected[0].getAttribute("id") +"&amp;b_node="+ node_id +"', 'popup_plot_link', 'width=600,height=450,toolbar=0,resizable=1,scrollbars=1'); t.focus(); return false;\">{/literal}{$lang.plot}{literal}</a></div>";
				}
			} else {
				html = html + "</div>";
			}
                        var marker = createMarker(point, html, icon);
                        markers[node_id] = true;
        		map.addOverlay(marker);
                }
        }
}

{/literal}


