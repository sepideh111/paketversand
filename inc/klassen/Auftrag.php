<?php
class Auftrag
{
	// Attribute
	protected $AuftragNr;
	protected $Datum;
	protected $Status;
	protected $Sendungsnummer;
	protected $Absender;
	protected $Empfaenger;
	protected $Preisstufe;
	protected $Preis;
	protected $Bilddatei;
	// GET- und SET-Methoden
	protected function getAuftragNr()
	{
		return $this->AuftragNr;
	}
	protected function setAuftragNr($AuftragNr)
	{
		$this->AuftragNr = $AuftragNr;
	}
	protected function getDatum()
	{
		return $this->Datum;
	}
	protected function setDatum($Datum)
	{
		$this->Datum = $Datum;
	}
	protected function getStatus()
	{
		return $this->Status;
	}
	protected function setStatus($Status)
	{
		$this->Status = $Status;
	}
	protected function getSendungsnummer()
	{
		return $this->Sendungsnummer;
	}
	protected function setSendungsnummer($Sendungsnummer)
	{
		$this->Sendungsnummer = $Sendungsnummer;
	}
	protected function getAbsender()
	{
		return $this->Absender;
	}
	protected function setAbsender($Absender)
	{
		$this->Absender = $Absender;
	}
	protected function getEmpfaenger()
	{
		return $this->Empfaenger;
	}
	protected function setEmpfaenger($Empfaenger)
	{
		$this->Empfaenger = $Empfaenger;
	}
	protected function getPreisstufe()
	{
		return $this->Preisstufe;
	}
	protected function setPreisstufe($Preisstufe)
	{
		$this->Preisstufe = $Preisstufe;
	}
	protected function getPreis()
	{
		return $this->Preis;
	}
	protected function setPreis($Preis)
	{
		$this->Preis = $Preis;
	}
	protected function getBilddatei()
	{
		return $this->Bilddatei;
	}
	protected function setBilddatei($Bilddatei)
	{
		$this->Bilddatei = $Bilddatei;
	}
}
?>
