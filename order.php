<hr>
<?php
// nach dem absenden des registrationsformular
if(isset($_SESSION['bestellsumme'])){
    if(isset($_GET['send'])){
    	 $vorname = htmlspecialchars($_POST['vorname']);
    	 $nachname = htmlspecialchars($_POST['nachname']);
    	 $strasse = htmlspecialchars($_POST['strasse']);
    	 $hausnummer = htmlspecialchars($_POST['hausnummer']);
    	 $plz = htmlspecialchars($_POST['plz']);
    	 $stadt = htmlspecialchars($_POST['stadt']);
    	 $telefon = htmlspecialchars($_POST['telefon']);
		 $email = htmlspecialchars($_POST['email']);
		 $username = htmlspecialchars($_POST['username']);
		 $password = htmlspecialchars($_POST['password']);
		 $password2 = htmlspecialchars($_POST['password2']);
		 $error = false;
		 
		 // VALIDATION
		 
		 if ($password != $password2) {
			$error=true;
			$errormessage = "Passwörter stimmen nicht überein!";
		 }
		 
		 if (empty($password2)) {
			$error=true;
			$errormessage = "Passwort muss gesetzt sein!";
		 }
		 
		 if (empty($password)) {
			$error=true;
			$errormessage = "Passwort muss gesetzt sein!";
		 }
		 
		 if (empty($username)) {
			$error=true;
			$errormessage = "Benutzername muss gesetzt sein!";
		 }
		 
		 if (empty($email)) {
			$error=true;
			$errormessage = "Email Adresse muss gesetzt sein!";
		 }
		 
		 if (empty($telefon)) {
			$error=true;
			$errormessage = "Telefonnummer muss gesetzt sein!";
		 }
		 
		 if (empty($plz)) {
			$error=true;
			$errormessage = "Postleitzahl muss gesetzt sein!";
		 }
		 
		 if (empty($stadt)) {
			$error=true;
			$errormessage = "Ort muss gesetzt sein!";
		 }
		 
		 if (empty($hausnummer)) {
			$error=true;
			$errormessage = "Hausnummer muss gesetzt sein!";
		 }
		 
		 if (empty($strasse)) {
			$error=true;
			$errormessage = "Strasse muss gesetzt sein!";
		 }
		 
		 if (empty($nachname)) {
			$error=true;
			$errormessage = "Nachname muss gesetzt sein!";
		 }
		 
		 if (empty($vorname)) {
			$error=true;
			$errormessage = "Vorname muss gesetzt sein!";
		 }
		 
		 if (!$error) {
			 // SUCCESS FALL
			 
			 // get max_kunde_id
			 $sth = query("SELECT max(ID) from kunde");
			 $kunde = mysql_fetch_array($sth);
			 
			 $maxkunde = $kunde[0]+1;
			 
			 // kunde erfassen
			 query(
			 "INSERT INTO ".PREFIX."kunde (ID, vorname, nachname, strasse, hausnummer, plz, stadt, telefon, email, username, password)
			 VALUES (".$maxkunde.", '".$vorname."', '".$nachname."', '".$strasse."', '".$hausnummer."', '".$plz."', '".$stadt."', '".$telefon."', '".$email."', '".$username."', '".$password."');"
			 );
       
			// bestellung erfassen
			query("UPDATE ".PREFIX."bestellung SET done='0', wish='' WHERE ID=".$_SESSION['bestell_ID']." ");
			
			$_SESSION['ID'] = $maxkunde;
			die(header('Location: http://localhost:8080/index.php?site=bestellung'));
		 }
    }
} else $errormessage = 'Bestellsumme nicht gesetzt';

// fehlermeldung
if(isset($errormessage)) {
    echo '<div id="errormessage" class="alert alert-danger" role="alert">'.$errormessage.'</div>';
}

// registrationsform
echo '
	<form method="post" action="index.php?site=order&send=1" id="post" name="post" enctype="multipart/form-data" ">
	<table id="bestellung" class="table" width="100%">
	  <tr>
		<td width="30%">Vorname *</td>
		<td width="75%"><input type="text" name="vorname" size="30" value="'.$vorname.'"/></td>
	  </tr>
	  <tr>
		<td width="30%">Nachname *</td>
		<td width="75%"><input type="text" name="nachname" size="30" value="'.$nachname.'"/></td>
	  </tr>
	  <tr>
		<td width="30%">Strasse / Hausnummer *</td>
		<td width="75%">
			<input type="text" name="strasse" size="21" value="'.$strasse.'"/>
			<input type="text" name="hausnummer" size="4" value="'.$hausnummer.'"/>
		</td>
	  </tr>
	  <tr>
		<td width="30%">PLZ / Ort *</td>
		<td width="75%">
			<input type="text" name="plz" class="jq_zipcity_autocomplete jq_zip_autocomplete" size="4" value="'.$plz.'"/>
			<input type="text" name="stadt" class="jq_zipcity_autocomplete jq_city_autocomplete" size="21" value="'.$stadt.'"/>
		</td>
	  </tr>
	  <tr>
		<td width="30%">Telefon *</td>
		<td width="75%"><input type="text" name="telefon" size="30" value="'.$telefon.'"/></td>
	  </tr>
	  <tr>
		<td width="30%">E-Mail *</td>
		<td width="75%"><input type="email" name="email" size="30" value="'.$email.'"/></td>
	  </tr>
	  <tr>
		<td width="30%">Benutzername *</td>
		<td width="75%"><input type="text" name="username" size="30" value="'.$username.'"/></td>
	  </tr>
	  <tr>
		<td width="30%">Passwort *</td>
		<td width="75%"><input type="password" name="password" size="30" value=""/></td>
	  </tr>
	  <tr>
		<td width="30%">Passwort bestätigen *</td>
		<td width="75%"><input type="password" name="password2" size="30" value=""/></td>
	  </tr>
	  <tr>
		<td colspan="2"><span>* sind Mussfelder</span></td>
	  </tr>
	  <tr>
		<td colspan="2" ><button class="btn btn-danger btn-block" id="registerbutton" "type="submit" >Registrieren</button></td>
	  </tr>
	</table>
	</form>';

?>
<hr>