<?php
class Auftragsbearbeitung
{
	// Attribute
	protected $AuftragNr;
	protected $MitarbeiterNr;
	protected $Datum;
	protected $Art_der_Taetigkeit;
	// GET- und SET-Methoden
	protected function getAuftragNr()
	{
		return $this->AuftragNr;
	}
	protected function setAuftragNr($AuftragNr)
	{
		$this->AuftragNr = $AuftragNr;
	}
	protected function getMitarbeiterNr()
	{
		return $this->MitarbeiterNr;
	}
	protected function setMitarbeiterNr($MitarbeiterNr)
	{
		$this->MitarbeiterNr = $MitarbeiterNr;
	}
	protected function getDatum()
	{
		return $this->Datum;
	}
	protected function setDatum($Datum)
	{
		$this->Datum = $Datum;
	}
	protected function getArt_der_Taetigkeit()
	{
		return $this->Art_der_Taetigkeit;
	}
	protected function setArt_der_Taetigkeit($Art_der_Taetigkeit)
	{
		$this->Art_der_Taetigkeit = $Art_der_Taetigkeit;
	}
}
?>
