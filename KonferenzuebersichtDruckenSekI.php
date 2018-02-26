<?php
require_once './auth.php';
require_once './Verbindung.php';

$html = "";
$mysqli = new Verbindung(); // Eine neue Datenbankverbindung aufbauen
if ($mysqli->getVerbindung()->connect_error) {
	$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->getVerbindung()->connect_error;
} 
else {
    $mysqli->getVerbindung()->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
    $sqlKlassenSekI = 'Select Klasse From noten Where Klasse != \'Q2\' AND Klasse != \'Q1\' AND Klasse != \'EFA\' AND Klasse != \'EFB\' AND Klasse != \'EFC\' AND Klasse != \'EFD\' AND Klasse != \'EFE\' AND Klasse != \'EFF\' Group by Klasse';
    $resultKlassenSekI = $mysqli->getVerbindung()->query($sqlKlassenSekI);
    while($itemKlasse = $resultKlassenSekI->fetch_row()) {
        // Fächer auslesen
        $sqlFaecher =  'SELECT Fach From noten Where Klasse = '.$itemKlasse[0].' Group by Fach';
        $result = $mysqli->getVerbindung()->query($sqlFaecher);
        $anzahlFaecher = mysqli_num_rows($result) + 4; // Vorname, Nachname, Flst. und UeFehlstd.
        // Relevate Fächer mit Noten holen
        $sqlNotenUebersicht = 'SELECT Vorname, Nachname, ';
        while($item = $result->fetch_row()) {
            $sqlNotenUebersicht = $sqlNotenUebersicht.'GROUP_CONCAT(CASE WHEN Fach = \''.$item[0].'\' THEN Note END) AS \''.$item[0].'\',';
        }
        $sqlNotenUebersicht = substr($sqlNotenUebersicht, 0, -1);
        $sqlNotenUebersicht = $sqlNotenUebersicht.', Sum(`Fstd1.Q` + `Fstd2.Q`) as `Fstd.`, Sum(`Ue.1.Q` + `Ue.2.Q`) as `Ue. Fstd` FROM noten WHERE Klasse = '.$itemKlasse[0].' Group by Nachname, Vorname';
        
        $resultGesamt = $mysqli->getVerbindung()->query($sqlNotenUebersicht);
        
        // Tabellenheader zusammenbauen
        $html = $html.      '<p><title>Klasse: '.$itemKlasse[0].'</title></p>'
                . '<table  border="1">'
                            . '<thead>'
                            . '<tr> ';
                                $finfo = $resultGesamt->fetch_fields();
                                foreach ($finfo as $val) {
                                    if(($val->name) == "Nachname")
                                    {
                                        $html = $html. '<th width="180px">'.$val->name.'</th>';
                                    }
                                    elseif(($val->name) == "Vorname")
                                    {
                                        $html = $html. '<th width="180px">'.$val->name.'</th>';
                                    }
                                    elseif(($val->name) == "Fstd.")
                                    {
                                        $html = $html. '<th width="50px">'.$val->name.'</th>';
                                    }
                                    elseif(($val->name) == "Ue. Fstd")
                                    {
                                        $html = $html. '<th width="50px">'.$val->name.'</th>';
                                    }
                                    else
                                    {
                                        $html = $html. '<th width="30px">'.$val->name.'</th>';
                                    }
                                }                  
            $html = $html   . '</tr> '
                            . '</thead>';

        $i = 2;
        // Tabelle für die Ausgabe zusammen bauen
        while($item = $resultGesamt->fetch_row()) {
             $html = $html      . '<tr> '
                                . '<td width="180px">'.$item[0].'</td> '
                                . '<td width="180px">'.$item[1].'</td> ';
                                 while($i< ($anzahlFaecher-2)) // Fächer als Tableheader hinzufügen
                                {
                                     if($item[$i] == "NU" || $item[$i] == "" || $item[$i] == "5" || $item[$i] == "6")
                                     {
                                        $html = $html. '<td width="30px" bgcolor="#FF0000"></td>';
                                     }
                                     elseif ($item[$i] == "4") {
                                         $html = $html. '<td width="30px" bgcolor="#FFFF00">'.$item[$i].'</td>';
                                     }
                                     elseif ($item[$i] == "1") {
                                         $html = $html. '<td width="30px" bgcolor="#00FF40">'.$item[$i].'</td>';
                                     }
                                     else
                                     {
                                        $html = $html. '<td width="30px">'.$item[$i].'</td>';
                                        
                                     }
                                     $i = $i + 1;
                                     
                                }
            $html = $html       . '<td width="50px">'.$item[$anzahlFaecher-2].'</td> '
                                . '<td width="50px">'.$item[$anzahlFaecher-1].'</td> '
                            . '</tr> ';
           $i = 2;             
        }
        $html = $html. '</table>';
    }
}
//var_dump($html);
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
$pdf->AddPage('L', 'A4');
 
// Fügt den HTML Code in das PDF Dokument ein
$pdf->writeHTML($html, true, false, true, false, '');
 
//Ausgabe der PDF
 
//Variante 1: PDF direkt an den Benutzer senden:
$pdf->Output("konferenzuebersicht_SekII.pdf", 'I');
 
//Variante 2: PDF im Verzeichnis abspeichern:
//$pdf->Output(dirname(__FILE__).'/'.$pdfName, 'F');
//echo 'PDF herunterladen: <a href="'.$pdfName.'">'.$pdfName.'</a>';
 
?>
