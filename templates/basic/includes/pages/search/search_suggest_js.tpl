{*
 * WiND - Wireless Nodes Database
 * Basic HTML Template
 *
 * Copyright (C) 2006 John Kolovos <cirrus@awmn.net>
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
var req = null;
var hov = -1;
var origval = null;


function loadXMLDoc(input) {

	if(input == "") {
		document.getElementById('searchResult').style.display = 'none';
	} else {
		origval = input;
		url = "{/literal}{$suggest_url}{literal}&q=" + input;
		// Internet Explorer
		try { req = new ActiveXObject("Msxml2.XMLHTTP"); }
		catch(e) {
			try { req = new ActiveXObject("Microsoft.XMLHTTP"); }
			catch(oc) { req = null; }
		}
		// Mozailla/Safari
		if (req == null && typeof XMLHttpRequest != "undefined") {
			req = new XMLHttpRequest();
		}
		// Call the processChange() function when the page has loaded
		if (req != null) {
			req.onreadystatechange = processChange;
			req.open("GET", url, true);
			req.send(null);
		}
	}
}

function processChange(evt) {
	// The page has loaded and the HTTP status code is 200 OK
	if (req.readyState == 4) {
		if (req.status == 200) {
			document.getElementById('searchResult').style.display = 'block';
			// Write the contents of this URL to the searchResult layer
			if (origval == null) {
				document.getElementById('searchResult').style.display = 'none';
			}
			else
				getObject("searchResult").innerHTML = req.responseText;
		}
	}
}

function getObject(name) {
	var ns4 = (document.layers) ? true : false;
	var w3c = (document.getElementById) ? true : false;
	var ie4 = (document.all) ? true : false;

	if (ns4) return eval('document.' + name);
	if (w3c) return document.getElementById(name);
	if (ie4) return eval('document.all.' + name);
	return false;
}

function hideSearch() {
	document.getElementById('searchResult').style.display = 'none';
}

function hover(ev,val) {
	test = document.getElementById('searchResult').getElementsByTagName('tr');
	if(document.getElementById('q').value == "") origval = null;
	if(ev == 38 && hov != -1){
		if(document.getElementById('searchResult').style.display == 'none')
			document.getElementById('searchResult').style.display = 'block';
		hov--;
		if(hov<0) {
			document.getElementById('q').value = origval;
			document.getElementById('q').select();
		}
		for (var i=0; i<test.length; i++) {
			if(i==hov) {
				test2 = test[i].getElementsByTagName('td');
				document.getElementById('q').value = test2[0].innerHTML +' '+ test2[1].innerHTML;
				test[i].style.background='orange';
			} else {
				test[i].style.background='white';
			}
		}
		document.getElementById('q').select();
	}
	else if(ev == 40) {
		if(document.getElementById('searchResult').style.display == 'none')
			document.getElementById('searchResult').style.display = 'block';
		hov++;
		if(hov==test.length) hov=test.length-1;
		for (var i=0; i<test.length; i++) {

			if(i==hov) {
				test2 = test[i].getElementsByTagName('td');
				document.getElementById('q').value = test2[0].innerHTML +' '+ test2[1].innerHTML;
				test[i].style.background='orange';
			} else {
				test[i].style.background='white';
			}
		}
		document.getElementById('q').select();
	}
	else if(ev == 13 && hov != -1) {
		document.getElementById('searchResult').style.display = 'none';
	}
	else if(ev == 27) {
		document.getElementById('searchResult').style.display = 'none';
		document.getElementById('q').select();
	}
	else if(ev == "mouse") {
		for (var i=0; i<test.length; i++) {
			test[i].style.background='white';
		}
		val.style.background='orange';
	}
	else {
		loadXMLDoc(val);
		hov=-1;
	}
}

{/literal}	
