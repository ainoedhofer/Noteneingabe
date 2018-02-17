<?php require_once './authAdmin.php'; ?>
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
				<li><a href="Oberstufe.php">Oberstufe</a></li>
				<li><a href="Unterstufe.php">Unterstufe</a></li>
				<li><a href="LogIn.php">Anmeldung</a></li>
				<li><a href="Hilfe.php">Hilfe</a></li>
				<li><a href="#" class="active">Administrator</a></li>
			</ul>
		</div>
		<div class="clearing"></div>
		<div class="logo-search-wrapper">
			<div class="logo-search-container">
				<div class="logo"> GSMA Noteneingabe: Sie sind als Admin angemeldet <a href="./logout.php">beenden</a></div>
			</div>
		</div>
	</div>
<div class="main-content-wrapper">
	<div class="left-column">
		<h1>Optionen</h1>
		<table>
				<tr>
					<td>Mit dieser Option werden die Leistungsdaten eingespielt</td>
					<td><a href="LeistungsdatenEinspielen.php"><button>Leistungsdaten einspielen</button></a></td>
				</tr>
				<tr>
					<td>Mit dieser Option wird die Konferenzübersicht erstellt</td>
					<td><a href="KonferenzueberichtDrucken.php"><button>Konferenzübericht erstellen</button></a></td>
				</tr>
				<tr>
					<td>Mit dieser Option werden alle noch fehlenden Noten angezeigt</td>
					<td><a href="FehlendeNotenAnzeigen.php"><button>Fehlende Noten anzeigen</button></a></td>
				</tr>
		</table>
	</div>
	<div class="right-column">
		<div class="right-col-content-title ">
			<h1>Termine :</h1>
		</div>
		<ul>
			<li class="under-line">
				<div class="user"><img src="images/alarm-clock--arrow.png" alt="themedemic" /></div>
				<div class="user-comments">
					<h1>Passwortausgabe :</h1>
					28.06.2017 ab 07:55 Uhr
				</div>
			</li>
			<li class="under-line">
				<div class="user"><img src="images/alarm-clock--pencil.png" alt="themedemic" /></div>
				<div class="user-comments">
					<h1>Notenabgabe :</h1>
					05.07.2017 bis 12:00 Uhr
				</div>
			</li>
			<li class="noline">
				<div class="user"><img src="images/alarm-clock--exclamation.png" alt="themedemic" /></div>
				<div class="user-comments">
					<h1>Notenkonferenzen :</h1>
					<p>Sek 1 am 08.07.2017 ab 14.00 Uhr</p>
					<p>Sek 2 am 09.07.2017 ab 14.00 Uhr</p>
				</div>
			</li>
		</ul>
	</div>
</div>
<div class="footer">
  <div class="footer-wrapper">
    <div class="footer-content">
      <h1>Vivamus Tempor Dui  Augue Porttitor Rut</h1>
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
