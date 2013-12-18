

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
}

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
			console.log(object._dialog_el.find('form'));
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
			dialogClass: 'login-dialog'
		});
	});
};
