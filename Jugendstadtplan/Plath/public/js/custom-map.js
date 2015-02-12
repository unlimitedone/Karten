/*!
 * Author: Immanuel Plath
 * Copyright 2014 Jugendstadtplan Leipzig
 * map functions
 */

	// set up the map and set start coordinates
	var map = L.map('map').setView([51.3400, 12.3800], 13);

	// get to map data from map-data provider (Mapbox)
	// old v3 api access way
	//L.tileLayer('http://{s}.tiles.mapbox.com/v3/unlimitedone.k3inkm7m/{z}/{x}/{y}.png', {
	// use new api v4 to access map data
	L.tileLayer('http://api.tiles.mapbox.com/v4/unlimitedone.k3inkm7m/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoidW5saW1pdGVkb25lIiwiYSI6ImNBRlZXSHcifQ.abiM9uDEj2zyQC6nFFsC3w', {
		attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
		maxZoom: 18
	}).addTo(map);

	/* global variables */

    var map;
    var JSONFile = "data/jugendstadtplan.json";
    var lang = "de";

	// Data processing done down here

    // strings for JSON keys
    var rdfType = "http://www.w3.org/1999/02/22-rdf-syntax-ns#type";
    var rdfLabel = "http://www.w3.org/2000/01/rdf-schema#label";
    var owlSameAs = "http://www.w3.org/2002/07/owl#sameAs";
    var hasAddress = "http://leipzig-data.de/Data/Jugendstadtplan/hasAddress";
    var geoLat = "http://www.w3.org/2003/01/geo/wgs84_pos#lat";
    var geoLong = "http://www.w3.org/2003/01/geo/wgs84_pos#long";
    var category = "http://leipzig-data.de/Data/Jugendstadtplan/hascategory";
    var hasURL = "http://leipzig-data.de/Data/Model/hasURL";

    var jsp_URI = new Array();
    var testcounter = 0;
	// var contains all global marker (locations)
    var allmarker = new Array();
	
	// look up for all locations and display them on map
	//==========================================
	function allLocations(removeMarkers) {
		if(removeMarkers)
		{
			removeAllMarkers();
		}
		$.ajax({
			type: 'GET',
			url: JSONFile,
			dataType: 'json',
			success: function (data) {
				$.each(data, function (key) {
					jsp_URI.push(key);
				});

				for (var i in data) {
					var jsp_uri = jsp_URI[testcounter];

					// if this is jsp:Ort
					if (typeof (data[i][rdfType]) == "undefined") console.log("rdfTypenot set");
					else {
						if (data[i][rdfType][0].value == "http://leipzig-data.de/Data/Jugendstadtplan/Ort") {

							if (data[i][hasAddress] != null) {
								//if jsp:Ort has an address minimum requirements are fullfilled, let's mark the place
								var address = data[i][hasAddress][0].value;
								//Geo-Coordinates:
								if (typeof (data[address]) == "undefined") console.log(jsp_URI[testcounter] + " Adress Ressource non-exisent :" + address);
								else {

									if (typeof (data[address][geoLat]) == "undefined") console.log(jsp_URI[testcounter] + " Adress Ressource without GEODATA :" + address);
									else {
										//if geocordinates existing -> we are happy using them
										var lat = parseFloat(data[address][geoLat][0].value);
										var lng = parseFloat(data[address][geoLong][0].value);

										if (typeof lat != "undefined") {
											// Label
											if (typeof (data[i][rdfLabel]) == "undefined") console.log(jsp_URI[testcounter] + "RDF Label non-existent");
											else {
												var label = data[i][rdfLabel][0].value;
												// AB HIER ENTSTEHT DER OUTPUT
												//TODO: Doppeltagging beachten!!
												var LamMarker = L.marker([lat, lng]).addTo(map).bindPopup('<b>' + label + '</b><br/><a href="#" onclick="contentloader(\'' + jsp_uri + '\',\'' + lang + '\');">Informationen anzeigen</a>.');
												map.addLayer(LamMarker);
												allmarker.push(LamMarker);

											}
										}
									}
								}
							}
						}
					}
					testcounter = testcounter + 1;
				}
			},
			data: {},
			async: false
		}); 
	}
	
	// init map with all avaiable locations
	allLocations(false);
	
	$(document).ready(function() {
		$(window).keydown(function(event){
			if(event.keyCode == 13) {
				event.preventDefault();
				searchRequest(document.getElementById("searchfield").value);
				return false;
			}
		});
	});