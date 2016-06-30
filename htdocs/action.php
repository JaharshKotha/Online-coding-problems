<?php

//Script for login authentication; handles exceptions ; writes to the log file incase of any

session_start();
$uname =$_POST["uname"];
$passwd=$_POST["passwd"];
try
	{
	$con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
	$u ="'".$uname."'";
	$p = "'".$passwd."'";
	$s = "select *from LOGIN where uname=$u and password=$p";
	if((isset($_POST["uname"])&& isset($_POST["passwd"])) && (($_POST["uname"] !=null)&&($_POST["passwd"] !=null)))
		{
			
		$r = pg_query($con,$s);
		$row = pg_fetch_array($r);
		$p=trim($passwd);
		$pc=trim($row[2]);
		if($p==$pc)
		{
			$_SESSION['uname']=trim($row[1]);
			$_SESSION['displayname']=strtoupper(trim($row[5][0])).strtoupper(trim($row[6][0]));
                        			//$_SESSION['uname']='PS1';
			$_SESSION['utype']=trim($row[3]);
			$_SESSION['login_ok']=1;
			$_SESSION['timestamp']=time();
			
			echo strcmp($passwd,$row[2]);
			

			
			header("Location:dash.php");
			
		}
		else
		{

			header("Location:login.php");
			$_SESSION['login_fail']=1;
		}
	}
	else
	{
		header("Location:login.php");
		$_SESSION['login_fail']=1;
		
	}
}
catch (Exception $e)
{
	echo 'Error: ',  $e->getMessage(), "\n";
	$log_ = fopen("logfile.txt", "a") or die("Unable to open Log file!");
	fwrite($log_, $e->getMessage());
	fclose($myfile);	
}
?>
