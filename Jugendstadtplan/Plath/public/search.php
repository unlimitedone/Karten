<?php
/**
 * User: Immanuel Plath
 * Date: 05.12.14
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
include_once "../module/searching.php";

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
	// gzip All Output
	ob_start('ob_gzhandler');
	// Change Content Header
	header('Content-Type: application/json;charset=utf-8');
	
	$response = "";
	$searchKey = "";
	if (isset($_GET["search"])) 
	{
		$searchKey = $_GET["search"];
		$response = searchByUri($searchKey);
		$response = json_encode($response);
	}
    return $response;
}

// print website to user
echo response();

?>



