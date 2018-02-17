<?php 	require_once './auth.php';
		require_once './Verbindung.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Noteneingabe St. Michael Gymnasium Ahlen</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css' />
</head>
<body>
<div class="header-wrapper">
		<div class="menu">
			<ul>
				<li><a href="index.php">Start</a></li>
				<li><a href="#" class="active">Oberstufe</a></li>
				<li><a href="Unterstufe.php">Unterstufe</a></li>
				<li><a href="LogIn.php">Anmeldung</a></li>
				<li><a href="Hilfe.php">Hilfe</a></li>
				<li><a href="LogInAdminAngemeldet.php">Administrator</a></li>
			</ul>
		</div>
		<div class="clearing"></div>
		<div class="logo-search-wrapper">
			<div class="logo-search-container">
				<div class="logo"> GSMA Noteneingabe: <?php echo $login_status; ?></div>
			</div>
		</div>
	</div>
	<div class="main-content-wrapper">
		<div class="left-column">
				<div class="left-col-content-title">
					<h1>Klasse/Kurs: 
					<?php if(isset($_GET['klasse']))
							{
								echo $_GET['klasse'];
							}
					?>
					</h1>
						<div class="left-col-content">
							<?php
							/**
							 * Über die GET-Paramter klasse und kurs werden die für den angemeldeten
							 * Benutzer relevanten Klassen und Kurse aus der Datenbank geholt.
							 * Diese werden dann auf der linken Seite angezeigt. Klassen für die Oberstufe 
							 * sind Q1, Q2, EF, EFA, EFB, usw.
							 */
								if(isset($_GET['klasse']))
								{
									$mysqli = new Verbindung(); // Eine neue Datenbankverbindung aufbauen
									$mysqli->getVerbindung()->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
									if ($mysqli->getVerbindung()->connect_error) {
										$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->getVerbindung()->connect_error;
									} 
									else {
									$query = "SELECT * FROM noten WHERE Fachlehrer = '".$_SESSION['user']['username']."' AND Kurs = '".$_GET['kurs']."' AND Klasse = '".$_GET['klasse']."'";
									$result = $mysqli->getVerbindung()->query($query);
									}
									
									/** 
									 * 	Die Ausgaben werden mit einem Formular gekapselt, um die Eingaben zu speichern. Der Benutzer muss also 
									 * 	aktiv auf "speichern" klicken, damit die Daten in der Datenbank gespeichert werden!
									 */
									echo "<form action=\"speichern.php\" method=\"post\">";
									echo "<table><tr><td width=\"25%\">Vorname</td><td width=\"25%\">Nachname</td><td>Kursart</td><td>KL 1.Q</td><td>KL 2.Q</td><td>KL Ges </td><td>SOMI 1.Q</td><td>SOMI 2.Q</td><td>SOMI Ges</td><td>NOTE Ges</td><td>Fstd 1.Q</td><td>Fstd 2.Q</td><td>Fstd Ges</td><td>Ue. 1.Q</td><td>Ue. 2.Q</td><td>Ue. Ges</td></tr>";
									$i = 0;
									while($item = $result->fetch_row()) {
										echo "<tr><td><input name=\"Data[".$i."][Vorname]\" value=\"".$item[2]."\" style=\"width:95%;\" readonly/></td><td><input name=\"Data[".$i."][Nachname]\" value=\"".$item[1]."\" style=\"width:95%;\" readonly/></td><td><input name=\"Data[".$i."][Kursart]\" value=\"".$item[8]."\" style=\"width:70%;\" readonly/></td><td><input name=\"Data[".$i."][KL1.Q]\" value=\"".$item[20]."\" /></td><td><input name=\"Data[".$i."][KL2.Q]\" value=\"".$item[21]."\" /></td><td><input name=\"Data[".$i."][KLGes]\" value=\"".$item[22]."\" /></td><td><input name=\"Data[".$i."][SOMI1.Q]\" value=\"".$item[23]."\" /></td><td><input name=\"Data[".$i."][SOMI2.Q]\" value=\"".$item[24]."\" /></td><td><input name=\"Data[".$i."][SOMIGes]\" value=\"".$item[25]."\" /></td><td><input name=\"Data[".$i."][NOTEGes]\" value=\"".$item[10]."\" /></td><td><input name=\"Data[".$i."][Fstd1.Q]\" value=\"".$item[26]."\" /></td><td><input name=\"Data[".$i."][Fstd2.Q]\" value=\"".$item[27]."\" /></td><td><input name=\"Data[".$i."][FstdGes]\" value=\"".$item[18]."\" /></td><td><input name=\"Data[".$i."][Ue.1.Q]\" value=\"".$item[28]."\" /></td><td><input name=\"Data[".$i."][Ue.2.Q]\" value=\"".$item[29]."\" /></td><td><input name=\"Data[".$i."][Ue.Ges]\" value=\"".$item[19]."\" /></td></tr>";
										echo "<input name=\"Data[".$i."][GebDatum]\" value=\"".$item[3]."\" type=\"hidden\" />";
										$i = $i + 1;
									}
									
									/** 
									 * Die nächsten Angaben dienen der Weiterleitung und differenzierung der Eingaben auf den weiteren
									 * verarbeitenden Seiten. Gemeint ist hier der Aufruf des speicherns, welcher in speichern.php landet.
									 */
									echo "<input name=\"Seite\" value=\"Oberstufe.php\" type=\"hidden\" />";
									echo "<input name=\"Kurs\" value=\"".$_GET['Kurs']."\" type=\"hidden\" />";
									echo "<input name=\"Klasse\" value=\"".$_GET['Klasse']."\" type=\"hidden\" />";
									echo "<input name=\"Fachlehrer\" value=\"".$_SESSION['user']['username']."\" type=\"hidden\" />";
									echo "</table> <p style=\"width:100%;\"> <input type=\"submit\" value=\"Noten speichern\" style=\"width:100%;\"/></p> </form>";							
								}	
								else {
									echo "<p>Bitte einen Kurs oder eine Klasse auf der rechten Seite auswählen!</p>";
								}
							?>			
						</div>
				</div>
		</div>
		<div class="right-column">
			<div class="right-col-content">
				<div class="right-col-content-title ">
					<h1>Klassen &amp; Kurse</h1>
				</div>
				<ul class="submenu">
					<?php
					/**
					 * Das Submenü wird an der rechten Seite angezeigt und stellt die Kursnavigation dar.
					 */
					$mysqli = new Verbindung(); // Eine neue Datenbankverbindung aufbauen
					if ($mysqli->getVerbindung()->connect_error) {
						$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->getVerbindung()->connect_error;
					} 
					else {
						$query = "SELECT Kurs, Klasse FROM noten WHERE Fachlehrer = '".$_SESSION['user']['username']."' AND Klasse = 'Q2' OR Klasse = 'Q1' OR Klasse = 'EFA' OR Klasse = 'EFB' OR Klasse = 'EFC' OR Klasse = 'EFD' OR Klasse = 'EFE' OR Klasse = 'EFF'";
						$result = $mysqli->getVerbindung()->query($query);
						while($dataItem = $result->fetch_row())
						{
							//Die Auswahl der Kurse wird mittlens GET-Variable übergeben
							echo '<li><a href="Oberstufe.php?klasse='.$dataItem['Klasse'].'&kurs='.$dataItem['Kurs'].'">'.$dataItem['Kurs'].'-'.$dataItem['Klasse'].'</a></li>';
							
						}
					}
					?>
				</ul>
			</div>
		</div>
	</div>
<div class="footer">
  <div class="footer-wrapper">
    <div class="footer-content">
      <h1>Kontakt</h1>
      <p>&Ouml;ffnungszeiten: Montag bis Donnerstag 7.30 bis 16 Uhr und Freitag 7.30 bis 13 Uhr
      </p>
      <p>Gymnasium St. Michael, Warendorfer Str. 72 in 59227 Ahlen
      </p>
      <p>Telefon: (0 23 82) 91 56-0, Telefax: (0 23 82) 91 56-45</p>
      <p>E-Mail: gymnasiumstmichael@bistum-muenster.de, Web: www.gymnasium-sankt-michael.de
      </p>
    </div>
    <div class="subscribe">
      <h1>&Ouml;ffungszeiten</h1>
      <p>Montag bis Donnerstag 7.30 bis 16 Uhr und Freitag 7.30 bis 13 Uhr
      </p>
    </div>
  </div>
</div>
<div class="copyrights">Copyright (c) Henning Ain&ouml;dhofer. Design by Henning Ain&ouml;dhofer</div>
</body>
</html>
