<?php
	session_start();
	session_regenerate_id();
	if (isset($_SESSION['login'])) {
		$login_status = 'Sie sind als ' . htmlspecialchars($_SESSION['user']['username']) . ' angemeldet. <a href="./logout.php">beenden</a>';
	} else {
		$login_status = 'Sie sind nicht angemeldet!';
	}
        
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
				<li><a href="#" class="active">Start</a></li>
				<li><a href="Oberstufe.php">Oberstufe</a></li>
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
					<h1>Herzlich Willkommen</h1>
						<div class="left-col-content">
						<p>
							Auf dieser Seite werden ab sofort zu jeder Konferenz die Noten eingegeben. Melden Sie sich mit ihrem Account und 
							ihrem Passwort in der Anmeldemaske unter dem Reiter "Anmeldung" an. Geben Sie anschließend im Reiter Oberstufe und/oder
							im Reiter Unterstufe ihre Noten ein. Die Navigation zwischen den Klassen gelingt über das rechte Anzeigefenster. Bei
							Fragen kann vielleicht der Reiter "Hilfe" ein erste Lösungsansätze bieten.
						</p>
						</div>
				</div>
		</div>
		<div class="right-column">
			<div class="right-col-content">
				<div class="right-col-content-title ">
					<h1>Statistik</h1>
				</div>
				<ul class="submenu">
					<li><a href="#">Anzahl bereits eingegebener Noten: <?php 
                                        
						$mysqli = new Verbindung(); // Eine neue Datenbankverbindung aufbauen
						if ($mysqli->getVerbindung()->connect_error) {
							$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->getVerbindung()->connect_error;
						} 
						else {
							$query = "SELECT Count(*) * 6 FROM noten WHERE Note != '' ";
							$result = $mysqli->getVerbindung()->query($query);
						}
						$res = mysqli_fetch_row($result);
						echo $res[0];
					?>
					</a></li>
					<li><a href="#">Bereits angemeldete Lehrer: <?php 
						$mysqli = new Verbindung(); // Eine neue Datenbankverbindung aufbauen
						if ($mysqli->getVerbindung()->connect_error) {
							$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->getVerbindung()->connect_error;
						} 
						else {
							$query = "SELECT Count(*) FROM users";
							$result = $mysqli->getVerbindung()->query($query);
						}
						$res = mysqli_fetch_row($result);
						echo $res[0];
					?>
					</a></li>
					<li><a href="#">Tage bis Abgabe: <?php 
						$mysqli = new Verbindung(); // Eine neue Datenbankverbindung aufbauen
						if ($mysqli->getVerbindung()->connect_error) {
							$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->getVerbindung()->connect_error;
						} 
						else {
							$query = "SELECT to_days(konferenzdatum) - to_days(CURDATE()) FROM konferenzdaten";
							$result = $mysqli->getVerbindung()->query($query);
						}
						$res = mysqli_fetch_row($result);
						echo $res[0];
					?>
					</a></li>
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
