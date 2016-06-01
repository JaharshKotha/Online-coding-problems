<?php
session_start();
ob_start();

$con_id =$_POST["con_id"];
$con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz") or die("Error connecting");
$c = "'".$con_id."'";

$s = "delete from creat_connections where con_id=$c;";
$r = pg_query($con,$s);
header("Location:admin.php");

?>