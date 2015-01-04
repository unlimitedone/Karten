<?php
/**
 * User: Immanuel Plath
 * Date: 05.12.14
 */

// output settings
//=========================
ini_set('default_charset', 'utf-8');

// base settings
//=========================

// Function
// function read .ini file with translate text for website
// param: wished language example "de" or "en" ...
// return: a array is returned which contain all data
//=========================
function getTranslation($language)
{
    $pathToTranslateDir = "../data/translation/";
    $fullpath           = $pathToTranslateDir . $language . ".ini";
    $translation        = parse_ini_file($fullpath);
    return $translation;
}

?>