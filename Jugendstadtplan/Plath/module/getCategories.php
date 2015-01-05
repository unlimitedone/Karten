<?php
/**
 * User: Immanuel Plath
 * Date: 05.12.14
 */

// include section
//=========================
include_once "../config/config.php";
include_once "translate.php";
include_once "html.php";
require_once "../vendor/autoload.php";

// output settings
//=========================
ini_set('default_charset', 'utf-8');

// Function
// function returns all categories which could found in rdf data
// param: language example "de" or "en" ...
// param: categOne define name of first category contain all locations
// param: categTwo define name of second category contain all locations without a category
// return: html contains all categories
//=========================
function getCategories($lang, $categOne, $categTwo)
{
    // set RDF namespaces
    EasyRdf_Namespace::set('ldo', 'http://leipzig-data.de/Data/Ort/');
    EasyRdf_Namespace::set('ldp', 'http://leipzig-data.de/Data/Person/');
    EasyRdf_Namespace::set('ldtag', 'http://leipzig-data.de/Data/Tag/');
    EasyRdf_Namespace::set('ld', 'http://leipzig-data.de/Data/Model/');
    EasyRdf_Namespace::set('sysont', 'http://ns.ontowiki.net/SysOnt/');
    EasyRdf_Namespace::set('xsd', 'http://www.w3.org/2001/XMLSchema#');
    EasyRdf_Namespace::set('jsp1', 'http://localhost/jsp/');
    EasyRdf_Namespace::set('jsp', 'http://leipzig-data.de/Data/Jugendstadtplan/');
    
    // parse rdf graph
	$menuCategories = "";
	$categoriesContent = "";
    // uri for RDF file
    $docuri1        = "http://leipzig-data.de/Jugendstadtplan/Emanuel/Data/unsere_data_1.json";
    // load graph via uri
    $graph1         = EasyRdf_Graph::newAndLoad($docuri1);
    // count avaiable categories ($count = 2 because first two categories are static)
    $count          = 2;
    // contains alle categories
    $testarray      = array();
    // search in rdf graph for categories
    foreach ($graph1->resources() as $res) {
		// check if location has a category
        if ($res->hasProperty('jsp:hascategory') == 1) {
            // get all categories for a location
            foreach ($res->all('jsp:hascategory') as $art) {
                // check if category is found in step before
                if (!in_array($art, $testarray)) {
                    $testarray[] = $art;
                    $res2        = $graph1->resource($art);
                    $labelres2   = $res2->label($lang);
                    
                    $type = str_replace("http://leipzig-data.de/Data/Jugendstadtplan/", "", $res2);
					$menuCategories.= '
					<li role="presentation" class=""><a onclick=\'getGroupLocations("'. $labelres2 .'");\' aria-controls="home'.$count.'" data-toggle="tab" id="home'.$count.'-tab" role="tab" href="#home'.$count.'" aria-expanded="false">'.$labelres2.'</a></li>';
					$categoriesContent.= '
					<div aria-labelledby="home'.$count.'-tab" id="home'.$count.'" class="tab-pane fade" role="tabpanel">
						<!-- <p>Comes soon ...</p> -->
					</div>';
                    $count++;
                }
            }
            
        }
    }

	$pageCategories = pageCategories($menuCategories, $categoriesContent, $categOne, $categTwo);
	return $pageCategories;
}

?>


