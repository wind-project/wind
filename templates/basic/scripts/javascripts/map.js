
/**
 * @brief Map with all the information of the network topology
 * @param el_id The id of the element to render map on
 * @param topology_url The url with network topology information.
 * @param options
 * 	- bound_sw : The southwest point of the boundaries (lat,lng)
 *  - bound_ne	: The northeast point of the boundaries (lat,lng)
 *  - center : Center of the map (lat,lng)
 */
var NetworkMap = function(el_id, topology_url, options) {
	// Private variables
	
	this._map_el_id = el_id;
	this._topology_url = topology_url;
	this._default_filter = {
		p2p : true,
		ap: true,
		client : true,
		unlinked : false
	};
	this._filter = $.extend({}, this._default_filter);
	this._node_popup = null;
	
	// Process options
	this._default_options = {
		bound_sw : [37.97152, 23.72664],
		bound_ne : [37.97152, 23.72664],
		center: null
	};
	this.options = $.extend({}, this._default_options, options);
	
	// Construct map
	this._constructMap();
	
	// Download topology
	this._downloadTopology();
	
};

/**
 * @brief Construct and return DOM Element for a node popup
 */
NetworkMap.prototype._constructNodePopup = function(feature) {
	
	var popup_body = $(
		'<div><div class="nodePopup" ><span class="title"/><span class="id"/>'
			+ '<ul class="attributes" />'
			+ '<a>Node info</a>'
			+ '</div></div>'
			);
	
	popup_body.find('.nodePopup').addClass(feature.attributes['type']);
	popup_body.find('.title').text(feature.attributes['name']);
	popup_body.find('.id').text('#'+String(feature.attributes['id']));
	popup_body.find('a').attr('href', feature.attributes['url']);
	var ul = popup_body.find('ul');
	var displayAttribute = function(key, value) {
		var li = $('<li><span class="key"></span>: <span class="value"></span></li>');
		li.find('.key').text(key);
		li.find('.value').text(value);
		ul.append(li);
	};
	if (feature.attributes['area']) {
		ul.append($('<li class="area"/>').text(feature.attributes['area']));
	}
	
	// Generate links description
	var total_links = String(feature.attributes['total_p2p']
		+ feature.attributes['total_ap_subscriptions']
		+ feature.attributes['total_clients']);
	var extra_info = [];
	if (feature.attributes['total_p2p'] > 0)
		extra_info.push("PtP: " + feature.attributes['total_p2p']);
	if (feature.attributes['total_clients'] > 0)
		extra_info.push("Clients: " + feature.attributes['total_clients']);
	if (feature.attributes['total_ap_subscriptions'] > 0)
		extra_info.push("AP client: " + feature.attributes['total_ap_subscriptions']);
	if (extra_info.length)
		total_links += ' (' + extra_info.join(", ") + ')';
	displayAttribute("Links", total_links);

	return popup_body;
};

/**
 * @brief Construct the complete map without topology
 */
