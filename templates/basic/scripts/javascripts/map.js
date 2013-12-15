
/**
 * Load wind map on element
 */
var load_map = function(map_id, _nodes_url) {

	var nodes_url = _nodes_url + '&show_p2p=1&show_aps=1&show_clients=1&show_unlinked=1&show_links_p2p=1&show_links_client=1&show_links_ap=1';
    var center = new OpenLayers.LonLat(25.1405, 35.2826)
    	.transform('EPSG:4326', 'EPSG:3857');
    
    // Finally we create the map
    map = new OpenLayers.Map({
        div: map_id, projection: 'EPSG:3857',
        layers: [new OpenLayers.Layer.OSM()],
    	center: center,
		zoom: 15
    });
    
    
    // Try to load nodes
    $.get(nodes_url, function(network){

        
        // Map nodes to features
        var node_features = $.map(network.nodes, function(node, node_id) {
        	var colors_per_type = {
        		'client' : '#0000ff',
        		'p2p' : '#00ff00',
        		'ap' : '#00ff00',
        		'p2p-ap': '#00ff00',
        		'unlinked' : '#ff0000',
        	};
        	var properties = jQuery.extend({}, node);
        	properties['color'] = colors_per_type[properties['type']];
        	
        	return {
        		'type': "Feature",
        		'id' : node['id'],
            	'geometry': {
            		'type': 'Point',
            		'coordinates': [node['lon'], node['lat']]
            	},
            	'properties': properties,
        	};
        });
        
        // Map links to features
        var link_features = $.map(network.links, function(link, link_id) {
        	return {
        		'type': "Feature",
//        		'id' : link['id'],
        		'geometry': {
        			'type': 'LineString',
            		'coordinates': [ [link['lon1'], link['lat1']],
            		                 [link['lon2'], link['lat2']] ]  
            	},
            	'properties': {
            		'status' : link['status'],
            		'type' : link['type']
            	}
        	};
        });
        
        var nodesGeo = {
                "type": "FeatureCollection", 
                "features": node_features
        };
        
        var linksGeo = {
                "type": "FeatureCollection", 
                "features": link_features
         };
        
		// Load geojson
		var geojson_format = new OpenLayers.Format.GeoJSON({
			'internalProjection': "EPSG:900913",
			'externalProjection': "EPSG:4326"
		});
		//console.log(geojson_format.read(nodesGeo));

         var nodes_layer = new OpenLayers.Layer.Vector("Nodes", {
             //strategies: [new OpenLayers.Strategy.Cluster()],
             styleMap: new OpenLayers.StyleMap({
             	'default' : new OpenLayers.Style({
        			'pointRadius' : 5,
        			'strokeWidth' : 1,
        			'strokeColor' : '#000000',
        			'fillColor' : '${color}',
            	}),
            	'hover' : new OpenLayers.Style({
            		label: '${name}',
            		labelYOffset: -13,
                    labelOutlineColor: "white",
                    labelOutlineWidth: 4
            	}),
            	'select' : new OpenLayers.Style({
            		'strokeWidth' : 2,
            		'pointRadius' : 7,
            	})
    		})
         }); 
         map.addLayer(nodes_layer);
         nodes_layer.addFeatures(geojson_format.read(nodesGeo));
         
         var links_layer = new OpenLayers.Layer.Vector("Links", {
             //strategies: [new OpenLayers.Strategy.Cluster()],
             styleMap: new OpenLayers.StyleMap({
             	'default' : new OpenLayers.Style({
        			'strokeWidth' : 2.5,
        			'strokeColor' : '#000000',
            	})
    		})
         }); 
         map.addLayer(links_layer);
         links_layer.addFeatures(geojson_format.read(linksGeo));
         
         highlightControl = new OpenLayers.Control.SelectFeature(nodes_layer, {
        	 hover: true,
        	 highlightOnly: true,
        	 renderIntent: "hover"
         });
         
         // Selection
         selectControl = new OpenLayers.Control.SelectFeature(nodes_layer, {
             onSelect: function(feature) {
            	 //console.log(feature);
            	 var popup_body = $('<div class="nodePopup" ><span class="title"></span>' +
            			 '<ul class="attributes" ></ul>' +
            			 '<a>More info</a></div>');
            	 popup_body.find('.title').text(feature.attributes['name'] +
            			 ' (#' + String(feature.attributes['id']) + ')');
            	 popup_body.find('a').attr('href', feature.attributes['url']);
            	 var ul = popup_body.find('ul');
            	 $.each(feature.attributes, function(key, value){
            		var li = $('<li><span class="key"></span>: <span class="value"></span></li>');
            		li.find('.key').text(key);
            	 	li.find('.value').text(value);
            		ul.append(li);
            	 });
            	 
            	 var popup = new OpenLayers.Popup("chicken",
                        new OpenLayers.LonLat(feature.geometry.x, feature.geometry.y),
                        new OpenLayers.Size(100,100),
                        popup_body.html(),
                        false);
            	 
            	 popup.autoSize = true;
            	 popup.panMapIfOutOfView = true;
            	 feature.attributes['popup'] = popup;
            	 map.addPopup(popup);
            	 
             },
             onUnselect: function(feature) {
            	 map.removePopup(feature.attributes['popup']);
             }
         });
         map.addControl(highlightControl);
         map.addControl(selectControl);
         highlightControl.activate();
         selectControl.activate();
             
    })
    

};
