<?php
	session_start();
	session_regenerate_id();

	$trennzeichen2 = preg_quote(':'); //Hier wird das Trennzeichen neu definiert
	$regex2 = '\s*['.$trennzeichen2.']+\s*';
	$j = 0;
	
	//Eingegebene Werte in ein zweidimensionales Array einlesen
	$k = 0;
	while( list( $field, $value ) = each( $_POST )) {
		echo $field." ".$value;
		$zeile = preg_split('='.$regex2.'=u', $field);
		$datenArray[$j][0] = $zeile[0];
		$datenArray[$j][1] = $zeile[1];
		$datenArray[$j][2] = $zeile[2];
		$datenArray[$j][3] = $zeile[3];
		
		switch ($k % 3) 
				{
    			case 0:
    				$datenArray[$j][6] = $value;
        			$j = $j+1;
        			break;
    			case 1:
        			$datenArray[$j][4] = $value;
        			break;
    			case 2:
        			$datenArray[$j][5] = $value;
        			break;
				} 	
	}		
	
	//Datei Zeilenweise in ein Zweidimensionales Array einlesen.
	$datei = file('./Daten/'.strtoupper($_SESSION['user']['username']).'.txt');

	$trennzeichen = preg_quote('|'); //Hier wird das Trennzeichen neu definiert
	$regex = '\s*['.$trennzeichen.']+\s*';	
	
	for($i=0; $i<count($datei); $i++)
	{
		$zeile = $datei[$i];
		$einzelwerte = preg_split('='.$regex.'=u', $zeile);
				
		$dateiArray [$i][0] = $einzelwerte[0];
		$dateiArray [$i][1] = $einzelwerte[1];
		$dateiArray [$i][2] = $einzelwerte[2];
		$dateiArray [$i][3] = $einzelwerte[3];
		$dateiArray [$i][4] = $einzelwerte[4];
		$dateiArray [$i][5] = $einzelwerte[5];
		$dateiArray [$i][6] = $einzelwerte[6];
		$dateiArray [$i][7] = $einzelwerte[7];
		$dateiArray [$i][8] = $einzelwerte[8];
		$dateiArray [$i][9] = $einzelwerte[9];
		$dateiArray [$i][10] = $einzelwerte[10];
		$dateiArray [$i][11] = $einzelwerte[11];
		$dateiArray [$i][12] = $einzelwerte[12];
		$dateiArray [$i][13] = $einzelwerte[13];
		$dateiArray [$i][14] = $einzelwerte[14];
		$dateiArray [$i][15] = $einzelwerte[15];
		$dateiArray [$i][16] = $einzelwerte[16];
		$dateiArray [$i][17] = $einzelwerte[17];
		$dateiArray [$i][18] = $einzelwerte[18];
	}
	
	//Datenmatching
	
	for($i=0; $i<count($datenArray); $i++)
	{
		for($j=0; $j<count($dateiArray); $j++)
		{
			if(strcmp($datenArray[$i][0],$dateiArray[$j][0]) &&
				strcmp($datenArray[$i][1],$dateiArray[$j][1]) &&
				strcmp($datenArray[$i][2],$dateiArray[$j][15]) &&
				strcmp($datenArray[$i][3],$dateiArray[$j][8])) 
			{
        			$dateiArray[$j][9] = $datenArray[$i][4];
        			$dateiArray[$j][17] = $datenArray[$i][5];
        			$dateiArray[$j][18] = $datenArray[$i][6];
				} 
		}
	}
	
	
	//Array in TXT zurück schreiben.
	$fp=fopen('./Daten/'.strtoupper($_SESSION['user']['username']).'.txt', "w");
	fclose($fp);
	$fp=fopen('./Daten/'.strtoupper($_SESSION['user']['username']).'.txt', "w");
	for($i=0; $i<count($dateiArray); $i++)
	{
		for($j=0; $j<count($dateiArray); $j++)
		{
			$string = $dateiArray [$i][0]."|".$dateiArray [$i][1]."|".$dateiArray [$i][2]."|".$dateiArray [$i][3]."|".$dateiArray [$i][4]."|".$dateiArray [$i][5]."|".$dateiArray [$i][6]."|".$dateiArray [$i][7]."|".$dateiArray [$i][8]."|".$dateiArray [$i][9]."|".$dateiArray [$i][10]."|".$dateiArray [$i][11]."|".$dateiArray [$i][12]."|".$dateiArray [$i][13]."|".$dateiArray [$i][14]."|".$dateiArray [$i][15]."|".$dateiArray [$i][16]."|".$dateiArray [$i][17]."|".$dateiArray [$i][18]."\r\n";
			fwrite($fp, $string);
		}
	}
	fclose($fp);
?>        