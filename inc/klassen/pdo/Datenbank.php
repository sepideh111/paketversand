<?php
namespace klassen\pdo;
class Datenbank
{
	// Attribute
	public $host="localhost";
	public $port=3306;
	public $dbname="paketversand";
	public $user="root";
	public $kennwort="";
	public $db_objekt;	// PDO Objekt		
	
	################################################################################################
	// Magische Methoden
	public function __construct()
	{
		$this->verbindung_herstellen();
		#echo "<h1>PDO</h1>";
	}	
	################################################################################################
	
	// Methoden
	protected function verbindung_herstellen()
	{
		$this->db_objekt = new \PDO("mysql:host=".$this->host."; dbname=".$this->dbname.";port:".
									$this->port."",$this->user, $this->kennwort,
									
									array
									(
										\PDO::ATTR_ERRMODE 					=> \PDO::ERRMODE_WARNING,
										\PDO::ATTR_DEFAULT_FETCH_MODE 		=> \PDO::FETCH_ASSOC,
										\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY 	=> true,
										\PDO::MYSQL_ATTR_INIT_COMMAND 		=> "SET NAMES utf8"
									)
								);
	}	
	
	public function abfrage_ausfuehren($sql, $array = array())
	{
		#$antwort = $this->db_objekt->query($sql);
		#return $antwort;
		$antwort = $this->db_objekt->prepare($sql); // Befehl ohne Daten vorbereiten
		$antwort->execute($array); // Daten in den Befehl füllen
		return $antwort;
	}
	
	public function sql_insert($sql, $array = array())
	{
		$antwort = $this->abfrage_ausfuehren($sql, $array);
		return $this->db_objekt->lastInsertId();
	}	
	
	public function sql_update($sql, $array = array())
	{
		$antwort = $this->abfrage_ausfuehren($sql, $array);
		if($antwort->rowCount() == 0)
		{
			return "Update fehlgeschlagen: ".$antwort->rowCount()." Datensätze aktualisiert";
		}
		else
		{
			return "Update erfolgreich: ".$antwort->rowCount()." Datensätze aktualisiert";
		}		
	}
	
	public function sql_delete($sql, $array = array())
	{
		$antwort = $this->abfrage_ausfuehren($sql, $array);
		if($antwort->rowCount() == 0)
		{
			return "Delete fehlgeschlagen: ".$antwort->rowCount()." Datensätze gelöscht";
		}
		else
		{
			return "Delete erfolgreich: ".$antwort->rowCount()." Datensätze gelöscht";
		}		
	}
	
	public function sql_select($sql, $array = array())
	{
		$antwort = $this->abfrage_ausfuehren($sql, $array);
		$daten = $antwort->fetchAll(); // alle Datensätze
		return $daten;
	}	
	
}


#############################################
/*
$db = new Datenbank();

$insert_id = $db->sql_insert("insert into mitarbeiter (name, vorname) values ('Mustermann','Max');");
echo "<h1>Insert: $insert_id</h1>";

echo "<hr />";
echo $db->sql_update("update mitarbeiter set vorname='Fritz'");

echo "<hr />";
echo "<pre>";
print_r($db->sql_select("select * from mitarbeiter"));
echo "</pre>";

echo "<hr />";
echo $db->sql_delete("delete from mitarbeiter");
*/
?>