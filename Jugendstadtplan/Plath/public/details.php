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
include_once "../module/helper.php";
include_once "../module/getDetails.php";

// ouput settings
//=========================
ini_set('default_charset', 'utf-8');

// Function
// function build final Webpage and include params
// param: no params necessary 
// return: complete webpage
//=========================
function outDetails()
{
	$language = "";
	$uri = "";
	$page = "";
	if (isset($_GET["lang"])) 
	{
		$language = $_GET["lang"];
	}
	$language = validateLanguage($language);
	if (isset($_GET["uri"])) 
	{
		$uri = $_GET["uri"];
		$page = getLocationDetails($uri, $language);
		//$page = "done";
	}
    return $page;
}

// print website to user
echo outDetails();

?>



