/*!
 * Author: Immanuel Plath
 * Copyright 2014 Jugendstadtplan Leipzig
 * map functions
 */

// set up the map and set start coordinates
var map = L.map('map').setView([51.3400, 12.3800], 13);

// get to map data from map-data prvider (Mapbox)
L.tileLayer('http://{s}.tiles.mapbox.com/v3/unlimitedone.k3inkm7m/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
    maxZoom: 18
}).addTo(map);

/* global variables */

    var marker_brain = new Array(); // Internal storage array for the observation which cathegory is choosen and which isn't
    var map;
    var JSONFile = "data/unsere_data_1.json";
    var glat;
    var glong;
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
    var allmarker = new Array();
    allmarker['all']  = new Array();
    var allmarker2 = new Array();
    var count_coordinaten_gesaugt = 0;
    var log_probs = new Array();
    var cathegories = new Array();
    cathegories.push('all');
    var marker_uris = new Array();
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
                                        //fetching the rest of the Data
                                        // URI, die die ID für das Array mit allen markern wird
                                        // for the cathegory Filter
                                        //gleich noch ne schleife hier einfügen


                                        // Label
                                        if (typeof (data[i][rdfLabel]) == "undefined") console.log(jsp_URI[testcounter] + "RDF Label non-existent");
                                        else {
                                            var label = data[i][rdfLabel][0].value;


                                            // AB HIER ENTSTEHT DER OUTPUT

                                            //TODO: Doppeltagging beachten!!

                                            if (type == "Museum") { // Hier später highlight der mintorte
                                                var LamMarker = L.marker([lat, lng], {icon: redMarker}).addTo(map)
                                                    .bindPopup('<b>' + label + '</b><br/><a href="#" onclick="contentloader(\'' + jsp_uri + '\',\'' + lang + '\');">Informationen anzeigen</a>.');
                                                allmarker2[jsp_uri] = new Array();

                                            }
                                            else {
                                                var LamMarker = L.marker([lat, lng]).addTo(map)
                                                    .bindPopup('<b>' + label + '</b><br/><a href="#" onclick="contentloader(\'' + jsp_uri + '\',\'' + lang + '\');">Informationen anzeigen</a>.');
                                                allmarker2[jsp_uri] = new Array();

                                            }
                                            marker_uris.push(jsp_uri);
                                            allmarker2[jsp_uri].push(LamMarker);
                                            allmarker2[jsp_uri].push(lat);
                                            allmarker2[jsp_uri].push(lng);
                                            map.addLayer(allmarker2[jsp_uri][0]);
                                            /*Hier wird das letzt hinzugefügte Array ausgegeben */

                                            //Filter ab hier

                                            //TODO: cathegory allgemein wenn keiner gesetzt
                                            if (typeof data[i][category] == "undefined") {
                                                console.log(jsp_URI[testcounter] + " jsp:hascategory non-existent");
                                                var type="NA"; // Variable for all the ones without a category
                                            }
                                            else {

                                                var type = data[i][category][0].value.replace("http://leipzig-data.de/Data/Jugendstadtplan/", ""); // hier nacher noch schleife um mehrere arts abzudecken
                                            }
                                                //Filtern nach Type
                                                if (typeof allmarker[type] == 'undefined') {
                                                    cathegories.push(type);
                                                    allmarker[type] = new Array();
                                                    //set the marker brain as active
                                                    marker_brain[type] = 1;
                                                }

                                                var pushtest1 = allmarker[type].push(jsp_uri);
                                                // In Kategorie alle packen
                                                allmarker['all'].push(jsp_uri);
                                            //Filter nach irgendwas anderes


                                            count_coordinaten_gesaugt = count_coordinaten_gesaugt + 1;
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