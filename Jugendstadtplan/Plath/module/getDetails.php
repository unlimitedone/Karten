<?php
/**
 * User: Immanuel Plath
 * Date: 05.12.14
 */

// include section
//=========================
include_once "../config/config.php";
include_once "translate.php";
require_once "../vendor/autoload.php";

// ouput settings
//=========================
ini_set('default_charset', 'utf-8');

// Function
// function return for a provided uri all location details
// param: uri from a location
// param: language example "de" or "en" ...
// return: a valid existing language
//=========================
function getLocationDetails($uri, $language)
{
    // Set RDF namespaces
	EasyRdf_Namespace::set('ldo', 'http://leipzig-data.de/Data/Ort/');
    EasyRdf_Namespace::set('ldp', 'http://leipzig-data.de/Data/Person/');
    EasyRdf_Namespace::set('ldtag', 'http://leipzig-data.de/Data/Tag/');
    EasyRdf_Namespace::set('ld', 'http://leipzig-data.de/Data/Model/');
    EasyRdf_Namespace::set('sysont', 'http://ns.ontowiki.net/SysOnt/');
    EasyRdf_Namespace::set('xsd', 'http://www.w3.org/2001/XMLSchema#');
    EasyRdf_Namespace::set('jsp1', 'http://localhost/jsp/');
    EasyRdf_Namespace::set('jsp', 'http://leipzig-data.de/Data/Jugendstadtplan/');
    
	// path to full rdf file
    $docuri = "http://leipzig-data.de/Jugendstadtplan/Emanuel/Data/unsere_data_1.json";
    // load full graph
	$graph = EasyRdf_Graph::newAndLoad($docuri);
    // requested uri path
	$requested_res = $uri;
	// load language data
    $lang = getTranslation($language);
	// contain html returned to client
	$answer = "";
	//load ressource by requested uri
    $requested_res_data = $graph->resource($requested_res); 
    
    // build html answer
    $answer.= "<div id='eigenschaften'><table>";
    foreach ($requested_res_data->properties() as $bezeichner) {
        if (($bezeichner != "rdf:type") AND ($bezeichner != "rdfs:label") AND ($bezeichner != "ld:hasURL") AND ($bezeichner != "jsp:hasAddress") AND ($bezeichner != "jsp:hasOpeningHours") AND ($bezeichner != "jsp:hasdescription") AND ($bezeichner != "jsp:hasIrregularOpeningHours")) 
		{
            $description = str_replace("http://leipzig-data.de/Data/Jugendstadtplan/", "", $requested_res_data->get($bezeichner));
            $bezeichner_human = explode(":", $bezeichner);
            $answer.= "<tr><td>" . $bezeichner_human[1] . "</td><td>" . $description . "</td></tr>";
        }
    }

    $answer.= "</table></div>";

    // Label
    $label = $requested_res_data->label();
    $answer.= "<div id='heading'>" . $label . "</div>";
    
    // Description
    $description = $requested_res_data->getLiteral("jsp:hasdescription", $language);
    if (empty($description))
	{
		$description = $lang["entryNotAvaiable"];
	}	
	$answer.= "<div id='description'>" . $description . "</div>";
    
    //Kontakt
    $address_uri       = $requested_res_data->get("jsp:hasAddress");
    $address_ressource = $graph->resource($address_uri);
    
    // resolve street_name
    $street_uri       = $address_ressource->get("ld:inStreet");
    $street_ressource = $graph->resource($street_uri);
    $street_name      = $street_ressource->label();
    
    //House Number
    $housenumber = $address_ressource->get("ld:hasHouseNumber");
    
    //ZIP
    $postcode = $address_ressource->get("ld:hasPostCode");
    
    //City
    $city = "Leipzig"; // muss noch besser
    $URL  = $requested_res_data->get("ld:hasURL");
    
    if (empty($street_name)) 
	{
        $street_name = $lang["entryNotAvaiable"];
    }
	$answer.= "<div id='address'><b>" . $label . "</b><br/>" . $street_name . " " . $housenumber . "<br/>\n" . $postcode . " " . $city . "<br/><br><a href='" . $URL . "' target='_blank'>" . $URL . "</a></div>";
    
    
    //Opening Hours
    $openinghours = $requested_res_data->get("jsp:hasOpeningHours");
    preg_match_all('/(Mo|Di|Mi|Do|Fr|Sa|So)[.0-9a-zA-Z\s]*\((\d+:[0-9][0-9])(\-|\–)(\d+\:[0-9][0-9])\)/', $openinghours, $array);
    $answer.= "<div id='openinghours'><table><tr></tr>";
	// improve check because no all cases known
	if (strlen($openinghours) == 0 or empty($openinghours))
	{
        $answer.= $lang["entryNotAvaiable"];
    }
    
    foreach ($array[1] as $Day) {
        $answer.= "<td>" . $Day . "</td>";
        
    }
    $answer.= "</tr>\n<tr>";
    
    
    foreach ($array[2] as $Day) {
        $answer.= "<td>" . $Day . "</td>";
        
    }
    
    $answer.= "</tr>\n<tr>";
    foreach ($array[1] as $Day) {
        $answer.= "<td>-</td>";
        
        
    }
    $answer.= "</tr>\n<tr>";
    
    foreach ($array[4] as $Day) {
        $answer.= "<td>" . $Day . "</td>";
        
    }
    $answer.= "</tr></table>";
    
    $hasirregularopeninghours = $requested_res_data->get("jsp:hasIrregularOpeningHours");
    
    if (!empty($hasirregularopeninghours)) 
	{
        $answer.= "<br/>*" . $hasirregularopeninghours;
    }
    
    $answer.= "</div>";
    return $answer;
}

?>