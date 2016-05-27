<?php
session_start();
$uname =$_POST["uname"];
$passwd=$_POST["passwd"];
$con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
$u ="'".$uname."'";
$p = "'".$passwd."'";
$s = "select *from LOGIN where uname=$u and password=$p";
$r = pg_query($con,$s);
$row = pg_fetch_array($r);
$p=trim($passwd);
$pc=trim($row[2]);
if($p==$pc)
{
	$_SESSION['uname']=$row[1];
	$_SESSION['utype']=$row[3];
	
	echo strcmp($passwd,$row[2]);

	
	header("Location:/dash.php");
	
}
else
{
	header("Location:/login.php");
	$_SESSION['login_fail']=1;
}
?>
