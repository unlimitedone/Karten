<?php
/** Kopie von 
 * User: Immanuel Plath
 * Date: 05.12.14
 */

// include section
//=========================
include_once "html.php";

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
function buildWebpage()
{
  $webpage = "";
  $webpage = pageHeader("tabTitle");
  $webpage.= pageNavigation("label", "map", "aboutUs", "contact", "languageButton");
  $webpage.= pageMap("placeDescription", "opening", "contact", "properties", "chooseEntry", "de");
  //$webpage.= getCategories("de", "allCategories", "noCategorie");
  $webpage.= pageFooter("copyright", date("Y", time()));
  return $webpage;
}

?>