<hr>
<?php
// nach dem submit der anmeldung
if(isset($_GET['send'])){
	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);
    
    $sth = query("SELECT * FROM `kunde` WHERE (email like '".$username."' or username = '".$username."') and password like '".$password."'");
    $user = mysql_fetch_array($sth);
        
    //Überprüfung des Passworts
    if ($user !== false && $user[10] == $password) {
        $_SESSION['ID'] = $user[0];
        die(header('Location: http://localhost:8080/index.php?site=bestellung'));
    } else {
        $errormessage = 'Zugangsdaten sind ungültig!';
    }
   
}

// Fehlermeldung
if(isset($errormessage)) {
    echo '<div class="alert alert-danger" role="alert">'.$errormessage.'</div>';
}

// anmeldungsform
echo '
<form method="post" action="index.php?site=anmelden&send=1" id="post" name="post" enctype="multipart/form-data" ">
<table id="bestellung" class="table" width="100%">
  <tr>
	<td width="30%">Benutzername / Email</td>
	<td width="75%"><input type="text" name="username" size="35" autofocus autocomplete="off" /></td>
  </tr>
  <tr>
	<td width="25%">Passwort</td>
	<td width="75%"><input type="password" name="password" size="35" value=""/></td>
  </tr>
  <tr>
	<td colspan="2" >&nbsp;</td>
  </tr>
  <tr>
	<td colspan="2" ><button class="btn btn-danger btn-block" type="submit" >Anmelden</button></td>
  </tr>
</table>
</form>';

?>
<hr>