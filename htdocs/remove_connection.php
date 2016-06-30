<?php
session_start();
ob_start();


$con_id =$_POST["con_id"];
$con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz") or die("Error connecting");
$c = "'".$con_id."'";

$get_db_name = "select db_name from creat_connections where con_id=$c;";

$r = pg_query($con,$get_db_name);
$dbn= pg_fetch_array($r);

$dbn = "'".$dbn[0]."'";
$get_admin_name = "select admin_uname from creat_connections where con_id=$c;";
$r = pg_query($con,$get_admin_name);
$ad_name= pg_fetch_array($r);

$s = "delete from creat_connections where con_id=$c;";
$r = pg_query($con,$s);
$ad_name = "'".$ad_name[0]."'";

$query =  "delete from table_view_control where admin_name=$ad_name and db_name=$dbn";
$r = pg_query($con,$query);

header("Location:admin.php");

?>