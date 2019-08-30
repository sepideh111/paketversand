<?php
namespace Seitensteuerung;

use klassen\pdo\Datenbank; // benutze diesen Namespace für Datenbank
use klassen\Auftrag;
use klassen\Auftragsbearbeitung;
use klassen\Paket;
use klassen\Mitarbeiter;
use klassen\Status;

use klassen\Datei;
use klassen\Dateimanager;

class Seitensteuerung
{
	// Attribute
	public $action 		= "";								// Seitenauswahl
	public $formData 	= array();							// Formulardaten
	public $template 	= "templates/grundgeruest.html";	// HTML-Seite
	public $content 	= "Inhalt ist noch leer"; 			// Seiteninhalt der Unterseite
	
	public function selectPage($page)
	{
		$this->action = $page;
		
		if(isset($_POST["login_formular"]))
		{
			$db = new Datenbank();
			$mitarbeiter = $db->sql_select("select * from mitarbeiter where login =:login",
											array("login" => $_POST['login']));
			if(count($mitarbeiter) == 1)
			{
				$hash = $mitarbeiter[0]["passwort"];
				if(password_verify($_POST["passwort"], $hash))
				{
					//$meldung = "richtig";
					$_SESSION["mitarbeiternr"] = $mitarbeiter[0]["mitarbeiternr"];
				}
				else
				{
					//$meldung = "falsch";
				}				
			}
			else
			{
				//$meldung = "Login fehlerhaft";
			}
			//echo $meldung;			
		}
		
		
		switch($this->action)
		{
			case "home":				$this->actionHome(); 				break;
			case "sendung_verfolgen":	$this->actionSendungVerfolgen();  	break;
			case "paket_versenden":		$this->actionPaketVersenden();		break;
			case "verwaltung":			$this->actionVerwaltung();			break;
			
			case "login":				$this->actionLogin();				break;	// NEU
			case "logout":				$this->actionLogout();				break;	// NEU
			
			case "kontakt":				$this->actionKontakt();				break;
			case "impressum":			$this->actionImpressum();			break;
			case "agb":					$this->actionAGB();					break;
			case "download":			$this->actionDownload();			break;
			case "veraltet": 			$this->actionVeraltet();	 		break;
			default:					$this->actionSeiteNichtGefunden();

		}	

		// Template Vorlage holen
		$zeichenkette = file_get_contents($this->template);
		
		$logout_string = "";
		$login_string = "";
		
		if(isset($_SESSION["mitarbeiternr"]))
		{
			$logout_string = '<a href="index.php?action=logout">Logout</a>';
		}
		else
		{
			#$login_string = '<a href="index.php?action=login">Login</a>';
		}
		
		$zeichenkette =	suchen_und_ersetzen("__#__LOGIN__#__", $login_string, 		$zeichenkette);
		$zeichenkette =	suchen_und_ersetzen("__#__LOGOUT__#__", $logout_string, 		$zeichenkette);
		
											// Suchstelle     Ersatzinhalt		html-Grundgerüst
		$neue_zeichenkette = suchen_und_ersetzen("__#__CONTENT__#__", $this->content, 		$zeichenkette);
		return $neue_zeichenkette;		
	}
	
