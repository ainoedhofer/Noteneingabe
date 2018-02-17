<?php
require_once './auth.php';

$mysqli = new Verbindundung(); // Eine neue Datenbankverbindung aufbauen
if ($mysqli->getVerbindung()->connect_error) {
	$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->getVerbindung()->connect_error;
} 
else {
	/* Hier müssen die Daten aus der Datenbank gezogen werden.
	 * 
	 * Zu jedem Schüler müssen die Gesamtfehlstunden berechnet werden. Darüber hinaus sollten alle Noten aus dem aktuellen HJ 
	 * nach Fächern soritert angezeigt werden.
	 * 
	 * SELECT
    `Fach`,
    `Kursart`,
    `KL1.Q`,
    `KL2.Q`,
    `KLGes`,
    `SOMI1.Q`,
    `SOMI2.Q`,
    `SOMIGes`,
    `Note`
FROM
    noten
WHERE
    `Vorname` = 'Uwe'
UNION 
Select 
SUM(`Fstd1.Q`),
     SUM(`Fstd2.Q`) as 'Fstd2.Q',
     SUM(`Fehlstunden`),
     SUM(`Ue.1.Q`),
     SUM(`Ue.2.Q`),
     SUM(`FehlstundenUnentschuldigt`) From noten where `Vorname` = 'Uwe') as Summen
	 * 
	 * 
	 * */
	$query = "SELECT * FROM noten";
	$result = $mysqli->getVerbindung()->query($query);
}

$html = "<p>test</p><p>test2</p><p>Hallo!</p>";

// TCPDF Library laden
require_once('tcpdf/tcpdf.php');
 
// Erstellung des PDF Dokuments
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 
// Dokumenteninformationen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("Henning Ainödhofer");
$pdf->SetTitle("Konferenzübersicht");
$pdf->SetSubject("Konferenzübersicht");
 
 
// Header und Footer Informationen
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
// Auswahl des Font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
// Auswahl der MArgins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
// Automatisches Autobreak der Seiten
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
// Image Scale 
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
// Schriftart
$pdf->SetFont('dejavusans', '', 10);
 
// Neue Seite
$pdf->AddPage();
 
// Fügt den HTML Code in das PDF Dokument ein
$pdf->writeHTML($html, true, false, true, false, '');
 
//Ausgabe der PDF
 
//Variante 1: PDF direkt an den Benutzer senden:
$pdf->Output("konferenzuebersicht_SekII.pdf", 'I');
 
//Variante 2: PDF im Verzeichnis abspeichern:
//$pdf->Output(dirname(__FILE__).'/'.$pdfName, 'F');
//echo 'PDF herunterladen: <a href="'.$pdfName.'">'.$pdfName.'</a>';
 
?>
