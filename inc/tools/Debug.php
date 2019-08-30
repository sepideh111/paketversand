<?php
namespace tools;
/*
Debug-Klasse
------------------
AUFGABEN:
- einschalten
- ausschalten
- Kontollausgabe
- Kategorien (Datenbank, PHP-Funktionen, Inhalte von Variablen / Formulare)
- Unterschied zu normalen PHP Fehlern
*/
?>
<!--
<div style="background-color:red; 	 color:white">1. DB: Datenbankzugriff</div>
<div style="background-color:yellow; color:black">2. PHP-Funktionen</div>
<div style="background-color:red; 	 color:white">3. DB: Datenbankzugriff</div>
<div style="background-color:orange; color:black">4. Variablen</div>
<div style="background-color:red; 	 color:white">5. DB: Datenbankzugriff</div>
<div style="background-color:orange; color:black">6. Variablen</div>
<div style="background-color:orange; color:black">7. Variablen</div>
<div style="background-color:yellow; color:black">8. PHP-Funktionen</div>
<div style="background-color:orange; color:black">9. Variablen</div>
<div style="background-color:red; 	 color:white">10. DB: Datenbankzugriff</div>
<div style="background-color:yellow; color:black">11. PHP-Funktionen</div>
<div style="background-color:red; 	 color:white">12. DB: Datenbankzugriff</div>
<div style="background-color:red; 	 color:white">13. DB: Datenbankzugriff</div>
<div style="background-color:yellow; color:black">14. PHP-Funktionen</div>
-->
<?php

class Debug
{
	// Attribute
	public $debugliste 			= array(); // Sammlung aller Ausgaben	
	public $aktiv_datenbank		= _DEBUG_AKTIV_DATENBANK; // aktuell abgeschaltet
	public $aktiv_funktion 		= _DEBUG_AKTIV_FUNKTION; // aktuell abgeschaltet
	public $aktiv_variable 		= _DEBUG_AKTIV_VARIABLE; // aktuell abgeschaltet	
	
	// Methoden
	protected function hinzufuegen($beschreibung, $inhalt, $kategorie)
	{
		$array = array("beschreibung" 	=> $beschreibung,
					   "inhalt" 		=> $inhalt,
					   "kategorie" 		=> $kategorie);
		$this->debugliste[] = $array; // hinzufuegen zum Array					   
	}

	public function hinzufuegen_datenbank($beschreibung, $inhalt)
	{
		$this->hinzufuegen($beschreibung, $inhalt, "Datenbankzugriff");
	}

	public function hinzufuegen_funktion($beschreibung, $inhalt)
	{
		$this->hinzufuegen($beschreibung, $inhalt, "Funktion");
	}

	public function hinzufuegen_variable($beschreibung, $inhalt)
	{
		$this->hinzufuegen($beschreibung, $inhalt, "Variable");
	}	
	
	public function __toString()
	{
		$string = "";
		// debugliste anzeigen
		foreach($this->debugliste as $nr => $eintrag)
		{
			switch($eintrag["kategorie"])
			{
				case "Funktion":
					if($this->aktiv_funktion)
					$string .= "<div style='background-color:orange; color:black'><b>".($nr+1)
								.". Funktionen:</b>".$eintrag["beschreibung"]."<br />(<pre>".$eintrag["inhalt"]."</pre>)</div>";
				break;
				case "Variable":
					if($this->aktiv_variable)
					$string .= "<div style='background-color:yellow; color:black'><b>".($nr+1)
								.". Variablen:</b>".$eintrag["beschreibung"]."<br />(<pre>".$eintrag["inhalt"]."</pre>)</div>";
				break;
				case "Datenbankzugriff":
					if($this->aktiv_datenbank)
					$string .= "<div style='background-color:red; color:white'><b>".($nr+1)
								.". Datenbankzugriff:</b> ".$eintrag["beschreibung"]."<br />(<pre>".$eintrag["inhalt"]."</pre>)</div>";
				break;
			}
		}
		
		if($string == "" && ($this->aktiv_funktion || $this->aktiv_variable || $this->aktiv_datenbank))
		{
			return "DEBUG ist leer";
		}	
		return $string;		
	}		
	
}
/*
$debug = new Debug();
$debug->hinzufuegen_datenbank("Einfügen in die Datenbank", "insert into...");
$debug->hinzufuegen_datenbank("Einfügen in die Datenbank", "insert into...");
$debug->hinzufuegen_funktion("Funktion starten", "hinzufuegen()");

$x = 10;
$debug->hinzufuegen_variable("Testvariable erstellen", $x);

$debug->hinzufuegen_datenbank("Einfügen in die Datenbank", "insert into...");

echo $debug;
*/
?>