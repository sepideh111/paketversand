<?php
namespace klassen;

class Dateimanager
{
									// $_FILES
	public function datei_hochladen($datei)
	{
		$datei_tempname = $datei["tmp_name"]; // Wie heißt die Datei auf dem Server?
		$neuer_dateiname = uniqid("bild_").".png"; // bild_4743828dfjkw48357
		
		$this->datei_kopieren($datei_tempname, $neuer_dateiname);
		return $neuer_dateiname;
	}

	public function datei_loeschen($datei)
	{
		unlink("uploads/".$datei);
	}		
	
	public function datei_kopieren($datei_tempname, $neuer_dateiname)
	{
		// kopiervorgang von A nach B (A = Quelle, B = Ziel)
		move_uploaded_file($datei_tempname, "uploads/".$neuer_dateiname);	
	}		
	
	public function png_datei_downloaden($datei)
	{
		$type = "image/png"; // Dateityp
		header("Content-type: $type"); // Welcher Typ soll geladen werden
		header("Content-Disposition: attachment; filename=bild.png"); // Name beim Client
		readfile($datei); // Datei lesen		
	}		
}
?>