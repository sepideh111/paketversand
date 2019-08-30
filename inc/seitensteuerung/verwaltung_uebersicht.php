<?php
use klassen\pdo\Datenbank; // benutze diesen Namespace für Datenbank
use klassen\Auftrag;
use klassen\Auftragsbearbeitung;
use klassen\Paket;
use klassen\Mitarbeiter;
use klassen\Status;

use klassen\Datei;
use klassen\Dateimanager;

$this->content .= "<h1>Verwaltung Übersicht</h1>";

		// Teiltemplate
$tabelle_oben = file_get_contents("templates/verwaltung_tabelle_oben.html");

// Suchen und ersetzen
$tabelle_oben = suchen_und_ersetzen("__SUCHE_SENDUNGSNUMMER__", @$_POST["suche_sendungsnummer"], $tabelle_oben);
$tabelle_oben = suchen_und_ersetzen("__SUCHE_AUFTRAGDATUM__", @$_POST["suche_auftragdatum"], $tabelle_oben);
$tabelle_oben = suchen_und_ersetzen("__SUCHE_ABSENDER__", @$_POST["suche_absender"], $tabelle_oben);
$tabelle_oben = suchen_und_ersetzen("__SUCHE_EMPFAENGER__", @$_POST["suche_empfaenger"], $tabelle_oben);

$this->content .= $tabelle_oben;

$db = new Datenbank();

$auftraege = $db->sql_select("select * from auftraege LEFT JOIN status 
							ON auftraege.status = status.statusnr
							WHERE auftraege.sendungsnummer LIKE '%".@$_POST["suche_sendungsnummer"]."%'
							AND auftraege.auftragdatum LIKE '%".@$_POST["suche_auftragdatum"]."%'
							AND auftraege.absender LIKE '%".@$_POST["suche_absender"]."%'
							AND auftraege.empfaenger LIKE '%".@$_POST["suche_empfaenger"]."%'
							");

foreach($auftraege as $nr => $auftrag)
{
	$zeichenkette = file_get_contents("templates/verwaltung_tabelle_mitte.html");
	
	$austausch_array = array(	"__AUFTRAGNR__" 		=> $auftrag["auftragnr"],
								"__SENDUNGSNUMMER__" 	=> $auftrag["sendungsnummer"],
								"__AUFTRAGDATUM__" 		=> $auftrag["auftragdatum"],
								"__ABSENDER__" 			=> $auftrag["absender"],
								"__EMPFAENGER__" 		=> $auftrag["empfaenger"],
								"__STATUSBESCHREIBUNG__" => $auftrag["statusbeschreibung"],
								"__BILD__" 				=> $auftrag["bilddatei"]
							);
							
	foreach($austausch_array as $platzhalter => $austauschwert)
	{
		$zeichenkette = suchen_und_ersetzen($platzhalter, $austauschwert, $zeichenkette);
	}
	
	$this->content .= $zeichenkette;
}

$this->content .= file_get_contents("templates/verwaltung_tabelle_unten.html");
?>