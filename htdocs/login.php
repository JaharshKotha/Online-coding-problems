<?php
session_set_cookie_params(0);
session_start();
ob_start();

$_SESSION['login_ok'] = 0;
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script>
    $('.message a').click(function () {
        $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
    });

    function popUpCal()
    {
        var url = "license.html";
        var width = 700;
        var height = 600;
        var left = parseInt((screen.availWidth / 2) - (width / 2));
        var top = parseInt((screen.availHeight / 2) - (height / 2));
        var windowFeatures = "width=" + width + ",height=" + height +
                ",status,resizable,left=" + left + ",top=" + top +
                "screenX=" + left + ",screenY=" + top + ",scrollbars=yes";

        window.open(url, "subWind", windowFeatures);
    }
    
    var $$ = {}; //jQuery object cache.
$$.w = $(window);
$$.h = $("#wrapper");
$$.m = $(".login-page");
$$.f = $("footer");
function vertical_height() {
  //  alert("sda");
    if($$.w.height()<500)
    {
        $$.f.hide();
    }
    else
    {
        $$.f.show();
    }
    var w = $$.w.height(),
        h = $$.h.outerHeight(true),
        m = $$.m.outerHeight(),
        f = $$.f.outerHeight(true),
        fin_height = Math.max(0, (w - h - m - f) / 2);
    console.log(fin_height);

    $$.m.css('marginTop', Math.floor(fin_height)).css('marginBottom', Math.ceil(fin_height));
    $$.h.text(fin_height);
};
var do_resize;
$(window).on('resize', function(){
  clearTimeout(do_resize);
  do_resize = setTimeout(vertical_height, 100);
}).trigger('resize');
</script>
<Html>
    <head>
        <link rel="stylesheet" type="text/css" href="master.css">
    </head>
    <body><div style="" class="header">
            <div>&nbsp;</div>
            <img src="img/intellispyre_logo.png">
        </div>
        <div id="wrapper" style="text-align: center; background:#B0C4DE;margin-top:30px">  
            <div style="display: inline-block;width:517px;padding-left: 2em;text-indent: --7em;"> Welcome to the IntelliSpyre Darkweb Threat Intelligence Platform. Please login with your credential below. If you do not have access information, please contact IntelliSpyre at <b>support@intellispyre.com</b> </div>
        </div>
        <div class="login-page">
            <div class="form">
                <form onsubmit="if (document.getElementById('agree').checked) {
                            return true;
                        } else {
                            alert('Please tick the box if you agree to the Terms and Conditions');
                            return false;
                        }" class="login-form" method="POST" action="action.php">
                    <input type="text" placeholder="username" name="uname" class="fullWidth"><br>
                    <input type="password" placeholder="password" name="passwd" class="fullWidth"><br>
                    <input type="checkbox" style="float: left; margin-top: 5px;" id="agree" value="check" name="checkbox" class="check"> <div style="margin-left: 25px;">I understand and agree to the <a onclick="popUpCal();
                            return false;" href="">Terms and Conditions</a></div><br>

                    <input type="submit" value="SUBMIT" class="fullWidth">

                </form>



            </div>
        </div>
        <footer><div id="wrapper" style="text-align: center; background:#B0C4DE;position: fixed;bottom: 0;width: 100%;">  
                <div style="display: inline-block;width:517px;padding-left: 2em;text-indent: --7em;">IntelliSpyre Inc. Copyright 2016 </div>
            </div></footer>


    </body>
</Html>