NetworkMap.prototype._constructMap = function() {
	var networkMap = this;
	
	// Calculate boundaries
	var bounds = new OpenLayers.Bounds();
	bounds.extend(new OpenLayers.LonLat(this.options.bound_sw[1], this.options.bound_sw[0]));
	bounds.extend(new OpenLayers.LonLat(this.options.bound_ne[1], this.options.bound_ne[0]));
	bounds.transform('EPSG:4326', 'EPSG:3857');
	
	// Calculate center
	var center;
	if (this.options['center']) {
		center = new OpenLayers.LonLat(this.options.center[1], this.options.center[0])
			.transform('EPSG:4326', 'EPSG:3857');
	} else {
		center = bounds.getCenterLonLat();
	}
	
	// LAYER : Nodes
	//-------------------------------------------------------
	this._layer_nodes = new OpenLayers.Layer.Vector("Nodes", {
		styleMap : new OpenLayers.StyleMap({
			'default' : new OpenLayers.Style({
				'pointRadius' : 5,
				'strokeWidth' : 1,
				'strokeColor' : '#000000',
				'fillColor' : '${color}',
			}),
			'hover' : new OpenLayers.Style({
				label : '${name}',
				labelYOffset : +13,
				labelOutlineColor : "white",
				labelOutlineWidth : 4
			}),
			'select' : new OpenLayers.Style({
				'pointRadius' : 7,
			})
		})
	});
	
	var nodesLayerHighlightControl = new OpenLayers.Control.SelectFeature(this._layer_nodes, {
		hover : true,
		highlightOnly : true,
		renderIntent : "hover"
	});

	// Selection
	var nodesLayerSelectControl = new OpenLayers.Control.SelectFeature(this._layer_nodes, {
			onSelect : function(feature) {
				var popup_body = networkMap._constructNodePopup(feature);

				var popup = new OpenLayers.Popup("node",
						new OpenLayers.LonLat(feature.geometry.x, feature.geometry.y),
						new OpenLayers.Size(100, 100),
						popup_body.html(),
						false
				);

				popup.autoSize = true;
				popup.panMapIfOutOfView = true;
				networkMap._node_popup = popup;
				networkMap._olMap.addPopup(popup);

			},
			onUnselect : function(feature) {
				if (networkMap._node_popup)
					networkMap._olMap.removePopup(networkMap._node_popup);
				networkMap._node_popup = null;
			}
		}
	);

	// LAYER : Links
	//-------------------------------------------------------
	this._layer_links = new OpenLayers.Layer.Vector("Links", {
		styleMap : new OpenLayers.StyleMap({
			'default' : new OpenLayers.Style({
				'strokeWidth' : 1.2,
				'strokeColor' : '${color}',
			}),
		})
	});
	
	// LAYER : map
	//-------------------------------------------------------
	this._layer_osm = new OpenLayers.Layer.OSM("OpenStreetMaps");
	this._layer_gmap = new OpenLayers.Layer.Google("Google Satelite", {type: google.maps.MapTypeId.SATELLITE, visibility: false});
	
	// Finally connect all components under a map object
	this._olMap = new OpenLayers.Map({
		div : this._map_el_id,
		projection : 'EPSG:3857',
		layers : [
		          this._layer_osm,
		          this._layer_gmap,
		          this._layer_links,
		          this._layer_nodes],
		center : center,
		zoom : 10,
		zoomDuration: 10,
		numZoomLevels: 20
	});
	this._olMap.zoomToExtent(bounds);
	
	this._olMap.addControl(nodesLayerHighlightControl);
	this._olMap.addControl(nodesLayerSelectControl);
	this._olMap.addControl(new OpenLayers.Control.LayerSwitcher());
	nodesLayerHighlightControl.activate();
	nodesLayerSelectControl.activate();
};

/**
 * @brief Download network topology and update map
 * @param focusSelected It will focus to selected node
 * 	if it is found. (default True)
 */
NetworkMap.prototype._downloadTopology = function(focusSelected) {
	var networkMap = this;
	
	// Process parameters
	if (typeof(focusSelected) == 'undefined') {
		focusSelected = true;
	}
	
	// Clear map
	this._layer_nodes.removeAllFeatures();
	this._layer_links.removeAllFeatures();
	if (networkMap._node_popup){
		networkMap._olMap.removePopup(this._node_popup);
		networkMap._node_popup = null;
	}
	
	// Try to load nodes
	$.get(this._topologyUrl(), function(topology) {
		networkMap._topology = topology;
		
		var GeoJSONParser = new OpenLayers.Format.GeoJSON({
			'internalProjection' : "EPSG:900913",
			'externalProjection' : "EPSG:4326"
		});

		// Convert nodes to GeoJSON
		var nodeFeatures = $.map(topology.nodes, function(node, node_id) {

			// Color mapping for nodes
			var colors_per_type = {
				'p2p' : '#f5c70c',
				'p2p-ap' : '#f5c70c',
				'ap' : '#61d961',
				'client' : '#5858ff',
				'unlinked' : '#ff3f4f',
			};

			// GeoJSON inherits all properties + extra
			var properties = jQuery.extend({}, node);
			
			properties['color'] = colors_per_type[properties['type']];
			if ('selected' in properties)
				properties['color'] = '#000000';

			return {
				'type' : "Feature",
				'id' : node['id'],
				'geometry' : {
					'type' : 'Point',
					'coordinates' : [ node['lon'], node['lat'] ]
				},
				'properties' : properties,
			};
		});
		var nodesGeoJSON = {
			"type" : "FeatureCollection",
			"features" : nodeFeatures
		};

		// Convert links to GeoJSON
		var linkFeatures = $.map(topology.links, function(link, link_id) {
			
			// GeoJSON inherits all properties + extra
			var properties = jQuery.extend({}, link);
			properties['color'] = (link['status'] == 'active')
				?'#00ff00'
				:'#ff0000';
			
			return {
				'type' : "Feature",
				'id' : link['id'],
				'geometry' : {
					'type' : 'LineString',
					'coordinates' : [
					        [ link['lon1'], link['lat1'] ],
							[ link['lon2'], link['lat2'] ] ]
				},
				'properties' : properties
			};
		});
		var linksGeoJSON = {
			"type" : "FeatureCollection",
			"features" : linkFeatures
		};

		// Load features on map
		networkMap._layer_nodes.addFeatures(GeoJSONParser.read(nodesGeoJSON));
		networkMap._layer_links.addFeatures(GeoJSONParser.read(linksGeoJSON));
		
		// Check if there is selected
		if (focusSelected && ('selected' in topology['meta'])) {
			networkMap.focusAtNode(topology['meta']['selected']);
		}

	});
};

