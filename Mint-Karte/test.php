<?php
require 'vendor/autoload.php';

/* 11.01.2015, HGG: Gefixt */

$graph = new EasyRdf_Graph("http://leipzig-data.de/Data/MINTBroschuere2012/");
// Parameter ist der Name des RDF Graphen

$graph->parseFile("data/MINTBroschuere2012.ttl");
// Name der Datei, aus der dieser RDF-Graph geladen werden soll

echo $graph->dump("html"); // erzeugt einen html view eines RDF Dumps

/* 

$me = $foaf->primaryTopic();
echo "My name is: ".$me->get('foaf:name')."\n";

*/
?>