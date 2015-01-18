<?php
/** Kopie von 
 * User: Immanuel Plath
 * Date: 05.12.14
 */

// load app settings
//=========================
include_once "config.php";

// debug settings
//=========================
if ($settings["debug"] == "1") {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// include section
//=========================
include_once "module/buildHtmlPage.php";

// output settings
//=========================
ini_set('default_charset', 'utf-8');

// base settings
//=========================

// print website to user
echo buildWebpage();

?>



