<?php
session_start();

require_once("config/config.inc.php");	

#require_once("inc/klassen/pdo/Datenbank.php");		
#require_once("inc/Seitensteuerung/Seitensteuerung.php");		
require_once("inc/funktionen/zeichenketten_funktionen.inc.php");
require_once("inc/funktionen/datum_und_zeit_funktionen.inc.php");

#require_once("inc/tools/Debug.php");

// Die Funktion lädt alle externen Dateien automatisch
function autoLoad($name)
{
	$pfad = "inc/".$name.".php";
	if(file_exists($pfad))
	{
		require_once($pfad);
	}	
}

// Autoloading // Dateiname und Klassenname muss gleich sein!!!
spl_autoload_register("autoLoad"); // Automatisches Laden aktivieren mit der vorbereiteten Funktion


// Instanzieren der Debugklasse
$_SESSION["debug"] = new \tools\Debug();	
/*
$_SESSION["debug"]->hinzufuegen_datenbank("Einfügen in die Datenbank", "insert into...");
$_SESSION["debug"]->hinzufuegen_funktion("Funktion starten", "hinzufuegen()");
$x = 10;
$_SESSION["debug"]->hinzufuegen_variable("Testvariable erstellen", $x);	
*/
if(!isset($_GET["action"]))
{
	$_GET["action"] = "home";
}

$controller = new \Seitensteuerung\Seitensteuerung(); # Neuer Controller erstellen
echo $controller->selectPage($_GET["action"]); // Internetseite zeigen


// Unten drunter Debugkontrolle
echo $_SESSION["debug"];























/*
require_once("inc/funktionen/zeichenketten_funktionen.inc.php");
require_once("inc/funktionen/datum_und_zeit_funktionen.inc.php");

if(!isset($_GET["action"]))
{
	$_GET["action"] = "home";
}

# Verarbeitung von Daten
switch($_GET["action"])
{
	case "paket_versenden":
		// Speichern der Daten in einer TXT-Datei
		// Wenn das Formular verschickt wurde
		if(isset($_POST["paket_versenden"]))
		{
			// Post Array umwandeln in eine serialisierte Version einer Zeichenkette
			$speicherbare_zeichenkette = serialize($_POST);
			#echo  $speicherbare_zeichenkette ;
			# a:4:{s:8:"absender";s:10:"Absender 1";s:10:"empfaenger";s:12:"Empfänger 2";s:5:"boxnr";s:1:"2";s:15:"paket_versenden";s:15:"Paket versenden";}
			
			// Dateiname generieren
			$dateiname = uniqid("paketsendung_"); // paketsendung_5b28d75206bec		

			// Die Zeichenkette in die Datei schreiben
			file_put_contents("paketsendungen/$dateiname.txt", $speicherbare_zeichenkette);	
			echo "<p>Daten wurden gespeichert</p>";			
		}
	break;
}




# Anzeige von einer Webseite
switch($_GET["action"])
{
	case "home":				$ausgabe = "Startseite"; 		break;
	case "sendung_verfolgen":	$ausgabe = "Sendung verfolgen"; break;
	case "paket_versenden":		
	
		$ausgabe = "<h1>Paket versenden</h1>"; 	
		$ausgabe .= "<form action='' method='post'>";
		
		$ausgabe .= "Absender:<br /> <textarea name='absender'></textarea><br />";
		$ausgabe .= "Empfaenger:<br /> <textarea name='empfaenger'></textarea><br />";
		
		$ausgabe .= "<h2>Bitte wählen Sie die Box aus:</h2>";
		$ausgabe .= "<select name='boxnr'>";
		$ausgabe .= "<option value='1'>Box 1: 30cm</option>";
		$ausgabe .= "<option value='2'>Box 2: 60cm</option>";
		$ausgabe .= "<option value='3'>Box 3: 100cm</option>";
		$ausgabe .= "</select><br />";
		
		$ausgabe .= "<br /><input type='submit' name='paket_versenden' value='Paket versenden'/>";
		
		$ausgabe .= "</form>";		

	break;
	case "verwaltung":			$ausgabe = "Verwaltung";		break;
	case "kontakt":				$ausgabe = "Kontakt";			break;
	case "impressum":			$ausgabe = "Impressum";			break;
	case "agb":					$ausgabe = "AGB";				break;
	
	##################################################
	# NEU
	##################################################
	case "download":			
		$ausgabe = "Download";			
		header("Location: downloads/download.php");
	break;
	case "veraltet":			
		$ausgabe = "Veraltet";
		header("Expires: Tue, 28 May 2019 18:25:00 GMT");
	break;
	default:					
	$ausgabe = "Error404 - Seite nicht gefunden";
	header("HTTP/1.1 404 Not Found"); // Status-Code setzen
}

// Template Vorlage holen
$zeichenkette = file_get_contents("templates/grundgeruest.html");
											// Suchstelle     Ersatzinhalt		html-Grundgerüst
$neue_zeichenkette = suchen_und_ersetzen("__#__CONTENT__#__", $ausgabe, 		$zeichenkette);
echo $neue_zeichenkette;
*/
?>