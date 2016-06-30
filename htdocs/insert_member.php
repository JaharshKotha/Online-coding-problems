<script>
function wt()
{
	var i=1000000;
	while(i>0)
	{
		--i;
	}
	
}
</script>
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
$rpasswd=$_POST["rpasswd"];

try
{
if($admin_name==NULL || $uname==NULL || $passwd==NULL || $fname==NULL || $utype==NULL || $lname==NULL || $email==NULL || $rpasswd==NULL)
{
echo "<script>
alert('Please fill up the form completely');
window.location.href='admin_add_a_new_member.php';
</script>";	
}

if(trim($passwd)!=trim($rpasswd))
{
	echo "<script>
alert('Passwords dont match');
window.location.href='admin_add_a_new_member.php';
</script>";
}

$con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz") or die("Error connecting");
$a="'".$admin_name."'";
$u ="'".$uname."'";
$pa = "'".$passwd."'";
$ut = "'".$utype."'";
$f = "'".$fname."'";
$l = "'".$lname."'";
$e = "'".$email."'";

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {


$s = "insert into login (uname,password,user_role,admin_uname,first_name,last_name,email) values($u,$pa,$ut,$a,$f,$l,$e);";

$r = pg_query($con,$s);
header("Location:admin.php");

}
else
{
	echo "<script>
alert('Invalid Email');
window.location.href='admin.php';
</script>";

}

}
catch (Exception $e)
{
	echo 'Error: ',  $e->getMessage(), "\n";
		
}




?>