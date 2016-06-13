<?php
session_start();
ob_start();

$admin_name=$_SESSION['uname'];
$uname =$_POST["uname"];
$passwd=$_POST["passwd"];
$fname=$_POST["fname"];
$utype=$_POST["utype"];
$lname=$_POST["lname"];
$email=$_POST["email"];

try
{
$con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz") or die("Error connecting");
$a="'".$admin_name."'";
$u ="'".$uname."'";
$pa = "'".$passwd."'";
$ut = "'".$utype."'";
$f = "'".$fname."'";
$l = "'".$lname."'";
$e = "'".$email."'";




$s = "insert into login (uname,password,user_role,admin_uname,first_name,last_name,email) values($u,$pa,$ut,$a,$f,$l,$e);";

$r = pg_query($con,$s);
}
catch (Exception $e)
{
	echo 'Error: ',  $e->getMessage(), "\n";
		
}
header("Location:admin.php");




?>