/**
 * @brief Construct the topology url based on filter
 */
NetworkMap.prototype._topologyUrl = function() {
	var topology_url = this._topology_url;
	filter = [];
	$.each(this._filter, function(key, value){
		if (value)
			filter.push(key);
	});
	topology_url += '&filter=' + filter.join(',');
	return topology_url;
};

/**
 * @brief Set the node filtering
 */
NetworkMap.prototype.setFilter = function(visible_filter) {
	this._filter = $.extend({}, this._default_filter, visible_filter);
	
	this._downloadTopology(false);	// Redownload map
};

/**
 * @brief Get node filtering
 */
NetworkMap.prototype.getFilter = function() {
	return this._filter;
};

/**
 * @brief Focus on specific node (if exists)
 */
NetworkMap.prototype.focusAtNode = function(node_id) {
	if (!node_id in this._topology.nodes)
		return false;	// Cannot find node
	
	var node = this._topology.nodes[node_id];
	var point = new OpenLayers.LonLat(node['lon'], node['lat'])
		.transform('EPSG:4326', 'EPSG:3857');
	
	this._olMap.setCenter(point, 15, true);
	
	// Hack because setCenter does not call callbacks
	this._layer_nodes.redraw();
	this._layer_links.redraw();
};


/**
 * @brief HUD implementation to control map filter.
 * @param map The NetworkMap object to render and control filter.
 * @param options The NetworkMap options object.
 */
var NetworkMapControlNodeFilter = function(map, options) {
	var nodeFilterObject = this;
	
	this._map = map;
	this._valid_filters = {
		'p2p' : 'backbone',
		'ap' : 'ap',
		'client' : 'clients',
		'unlinked' : 'unlinked'
	};

	// Construct hud
	this._element = $('<div class="map-hud map-filter"><ul/></ul></div>');
	$.each(this._valid_filters, function(filter, lang_token){
		nodeFilterObject._element.find('ul').append($('<li />').addClass(filter).text(lang[lang_token]));
	});
	$('#' + this._map._map_el_id).append(this._element);
	
	// Load current state
	this._loadState();
	
	// Add hooks
	this._element.find('li').click(function(){
		$(this).toggleClass('active');
		nodeFilterObject._saveState();
	});
};

/**
 * @brief Load state of filters from map
 */
NetworkMapControlNodeFilter.prototype._loadState = function() {
	var nodeFilterObject = this;
	
	$.each(this._map.getFilter(), function(filter, state){
		var li = nodeFilterObject._element.find('li.' + filter);
		if (!state) {
			li.removeClass('active');
		} else {
			li.addClass('active');
		}
	});
};

/**
 * @brief Save state of filters to the map
 */
NetworkMapControlNodeFilter.prototype._saveState = function() {
	var nodeFilterObject = this;
	var filters = this._map.getFilter();
	
	// Loop around filters
	$.each(this._map.getFilter(), function(filter, state){
		var li = nodeFilterObject._element.find('li.' + filter);
		
		filters[filter] = false;
		if (li.hasClass('active')) {
			filters[filter] = true;
		}
	});
	
	nodeFilterObject._map.setFilter(filters);
};


/**
 * @brief HUD implementation to control fullscreen mode
 * @param map The NetworkMap object to render and control filter.
 * @param options The NetworkMap options object.
 */
var NetworkMapControlFullScreen= function(map, options) {
	var fullScreenObject = this;
	
	this._map = map;
	this._map_element = $('#' + this._map._map_el_id);

	// Construct hud
	this._element = $('<div class="map-hud map-fullscreen"><span></span></div>')
	$('#' + this._map._map_el_id).append(this._element);
	this._element.find('span').click(function(){
		fullScreenObject.toggleFullscreen();
		return false;
	});
};

/**
 * @brief Check if map is fullscreen
 */
NetworkMapControlFullScreen.prototype.isFullscreen = function() {
	return this._map_element.hasClass('fullscreen');
};

/**
 * @brief Set fullscreen mode of the map
 */
NetworkMapControlFullScreen.prototype.setFullscreen = function() {
	if (this.isFullscreen())
		return;	// Already fullscreen
	
	var olMap = this._map._olMap;
	this._map_element.addClass('fullscreen');
	olMap.updateSize();
};

/**
 * @brief Restore map to default size
 */
NetworkMapControlFullScreen.prototype.restore = function() {
	if (!this.isFullscreen())
		return;	// It is already restored
	
	var olMap = this._map._olMap;
	this._map_element.removeClass('fullscreen');
	olMap.updateSize();
};

/**
 * @brief Toggle fullscreen mode
 */
NetworkMapControlFullScreen.prototype.toggleFullscreen = function() {
	if (this.isFullscreen())
		this.restore();
	else
		this.setFullscreen();
};