<?php
/**
 * User: Immanuel Plath
 * Date: 05.12.14
 */

// include section
//=========================
include_once "../config/config.php";

// output settings
//=========================
ini_set('default_charset', 'utf-8');

// base settings
//=========================

// Function
// function validate a GET param (with fallback to standard language)
// param: language example "de" or "en" ...
// return: a valid existing language
//=========================
function validateLanguage($language)
{
    global $settings;
	$lang = "de";
	switch ($language) {
        case "de":
            $lang = "de";
            break;
        case "en":
            $lang = "en";
            break;
        default:
            $lang = $settings["defaultLanguage"];
    }
	return $lang;
}
?>



