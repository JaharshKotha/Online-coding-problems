<?php
session_start();
ob_start();

$admin_name=$_SESSION['uname'];
$uname =$_POST["db_uname"];
$passwd=$_POST["db_passwd"];
$host=$_POST["db_host"];
$db_name=$_POST["db_name"];
$port=$_POST["port"];
try
{
$con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz") or die("Error connecting");
$a="'".$admin_name."'";
$u ="'".$uname."'";
$pa = "'".$passwd."'";
$h = "'".$host."'";
$d = "'".$db_name."'";
$p = "'".$port."'";

$s = "insert into creat_connections (admin_uname,host,port,db_uname,db_passwd,db_name) values($a,$h,$p,$u,$pa,$d);";

$r = pg_query($con,$s);
}
catch (Exception $e)
{
	echo 'Error: ',  $e->getMessage(), "\n";
		
}
header("Location:/admin.php");




?>