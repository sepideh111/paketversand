<?php
class Status
{
	// Attribute
	protected $StatusNr;
	protected $Statusbeschreibung;
	protected $Ende;
	// GET- und SET-Methoden
	protected function getStatusNr()
	{
		return $this->StatusNr;
	}
	protected function setStatusNr($StatusNr)
	{
		$this->StatusNr = $StatusNr;
	}
	protected function getStatusbeschreibung()
	{
		return $this->Statusbeschreibung;
	}
	protected function setStatusbeschreibung($Statusbeschreibung)
	{
		$this->Statusbeschreibung = $Statusbeschreibung;
	}
	protected function getEnde()
	{
		return $this->Ende;
	}
	protected function setEnde($Ende)
	{
		$this->Ende = $Ende;
	}
}
?>
