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
include_once "helper.php";
include_once "getCategories.php";

// ouput settings
//=========================
ini_set('default_charset', 'utf-8');

// base settings
//=========================

// Function
// function return a full website contains map
// param: wished language example "de" or "en" ...
// return: a array is returned which contain all data
//=========================
function buildWebpage($language)
{
    $language = validateLanguage($language);
	// check ini file for translated verbs
	$translation = getTranslation($language);
	// start building website
    $webpage = "";
	$webpage = pageHeader($translation["tabTitle"]);
	$webpage.= pageNavigation($translation["label"], $translation["map"], $translation["aboutUs"], $translation["contact"], $translation["languageButton"]);
	$webpage.= pageMap($translation["placeDescription"], $translation["opening"], $translation["contact"], $translation["properties"], $translation["chooseEntry"], validateLanguage($language));
	$webpage.= getCategories($language, $translation["allCategories"], $translation["noCategorie"]);
	$webpage.= pageFooter($translation["copyright"], date("Y", time()));
    return $webpage;
}

?>