<?php
$host = "localhost";
$user = "root";
$pwd = "usbw";
$db = "pizza";
define("PREFIX", '');

// set params
date_default_timezone_set('Europe/Zurich');
error_reporting(0);
mb_internal_encoding("UTF-8");
header('content-type: text/html; charset=utf-8');

// mysql connection

mysql_connect($host, $user, $pwd);
mysql_select_db($db);

mysql_query("SET NAMES 'utf8'");

// mysql query function

$_mysql_querys = array();
function query($query="") {
	if(stristr(str_replace(' ', '', $query), "unionselect")===FALSE AND stristr(str_replace(' ', '', $query), "union(select")===FALSE){
		if(empty($query)) return false;
		$result = mysql_query($query) or die('Query failed!');
		return $result;
	}
	else die();
}

?>