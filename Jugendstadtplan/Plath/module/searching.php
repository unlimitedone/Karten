<?php
/**
 * Author: Immanuel
 * Date: 14.12.14
 * Time: 20:25
 * To change this template use File | Settings | File Templates.
 */

// include section
//=========================
include_once "../config/config.php";
include_once "helper.php";
require_once "../vendor/autoload.php";

// output settings
//=========================
ini_set('default_charset', 'utf-8');

// Function
// function search a location by provided uri
// param: search uri for resource
// param: language example "de" or "en" ...
// return: html contains all categories
function searchByUri($search, $lang)
{
	// set rdf namespace
    EasyRdf_Namespace::set('ldo', 'http://leipzig-data.de/Data/Ort/');
    EasyRdf_Namespace::set('ldp', 'http://leipzig-data.de/Data/Person/');
    EasyRdf_Namespace::set('ldtag', 'http://leipzig-data.de/Data/Tag/');
    EasyRdf_Namespace::set('ld', 'http://leipzig-data.de/Data/Model/');
    EasyRdf_Namespace::set('owl', 'http://www.w3.org/2002/07/owl#');
    EasyRdf_Namespace::set('sysont', 'http://ns.ontowiki.net/SysOnt/');
    EasyRdf_Namespace::set('xsd', 'http://www.w3.org/2001/XMLSchema#');
    EasyRdf_Namespace::set('jsp1', 'http://localhost/jsp/');
    EasyRdf_Namespace::set('jsp', 'http://leipzig-data.de/Data/Jugendstadtplan/');
    EasyRdf_Namespace::set('geo', 'http://www.w3.org/2003/01/geo/wgs84_pos#');
	
	// search results 
	$searchResults = array();
	// count search results
	$CountSearchResults = 0;
	// url to rdf data
    $docuri = "http://leipzig-data.de/Jugendstadtplan/Emanuel/Data/unsere_data_1.json";
	// load rdf graph
    $graph = EasyRdf_Graph::newAndLoad($docuri);
	// validate requested language
	$lang = validateLanguage($lang);
	// start search in graph
    foreach ($graph->allOfType('jsp:Ort') as $strKey) {
        if (preg_match('/'.$search.'/i', $strKey->label())) {

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
    return $searchResults;

}

?>