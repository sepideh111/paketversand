<?php
class Paket
{
	// Attribute
	protected $Nr;
	protected $Preis;
	protected $Groesse;
	// GET- und SET-Methoden
	protected function getNr()
	{
		return $this->Nr;
	}
	protected function setNr($Nr)
	{
		$this->Nr = $Nr;
	}
	protected function getPreis()
	{
		return $this->Preis;
	}
	protected function setPreis($Preis)
	{
		$this->Preis = $Preis;
	}
	protected function getGroesse()
	{
		return $this->Groesse;
	}
	protected function setGroesse($Groesse)
	{
		$this->Groesse = $Groesse;
	}
}
?>
