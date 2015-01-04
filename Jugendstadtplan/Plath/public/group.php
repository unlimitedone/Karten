<?php
/**
 * User: Immanuel Plath
 * Date: 26.12.14
 */

// load app settings
//=========================
include_once "../config/config.php";

// debug settings
//=========================
if ($settings["debug"] == "1") {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// include section
//=========================
include_once "../module/getLocationsFromCategories.php";

// ouput settings
//=========================
ini_set('default_charset', 'utf-8');

// Function
// function build final Webpage and include params
// param: no params necessary 
// return: complete webpage
//=========================
function response()
{
	// Change Content Header
	header('Content-Type: application/json;charset=utf-8');
	
	$response = "";
	$searchGroup = "";
	if (isset($_GET["group"])) 
	{
		$lang = "de";
		if (isset($_GET["lang"]))
		{
			$lang = $_GET["lang"];
		}
		$searchGroup = $_GET["group"];
		$response = getLocationsByCategory($searchGroup, $lang);
		$response = json_encode($response);
	}
    return $response;
}

// print website to user
echo response();

?>



