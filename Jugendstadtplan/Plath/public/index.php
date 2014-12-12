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
include_once "../module/buildHtmlPage.php";

// ouput settings
//=========================
ini_set('default_charset', 'utf-8');

// base settings
//=========================

// Function
// function build final Webpage and include params
// param: no params necessary 
// return: complete webpage
//=========================
function outWebpage()
{
	$language = "";
	if (isset($_GET["lang"])) 
	{
		$language = $_GET["lang"];
	}
	$page = buildWebpage($language);
    return $page;
}

// print website to user
echo outWebpage();

?>



