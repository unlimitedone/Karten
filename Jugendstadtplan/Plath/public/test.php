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

Linke vorher Karten/Jugendstadtplan/RDF-Data ans Verzeichnis Plath/public

*/

$graph1 = new EasyRdf_Graph("http://leipzig-data.de/Data/JSP/TeilGraph/");
$graph1->parseFile("RDFData/Orte.ttl");
echo $graph1->dump("html");

?>


