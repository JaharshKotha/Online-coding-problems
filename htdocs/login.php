<?php

session_set_cookie_params(0);
session_start();
ob_start();

$_SESSION['login_ok']=0;
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script>
$('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});

function popUpCal()
{
    var url = "license.html";
    var width = 700;
    var height = 600;
    var left = parseInt((screen.availWidth/2) - (width/2));
    var top = parseInt((screen.availHeight/2) - (height/2));
    var windowFeatures = "width=" + width + ",height=" + height +   
        ",status,resizable,left=" + left + ",top=" + top + 
        "screenX=" + left + ",screenY=" + top + ",scrollbars=yes";

    window.open(url, "subWind", windowFeatures);
}
</script>
<Html>
<head>
<link rel="stylesheet" type="text/css" href="master.css">
</head>

<div class="login-page">
  <div class="form">
  <form action="action.php" method="POST" class="login-form" onsubmit="if(document.getElementById('agree').checked) { return true; } else { alert('Please tick the box if you agree to the Terms and Conditions'); return false; }">
<input class="fullWidth" type="text" name="uname" placeholder="username"><br>
 <input class="fullWidth" type="password" name ="passwd" placeholder="password"><br>
 <input type="checkbox" class="check" name="checkbox" value="check" id="agree" style="float: left; margin-top: 5px;"/> <div style="margin-left: 25px;">I understand and agree to the <a href="" onClick="popUpCal();return false;">Terms and Conditions</a></div><br>
  
<input class="fullWidth" type="submit" value="SUBMIT">
</form>

      
<?php
if(isset($_SESSION['login_fail']))
{
	echo "<h7>Authentication error - wrong username or password (case sensitive)</h7> ";
}
?> 
</div>
</div>
</Html>

