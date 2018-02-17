<?php
require_once './authAdmin.php'; //Ist der Angemeldete Bentuzer Administrator?

$mysqli = new Verbindung(); // Eine neue Datenbankverbindung aufbauen
if ($mysqli->getVerbindung()->connect_error) {
	$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->getVerbindung()->connect_error;
} 
else {
	$mysqli->getVerbindung()->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
	//speichern der TXT Daten nach der Anmeldung in der DB
	$trennzeichen = preg_quote('|'); //Hier wird das Trennzeichen definiert
	$regex = '\s*['.$trennzeichen.']+\s*';
	$daten = file('./Daten/SchuelerLeistungsdaten.dat'); //Hier wird die passende Datei geladen.
	
	//Durchlaufen aller Daten aus der Datei und speichern in der DB in Bezug zum Fachleherer
	if(isset($daten))
	{		
		for($i=1; $i<count($daten); $i++)
		{
			$zeile = $daten[$i];
			$einzelwerte = preg_split('='.$regex.'=u', $zeile);
			for($j=0; $j<count($einzelwerte); $j++)
			{
				// In der Datei befinden sich Spalten in denen keine Einträge vorhanden sind. Diese werden auf NULl gesetzt.
				if($einzelwerte[$j] === '' || $einzelwerte[$j] === ' ')
				{
					$einzelwerte[$j] = "NULL";
				}	
			}
			
			// Es werden alle Daten aus der Datei in die Datenbank geholt
			$query = "INSERT INTO `noten`(`Nachname`, `Vorname`, `Geburtsdatum`, `Jahr`, `Abschnitt`, `Fach`, `Fachlehrer`, `Kursart`, `Kurs`, `Note`, `AbiFach`, `Wochenstunden`, `Schul-Nummer`, `Zusatzkraft`, `WochenstundenZusatzkraft`, `OberstufenJahrgang`, `KursJahrgaenge`) VALUES  ('".$einzelwerte[0]."','".$einzelwerte[1]."','".$einzelwerte[2]."', ".$einzelwerte[3].",".$einzelwerte[4].",'".$einzelwerte[5]."','".$einzelwerte[6]."','".$einzelwerte[7]."','".$einzelwerte[8]."','".$einzelwerte[9]."',".$einzelwerte[10].",".$einzelwerte[11].",'".$einzelwerte[12]."','".$einzelwerte[13]."',".$einzelwerte[14].",'".$einzelwerte[15]."','".$einzelwerte[16]."') ON DUPLICATE KEY UPDATE `Nachname`='".$einzelwerte[0]."'";
			if ($mysqli->getVerbindung()->query($query) === TRUE) {
				
			} else {
				// Bei einem Fehler des Imports wird ein Fehlerprotokoll ausgegeben
				echo "Error: " . $query . "<br>" . $mysqli->getVerbindung()->error;
			}						
		}
	}
	
	/**
	 * Im nachfolgenden Abschnitt werden Informationen aus der LeisutungsdatenDatei mit der Lernabschnittsdatei
	 * verknüpft, da so viel einfacher mit der Datenbank bearbeitet werden kann. Es wird die Klasse ausgelesen und
	 * der Datenbank für den passenden Schüler (Schlüssel: Nachname, Vorname, Geburtsdatum) zugeordnet.
	 *
	 * => Achtung: mögliche Fehlerquelle falls es zwei Schüler gibt, die gleich heißen und am selben Tag 
	 * Geburtstag haben. Diese Fehlerquelle wird bisher in Kauf genommen...
	 * 
	 * Stand: Januar 2018
	 */
	$mysqli->getVerbindung()->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
	$trennzeichen = preg_quote('|'); //Hier wird das Trennzeichen definiert
	$regex = '\s*['.$trennzeichen.']+\s*';
	$daten = file('./Daten/SchuelerLernabschnittsdaten.dat'); //Hier wird die passende Datei geladen.
	
	//Durchlaufen aller Daten aus der Datei und speichern in der DB in Bezug zum Fachleherer
	if(isset($daten))
	{		
		for($i=1; $i<count($daten); $i++)
		{
			$zeile = $daten[$i];
			$einzelwerte = preg_split('='.$regex.'=u', $zeile);
			$klasse = $einzelwerte[6];
			$nachname = $einzelwerte[0];
			$vorname = $einzelwerte[1];
			$GebDatum = $einzelwerte[2];
			
			$query = "UPDATE `noten` SET `Klasse` = '".$klasse."' WHERE `Nachname`= '".$nachname."' AND `Vorname`= '".$vorname."' AND `Geburtsdatum`= '".$GebDatum."'";
			if ($mysqli->getVerbindung()->query($query) === TRUE) {
				
			} 
			else 
			{
				echo "Error: " . $query . "<br>" . $mysqli->getVerbindung()->error;
			}
		}
	}
	
	header('Location: http://' . $_SERVER['HTTP_HOST'] . '/Eingabeseite/index.php');
}
?>
