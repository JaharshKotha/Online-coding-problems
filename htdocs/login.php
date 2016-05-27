
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script>
$('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});
</script>
<Html>
<head>
<link rel="stylesheet" type="text/css" href="master.css">
</head>
<div class="login-page">
  <div class="form">
  <form action="action.php" method="POST" class="login-form">
<input type="text" name="uname" placeholder="username"><br>
 <input type="password" name ="passwd" placeholder="password"><br>
<input type="submit" value="SUBMIT">
</form>
<?php
if(isset($_SESSION['login_fail']))
{
	echo "<h7>Authentication failure ! We dont recognze you.</h7> ";
}
?>
  </div>
</div>
</Html>

