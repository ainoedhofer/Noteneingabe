<?php
	session_start();
	session_regenerate_id();

	if (empty($_SESSION['login'])) {
		header('Location: http://' . $_SERVER['HTTP_HOST'] . '/Eingabeseite/index.php');
		exit;
	} else {
		$login_status = 'Sie sind als ' . htmlspecialchars($_SESSION['user']['username']) . ' angemeldet. <a href="./logout.php">beenden</a>';
	} 
        
?>
