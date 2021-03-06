<?php
require_once './Verbindung.php';

if (isset($_SESSION['login'])) {
	header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
} else {
	
	if (!empty($_POST)) {
		if (
			empty($_POST['f']['username']) ||
			empty($_POST['f']['password'])
		) {
			$message['error'] = 'Es wurden nicht alle Felder ausgefüllt.';
		} else {
			$mysqli = new Verbindung(); // Eine neue Datenbankverbindung aufbauen
			if ($mysqli->getVerbindung()->connect_error) {
				$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->getVerbindung()->connect_error;
			} else {
				$query = sprintf(
					"SELECT username, password, admin, klassenlehrer FROM users WHERE username = '%s'",
					$mysqli->getVerbindung()->real_escape_string($_POST['f']['username'])
				);
				$result = $mysqli->getVerbindung()->query($query);
				if ($result != NULL) {
                                        $row = $result->fetch_array(MYSQLI_ASSOC);
					if ($row['password'] == $_POST['f']['password']) {
						session_start();
						if($row['admin'] == 1)
						{
							$_SESSION = array(
								'login' => true,
								'admin' => true,
								'user'  => array(
									'username'  => $row['username']
								),
								'klassaenlehrer' => $row['klassenlehrer']
							);
						}
						else
						{
							$_SESSION = array(
								'login' => true,
								'admin' => false,
								'user'  => array(
									'username'  => $row['username']
								),
								'klassaenlehrer' => $row['klassenlehrer']
							);
						}
						$message['success'] = 'Anmeldung erfolgreich, <a href="index.php">weiter zum Inhalt.';
						$login_status = 'Sie sind als ' . htmlspecialchars($_SESSION['user']['username']) . ' angemeldet. <a href="./logout.php">beenden</a>';
					} else {
						$message['error'] = 'Das Kennwort ist nicht korrekt.';
					}
				} else {
					$message['error'] = 'Der Benutzer wurde nicht gefunden.'.$result->num_rows.'test'.$query;
				}
				$mysqli->getVerbindung()->close();
			}
		}
                //header('Location: http://' . $_SERVER['HTTP_HOST'] . '/Eingabeseite/index.php');
	} else {
		$message['notice'] = 'Geben Sie Ihre Zugangsdaten ein um sich anzumelden.<br />';
	}
}
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
				<li><a href="Oberstufe.php">Oberstufe</a></li>
				<li><a href="Unterstufe.php">Unterstufe</a></li>
				<li><a href="#" class="active">Anmeldung</a></li>
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
		<div class="left-col-content-login">
			<div class="left-col-content-title">
				<h1>Hier bitte anmelden</h1>
			</div>
			<br/>
			<form action="./LogIn.php" method="post">
<?php if (isset($message['error'])): ?>
			<fieldset class="error"><legend>Fehler</legend><?php echo $message['error'] ?></fieldset>
<?php endif;
	if (isset($message['success'])): ?>
			<fieldset class="success"><legend>Erfolg</legend><?php echo $message['success'] ?></fieldset>
<?php endif;
	if (isset($message['notice'])): ?>
			<fieldset class="notice"><legend>Hinweis</legend><?php echo $message['notice'] ?></fieldset>
<?php endif; ?>
			<fieldset>
				<legend>Benutzerdaten</legend><br/>
				<div><label for="username">Benutzername</label><br/>
					<input type="text" name="f[username]" id="username"<?php 
					echo isset($_POST['f']['username']) ? ' value="' . htmlspecialchars($_POST['f']['username']) . '"' : '' ?> /></div><br/>
				<div><label for="password">Kennnwort</label> <br/><input type="password" name="f[password]" id="password" /></div><br/>
			</fieldset>
			<fieldset>
				<div><input type="submit" name="submit" value="Anmelden" /></div>
			</fieldset>
		</form>
		</div>
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
