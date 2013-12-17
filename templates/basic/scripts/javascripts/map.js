
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
	this._el_id = el_id;
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
 * @brief Construct the map
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
				networkMap._map.addPopup(popup);

			},
			onUnselect : function(feature) {
				if (networkMap._node_popup)
					networkMap._map.removePopup(networkMap._node_popup);
				networkMap._node_popup = null;
			}
		}
	);

	// LAYER : Links
	//-------------------------------------------------------
	this._layer_links = new OpenLayers.Layer.Vector("Links", {
		styleMap : new OpenLayers.StyleMap({
			'default' : new OpenLayers.Style({
				'strokeWidth' : 1,
				'strokeColor' : '#000000',
			}),
		})
	});
	
	// LAYER : map
	//-------------------------------------------------------
	this._layer_osm = new OpenLayers.Layer.OSM("OpenStreetMaps");
	this._layer_gmap = new OpenLayers.Layer.Google("Google Terain", {type: google.maps.MapTypeId.SATELLITE, visibility: false});
	
	// Finally connect all components under a map object
	this._map = new OpenLayers.Map({
		div : this._el_id,
		projection : 'EPSG:3857',
		layers : [ this._layer_osm, this._layer_gmap, this._layer_links, this._layer_nodes],
		center : center,
		zoom : 10,
		zoomDuration: 10
	});
	this._map.zoomToExtent(bounds);
	
	this._map.addControl(nodesLayerHighlightControl);
	this._map.addControl(nodesLayerSelectControl);
	this._map.addControl(new OpenLayers.Control.LayerSwitcher());
	nodesLayerHighlightControl.activate();
	nodesLayerSelectControl.activate();
};

/**
 * @brief Download network topology
 */
NetworkMap.prototype._downloadTopology = function() {
	var networkMap = this;
	
	// Clear map
	this._layer_nodes.removeAllFeatures();
	this._layer_links.removeAllFeatures();
	if (networkMap._node_popup){
		networkMap._map.removePopup(this._node_popup);
		networkMap._node_popup = null;
	}
	
	// Try to load nodes
	$.get(this._topologyUrl(), function(topology) {
		var GeoJSONParser = new OpenLayers.Format.GeoJSON({
			'internalProjection' : "EPSG:900913",
			'externalProjection' : "EPSG:4326"
		});

		// Convert nodes to GeoJSON
		var nodeFeatures = $.map(topology.nodes, function(node, node_id) {

			// Color mapping for nodes
			var colors_per_type = {
				'client' : '#0000ff',
				'p2p' : '#00ff00',
				'ap' : '#00ff00',
				'p2p-ap' : '#00ff00',
				'unlinked' : '#ff0000',
			};

			// GeoJSON inherits all properties + extra
			var properties = jQuery.extend({}, node);
			properties['color'] = colors_per_type[properties['type']];

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
			return {
				'type' : "Feature",
				'id' : link['id'],
				'geometry' : {
					'type' : 'LineString',
					'coordinates' : [
					        [ link['lon1'], link['lat1'] ],
							[ link['lon2'], link['lat2'] ] ]
				},
				'properties' : {
					'status' : link['status'],
					'type' : link['type']
				}
			};
		});
		var linksGeoJSON = {
			"type" : "FeatureCollection",
			"features" : linkFeatures
		};

		// Load features on map
		networkMap._layer_nodes.addFeatures(GeoJSONParser.read(nodesGeoJSON));
		networkMap._layer_links.addFeatures(GeoJSONParser.read(linksGeoJSON));

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
	
	this._downloadTopology();	// Redownload map
};

/**
 * @brief Get node filtering
 */
NetworkMap.prototype.getFilter = function() {
	return this._filter;
};


/**
 * @brief HUD implementation to control map filter.
 * @param map The NetworkMap object to render and control filter.
 * @param options The NetworkMap options object.
 */
var NetworkMapUiNodeFilter = function(map, options) {
	var nodeFilterObject = this;
	
	this._map = map;
	this._valid_filters = ['p2p','ap', 'client', 'unlinked'];

	// Construct hud
	this._element = $('<div class="map-hud map-filter"><ul/></ul></div>');
	$.each(this._valid_filters, function(key, value){
		nodeFilterObject._element.find('ul').append($('<li />').addClass(value).text(value));
	});
	$('#' + this._map._el_id).append(this._element);
	
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
NetworkMapUiNodeFilter.prototype._loadState = function() {
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
NetworkMapUiNodeFilter.prototype._saveState = function() {
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