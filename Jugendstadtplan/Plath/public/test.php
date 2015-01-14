<?php
/**
 * User: Immanuel Plath
 * Date: 05.12.14
 */

// include section
//=========================
require_once "../vendor/autoload.php";

// output settings
//=========================
ini_set('default_charset', 'utf-8');

/*

Aufruf "php test.php >o.html"

Emanuels json-Datei in Trutle verwandeln

*/

$graph = new EasyRdf_Graph("http://leipzig-data.de/Data/JSP-Alt/");
$graph->parseFile("data/jugendstadtplan.json");
echo $graph->serialise("turtle");

?>


