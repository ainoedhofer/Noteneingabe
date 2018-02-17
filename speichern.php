<?php require_once './auth.php'; 
require_once './Verbindung.php';
			$mysqli = new Verbindung(); // Eine neue Datenbankverbindung aufbauen
			if ($mysqli->getVerbindung()->connect_error) {
				$message['error'] = 'Datenbankverbindung fehlgeschlagen: '. $mysqli->getVerbindung()->connect_error;
			} else {
				/**
				 * Bearbeiten der Formularabgabe für die Unterstufe
				 */
				if($_POST['seite'] === "Unterstufe.php")
				{
					if(isset($_POST['fach'])) //Klasse mit Fach
					{
						foreach($_POST['Data'] as $dataItem)
						{
							// Daten in die Datenbank einspielen.
							$query = "UPDATE `noten` SET `Note`='".trim($dataItem['NOTEGes'])."',`Fehlstunden`=".trim($dataItem['FstdGes']).",`FehlstundenUnentschuldigt`=".trim($dataItem['Ue.Ges']).", `KL1.Q`='".trim($dataItem['KL1.Q'])."',`KL2.Q`='".trim($dataItem['KL2.Q'])."',`KLGes`='".trim($dataItem['KLGes'])."',`SOMI1.Q`='".trim($dataItem['SOMI1.Q'])."', `SOMI2.Q`='".trim($dataItem['SOMI2.Q'])."',`SOMIGes`='".trim($dataItem['SOMIGes'])."',`Fstd1.Q`=".trim($dataItem['Fstd1.Q']).",`Fstd2.Q`=".trim($dataItem['Fstd2.Q']).",`Ue.1.Q`=".trim($dataItem['Ue.1.Q']).",`Ue.2.Q`=".trim($dataItem['Ue.2.Q'])." WHERE `Nachname` = '".$dataItem['Nachname']."' AND `Vorname` = '".$dataItem['Vorname']."' AND `Geburtsdatum` = '".$dataItem['GebDatum']."' AND `Fachlehrer` = '".$_POST['Fachlehrer']."' AND `Kursart` = '".$dataItem['Kursart']."' AND `Fach` = '".$_POST['fach']."' AND `Klasse` = '".$_POST['klasse']."'";
							if($mysqli->getVerbindung()->query($query))
							{
								// Kein Fehler
							}
							else
							{
								echo mysqli_errno($mysqli->getVerbindung()) . ": " . mysqli_error($mysqli->getVerbindung()) . "\n";
							}
						}
						$query = "UPDATE `users` SET `letzteAenderung`= '".date('Y-m-d')."' WHERE `username`= '".$_POST['Fachlehrer']."'";
						$mysqli->getVerbindung()->query($query);
						$mysqli->getVerbindung()->close();
					}
					else //Kurs
					{
						foreach($_POST['Data'] as $dataItem)
						{
						
							$query = "UPDATE `noten` SET `Note`='".trim($dataItem['NOTEGes'])."',`Fehlstunden`=".trim($dataItem['FstdGes']).",`FehlstundenUnentschuldigt`=".trim($dataItem['Ue.Ges']).", `KL1.Q`='".trim($dataItem['KL1.Q'])."',`KL2.Q`='".trim($dataItem['KL2.Q'])."',`KLGes`='".trim($dataItem['KLGes'])."',`SOMI1.Q`='".trim($dataItem['SOMI1.Q'])."', `SOMI2.Q`='".trim($dataItem['SOMI2.Q'])."',`SOMIGes`='".trim($dataItem['SOMIGes'])."',`Fstd1.Q`=".trim($dataItem['Fstd1.Q']).",`Fstd2.Q`=".trim($dataItem['Fstd2.Q']).",`Ue.1.Q`=".trim($dataItem['Ue.1.Q']).",`Ue.2.Q`=".trim($dataItem['Ue.2.Q'])." WHERE `Nachname` = '".$dataItem['Nachname']."' AND `Vorname` = '".$dataItem['Vorname']."' AND `Geburtsdatum` = '".$dataItem['GebDatum']."' AND `Fachlehrer` = '".$_POST['Fachlehrer']."' AND `Kursart` = '".$dataItem['Kursart']."' AND `Kurs` = '".$_POST['kurs']."'";
							if($mysqli->getVerbindung()->query($query))
							{
								// Kein Fehler
							}
							else
							{
								echo mysqli_errno($mysqli->getVerbindung()) . ": " . mysqli_error($mysqli->getVerbindung()) . "\n";
							}
						}
						$query = "UPDATE `users` SET `letzteAenderung`= '".date('Y-m-d')."' WHERE `username`= '".$_POST['Fachlehrer']."'";
						$mysqli->getVerbindung()->query($query);
						$mysqli->getVerbindung()->close();
					}
				}
				else //Oberstufe und Kurse
				{
					foreach($_POST['Data'] as $dataItem)
				    {
					
						$query = "UPDATE `noten` SET `Note`='".trim($dataItem['NOTEGes'])."',`Fehlstunden`=".trim($dataItem['FstdGes']).",`FehlstundenUnentschuldigt`=".trim($dataItem['Ue.Ges']).", `KL1.Q`='".trim($dataItem['KL1.Q'])."',`KL2.Q`='".trim($dataItem['KL2.Q'])."',`KLGes`='".trim($dataItem['KLGes'])."',`SOMI1.Q`='".trim($dataItem['SOMI1.Q'])."', `SOMI2.Q`='".trim($dataItem['SOMI2.Q'])."',`SOMIGes`='".trim($dataItem['SOMIGes'])."',`Fstd1.Q`=".trim($dataItem['Fstd1.Q']).",`Fstd2.Q`=".trim($dataItem['Fstd2.Q']).",`Ue.1.Q`=".trim($dataItem['Ue.1.Q']).",`Ue.2.Q`=".trim($dataItem['Ue.2.Q'])." WHERE `Nachname` = '".$dataItem['Nachname']."' AND `Vorname` = '".$dataItem['Vorname']."' AND `Geburtsdatum` = '".$dataItem['GebDatum']."' AND `Fachlehrer` = '".$_POST['Fachlehrer']."' AND `Kursart` = '".$dataItem['Kursart']."' AND `Kurs` = '".$_POST['kurs']."' AND `Klasse` = '".$_POST['klasse']."'";
						if($mysqli->getVerbindung()->query($query))
						{
							// Kein Fehler
						}
						else
						{
							echo mysqli_errno($mysqli->getVerbindung()) . ": " . mysqli_error($mysqli->getVerbindung()) . "\n";
						}
					}
					$query = "UPDATE `users` SET `letzteAenderung`= '".date('Y-m-d')."' WHERE `username`= '".$_POST['Fachlehrer']."'";
					$mysqli->getVerbindung()->query($query);
					$mysqli->getVerbindung()->close();
				}				
			}	
			if($_POST['seite'] === "Unterstufe.php")
			{
				if(isset($_POST['fach']))
				{
					header('Location: http://' . $_SERVER['HTTP_HOST'] . '/Eingabeseite/'.$_POST['seite'].'?klasse='.$_POST['klasse'].'&fach='.$_POST['fach']);
				}
				else
				{
					header('Location: http://' . $_SERVER['HTTP_HOST'] . '/Eingabeseite/'.$_POST['seite'].'?kurs='.$_POST['kurs']);
				}
			}
			else
			{
				header('Location: http://' . $_SERVER['HTTP_HOST'] . '/Eingabeseite/'.$_POST['seite'].'?klasse='.$_POST['klasse'].'&kurs='.$_POST['kurs']);
			}
?>
