<?php
/*
Aktualisieren von komplexen Strukturen
=============================================

Vorgehensweise
1. file_get_contents
2. unserialize
3. ändern
4. serialize
5. file_put_contents
*/
// lesen einer Datei
$rohdaten = file_get_contents("paketsendungen/paketsendung_5cecf5489e8c5.txt");
echo $rohdaten;

// umwandeln in den normalen Zustand vorher
$formulardaten = unserialize($rohdaten);

echo "<pre>";
print_r($formulardaten);
echo "</pre>";

// neuer Eintrag
$formulardaten["status"] = "erledigt";

$speicherbare_zeichenkette = serialize($formulardaten);
$anzahl_der_zeichen = file_put_contents("paketsendungen/formulardaten.txt", $speicherbare_zeichenkette);
echo $anzahl_der_zeichen;
?>