	protected function actionHome()
	{
		# $this->content = "<h1>Startseite NEU</h1>";
		$this->content = file_get_contents("templates/startseite.html");
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	protected function actionSendungVerfolgen()
	{
		$this->content = "<h1>Sendung verfolgen</h1>";
		
		$this->content .= "<h3>Sendungsnummer</h3>";
		
		$this->content .= "<form action='' method='post'><input type='text' name='sendungsnummer'>
									<input type='submit' name='sendung_verfolgen'></form>";
									
		if(isset($_POST["sendung_verfolgen"]))
		{			
			$db = new Datenbank();
			$auftrag = $db->sql_select("select * from auftraege where sendungsnummer='".$_POST["sendungsnummer"]."'");	
			// Wenn ein Auftrag gefunden wurde
			if(count($auftrag) == 1)
			{
				include("sendungsverfolgung_details.php");
			}
			else
			{
				$this->content .= "Es wurde kein Auftrag gefunden!";
			}			
		}
	}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
	protected function actionPaketVersenden()
	{
		$this->content = "<h1>Paket versenden</h1>";
		$this->formData = $_POST;
		

################################################################################################		
$_SESSION["debug"]->hinzufuegen_variable("Formulardaten für Paket versenden:", print_r($_POST,true));			
################################################################################################			
				
		
		// Speichern der Daten in einer TXT-Datei
		// Wenn das Formular verschickt wurde
		if(isset($this->formData["paket_versenden"]))
		{
			// Post Array umwandeln in eine serialisierte Verison einer Zeichenkette
			$speicherbare_zeichenkette = serialize($this->formData);
			//die($speicherbare_zeichenkette); // programm beenden mit dem letzten schrei
			// a:4:{s:8:"absender";s:1:"a";s:10:"empfaenger";s:1:"e";s:5:"boxnr";s:1:"2";s:15:"paket_versenden";s:15:"Paket versenden";}
			// Array mit 4 Elementen, String mit 8 Zeichen ...

			################################################################################################
			$_SESSION["debug"]->hinzufuegen_variable("Zeichenkette speichern:", $speicherbare_zeichenkette);
			################################################################################################			
					
			
			
			// Dateiname generieren
			$dateiname = uniqid("paketsendung_"); // paketsendung_5b28d75206bec
			// Die Zeichenkette in die Datei schreiben
			file_put_contents("paketsendungen/$dateiname.txt", $speicherbare_zeichenkette);
			$this->content .= "Daten wurden gespeichert";		


			#############################################################
			
			#$db = new \klassen\pdo\Datenbank();
			$db = new Datenbank();
			$preisliste = $db->sql_select("select * from preisliste where nr =".$this->formData["boxnr"]);

################################################################################################
$_SESSION["debug"]->hinzufuegen_variable("Preisliste:", print_r($preisliste,true));
################################################################################################

################################################################################################
$_SESSION["debug"]->hinzufuegen_variable("Upload FILES:", print_r($_FILES,true));
$_SESSION["debug"]->hinzufuegen_variable("Upload POST:", print_r($_POST,true));
################################################################################################

			$datei = new Datei($_FILES["uploaddatei"]);
			$dateimanager = new Dateimanager();





			$auftrag_id = $db->sql_insert("insert into auftraege 
					(status, sendungsnummer, absender, empfaenger, preisstufe, preis, bilddatei)
					values
					(
						:platzhalter_status, 
						:platzhalter_sendungsnummer, 
						:platzhalter_absender, 
						:platzhalter_empfaenger, 
						:platzhalter_preisstufe, 
						:platzhalter_preis, 
						:platzhalter_bilddatei
					)",
					array(
						"platzhalter_status" => 1,						// DEFAULT
						"platzhalter_sendungsnummer" => uniqid(),		// eindeutige ID
						"platzhalter_absender" => $this->formData["absender"],
						"platzhalter_empfaenger" => $this->formData["empfaenger"],
						"platzhalter_preisstufe" => $this->formData["boxnr"],
						"platzhalter_preis" => $preisliste[0]["preis"],
						"platzhalter_bilddatei" => $dateimanager->datei_hochladen($datei->getDateiinfo())
					)
				);
			
		}
		else
		{
			$this->content .= file_get_contents("templates/paket_versenden_formular.html");
		}
	}
	
	
	
	
	
	protected function actionVerwaltung()
	{
		$this->content = "";
		if(isset($_SESSION["mitarbeiternr"]))
		{
			$db = new Datenbank();
			
			if(isset($_POST["statusnr"]))
			{
				$teile = explode(";", $_POST["statusnr"]);
				$statusnr = $teile[0];
				$beschreibung = $teile[1];
				
				$db->sql_update("update auftraege set status = '".$statusnr."' 
								where auftragnr='".$_POST["auftragnr"]."'");
								
				$db->sql_insert("insert into bearbeitung (auftragnr, mitarbeiternr, art_der_taetigkeit)
								values (:auftragnr, :mitarbeiternr, :art_der_taetigkeit)",
								
								array("auftragnr" => $_POST["auftragnr"],
									  "mitarbeiternr" => $_SESSION["mitarbeiternr"],
									  "art_der_taetigkeit" => $beschreibung));
				$this->content .= "<div style='color:red;'>Der Status wurde geändert!</div>"; 
			}
			
			if(isset($_POST["absender"]) && isset($_POST["empfaenger"]))
			{
				$db->sql_update("update auftraege set 
								absender = :absender, 
								empfaenger = :empfaenger 
								where auftragnr=:auftragnr",
								array(
								 "absender" => $_POST["absender"],
								 "empfaenger" => $_POST["empfaenger"],
								 "auftragnr" => $_POST["auftragnr"]
								)
								);	
				$this->content .= "<div style='color:red;'>Die Daten wurden geändert!</div>";											
			}
			
			if(isset($_POST["loeschen"]))
			{
				$this->content .= $db->sql_delete("delete from bearbeitung where auftragnr = ".$_POST["auftragnr"]);
				$this->content .= $db->sql_delete("delete from auftraege where auftragnr = ".$_POST["auftragnr"]);
				$this->content .= "<div style='color:red;'>Die Daten wurden gelöscht!</div>";	
			}
			
			switch(@$_GET["modus"])
			{
				case "details":		include("verwaltung_details.php");				break;
				case "loeschen":	include("verwaltung_loeschbestaetigung.php");	break;
				default:			include("verwaltung_uebersicht.php");
			}
			
		}
		else
		{
			$this->actionLogin(); // Weiterleitung zum Login
		}
	}
	
	
	
	protected function actionLogin()
	{
		$this->content = "<h1>Login</h1>";
		// Teiltemplate
		$this->content .= file_get_contents("templates/login.html");
		
	}
	
	protected function actionLogout()
	{
		$this->content = "<h1>Logout</h1>";
		$this->content .= "Sie sind nun abgemeldet";
		unset($_SESSION["mitarbeiternr"]);
	}
	
	
	
	
	
	
	
	
	
	
	
	protected function actionKontakt()
	{
		$this->content = "<h1>Kontakt</h1>";
	}	
	
	protected function actionImpressum()
	{
		$this->content = "<h1>Impressum</h1>";
	}		
	
	protected function actionAGB()
	{
		$this->content = "<h1>AGB</h1>";
	}
	
	protected function actionDownload()
	{
		$this->content = "<h1>Download</h1>";
		header("Location: downloads/download.php"); // Weiterleitung
	}	
	
	protected function actionVeraltet()
	{
		$this->content = "<h1>Veraltet</h1>";
		header("Expires: Tue, 24 Apr 2018 11:06:00 GMT");
	}	
	
	protected function actionSeiteNichtGefunden()
	{
		$this->content = "<h1>Seite nicht gefunden</h1>";
		header("HTTP/1.1 404 Not Found"); // Fehlerseite
		#header("Location: 404_not_found.php"); // Weiterleitung an die Fehlerseite
	}		
	
}
?>