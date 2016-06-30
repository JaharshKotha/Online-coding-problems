<?php
session_start();
ob_start();

$admin_name=$_SESSION['uname'];
$dbn =$_POST["databna"];
$tn=$_POST["tabna"];
$cols=$_POST["colna"];

try
{
$con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz") or die("Error connecting");
$a="'".$admin_name."'";
$u ="'".$dbn."'";
$t = "'".$tn."'";
$col = "'".$cols."'";

$s = "delete from filters where dbname=$u and tablename=$t and colname=$col and admin_uname=$a;";

$r = pg_query($con,$s);
}
catch (Exception $e)
{
	echo 'Error: ',  $e->getMessage(), "\n";
		
}
header("Location:view_control.php");




?>