<?php session_start();?>

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
  <h5> Hey <?php echo $_SESSION['uname'];?> would you like to setup a new connection </h5>
  <form action="action.php" method="POST" class="login-form">
<input type="text" name="uname" placeholder="db_username"><br>
 <input type="password" name ="passwd" placeholder="db_password"><br>
 <input type="password" name ="host" placeholder="hostname or ip address"><br>
<div class="row">
 <input type="submit" value="SUBMIT">
 <input type="usexist" value="USE EXISTING">
</div>
 </form>

  </div>
</div>
</Html>