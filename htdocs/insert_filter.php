<?php
?><?php
session_start();
ob_start();

$admin_name=$_SESSION['uname'];
$dbn =$_POST["dbna"];
$tn=$_POST["tna"];
$cols=$_POST["cn"];
$fd=$_POST["from_date"];
$td=$_POST["to_date"];


try
{
	if($cols==NULL || $fd==NULL ||$td==NULL)
{
	
echo "<script>
alert('Please fill up the filter completely');
window.location.href='view_control.php';
</script>";	
}

$date_regex = '/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/';
if(preg_match($date_regex, $fd) && preg_match($date_regex, $td) ) {
$con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz") or die("Error connecting");
$a="'".$admin_name."'";
$u ="'".$dbn."'";
$t = "'".$tn."'";
$col = "'".$cols."'";
$fd=  "'".$fd."'";
$td = "'".$td."'";

$s = "insert into filters (dbname,tablename,colname,admin_uname,fd,td) values ($u,$t,$col,$a,$fd,$td);";

$r = pg_query($con,$s);
header("Location:view_control.php");

}

else
{
	echo "<script>
alert('Please enter a valid date');
window.location.href='view_control.php';
</script>";
	
}

}
catch (Exception $e)
{
	echo 'Error: ',  $e->getMessage(), "\n";
		
}




?>