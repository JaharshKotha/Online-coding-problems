<?php

$con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
	$s = "select db_name from creat_connections where admin_uname='PS1';";
$r = pg_query($con,$s);
echo 'Databases on the server';
$array = array();
while($row = pg_fetch_array($r))
{
	$array[]=$row[0];
	echo $row[0];

	
}
for($i=0;$i<sizeof($array);$i++)
{
	echo "host=localhost port=5421 dbname=$array[$i] user=postgres password=plz";
$con1 = pg_connect("host=localhost port=5421 dbname=$array[$i] user=postgres password=plz");


$s = "SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema NOT IN('pg_catalog', 'information_schema');";
$r = pg_query($con1,$s);
while($ro = pg_fetch_array($r))
{

echo '<br><h3>'.$ro[0].':</h3><br><br>';

}
}


?>