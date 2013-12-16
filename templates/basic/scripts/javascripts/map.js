
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
				'strokeWidth' : 2,
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
				var popup_body = $('<div class="nodePopup" ><span class="title"></span>'
						+ '<ul class="attributes" ></ul>'
						+ '<a>More info</a></div>');
				popup_body.find('.title').text(
						feature.attributes['name'] + ' (#'
								+ String(feature.attributes['id']) + ')');
				popup_body.find('a')
						.attr('href', feature.attributes['url']);
				var ul = popup_body.find('ul');
				$
						.each(
								feature.attributes,
								function(key, value) {
									var li = $('<li><span class="key"></span>: <span class="value"></span></li>');
									li.find('.key').text(key);
									li.find('.value').text(value);
									ul.append(li);
								});

				var popup = new OpenLayers.Popup("chicken",
						new OpenLayers.LonLat(feature.geometry.x,
								feature.geometry.y), new OpenLayers.Size(
								100, 100), popup_body.html(), false);

				popup.autoSize = true;
				popup.panMapIfOutOfView = true;
				feature.attributes['popup'] = popup;
				networkMap._map.addPopup(popup);

			},
			onUnselect : function(feature) {
				networkMap._map.removePopup(feature.attributes['popup']);
			}
		}
	);

	// LAYER : Links
	//-------------------------------------------------------
	this._layer_links = new OpenLayers.Layer.Vector("Links", {
		styleMap : new OpenLayers.StyleMap({
			'default' : new OpenLayers.Style({
				'strokeWidth' : 1.5,
				'strokeColor' : '#000000',
			})
		})
	});
	
	// LAYER : map
	//-------------------------------------------------------
	this._layer_map = new OpenLayers.Layer.OSM();
	
	// Finally connect all components under a map object
	this._map = new OpenLayers.Map({
		div : this._el_id,
		projection : 'EPSG:3857',
		layers : [ this._layer_map, this._layer_links, this._layer_nodes],
		center : center,
		zoom : 10
	});
	this._map.zoomToExtent(bounds);
	
	this._map.addControl(nodesLayerHighlightControl);
	this._map.addControl(nodesLayerSelectControl);
	nodesLayerHighlightControl.activate();
	nodesLayerSelectControl.activate();
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
};

/**
 * @brief Get node filtering
 */
NetworkMap.prototype.getFilter = function() {
	return this._filter;
};

/**
 * @brief Download network topology
 */

NetworkMap.prototype._downloadTopology = function() {
	var networkMap = this;
	
	// Clear map
	this._layer_nodes.removeAllFeatures();
	this._layer_links.removeAllFeatures();
	
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
					'coordinates' : [ [ link['lon1'], link['lat1'] ],
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
