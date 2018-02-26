<?php
require_once './auth.php';
require_once './Verbindung.php';

$mysqli = new Verbindung(); // Eine neue Datenbankverbindung aufbauen
if ($mysqli->getVerbindung()->connect_error) {
	$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->getVerbindung()->connect_error;
} 
else {
	$query = "SELECT * FROM noten WHERE ";
	$result = $mysqli->getVerbindung()->query($query);
}
?>
