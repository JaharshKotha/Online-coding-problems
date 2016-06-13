<?php
include_once("Config.php");

session_start();
ob_start();
$qMain = str_replace("'",SINGLE_QUOTES_REPLACER,$_GET['queryMain']);
$tName = $_GET['tagName'];
$tDesc = $_GET['tagDescription'];
$qCol = trim($_GET['queryColTagForm']);
$u = trim($_SESSION['uname']);

$con1 = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");

$sql = "INSERT INTO saved_query (tags, description,query ,cols,uname)VALUES ('$tName', '$tDesc','$qMain','$qCol','$u')";
//echo $sql;
pg_query($sql)
?>
