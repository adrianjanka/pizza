<hr>
<?php

if(isset($_GET['action'])) {
	if($_GET['action']=="add") {

    // Kunde hinzufügen
    if(!isset($_SESSION['ID'])){
	   query("INSERT INTO ".PREFIX."kunde () values()");     // wenn nein, wird neuer Kunde generiert
	   $ID = mysql_insert_id();
	   $_SESSION['ID'] = $ID;   
    }
    // Neue Bestellung
    if(!isset($_SESSION['bestell_ID'])){ 
       $ID = $_SESSION['ID'];
       $date = date("Y-m-d"); 
       query("INSERT INTO ".PREFIX."bestellung (kunde_ID, datum) values('$ID','$date')");
       
       $bestell_ID = mysql_insert_id();
       $_SESSION['bestell_ID'] = $bestell_ID;
    }
    
    // Produkt hinzufügen
    if(isset($_GET['produkt'])){   // Produkt zur Bestellung hinzufügen
       $bestell_ID = $_SESSION['bestell_ID'];
       $produkt_ID = $_GET['produkt'];
       $size = $_GET['size'];
       
       query("INSERT INTO ".PREFIX."produktzubestellung (bestell_ID, produkt_ID, size)
	          values('$bestell_ID','$produkt_ID','$size')");
					 
       $_GET['item'] = mysql_insert_id();
    }
  }
  // Produkt wird entfernt
  elseif($_GET['action']=="sub"){
      $produktzubestell_ID = $_GET['produkt'];
	    query("DELETE FROM ".PREFIX."produktzubestellung WHERE ID='$produktzubestell_ID'");  
  }
}
  
//// Produktdaten auslesen    
echo '<table width="100%" class="table" border="0" cellspacing="1" cellpadding="3">';
							
$produktq = query("SELECT * FROM produkt WHERE kat_ID=19");

while($produkt = mysql_fetch_array($produktq)){
  echo '<tr>';
  
  echo '<td align="center"><img class="pizzaimg" src="img/pizza/'.str_replace(' ', '', $produkt["name"]).'.jpg"></td>';
  
  echo '<td><h4>'.$produkt["name"].'</h4>';
//// Preis ausgabe                   
	 $preisq = query("SELECT size.size, 
					size.name AS name, 
					size.comment AS comment, 
					size.def_preis,
					produkt.ID AS produktID, 
					belagzuprodukt.produkt_ID,
					belagzuprodukt.belag_ID,
					belag.ID,belag.value,
					belagpreis.size,
					belagpreis.value,
					belagpreis.preis, 
					size.def_preis + SUM(belagpreis.preis) AS preis
					
					FROM size,produkt,belagzuprodukt,belag,belagpreis 
					WHERE size.produktkat_ID = '19'
					AND produkt.ID = '".$produkt['ID']."'
					AND belagzuprodukt.produkt_ID = produkt.ID
					AND belag.ID = belagzuprodukt.belag_ID
					AND belagpreis.value = belag.value
					AND belagpreis.size = size.size 
					
					GROUP BY size.size
					ORDER BY preis");
	   if(mysql_num_rows($preisq)>=1){
		  echo '<span class="pizzadesc">';
		  while($preis = mysql_fetch_array($preisq)){
			echo $preis["name"].' ('.$preis["comment"].') - <a href="/index.php?site=category&catID=19&action=add&produkt='.$preis['produktID'].'&size='.$preis['size'].'">'.round($preis['preis']).' CHF&nbsp;&nbsp;<img src="img/cart.png" width="14" height="14" alt="cart" /></a><br>';
		  }
	   }
//// Zutatenausgabe
	$belagq = query("SELECT belag.name, belag.ID, belagzuprodukt.belag_ID, belagzuprodukt.produkt_ID 
					   FROM belag,belagzuprodukt 
					   WHERE belagzuprodukt.produkt_ID=" . $produkt['ID'] . "
					   AND belagzuprodukt.belag_ID = belag.ID
					   ORDER BY belag.ID");
	$limit = mysql_num_rows($belagq); 
	if($limit >= 1){
	   echo 'mit ';
	   $i = 1;
	   while($belag = mysql_fetch_array($belagq)){
		 echo $belag["name"].", ";
		 $i++;         
	   }
	}
	echo '</span>';
	echo '</td></tr>';
}

echo '</table>';

?>

<hr>