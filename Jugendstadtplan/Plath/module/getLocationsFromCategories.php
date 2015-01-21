<?php
/**
 * Author: Immanuel
 * Date: 26.12.14
 * Time: 12:27
 * To change this template use File | Settings | File Templates.
 */

// include section
//=========================
include_once "../config/config.php";
include_once "helper.php";
require_once "../vendor/autoload.php";
require_once "graphLoader.php";

// output settings
//=========================
ini_set('default_charset', 'utf-8');

// Function
// function returns all locations for a specific location
// param: category: select your category for example "Nachtleben"
// param: language example "de" or "en" ...
// return: html contains all categories
function getLocationsByCategory($category, $lang)
{
	// array cotain all fornd locations
	$searchResults = array();
	// count search results
	$CountSearchResults = 0;
    // load full graph
	$rdfGraph = new RdfGraph(array("../data/rdf/jugendstadtplan.json"));
	$graph = $rdfGraph->getGraph();
	// validate requested language
	$lang = validateLanguage($lang);
	// start search in graph for category
    foreach ($graph->allOfType('jsp:Ort') as $strKey) {
		if ($strKey->hasProperty('jsp:hascategory') == 1) {
			if($category != "nocategory")
			{
				$foundCategory = false;
				// check if location has category we search for
				foreach ($strKey->all('jsp:hascategory') as $art) {
					$res2        = $graph->resource($art);
					$labelres2   = $res2->label($lang);
					if (preg_match('/'.$category.'/i', $labelres2)) {
						$foundCategory = true;
						break; 
					}
				}
				if($foundCategory){
					// get Adress and lookup for coordinates
					$address = $strKey->get('jsp:hasAddress');
					$res = $graph->resource($address);
					// get coordinates
					$latitude = $res->get('geo:lat');
					$longitude = $res->get('geo:long');

					// check if location has coordinates
					if (strlen($latitude) > 0 AND strlen($longitude) > 0) {
						$location["uri"] = str_replace('http://localhost/jsp/', 'http://leipzig-data.de/Data/Jugendstadtplan/', $strKey);
						$location["latitude"] = (string) $latitude;
						$location["longitude"] = (string) $longitude;
						$location["language"] = $lang;
						$location["locationName"] = (string)$strKey->label();
						$searchResults[] = $location;
						$CountSearchResults++;
					}
					unset($location);
				}
			}
		} else {
			if($category == "nocategory")
			{
				// get Adress and lookup for coordinates
				$address = $strKey->get('jsp:hasAddress');
				$res = $graph->resource($address);
				// get coordinates
				$latitude = $res->get('geo:lat');
				$longitude = $res->get('geo:long');

				// check if location has coordinates
				if (strlen($latitude) > 0 AND strlen($longitude) > 0) {
					$location["uri"] = str_replace('http://localhost/jsp/', 'http://leipzig-data.de/Data/Jugendstadtplan/', $strKey);
					$location["latitude"] = (string) $latitude;
					$location["longitude"] = (string) $longitude;
					$location["language"] = $lang;
					$location["locationName"] = (string)$strKey->label();
					$searchResults[] = $location;
					$CountSearchResults++;
				}
				unset($location);
			}
		}
    }
    return $searchResults;

}

?>