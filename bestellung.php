<hr>
<?php
	// Zufallszeit ausgeben
	$timearray[0] = 20;
	$timearray[1] = 30;
	$timearray[2] = 40;
	$timearray[3] = 50;
	$timearray[4] = 60;
	$timearray[5] = 70;
	echo '
		<div class="alert alert-success" role="alert">
		  Bestellung abgeschickt. - Die Lieferzeit beträgt '.$timearray[rand(0,5)].' Minuten
		</div>
	';
	
	$kundeq = query("SELECT * FROM kunde WHERE ID=" . $_SESSION['ID'] . "");
    $kunde = mysql_fetch_array($kundeq);
	
	// adresse
	echo '
		<table id="benutzer" class="table" width="100%">
		<thead>
			<tr>
			  <th colspan="2" scope="col">Adresse</th>
			</tr>
		  </thead>
          <tr>
            <td width="30%">Vorname: </td>
            <td width="75%">'.$kunde['vorname'].'</td>
          </tr>
          <tr>
            <td width="30%">Nachname: </td>
            <td width="75%">'.$kunde['nachname'].'</td>
          </tr>
          <tr>
            <td width="30%">Strasse / Hausnummer: </td>
            <td width="75%">'.$kunde['strasse'].' '.$kunde['hausnummer'].'</td>
          </tr>
          <tr>
            <td width="30%">PLZ / Ort: </td>
            <td width="75%">'.$kunde['plz'].' '.$kunde['stadt'].'</td>
          </tr>
          <tr>
            <td width="30%">Telefon: </td>
            <td width="75%">'.$kunde['telefon'].'</td>
          </tr>
		  <tr>
            <td width="30%">E-Mail: </td>
            <td width="75%">'.$kunde['email'].'</td>
          </tr>
		  <tr>
			<td colspan="2" ><a href="http://localhost:8080/"><button class="btn btn-dark btn-block" type="submit" >Zurück zur Auswahl</button></a></td>
		  </tr>
        </table>
	';
	
	// destory session
	session_destroy();
?>
<hr>