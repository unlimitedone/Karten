/*!
 * Author: Immanuel Plath
 * Copyright 2014 Jugendstadtplan Leipzig
 * Description: this file contains all helper functions
 */
 
// contentloader loads the content asynchronously into the divs of the details box 
//==================================================================================
function contentloader(uri, lang) {
    $("#label").load("details?lang=" + lang + "&uri=" + uri + " #heading");
    $("#properties").load("details.php?lang=" + lang + "&uri=" + uri + " #eigenschaften");
    $("#contact").load("details.php?lang=" + lang + "&uri=" + uri + " #address");
    $("#opening").load("details.php?lang=" + lang + "&uri=" + uri + " #openinghours");
	$("#description").load("details.php?lang=" + lang + "&uri=" + uri + " #description");
}

// send search request to webseerver and display response
//=======================================================
function searchRequest(searchKey) {
	var requestStart = Date.now();
	$.ajax({
		url: "search.php?search=" + searchKey,
		type: "post",
		datatype: 'json',
		success: function(data){
			if(data.length == 0) {
				$('#searchResponse').html('<strong>Sorry!</strong> for your keyword: <strong>"' + searchKey + '"</strong> we found <strong>0</strong> search results!');
				$("#searchResponse").removeClass('alert-success');
				$("#searchResponse").addClass('alert-warning');
				$("#searchResponse").slideDown('slow').delay(4000).slideUp('slow');
			} else {
				$('#searchResponse').html('<strong>Success!</strong> for your keyword: <strong>"' + searchKey + '"</strong> we found <strong>' + data.length + '</strong> search results! It took ' + (Date.now() - requestStart) + ' ms!');
				$("#searchResponse").removeClass('alert-warning hide');
				$("#searchResponse").addClass('alert-success');
				$("#searchResponse").slideDown('slow').delay(4000).slideUp('slow');
			}
			// remove all markers from map
			removeAllMarkers();
			// set search results on map
			$.each(data, function (key, json) {
				addLocation(json.uri, json.locationName, json.latitude , json.longitude, json.language);
			})
		}  
    }); 
}

// send search request to webseerver and display response
//=======================================================
function getGroupLocations(group) {
	var requestStart = Date.now();
	var language = getUserLanguage();
	//var language = "de";
	$.ajax({
		url: "group.php?group=" + group + "&lang=" + language,
		type: "post",
		datatype: 'json',
		success: function(data){
			if(data.length == 0) {
				$('#searchResponse').html('<strong>Sorry!</strong> for your selected group: <strong>"' + group + '"</strong> we found <strong>0</strong> search results!');
				$("#searchResponse").removeClass('alert-success');
				$("#searchResponse").addClass('alert-warning');
				$("#searchResponse").slideDown('slow').delay(4000).slideUp('slow');
			} else {
				$('#searchResponse').html('<strong>Success!</strong> for your selected group: <strong>"' + group + '"</strong> we found <strong>' + data.length + '</strong> search results! It took ' + (Date.now() - requestStart) + ' ms!');
				$("#searchResponse").removeClass('alert-warning hide');
				$("#searchResponse").addClass('alert-success');
				$("#searchResponse").slideDown('slow').delay(4000).slideUp('slow');
			}
			// remove all markers from map
			removeAllMarkers();
			// set search results on map
			$.each(data, function (key, json) {
				addLocation(json.uri, json.locationName, json.latitude , json.longitude, json.language);
			})
		}  
    }); 
}

// watch if search button is pressed by user
//==========================================
$('.startSearch').click(function() {
	searchRequest(document.getElementById("searchfield").value);
});

// add location to map
//==========================================
function addLocation(jsp_uri, label, lat, lng, lang) {
	var LamMarker = L.marker([lat, lng]).addTo(map).bindPopup('<b>' + label + '</b><br/><a href="#" onclick="contentloader(\'' + jsp_uri + '\',\'' + lang + '\');">Informationen anzeigen</a>.');
	map.addLayer(LamMarker);
	allmarker.push(LamMarker);
}

// get user language
//==========================================
function getUserLanguage() {
	// get user language from inline html
	//var language = document.getElementById("languageStore").innerHTML;
	// or get user language via url param "lang"
	var language = getParamFromURL("lang");
	// fallback to default language if no param is found
	if(language == false){
		language = "de";
	}
	console.log(language);
	return language;
}

// remove all markers from map
//==========================================
function removeAllMarkers() {
	for (i = 0; i < allmarker.length; i++) {
        map.removeLayer(allmarker[i]);
    }
}

// set location focus in map
//==========================================
function setFocusToMarker(uri) {
    //Map zentrieren an gewünschter Stelle
    map.panTo([allmarker[uri][1], allmarker[uri][2]]);
    //PopUp öffnen
    allmarker[uri][0].openPopup();
}

// get params from URL
//==========================================
function getParamFromURL(param)
{
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        if(pair[0] == param){return pair[1];}
    }
    return(false);
}