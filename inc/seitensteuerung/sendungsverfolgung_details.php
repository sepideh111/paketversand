<?php
use klassen\pdo\Datenbank; // benutze diesen Namespace für Datenbank
use klassen\Auftrag;
use klassen\Auftragsbearbeitung;
use klassen\Paket;
use klassen\Mitarbeiter;
use klassen\Status;

use klassen\Datei;
use klassen\Dateimanager;

$this->content .= "<h1>Sendungsverfolgung Details</h1>";

$db = new Datenbank();

$auftrag = $db->sql_select("select * from auftraege where sendungsnummer='".$_POST["sendungsnummer"]."'");

$zeichenkette = file_get_contents("templates/auftrag_details.html");

$zeichenkette = suchen_und_ersetzen("__ZURUECK_LINK__", '', $zeichenkette);

// Austauschen
									// Suchstelle     	Ersatzinhalt		html-Grundgerüst
$zeichenkette = suchen_und_ersetzen("__HEADLINE__", 
		$auftrag[0]["auftragnr"]." / ".
		"Datum: ".$auftrag[0]["auftragdatum"]." / ".
		"SendungsNr: ".$auftrag[0]["sendungsnummer"]
		,	$zeichenkette);
		
		
// ############################################################# 
// STATUS	
// #############################################################
	
$statusinfo = $db->sql_select("select * from status where statusnr=".$auftrag[0]["status"]);	
//echo $statusinfo["statusbeschreibung"];
$ende = $statusinfo[0]["ende"]; // Das ist die Spalte mit 0 oder 1

$zeichenkette = suchen_und_ersetzen("__STATUS__", 
		"<div style='color:red'>".$statusinfo[0]["statusbeschreibung"]."</div>"
		,	$zeichenkette);		
		
		
// ############################################################# 
// Details	
// #############################################################
$details = "";

$details .= "Absender:".$auftrag[0]["absender"]."<br />";
$details .= "Empfaenger:".$auftrag[0]["empfaenger"]."<br />";


$details .= "Preisstufe:".$auftrag[0]["preisstufe"]."<br />";
$details .= "Preis:".$auftrag[0]["preis"]."<br />";
$details .= "Bilddatei:".$auftrag[0]["bilddatei"]."<br />";
	
$zeichenkette = suchen_und_ersetzen("__DETAILS__", $details ,	$zeichenkette);		


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

$zeichenkette = suchen_und_ersetzen("__EREIGNISSE__", $ereignisse ,	$zeichenkette);

$this->content .= $zeichenkette;
?>