<?php
	session_start();
	session_regenerate_id();

	if (isset($_SESSION['admin'])){
		if($_SESSION['admin'] == false) {
			header('Location: http://' . $_SERVER['HTTP_HOST'] . '/Eingabeseite/index.php');
			exit;
		}
		else
		{
			$login_status = 'Sie sind als Admin angemeldet. <a href="./logout.php">beenden</a>';
		}
	}
	else
	{
		header('Location: http://' . $_SERVER['HTTP_HOST'] . '/Eingabeseite/index.php');
		exit;
	}
?>
