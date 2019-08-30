<?php
// Datum/Zeit-Funktionen
/*
echo time(); // seit 1.1.1970 vergangene Sekunden (z.B. 1558951614 = timestamp)
echo "<hr>";
echo "<hr>";
echo strftime("%d.%m.%Y %H:%M:%S", 1558951614);

echo "<hr>";
echo "Datum:" . strftime("%D", 1558951614);
echo "<hr>";
echo "Minuten:" . strftime("%M", 1558951614);
echo "<hr>";
echo "Jahr:" . strftime("%Y", 1558951614);
*/
function timestamp_lesbar($timestamp)
{
	return strftime("%d.%m.%Y %H:%M:%S", $timestamp );
}

function timestamp_erstellen($stunde, $minute, $sekunde, $monat, $tag, $jahr)
{
	return gmmktime($stunde, $minute, $sekunde, $monat, $tag, $jahr);
}

#echo timestamp_erstellen(12, 10, 37, 5, 27, 2019);

function timestamp_anhand_datum_uhrzeit($datum, $uhrzeit = "00:00:00")
{
	$array_datum 	= explode(".", $datum); // String in Array umwandeln
	$array_uhrzeit 	= explode(":", $uhrzeit); // String in Array umwandeln
	
	$tag 			=  $array_datum[0];
	$monat			=  $array_datum[1];  
	$jahr 			=  $array_datum[2];	
	
	$stunde 		=  $array_uhrzeit[0];
	$minute 		=  $array_uhrzeit[1];
	$sekunde 		=  $array_uhrzeit[2];

	return gmmktime($stunde, $minute, $sekunde, $monat, $tag, $jahr);	
}
/*
echo timestamp_anhand_datum_uhrzeit("27.05.2019", "12:11:01");
echo "<hr />";
*/
function timestamp_anhand_datum_uhrzeit2($datum, $uhrzeit = "00:00:00")
{
	// list erzeugt Variablen aus einem Array
	list($tag, $monat, $jahr)			= explode(".", $datum); // String in Array umwandeln
	list($stunde, $minute, $sekunde) 	= explode(":", $uhrzeit); // String in Array umwandeln	
	
	return gmmktime($stunde, $minute, $sekunde, $monat, $tag, $jahr);	
}
/*
echo timestamp_anhand_datum_uhrzeit2("27.05.2019", "12:11:01");
echo "<hr />";
*/

function timestamp_anhand_datum_uhrzeit3($datum, $uhrzeit = "00:00:00")
{
	// identisch wie der list befehl = erzeugt Variablen aus einem Array
	[$tag, $monat, $jahr]			= explode(".", $datum); // String in Array umwandeln
	[$stunde, $minute, $sekunde] 	= explode(":", $uhrzeit); // String in Array umwandeln
	
	return gmmktime($stunde, $minute, $sekunde, $monat, $tag, $jahr);	
}
/*
echo timestamp_anhand_datum_uhrzeit3("27.05.2019", "12:11:01");
echo "<hr />";
*/





?>