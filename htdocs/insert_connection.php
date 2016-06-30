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
	if($admin_name==NULL || $uname==NULL || $passwd==NULL || $host==NULL || $db_name==NULL ||$port==NULL)
{
echo "<script>
alert('Please fill up the form completely');
window.location.href='admin_create_new_connection.php';
</script>";	
}
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
$query = "SELECT table_name FROM information_schema.tables WHERE table_type IN ('BASE TABLE' , 'VIEW') AND table_schema NOT IN('pg_catalog', 'information_schema');";
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

$con2 = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz" );
$z = "select datname from pg_database where datistemplate is false";
$zr = $r = pg_query($con2, $z);
$arr_res1 = pg_fetch_all($r);
$arr_len1 = count($arr_res1);
 $createquery="create table if not exists metatable(database_name varchar(100),existing_table_name varchar(100),new_table_name varchar(100),PRIMARY KEY(database_name, existing_table_name),
              CONSTRAINT no_duplicate_tag UNIQUE (database_name, existing_table_name))";
 $res=pg_query($con2,$createquery);
      $createquery2="create table if not exists metatable2(table_name varchar(100),existing_col_name varchar(100),new_col_name varchar(100) ,PRIMARY KEY(table_name, existing_col_name),
              CONSTRAINT no_duplicate2_tag UNIQUE (table_name, existing_col_name))";
     $res2=pg_query($con2,$createquery2);
 for($x = 0; $x < $arr_len1; $x++){
     echo $arr_res1[$x]['datname'];
     echo"host=localhost port=5421 dbname=".$arr_res1[$x]['datname']." user=postgres password=plz";
     $conne2 = pg_connect("host=localhost port=5421 dbname=".$arr_res1[$x]['datname']." user=postgres password=plz");
     $z1 = "select table_name from information_schema.tables where table_schema = 'public';";
     $z1r = pg_query($conne2, $z1);
     $arr_temp = pg_fetch_all($z1r);

     $arr_templen = count($arr_temp);
     for($y = 0; $y < $arr_templen; $y++){
         $insertquery="insert into metatable values('".$arr_res1[$x]['datname']."','".$arr_temp[$y]['table_name']."', '".$arr_temp[$y]['table_name']."')";;
         $res3=pg_query($con2,$insertquery);
         $z2 = "select column_name from information_schema.columns where table_name ='".$arr_temp[$y]['table_name']."'";
                //echo "insert into metatable values('".$arr_res1[$x]['datname']."','".$arr_temp[$y]['table_name']."', '".$arr_temp[$y]['table_name']."')";
//echo $z2;
         $z2r = pg_query($conne2, $z2);
         $arr_tempres2 = pg_fetch_all($z2r);
         $arr_templen2 = count($arr_tempres2);
         for($y1 = 0; $y1 < $arr_templen2; $y1++){
             $insertquery2="insert into metatable2 values('".$arr_temp[$y]['table_name']."','".$arr_tempres2[$y1]['column_name']."','".$arr_tempres2[$y1]['column_name']."')";
             $res4=pg_query($con2,$insertquery2);        
         }
     }
 }
 







header("Location:admin.php");


}
catch (Exception $e)
{
	echo 'Error: ',  $e->getMessage(), "\n";
		
}


?>