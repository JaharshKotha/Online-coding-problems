<?php
session_start();
ob_start();

$mem_id =$_POST["memid"];
$con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz") or die("Error connecting");
$m = "'".$mem_id."'";

$s = "delete from login where id=$m;";
$r = pg_query($con,$s);
header("Location:admin.php");

?>