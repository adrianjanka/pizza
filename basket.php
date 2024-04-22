<?php

//// START WARENKORB  
echo '<table  width="100%" border="0" cellspacing="2" cellpadding="5">
       <tr>
        <td width="5%">&nbsp;</td>
        <td width="30%">Artikel</td>
        <td width="20%">Preis</td>
        <td width="35%">Editieren</td>
       </tr>';
 
// Nur wenn bereits ein Produkt in den Warenkorb geschoben wurde                                
if(isset($_SESSION['bestell_ID'])){

      // Ausgabe aller Produkte im Warenkorb
      $produktq = query("(SELECT
				produktzubestellung.ID AS produktzubestellID,
				produkt.ID,
				'' AS kat_name,
				produkt.name AS produkt,
				size.size,
				size.name AS groesse,
				size.def_preis,
				COUNT(produktzubestellung.produkt_ID) AS anzahl,
				SUM(produktpreis.preis) AS summe
				
				FROM produktzubestellung, produkt, produktpreis, size
				WHERE produktzubestellung.bestell_ID = '".$_SESSION['bestell_ID']."'
				AND produktzubestellung.produkt_ID = produkt.ID
				AND produkt.ID = produktpreis.produkt_ID
				AND produktpreis.size = size.size
				AND size.size = produktzubestellung.size
				AND size.size = produktpreis.size
				GROUP BY produktpreis.ID)
				
				UNION
				
				(SELECT produktzubestellung.ID AS produktzubestellID, 
				produkt.ID,
				produktkat.name AS kat_name,
				produkt.name AS produkt,
				size.size,
				size.name AS groesse,
				size.def_preis,
				1 AS anzahl,
				def_preis + SUM(belagpreis.preis) AS summe
				
				FROM produktzubestellung, produkt, produktkat,
				size, belagzuprodukt, belag, belagpreis
				
				WHERE produktzubestellung.bestell_ID = '".$_SESSION['bestell_ID']."'
				AND produktzubestellung.produkt_ID = produkt.ID
				AND produkt.ID = belagzuprodukt.produkt_ID
				AND belagzuprodukt.belag_ID = belag.ID
				AND belag.value = belagpreis.value
				AND belagpreis.size = size.size
				AND produktzubestellung.size = size.size
				AND produkt.kat_ID = produktkat.ID
				AND produktkat.ID = size.produktkat_ID
				
				GROUP BY produktzubestellung.ID)
				
				ORDER BY produktzubestellID");
        
        $bestellsumme = 0; // Gesamtsumme
        while($produkt = mysql_fetch_array($produktq)){
          
          echo '<tr>
                  <td>'.$produkt['anzahl'].'x</td>
                  <td>'.$produkt['kat_name'].' ' . $produkt["produkt"] . ' - ' . $produkt["groesse"];
              
//// START EDIT         
         // Produkt hinzufuegen / löschen
         echo'</td> 
              <td>' . round($produkt['summe']) . ' CHF</td>
              <td><a href="index.php?site=category&action=add&produkt='.$produkt['ID'].'&size='.$produkt['size'].'"><img src="img/add.png" width="14" height="14" alt="add" /></a>&nbsp;
                  <a href="index.php?site=category&action=sub&produkt='.$produkt['produktzubestellID'].'"><img src="img/minus.png" width="14" height="14" alt="minus" /></a>&nbsp;';
				  
           echo'</tr>';
    
      $bestellsumme += round($produkt['summe']);  // bestellsumme ist die summe aller Produkte plus extras
    }
    $_SESSION['bestellsumme'] = round($bestellsumme);   // bestellsumme wird in die sessin gespeichert
    if(round($bestellsumme) > 0){ // anzeige nur wenn ein produkt ausgwählt wird
		echo '<tr> <td colspan="2" align="right">summe: </td> <td>' . round($bestellsumme) . ' CHF</td>';
		echo '<td><a href="index.php?site=user" ><button class="btn btn-outline-danger">bestellen</button></a></td></tr>';
	}
}
else{            
  echo '<tr>
          <td colspan="4">keine Artikel im Warenkorb</td>
        </tr>';
}    
echo '</table>';



?>