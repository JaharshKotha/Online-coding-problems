<?php
session_start();
ob_start();

$colMaparray = array(
    "smallint" => "integer",
    "integer" => "integer",
    "bigint" => "integer",
    "decimal" => "integer",
    "numeric" => "integer",
    "real" => "integer",
    "double" => "integer",
    "serial" => "integer",
    "bigserial" => "integer",
    "character" => "string",
    "varchar" => "string",
    "char" => "string",
    "text" => "string",
    "timestamp" => "calender",
    "date" => "calender",
);

$con2 = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
$aName = $_SESSION['admin_uname'];
$z = "select * from table_view_control where admin_name=$aName;";
$zr = $r = pg_query($con2, $z);
$dbA = array();
while ($zo = pg_fetch_array($r)) {

    $dbA[] = $zo[3];
}

$associativeArrayMainD = array();
for ($k = 0; $k < sizeof($dbA); $k++) {
    //  echo $dbA[$k];

    $con = pg_connect("host=localhost port=5421 dbname=$dbA[$k] user=postgres password=plz");
    $s = "SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema NOT IN ('pg_catalog', 'information_schema')";
//$s = "SELECT column_name FROM information_schema.columns WHERE table_name = 'login';";
    $r = pg_query($con, $s);

    $associativeArrayMain = array();

    while ($row = pg_fetch_row($r)) {
        $s = "SELECT column_name ,data_type  FROM information_schema.columns WHERE table_name = '$row[0]'";
        // echo $row[0];
        $r1 = pg_query($con, $s);
        $associativeArray = array();
        while ($row2 = pg_fetch_row($r1)) {
            $words = preg_split('/[^\w]/', trim($row2[1]));
            if (!isset($colMaparray[$words[0]])) {
                $associativeArray[$row2[0]] = "string";
            } else {
                $associativeArray[$row2[0]] = $colMaparray[trim($words[0])];
            }
            //    echo $row2[0];
            //echo "\n";
            //echo $row2[1];
            //echo "\n";
        }
        $associativeArrayMain[$row[0]] = $associativeArray;
    }
    $associativeArrayMainD[$dbA[$k]] = $associativeArrayMain;
}

echo str_replace('""', '"', stripslashes(json_encode($associativeArrayMainD)));
?>