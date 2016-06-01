<?php
session_start();
ob_start();

$admin_name=$_SESSION['uname'];
$dbn =$_POST["dbn"];
$tn=$_POST["tn"];
$cols=$_POST["cols"];


try
{
$con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz") or die("Error connecting");
$a="'".$admin_name."'";
$u ="'".$dbn."'";
$t = "'".$tn."'";
$col = "'".$cols."'";


$s = "UPDATE table_view_control SET table_rows = $col WHERE table_name = $t and admin_name=$a;";

$r = pg_query($con,$s);
}
catch (Exception $e)
{
	echo 'Error: ',  $e->getMessage(), "\n";
		
}
header("Location:view_control.php");




?>