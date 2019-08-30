<?php
use klassen\pdo\Datenbank; // benutze diesen Namespace für Datenbank
use klassen\Auftrag;
use klassen\Auftragsbearbeitung;
use klassen\Paket;
use klassen\Mitarbeiter;
use klassen\Status;

use klassen\Datei;
use klassen\Dateimanager;

$this->content = "<h1>Details</h1>";

$db = new Datenbank();

$auftrag = $db->sql_select("select * from auftraege where auftragnr=".$_GET["auftragnr"]);

#print_r($auftrag);

$zeichenkette = file_get_contents("templates/auftrag_details.html");

$zeichenkette = suchen_und_ersetzen("__ZURUECK_LINK__", 
'<a href="index.php?action=verwaltung">Zurück</a>', $zeichenkette);

$zeichenkette = suchen_und_ersetzen(
		"__HEADLINE__", 
		
		$auftrag[0]["auftragnr"]." / ".
		"Datum: ".$auftrag[0]["auftragdatum"]." / ".
		"SendungsNr: ".$auftrag[0]["sendungsnummer"],	
		
		$zeichenkette);



// ############################################################# 
// STATUS	
// #############################################################
$statusinfo = $db->sql_select("select * from status where statusnr=".$auftrag[0]["status"]);	
$ende = $statusinfo[0]["ende"]; // Das ist die Spalte mit 0 oder 1

if($ende == 1)
{
	$zeichenkette = suchen_und_ersetzen("__STATUS__", 
			"<div style='color:red'>Der Status kann nicht mehr geändert werden!</div>"
			,	$zeichenkette);
}
else
{
	// Status abfragen die nach dem aktuellen Status folgen
	$statusliste = $db->sql_select("select statusnr, statusbeschreibung, ende from status
	where statusnr > ".$auftrag[0]["status"]."
	order by statusnr");

	$status_formular = file_get_contents("templates/status_formular.html");	

	$optionen = "";	
	foreach($statusliste as $statuszeile)
	{
		$optionen .= '<option value="'.$statuszeile["statusnr"].';'.$statuszeile["statusbeschreibung"].'">'.$statuszeile["statusbeschreibung"].'</option>';
	}

	$status_formular = suchen_und_ersetzen("__OPTIONEN__", $optionen	,	$status_formular);	
	$status_formular = suchen_und_ersetzen("__AUFTRAGNR__", $auftrag[0]["auftragnr"]	,	$status_formular);
	
	$zeichenkette = suchen_und_ersetzen("__STATUS__", $status_formular	,	$zeichenkette);
}


$bearbeitung_formular = file_get_contents("templates/auftrag_bearbeitung_formular.html");		

$bearbeitung_formular = suchen_und_ersetzen("__ABSENDER__", $auftrag[0]["absender"] ,	$bearbeitung_formular);
$bearbeitung_formular = suchen_und_ersetzen("__EMPFAENGER__", $auftrag[0]["empfaenger"] ,	$bearbeitung_formular);		
$bearbeitung_formular =	suchen_und_ersetzen("__AUFTRAGNR__", $auftrag[0]["auftragnr"]	,	$bearbeitung_formular);

$zeichenkette = suchen_und_ersetzen("__DETAILS__", $bearbeitung_formular ,	$zeichenkette);	


$ereignisliste = $db->sql_select("select * from bearbeitung 
									where auftragnr = ".$auftrag[0]['auftragnr']."
									order by datum desc");	

$ereignisse = "";
foreach($ereignisliste as $datensatz)									
{
	$ereignisse .= $datensatz["mitarbeiternr"]." | ";
	$ereignisse .= $datensatz["datum"]." | ";
	$ereignisse .= $datensatz["art_der_taetigkeit"];
	$ereignisse .= "<br />";
}	

$zeichenkette =		suchen_und_ersetzen("__EREIGNISSE__", $ereignisse ,	$zeichenkette);

$this->content .= $zeichenkette;


?>