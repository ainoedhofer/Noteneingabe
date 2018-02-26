<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LeistungsdatenExportieren
 *
 * @author henning
 */
class LeistungsdatenExportieren 
{
    private $inhalt = null;
    private $handle = null;
    
    public function __construct() 
    {
        $this->handle = fopen ("./Daten/nachSchild.txt", w);
        $this->inhalt = "Nachname|Vorname|Geburtsdatum|Jahr|Abschnitt|Fach|Fachlehrer|Kursart|Kurs|Note|Abiturfach|Wochenstd.|Externe Schulnr.|Zusatzkraft|Wochenstd. ZK|Jahrgang|Jahrgänge|Fehlstd.|unentsch. Fehlstd.\r\n";
    }
    
    public function addData($zeile)
    {
        $this->inhalt = $this->inhalt.$zeile;
        $this->inhalt = $this->inhalt."\r\n";
    }
    
    public function schreibenUndbeenden()
    {
        fwrite($this->handle, $this->inhalt);
        fclose($this->handle);
    }
    
    public function getFile()
    {
        header('Content-Type: txt');

        header('Content-Disposition: attachment; filename="nachSchild.txt"');

        readfile('./Daten/nachSchild.txt');
    }
}

$fileWriter = new LeistungsdatenExportieren();

require_once './authAdmin.php'; //Ist der Angemeldete Bentuzer Administrator?
require_once './Verbindung.php';

$mysqli = new Verbindung(); // Eine neue Datenbankverbindung aufbauen
if ($mysqli->getVerbindung()->connect_error) {
	$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->getVerbindung()->connect_error;
} 
else 
{
    $query = "SELECT * FROM noten";
    $result = $mysqli->getVerbindung()->query($query);
        
    while($item = $result->fetch_row()) {
        for($i=1; $i<19; $i++)
        {
            // In der Datei befinden sich Spalten in denen keine Einträge vorhanden sind. Diese werden auf NULl gesetzt.
            if($item[$i] === "NULL")
            {
                    $item[$i] = "";
            }	
	}
        $fileWriter->addData($item[1]."|".$item[2]."|".$item[3]."|".$item[4]."|".$item[5]."|".$item[6]."|".$item[7]."|".$item[8]."|".$item[9]."|".$item[10]."|".$item[11]."|".$item[12]."|".$item[13]."|".$item[14]."|".$item[15]."|".$item[16]."|".$item[17]."|".$item[18]);
    }    
    $fileWriter->schreibenUndbeenden();
    $fileWriter->getFile();
}
?>
