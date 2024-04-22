<?php
// datenbank verbindung
$link = mysqli_connect("localhost", "root", "usbw", "pizza");

// alle ortschaften,plz holen
if (!empty($_POST['zip'])) {
    $sql = "select placeid,placename from place where placeid like '".$_POST['zip']."%'";
} elseif (!empty($_POST['city'])) {
    $sql = "select placeid,placename from place where placename like '".$_POST['city']."%'";
} else $sql = "";

$sth = mysqli_query($link, $sql);

$arraydata = array();
$count = 0;
while($row = mysqli_fetch_object($sth)) {
    
    $arraydata[$count]['zip'] = [$row->placeid];
    $arraydata[$count]['city'] = [$row->placename];
    $count++;
}

// json an den browser 
$data = $arraydata;
header('Content-Type: application/json');
echo json_encode($data);


?>