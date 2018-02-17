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
				<li><a href="Oberstufe.php" >Oberstufe</a></li>
				<li><a href="#" class="active">Unterstufe</a></li>
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
								if(isset($_GET['fach']))
								{
									echo("-");
									echo $_GET['fach'];
								}
							}
							else if(isset($_GET['kurs']))
							{
								echo $_GET['kurs'];
							}
						  
					?>
					</h1>
						<div class="left-col-content">
							<?php
							/**
							 * Über die GET-Paramter klasse und kurs werden die für den angemeldeten
							 * Benutzer relevanten Klassen und Kurse aus der Datenbank geholt.
							 * Diese werden dann auf der linken Seite angezeigt.
							 */
								if(isset($_GET['klasse']) || isset($_GET['kurs']))
								{
									$mysqli = new Verbindung(); // Eine neue Datenbankverbindung aufbauen
									$mysqli->getVerbindung()->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
									if ($mysqli->getVerbindung()->connect_error) {
										$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->getVerbindung()->connect_error;
									} 
									else {
										// Wenn das Fach gesetzt ist, wird die Klasse mit abgefragt
										if(isset($_GET['fach']))
										{
											$query = "SELECT * FROM `noten` WHERE `Fachlehrer` = '".$_SESSION['user']['username']."' AND `Klasse` = '".$_GET['klasse']."' AND `Fach` = '".$_GET['fach']."' ";
										}
										// Wenn der Kurs gesetzt ist, wird nur dieser abgefragt
										if(isset($_GET['kurs']))
										{
											$query = "SELECT * FROM `noten` WHERE `Fachlehrer` = '".$_SESSION['user']['username']."' AND `Kurs` = '".$_GET['kurs']."'";
										}
									$result = $mysqli->getVerbindung()->query($query);
									}
									/** Die Ausgaben werden mit einem Formular gekapselt, um die Eingaben zu speichern. Der Benutzer muss also 
									 * 	aktiv auf "speichern" klicken, damit die Daten in der Datenbank gespeichert werden!
									 */
									echo "<form action=\"speichern.php\" method=\"post\">";
									
									// schaut in der DB nach, ob der Benutzer Klassenlehrer der Klasse ist. Wenn ja, können Fehlstunden eingetragen werden.									
									if($_SESSION['user']['klassenlehrer'] === $_GET['klasse'])
									{
										echo "<table><tr><td width=\"25%\">Vorname</td><td width=\"25%\">Nachname</td><td>Kursart</td><td>NOTE Ges</td><td>Fstd Ges</td><td>Ue. Ges</td></tr>";
										$i = 0;
										while($item = mysqli_fetch_row($result)) {
											echo "<tr><td><input name=\"Data[".$i."][Vorname]\" value=\"".$item[2]."\" style=\"width:95%;\" readonly/></td><td><input name=\"Data[".$i."][Nachname]\" value=\"".$item[1]."\" style=\"width:95%;\" readonly/></td><td><input name=\"Data[".$i."][Kursart]\" value=\"".$item[8]."\" style=\"width:70%;\" readonly/></td><td><input name=\"Data[".$i."][NOTEGes]\" value=\"".$item[10]."\" /></td><td><input name=\"Data[".$i."][FstdGes]\" value=\"".$item[18]."\" /></td><td><input name=\"Data[".$i."][Ue.Ges]\" value=\"".$item[19]."\" /></td></tr>";
											echo "<input name=\"Data[".$i."][GebDatum]\" value=\"".$item[3]."\" type=\"hidden\" />";
											$i = $i + 1;
										}
									}
									else
									{
										echo "<table><tr><td width=\"25%\">Vorname</td><td width=\"25%\">Nachname</td><td>Kursart</td><td>NOTE Ges</td></tr>";
										$i = 0;
										while($item = mysqli_fetch_row($result)) {
											echo "<tr><td><input name=\"Data[".$i."][Vorname]\" value=\"".$item[2]."\" style=\"width:95%;\" readonly/></td><td><input name=\"Data[".$i."][Nachname]\" value=\"".$item[1]."\" style=\"width:95%;\" readonly/></td><td><input name=\"Data[".$i."][Kursart]\" value=\"".$item[8]."\" style=\"width:70%;\" readonly/></td><td><input name=\"Data[".$i."][NOTEGes]\" value=\"".$item[10]."\" /></td></tr>";
											echo "<input name=\"Data[".$i."][GebDatum]\" value=\"".$item[3]."\" type=\"hidden\" />";
											$i = $i + 1;
										}
									}
									
									/** 
									 * Die nächsten Angaben dienen der Weiterleitung und differenzierung der Eingaben auf den weiteren
									 * verarbeitenden Seiten. Gemeint ist hier der Aufruf des speicherns, welcher in speichern.php landet.
									 */
									echo "<input name=\"seite\" value=\"Unterstufe.php\" type=\"hidden\" />";
									if(isset($_GET['kurs'])){echo "<input name=\"kurs\" value=\"".$_GET['kurs']."\" type=\"hidden\" />";}
									if(isset($_GET['klasse'])){echo "<input name=\"klasse\" value=\"".$_GET['klasse']."\" type=\"hidden\" />";}
									if(isset($_GET['fach'])){echo "<input name=\"fach\" value=\"".$_GET['fach']."\" type=\"hidden\" />";}
									echo "<input name=\"Fachlehrer\" value=\"".$_SESSION['user']['username']."\" type=\"hidden\" />";
									echo "</table> <p style=\"width:100%;\"> <input type=\"submit\" value=\"Noten speichern\" style=\"width:100%;\"/></p> </form>";							
								}	
								else {
									echo "<p>Bitte einen Kurs oder eine Klasse auf der rechten Seite auswählen!</p>";
								}
								$mysqli->getVerbindung()->close();
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
					 * Das Submenü wird an der rechten Seite angezeigt und stellt die Klassen- und Kursnavigation dar.
					 */
					$mysqli = new Verbindung(); // Eine neue Datenbankverbindung aufbauen
					if ($mysqli->getVerbindung()->connect_error) {
						$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->getVerbindung()->connect_error;
					} 
					else {
						$query1 = "SELECT `Fach`, `Klasse` FROM `noten` WHERE `Fachlehrer` = '".$_SESSION['user']['username']."' AND Klasse != 'Q2' AND Klasse != 'Q1' AND Klasse != 'EFA' AND Klasse != 'EFB' AND Klasse != 'EFC' AND Klasse != 'EFD' AND Klasse != 'EFE' AND Klasse != 'EFF' AND (`Kurs` != NULL OR `Kurs` != 'NULL') GROUP BY `Fach`, `Klasse`";
						$result1 = $mysqli->getVerbindung()->query($query1);
						
						// Es werden alle Klassen für den Benutzer angezeigt
						foreach($result1 as $dataItem)
						{
							//Die Auswahl der Klasse wird mittlens GET-Variable übergeben
							echo '<li><a href="Unterstufe.php?klasse='.$dataItem['Klasse'].'&fach='.$dataItem['Fach'].'">'.$dataItem['Klasse']."-".$dataItem['Fach'].'</a></li>';
						}
						
						// Es werden alle Kurse für den Benutzer angezeigt
						$query2 = "SELECT Distinct `Kurs` FROM `noten` WHERE `Fachlehrer` = '".$_SESSION['user']['username']."' AND Klasse != 'Q2' AND Klasse != 'Q1' AND Klasse != 'EFA' AND Klasse != 'EFB' AND Klasse != 'EFC' AND Klasse != 'EFD' AND Klasse != 'EFE' AND Klasse != 'EFF' AND (`Kurs` != NULL OR `Kurs` != 'NULL')";
						$result2 = $mysqli->getVerbindung()->query($query2);							
						foreach($result2 as $dataItem)
						{
							//Die Auswahl der Kurse wird mittlens GET-Variable übergeben
							echo '<li><a href="Unterstufe.php?kurs='.$dataItem['Kurs'].'">'.$dataItem['Kurs'].'</a></li>';
						}
					}
					$mysqli->getVerbindung()->close();
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
