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

$check_query = "select * from creat_connections where admin_uname=$a and host=$h and port=$p and db_uname=$u and db_passwd=$pa and db_name=$d;";
$r1 = pg_query($con,$check_query);
if(pg_fetch_array($r1))
{
	header("Location:admin.php");
}
else
{
$s = "insert into creat_connections (admin_uname,host,port,db_uname,db_passwd,db_name) values($a,$h,$p,$u,$pa,$d);";

$con1 = pg_connect("host=localhost port=5421 dbname=$db_name user=postgres password=plz") or die("Error connecting");
$query = "SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' or table_type = 'VIEW' AND table_schema NOT IN('pg_catalog', 'information_schema');";
$r2 = pg_query($con1,$query);

while($row=pg_fetch_array($r2))
{
	
	$t_name="'".$row[0]."'";
	$query2 = "SELECT column_name FROM information_schema.columns WHERE table_name = $t_name;";
	$r3 = pg_query($con1,$query2);
	$cols="";
	while($row2=pg_fetch_array($r3))
	{
		$cols=$cols.",".$row2[0];
		
		
	}
	
	
$cols = ltrim($cols, ',');
$col = "'".$cols."'";
echo $cols."\n";

$in_query= "insert into table_view_control (table_name,table_rows,db_name,admin_name) values ($t_name,$col,$d,$a);";
$ir = pg_query($con,$in_query);

	
}


$r = pg_query($con,$s);
}
header("Location:admin.php");


}
catch (Exception $e)
{
	echo 'Error: ',  $e->getMessage(), "\n";
		
}


?>