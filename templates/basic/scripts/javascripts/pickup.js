	function pickup(list, text, value, mywindow) {
		if (list.multiple) {
			for(x=0; x<(list.length); x++){
				if (list.options[x].value == value) return;
			}
			var opt = new Option(text, value)
			list.options[list.options.length] = opt
			for(x=0; x<(list.length); x++){
				list.options[x].selected = "true"
			}
		} else {
			list.value = value
			l = document.getElementsByName(list.name + '_output')
			l[0].value = text
			mywindow.close()
		}
	}
	
	function remove_selected(list) {
		for(x=0; x<(list.length); x++){
			if (list.options[x].selected == true) {
				list.options[x] = null
				x--
			}
		}
		for(x=0; x<(list.length); x++){
			list.options[x].selected = "true"
		}
	}

	function pickup_value(object, value) {
		object.value = value
	}