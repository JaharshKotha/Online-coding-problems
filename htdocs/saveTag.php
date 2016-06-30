<?php

include_once("Config.php");
require_once('nossl/nossl_start.php');

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

session_start();
ob_start();

$qMain = str_replace("'", SINGLE_QUOTES_REPLACER, nossl_decrypt($_POST['queryMain']));
$tName = $_POST['tagName'];
$tDesc = $_POST['tagDescription'];
$qCol = trim($_POST['queryColTagForm']);
$u = trim($_SESSION['uname']);
//echo $_SESSION['uname'] .$_SESSION['admin_uname'];
$log = new Logging();

$log->lfile($_SERVER["DOCUMENT_ROOT"] . '/PHPProject1/Logs/' . date("m.d.y") . '.txt');

$log->lwrite('Action:::: Save Query ;;;; Query :::: (' . $qMain . ' ) ;;;; Tag :::: ' . $tName . ';;;; PageVisited :::: QueryPage(Saved Question)');

// close log file
$log->lclose();


//$con1 = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");

$con1 = new PDO('pgsql:dbname=postgres;host=localhost;port=5421', 'postgres', 'plz');
$tQuer = 'INSERT INTO saved_query (tags, description,query ,cols,uname)VALUES (:tName, :tDesc,:qMain,:qCol,:u) ';
$statement = $con1->prepare($tQuer);
$statement->bindValue(':tName', $tName, PDO::PARAM_STR);
$statement->bindValue(':tDesc', $tDesc, PDO::PARAM_STR);
$statement->bindValue(':qMain', $qMain, PDO::PARAM_STR);
$statement->bindValue(':qCol', $qCol, PDO::PARAM_STR);
$statement->bindValue(':u', $u, PDO::PARAM_STR);

//  echo $u;
$statement->execute();

//$sql = "INSERT INTO saved_query (tags, description,query ,cols,uname)VALUES ('$tName', '$tDesc','$qMain','$qCol','$u')";
//echo $sql;
//pg_query($sql)
?>
