/*
 * WiND - Wireless Nodes Database
 *
 * Copyright (C) 2005-2014 	by WiND Contributors (see AUTHORS.txt)
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Function to submit a form using ajax and collect results.
 * @param form The jquery selector of the form
 * @param success The callback function to be called on success 
 */
async_form = function(form, success){
	var action = form.attr('action');
	var data = form.serialize();
	
	$.post(action, data, success);
};

/**
 * Reload browser without resubmiting data
 */
reload = function() {
	window.location.href = window.location.href; 
};

/**
 * Class to implement the login form of the site
 */
var LoginForm = function(form_url) {
	// The URL of the form
	this._form_url = form_url;
	
	// Flag if form is loaded
	this._loaded = false;
	
	// Dialog element
	this._dialog_el = undefined;
	
	// Notification element
	this._notification_el = undefined;
};

/**
 * @brief Set an error message on form
 */
LoginForm.prototype.error = function(msg){
	if (! this._loaded)
		return;
	
	this._dialog_el.addClass('info');
	this._dialog_el.addClass('error');
	this._notification_el.text(msg);
	this._dialog_el.parent().effect("shake");
};

/**
 * @brief Set an info message on form
 */
LoginForm.prototype.info = function(msg){
	if (! this._loaded)
		return;
	
	this._dialog_el.addClass('info');
	this._dialog_el.removeClass('error');
	this._dialog_el.addClass('notification');
	this._notification_el.text(msg);
};

/**
 * @brief Reset form to initial state
 */
LoginForm.prototype.reset = function(){
	this._dialog_el.removeClass('error');
	this._dialog_el.removeClass('info');
	this._dialog_el.find('input[type=text], input[type=password]').val('');
};

/**
 * @brief Load form from the remote url
 * @param success A callback to call on success
 */
LoginForm.prototype.load = function(success){
	var object = this;
	if (! object._loaded) {
		// Load form and prepare hooks
		$('body').append('<div id="login-dialog"></div>');
		object._dialog_el = $('#login-dialog');
		
		object._dialog_el.load(object._form_url, function(){
			object._notification_el = object._dialog_el.find('.notification');
			object._loaded = true;
			
			// Hook close button
			object._dialog_el.find('.close').click(function() {
				object._dialog_el.dialog("close");
			});
			
			// Hook form submition
			object._dialog_el.find('form').submit(function() {
				object.info('Logging to the system');
				async_form($(this), function(result){
					if (result['success']) {
						reload();
					} else if (result['error']) {
						object.error(result['error']['body']);
					}
				});
				return false;
			});
				
			if (success)
				success();
		});
	} else {
		if (success)
			success();
	}
	
};

/**
 * @brief Show the form to the user 
 */
LoginForm.prototype.show = function(){
	var object = this;
	object.load(function(){
		object.reset();
		
		object._dialog_el.dialog({
			modal: true,
			resizable: false,
			dialogClass: 'login-dialog no-title-dialog'
		});
	});
};


/**
 * @brief Location Picker using NetworkMap
 * @param lat_element DOM element of latitude input
 * @param lng_element DOM element of longitude input
 */
LocationPicker = function(lat_element, lng_element) {
	var locationPickerObject = this;
	
	// Private variables
	this._lat_element = lat_element;
	this._lng_element = lng_element;
	
	// Extract initial values
	var position = null;
	if (this._lat_element.val() && this._lng_element.val()) {
		position = [
	                parseFloat(this._lat_element.val()),
	                parseFloat(this._lng_element.val())];
	}
	
	// Construct map
	this.map_element = $('<div class="map-picker-dialog">'
			+'<div id="location-picker" class="map picker"/></div>');
	$('body').append(this.map_element);
	
	this.map = new NetworkMap('location-picker', {
		'bound_ne' : map_options['bound_ne'],
		'bound_sw' : map_options['bound_sw'],
	});
	this.controlPicker = new NetworkMapControlPicker(this.map, {
		position: position,
		ok: function(picker) {
			var pos = picker.getPosition();
			locationPickerObject._lat_element.val(pos.lat);
			locationPickerObject._lng_element.val(pos.lon);
			locationPickerObject.destroy();
		},
		cancel: function() {
			console.log('canceled');
			locationPickerObject.destroy();
		}
	});
	this.controlFullScreen = new NetworkMapControlFullScreen(this.map);
	
	// Show dialog
	this.map_element.dialog({
		modal: true,
		movable: false,
		resizable: false,
		width: 'auto',
		height: 'auto',
		closeOnEscape: false,
		dialogClass: 'picker-dialog no-title-dialog'
	});
};

LocationPicker.prototype.destroy = function() {
	this.map.destroy();
	this.map_element.remove();
	
	delete this._lat_element;
	delete this._lng_element;
};

/**
 * @brief A table data filter mechanism
 * @param title The title of the search form
 * @param filter_element A string or DOM element of the filter form
 * @param table_element A string or DOM element of the data table
 * @returns {TableFilter}
 */
TableFilter = function(title, filter_element, table_element) {
	var TableFilterObject = this;
	
	// Accept dom element and selectors
	if (typeof(filter_element) == 'string')
		filter_element = $(filter_element);
	if (typeof(table_element) == 'string')
		table_element = $(table_element);
	
	// Private variables
	this.filter_element = filter_element;
	this.raw_table_element = table_element;
	this.title = title;
	
	this.filter_element.hide();
	
	// Add table wrapper and buttons
	this.table_element = this.raw_table_element.wrap('<div class="table-data-filter-wrapper" />').parent();
	this.table_element.prepend('<div class="table-data-filter-toolbar" />');
	this.table_element.find('.table-data-filter-toolbar').append(
		$('<button type="button" class="btn btn-default btn-sm search"/>')
			.text('Filter')
			.prepend('<span class="glyphicon glyphicon-filter"></span>')
			
	);
	
	// Create filter overview
	this._constructFilterOverview(this.table_element.find('.table-data-filter-toolbar'));
	// Add callbacks
	this.table_element.find('button.search').click(function(){
		TableFilterObject.filter_element.dialog({
			modal: true,
			resizable: false,
			height: 'auto',
			width: 'auto',
			title: title
		});
	});
};

TableFilter.prototype._constructFilterOverview = function(toolbar) {
	
	// Scan form values
	var enabled_filters = [];
	this.filter_element.find('.form-entry').each(function(index, entry){
		e = $(entry);
		var label = e.find('label').text();
		var val = '';
		if (e.find('input').length) {
			val = e.find('input').val();
			if (val && (e.find('select').length)) {
				map_comparison = {equal : '=', greater : '>', less : '<', greater_equal : '>=', less_equal : '<='};
				val = map_comparison[e.find('select').val()] + val;
			}
		} else {
			if (e.find('select option:selected').val())
				val = e.find('select option:selected').text();
		} 

		if (val) {
			enabled_filters.push({label:label, value:val});
		}
		
	});
	
	// Create title bar
	var list = $('<ul class="enabled-filters list-unstyled list-inline"/>');
	$.each(enabled_filters, function(index, obj){
		var entry = $('<li/>').append(
				$('<span class="name">').text(obj.label),
				$('<span class="value code">').text(obj.value)
		);
		list.append(entry);
	});
	
	toolbar.prepend(list);
};