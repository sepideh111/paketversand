<?php
class Mitarbeiter
{
	// Attribute
	protected $MitarbeiterNr;
	protected $Vorname;
	protected $Name;
	protected $Login;
	protected $Passwort;
	// GET- und SET-Methoden
	protected function getMitarbeiterNr()
	{
		return $this->MitarbeiterNr;
	}
	protected function setMitarbeiterNr($MitarbeiterNr)
	{
		$this->MitarbeiterNr = $MitarbeiterNr;
	}
	protected function getVorname()
	{
		return $this->Vorname;
	}
	protected function setVorname($Vorname)
	{
		$this->Vorname = $Vorname;
	}
	protected function getName()
	{
		return $this->Name;
	}
	protected function setName($Name)
	{
		$this->Name = $Name;
	}
	protected function getLogin()
	{
		return $this->Login;
	}
	protected function setLogin($Login)
	{
		$this->Login = $Login;
	}
	protected function getPasswort()
	{
		return $this->Passwort;
	}
	protected function setPasswort($Passwort)
	{
		$this->Passwort = $Passwort;
	}
}
?>
