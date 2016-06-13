<?php
session_start();
ob_start();

if($_SESSION['login_ok']==0)
{
	header("Location:login.php");;
}
   
    if(time() - $_SESSION['timestamp'] > 1000) { //subtract new timestamp from the old one
    echo"<script>alert('15 Minutes over!');</script>";
    unset($_SESSION['username'], $_SESSION['password'], $_SESSION['timestamp']);
    $_SESSION['logged_in'] = false;
	unset($_SESSION['admin_uname']);
    header("Location:logout.php"); //redirect to index.php
    exit;
} else {
    $_SESSION['timestamp'] = time(); //set new timestamp
}

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
$aName = trim($_SESSION['admin_uname']);
$z = "select * from table_view_control where admin_name=$aName;";
$zr = $r = pg_query($con2, $z);
$dbA = array();
$dbNAmeTVC = array();
while ($zo = pg_fetch_array($r)) {

    $dbA[] = $zo[3];
}
$dbA = array_unique($dbA);

for ($k = 0; $k < sizeof($dbA); $k++) {
    $z = "select table_name ,table_rows from table_view_control where admin_name=$aName and db_name='$dbA[$k]';";
    $zr = pg_query($con2, $z);
    $tableNameTVC = array();
    while ($zo = pg_fetch_array($zr)) {

        $tableNameTVC[$zo[0]] = explode(',', trim($zo[1]));
    }
    $dbNAmeTVC[trim($dbA[$k])] = $tableNameTVC;
}


$associativeArrayMainD = array();
for ($k = 0; $k < sizeof($dbA); $k++) {
    //echo $dbA[$k];

    $con = pg_connect("host=localhost port=5421 dbname=$dbA[$k] user=postgres password=plz");
    $s= "SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema NOT IN ('pg_catalog', 'information_schema')";
//$s = " select table_name from INFORMATION_SCHEMA.views WHERE table_schema = ANY (current_schemas(false))";
    $r = pg_query($con, $s);

    $associativeArrayMain = array();

    while ($row = pg_fetch_row($r)) {
        $s = "SELECT column_name ,data_type  FROM information_schema.columns WHERE table_name = '$row[0]'";
        // echo $row[0];
        $r1 = pg_query($con, $s);
        $associativeArray = array();
        while ($row2 = pg_fetch_row($r1)) {
            $words = preg_split('/[^\w]/', trim($row2[1]));
            if (!isset($colMaparray[$words[0]]) && in_array($row2[0], $dbNAmeTVC[trim($dbA[$k])][trim($row[0])])) {
                $associativeArray[$row2[0]] = "string";
            } else if (isset($dbNAmeTVC[trim($dbA[$k])][trim($row[0])]) && in_array($row2[0], $dbNAmeTVC[trim($dbA[$k])][trim($row[0])])) {
                $associativeArray[$row2[0]] = $colMaparray[trim($words[0])];
            }
            //    echo $row2[0];
            //echo "\n";
            //echo $row2[1];
            //echo "\n";
        }
        if (array_key_exists(trim($row[0]), $dbNAmeTVC[trim($dbA[$k])])) {
            $associativeArrayMain[$row[0]] = $associativeArray;
        }
    }
	
	
	//echo $dbA[$k];

    $con = pg_connect("host=localhost port=5421 dbname=$dbA[$k] user=postgres password=plz");
   // $s= "SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema NOT IN ('pg_catalog', 'information_schema')";
$s = " select table_name from INFORMATION_SCHEMA.views WHERE table_schema = ANY (current_schemas(false))";
    $r = pg_query($con, $s);

    //$associativeArrayMain = array();

    while ($row = pg_fetch_row($r)) {
        $s = "SELECT column_name ,data_type  FROM information_schema.columns WHERE table_name = '$row[0]'";
        // echo $row[0];
        $r1 = pg_query($con, $s);
        $associativeArray = array();
        while ($row2 = pg_fetch_row($r1)) {
            $words = preg_split('/[^\w]/', trim($row2[1]));
            if (!isset($colMaparray[$words[0]]) && in_array($row2[0], $dbNAmeTVC[trim($dbA[$k])][trim($row[0])])) {
                $associativeArray[$row2[0]] = "string";
            } else if (isset($dbNAmeTVC[trim($dbA[$k])][trim($row[0])]) && in_array($row2[0], $dbNAmeTVC[trim($dbA[$k])][trim($row[0])])) {
                $associativeArray[$row2[0]] = $colMaparray[trim($words[0])];
            }
            //    echo $row2[0];
            //echo "\n";
            //echo $row2[1];
            //echo "\n";
        }
        if (array_key_exists(trim($row[0]), $dbNAmeTVC[trim($dbA[$k])])) {
            $associativeArrayMain[$row[0]] = $associativeArray;
        }
    }
    if (array_key_exists(trim($dbA[$k]), $dbNAmeTVC)) {
        $associativeArrayMainD[$dbA[$k]] = $associativeArrayMain;
    }
}
?>

<style>
    ._1d7NndZU1ZUV8ckJ55iYYR {
        color: #525658;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 1em 2em;
    }
    ._1d7NndZU1ZUV8ckJ55iYYR ._2scMF-tWthFusp7jZxhUsU {
        color: #1f1f1f;
        font-weight: 700;
    }
    ._1d7NndZU1ZUV8ckJ55iYYR ._3Jkc80e3KAgrd-ka5bT3Ui {
        margin-top: 0.5em;
    }
    ._1d7NndZU1ZUV8ckJ55iYYR._2UOayrgLB5caOeAWHpqf0O ._2scMF-tWthFusp7jZxhUsU {
        font-size: 2em;
    }
    ._1d7NndZU1ZUV8ckJ55iYYR._2UOayrgLB5caOeAWHpqf0O ._3Jkc80e3KAgrd-ka5bT3Ui {
        font-size: 1em;
    }
    ._1d7NndZU1ZUV8ckJ55iYYR._1A_GGVx_KbD-IIkvsU2pIh {
        align-items: center;
    }
    ._1d7NndZU1ZUV8ckJ55iYYR._1A_GGVx_KbD-IIkvsU2pIh ._2scMF-tWthFusp7jZxhUsU {
        font-size: 2.5em;
    }
    ._1d7NndZU1ZUV8ckJ55iYYR._1A_GGVx_KbD-IIkvsU2pIh ._3Jkc80e3KAgrd-ka5bT3Ui {
        font-size: 1.2em;
    }
    .LegendItem {
        font-size: 1.2em;
        font-weight: 700;
        opacity: 1;
        transition: opacity 0.25s linear 0s;
    }
    .NNZY_V33LPAFqCAqUSvzQ {
        margin-bottom: 0.5em;
        margin-top: 0.5em;
    }
    ._1Z7aJftWKVG5Gy0osEys9.muted {
        opacity: 0.4;
    }
    ._1mX3zZmzXm3SmGfRY-dz_o._2Y7c2_PgU-NkxK3kMRI0fc {
        display: none;
    }
    ._1mX3zZmzXm3SmGfRY-dz_o._1SvpP38hhbHqja-Kx2O47U {
        flex-direction: column;
        margin-right: 1em;
    }
    ._1mX3zZmzXm3SmGfRY-dz_o._1SvpP38hhbHqja-Kx2O47U,
    ._1mX3zZmzXm3SmGfRY-dz_o._3QfZX_pEEghV4dbUcUqap4 {
        display: flex;
    }
    ._1mX3zZmzXm3SmGfRY-dz_o._3QfZX_pEEghV4dbUcUqap4 {
        flex-flow: row wrap;
        margin-top: 1em;
    }
    .l96_CLxo_PqCKgtKdL8oT {
        border-collapse: collapse;
        border-spacing: 0;
        font-family: Helvetica Neue, Helvetica, sans-serif;
        font-size: 12px;
        line-height: 12px;
        text-align: left;
        width: 100%;
    }
    .l96_CLxo_PqCKgtKdL8oT tr {
        border-bottom: 1px solid hsla(0, 0%, 84%, 0.3);
    }
    .l96_CLxo_PqCKgtKdL8oT td,
    .l96_CLxo_PqCKgtKdL8oT th {
        border-bottom: 1px solid hsla(0, 0%, 84%, 0.3);
        padding: 1em;
    }
    .oswsGtBEhm6HA5DPrrAWV td:first-child,
    .oswsGtBEhm6HA5DPrrAWV th:first-child {
        padding-left: 2em;
    }
    ._2invWT6W-hRbHKxyGhFNp2,
    ._3-BJmSrN_AZ5oUTAtifzAE {
        bottom: 0;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
    }
    ._3-BJmSrN_AZ5oUTAtifzAE {
        display: flex;
    }
    ._1D-1oZqhPsdIM49TnsRtZ8 {
        flex: 1 1 0;
    }
    ._2invWT6W-hRbHKxyGhFNp2 {
        align-items: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    ._2Q81lNKhwcWcAmU4dCPIDm {
        color: #676c72;
        font-size: 22px;
        font-weight: bolder;
    }
    .JUieEfAjaySary0mEND9k {
        color: #b8c0c9;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
    }
    ._1D-1oZqhPsdIM49TnsRtZ8 path {
        transition: opacity 0.3s linear 0s;
    }
    ._3JybVcfZ40IzqdFZm5ate0,
    ._3JybVcfZ40IzqdFZm5ate0 ._3PFIQNqtdfy8ZUomeXHFC1 {
        display: flex;
        justify-content: center;
    }
    ._3JybVcfZ40IzqdFZm5ate0 ._1_R7NyjGuoGD14CKs7DdHY {
        flex-shrink: 0;
        position: relative;
    }
    ._3JybVcfZ40IzqdFZm5ate0.wjSgG7NZXJKOT4ioSAP21 ._3PFIQNqtdfy8ZUomeXHFC1 {
        display: none;
    }
    ._3JybVcfZ40IzqdFZm5ate0.wjSgG7NZXJKOT4ioSAP21 ._1_R7NyjGuoGD14CKs7DdHY {
        flex: 1 1 0;
    }
    ._3JybVcfZ40IzqdFZm5ate0.nc0llpsUsCDg2YxK3EAfG {
        flex-direction: column-reverse;
        justify-content: space-around;
    }
    ._3JybVcfZ40IzqdFZm5ate0.nc0llpsUsCDg2YxK3EAfG ._3PFIQNqtdfy8ZUomeXHFC1 {
        flex-shrink: 1;
        overflow: hidden;
    }
    ._3JybVcfZ40IzqdFZm5ate0.nc0llpsUsCDg2YxK3EAfG._2YwR9bdPszq5v5Up3A7bUY ._3PFIQNqtdfy8ZUomeXHFC1 {
        flex-grow: 0;
        flex-shrink: 0;
        max-height: 25%;
    }
    ._3JybVcfZ40IzqdFZm5ate0.nc0llpsUsCDg2YxK3EAfG._2YwR9bdPszq5v5Up3A7bUY ._1_R7NyjGuoGD14CKs7DdHY {
        flex-grow: 1;
        flex-shrink: 1;
        min-height: 75%;
    }
    ._3JybVcfZ40IzqdFZm5ate0._14TOTpCMLXDHCesHGB6SZj {
        flex-direction: row;
        justify-content: space-around;
    }
    ._3JybVcfZ40IzqdFZm5ate0._14TOTpCMLXDHCesHGB6SZj ._3PFIQNqtdfy8ZUomeXHFC1 {
        flex-grow: 0;
        flex-shrink: 1;
        overflow: hidden;
    }
    ._3JybVcfZ40IzqdFZm5ate0._14TOTpCMLXDHCesHGB6SZj._2YwR9bdPszq5v5Up3A7bUY ._3PFIQNqtdfy8ZUomeXHFC1 {
        flex-grow: 0;
        flex-shrink: 0;
        max-width: 33%;
    }
    ._3JybVcfZ40IzqdFZm5ate0._14TOTpCMLXDHCesHGB6SZj._2YwR9bdPszq5v5Up3A7bUY ._1_R7NyjGuoGD14CKs7DdHY {
        flex-grow: 1;
        flex-shrink: 1;
        min-width: 66%;
    }
    ._29U08VsqFpQf7HG03EIE8W {
        color: #333;
        font-family: Humor Sans, sans-serif;
        font-size: 16px;
        text-align: center;
    }
    ._29U08VsqFpQf7HG03EIE8W text.title {
        font-size: 20px;
    }
    ._29U08VsqFpQf7HG03EIE8W path {
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-width: 2.5px;
    }
    ._29U08VsqFpQf7HG03EIE8W path.axis {
        stroke: #000;
    }
    ._29U08VsqFpQf7HG03EIE8W path.bgline {
        stroke: #fff;
        stroke-width: 6px;
    }
    ._3TLsalUZYdJqkR3JEsP5Cb {
        cursor: pointer;
    }
    .H7PNn7mlSkRSf2bEHC_KK {
        min-width: 200px;
        padding: 1em;
    }
    ._2dEsE0BjuIm9AswqvUZVT3 {
        color: #959595;
        font-size: 0.75em;
        font-weight: 700;
        margin-bottom: 1em;
        margin-left: 0.5em;
        text-transform: uppercase;
    }
    ._1kx-tSUaN4O2TPv1wYjxWk {
        color: #727479;
        font-weight: 700;
        padding-bottom: 0.5em;
        padding-top: 0.5em;
    }
    ._1kx-tSUaN4O2TPv1wYjxWk:hover,
    ._1kx-tSUaN4O2TPv1wYjxWk:hover ._3W2fqtVL1PTaSmVA6jA7Oc {
        color: #509ee3 !important;
    }
    ._1kx-tSUaN4O2TPv1wYjxWk._1s8ylQUKEaUK0MBk414lVf._3Vn3LE6qy5BUeBt2B-x6-Z,
    ._1kx-tSUaN4O2TPv1wYjxWk._1s8ylQUKEaUK0MBk414lVf._3Vn3LE6qy5BUeBt2B-x6-Z ._3W2fqtVL1PTaSmVA6jA7Oc {
        color: #9cc177;
    }
    ._1kx-tSUaN4O2TPv1wYjxWk .Icon {
        margin-right: 0.5em;
        visibility: hidden;
    }
    ._1kx-tSUaN4O2TPv1wYjxWk._3Vn3LE6qy5BUeBt2B-x6-Z .Icon,
    ._1kx-tSUaN4O2TPv1wYjxWk:hover .Icon {
        visibility: visible;
    }
    ._1kx-tSUaN4O2TPv1wYjxWk ._3W2fqtVL1PTaSmVA6jA7Oc {
        color: #959595;
    }
    div.dc-chart {
        float: left;
    }
    .dc-chart rect.bar {
        cursor: pointer;
        stroke: none;
    }
    .dc-chart rect.bar:hover {
        fill-opacity: 0.5;
    }
    .dc-chart rect.stack1 {
        fill: red;
        stroke: none;
    }
    .dc-chart rect.stack2 {
        fill: green;
        stroke: none;
    }
    .dc-chart rect.deselected {
        fill: #ccc;
        stroke: none;
    }
    .dc-chart .empty-chart .pie-slice path {
        cursor: default;
        fill: #fee;
    }
    .dc-chart .empty-chart .pie-slice {
        cursor: default;
    }
    .dc-chart .pie-slice {
        cursor: pointer;
        fill: #fff;
        font-size: 12px;
    }
    .dc-chart .pie-slice.external {
        fill: #000;
    }
    .dc-chart .pie-slice.highlight,
    .dc-chart .pie-slice *:hover {
        fill-opacity: 0.8;
    }
    .dc-chart .pie-path {
        fill: none;
        opacity: 0.4;
        stroke: #000;
        stroke-width: 2px;
    }
    .dc-chart .selected path {
        fill-opacity: 1;
        stroke: #ccc;
        stroke-width: 3;
    }
    .dc-chart .deselected path {
        fill: #ccc;
        fill-opacity: 0.5;
        stroke: none;
    }
    .dc-chart .axis line,
    .dc-chart .axis path {
        fill: none;
        shape-rendering: crispedges;
        stroke: #000;
    }
    .dc-chart .axis text {
        font: 10px sans-serif;
    }
    .dc-chart .axis .grid-line,
    .dc-chart .axis .grid-line line,
    .dc-chart .grid-line,
    .dc-chart .grid-line line {
        fill: none;
        opacity: 0.5;
        shape-rendering: crispedges;
        stroke: #ccc;
    }
    .dc-chart .brush rect.background {
        z-index: -999;
    }
    .dc-chart .brush rect.extent {
        fill: #4682b4;
        fill-opacity: 0.125;
    }
    .dc-chart .brush .resize path {
        fill: #eee;
        stroke: #666;
    }
    .dc-chart path.line {
        fill: none;
        stroke-width: 1.5px;
    }
    .dc-chart circle.dot {
        stroke: none;
    }
    .dc-chart g.dc-tooltip path {
        fill: none;
        stroke: grey;
        stroke-opacity: 0.8;
    }
    .dc-chart path.area {
        fill-opacity: 0.3;
        stroke: none;
    }
    .dc-chart .node {
        cursor: pointer;
        font-size: 0.7em;
    }
    .dc-chart .node *:hover {
        fill-opacity: 0.8;
    }
    .dc-chart .selected circle {
        fill-opacity: 1;
        stroke: #ccc;
        stroke-width: 3;
    }
    .dc-chart .deselected circle {
        fill: #ccc;
        fill-opacity: 0.5;
        stroke: none;
    }
    .dc-chart .bubble {
        fill-opacity: 0.6;
        stroke: none;
    }
    .dc-data-count {
        float: right;
        margin-right: 15px;
        margin-top: 15px;
    }
    .dc-data-count .filter-count,
    .dc-data-count .total-count {
        color: #3182bd;
        font-weight: 700;
    }
    .dc-chart g.state {
        cursor: pointer;
    }
    .dc-chart g.state *:hover {
        fill-opacity: 0.8;
    }
    .dc-chart g.state path {
        stroke: #fff;
    }
    .dc-chart g.deselected path {
        fill: grey;
    }
    .dc-chart g.deselected text {
        display: none;
    }
    .dc-chart g.county path {
        fill: none;
        stroke: #fff;
    }
    .dc-chart g.debug rect {
        fill: blue;
        fill-opacity: 0.2;
    }
    .dc-chart g.row rect {
        cursor: pointer;
        fill-opacity: 0.8;
    }
    .dc-chart g.row rect:hover {
        fill-opacity: 0.6;
    }
    .dc-chart g.row text {
        cursor: pointer;
        fill: #fff;
        font-size: 12px;
    }
    .dc-legend {
        font-size: 11px;
    }
    .dc-legend-item {
        cursor: pointer;
    }
    .dc-chart g.axis text {
        -moz-user-select: none;
        pointer-events: none;
    }
    .dc-chart path.highlight {
        stroke-width: 3;
    }
    .dc-chart .highlight,
    .dc-chart path.highlight {
        fill-opacity: 1;
        stroke-opacity: 1;
    }
    .dc-chart .fadeout {
        fill-opacity: 0.2;
        stroke-opacity: 0.2;
    }
    .dc-chart path.dc-symbol,
    g.dc-legend-item.fadeout {
        fill-opacity: 0.5;
        stroke-opacity: 0.5;
    }
    .dc-hard .number-display {
        float: none;
    }
    .dc-chart .box text {
        -moz-user-select: none;
        font: 10px sans-serif;
        pointer-events: none;
    }
    .dc-chart .box circle,
    .dc-chart .box line {
        fill: #fff;
        stroke: #000;
        stroke-width: 1.5px;
    }
    .dc-chart .box rect {
        stroke: #000;
        stroke-width: 1.5px;
    }
    .dc-chart .box .center {
        stroke-dasharray: 3, 3;
    }
    .dc-chart .box .outlier {
        fill: none;
        stroke: #ccc;
    }
    .dc-chart .box.deselected .box {
        fill: #ccc;
    }
    .dc-chart .box.deselected {
        opacity: 0.5;
    }
    .dc-chart .symbol {
        stroke: none;
    }
    .dc-chart .heatmap .box-group.deselected rect {
        fill: #ccc;
        fill-opacity: 0.5;
        stroke: none;
    }
    .dc-chart .heatmap g.axis text {
        cursor: pointer;
        pointer-events: all;
    }
    .z1 {
        z-index: 1;
    }
    .z2 {
        z-index: 2;
    }
    .z3 {
        z-index: 3;
    }
    .z4 {
        z-index: 4;
    }
    .z5 {
        z-index: 5;
    }
    .z6 {
        z-index: 6;
    }
    .zF {
        z-index: 999;
    }
    .public_Scrollbar_main.public_Scrollbar_mainActive,
    .public_Scrollbar_main:hover {
        background-color: hsla(0, 0%, 100%, 0.8);
    }
    .public_Scrollbar_mainOpaque,
    .public_Scrollbar_mainOpaque.public_Scrollbar_mainActive,
    .public_Scrollbar_mainOpaque:hover {
        background-color: #fff;
    }
    .public_Scrollbar_face::after {
        background-color: #c2c2c2;
    }
    .public_Scrollbar_faceActive::after,
    .public_Scrollbar_main:hover .public_Scrollbar_face::after,
    .public_Scrollbar_mainActive .public_Scrollbar_face::after {
        background-color: #0;
    }
    .public_fixedDataTable_hasBottomBorder,
    .public_fixedDataTable_header,
    .public_fixedDataTable_main {
        border-color: #d3d3d3;
    }
    .public_fixedDataTable_header .public_fixedDataTableCell_main {
        font-weight: 700;
    }
    .public_fixedDataTable_header,
    .public_fixedDataTable_header .public_fixedDataTableCell_main {
        background-color: #f6f7f8;
        background-image: linear-gradient(#fff, #efefef);
    }
    .public_fixedDataTable_footer .public_fixedDataTableCell_main {
        background-color: #f6f7f8;
        border-color: #d3d3d3;
    }
    .public_fixedDataTable_topShadow {
        background: rgba(0, 0, 0, 0) url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAECAYAAABP2FU6AAAAF0lEQVR4AWPUkNeSBhHCjJoK2twgFisAFagCCp3pJlAAAAAASUVORK5CYII=") repeat-x scroll 0 0;
    }
    .public_fixedDataTable_bottomShadow {
        background: rgba(0, 0, 0, 0) url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAECAYAAABP2FU6AAAAHElEQVQI12MwNjZmZdAT1+Nm0JDWEGZQk1GTBgAWkwIeAEp52AAAAABJRU5ErkJggg==") repeat-x scroll 0 0;
    }
    .public_fixedDataTable_horizontalScrollbar .public_Scrollbar_mainHorizontal {
        background-color: #fff;
    }
    .public_fixedDataTableCell_main {
        background-color: #fff;
        border-color: #d3d3d3;
    }
    .public_fixedDataTableCell_highlighted {
        background-color: #f4f4f4;
    }
    .public_fixedDataTableCell_cellContent {
        padding: 8px;
    }
    .public_fixedDataTableCell_columnResizerKnob {
        background-color: #0284ff;
    }
    .public_fixedDataTableColumnResizerLine_main {
        border-color: #0284ff;
    }
    .public_fixedDataTableRow_main {
        background-color: #fff;
    }
    .public_fixedDataTableRow_highlighted,
    .public_fixedDataTableRow_highlighted .public_fixedDataTableCell_main {
        background-color: #f6f7f8;
    }
    .public_fixedDataTableRow_fixedColumnsDivider {
        border-color: #d3d3d3;
    }
    .public_fixedDataTableRow_columnsShadow {
        background: rgba(0, 0, 0, 0) url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAABCAYAAAD5PA/NAAAAFklEQVQIHWPSkNeSBmJhTQVtbiDNCgASagIIuJX8OgAAAABJRU5ErkJggg==") repeat-y scroll 0 0;
    }
    .ScrollbarLayout_main {
        -moz-user-select: none;
        box-sizing: border-box;
        outline: medium none;
        overflow: hidden;
        position: absolute;
        transition-duration: 0.25s;
        transition-timing-function: ease;
    }
    .ScrollbarLayout_mainVertical {
        bottom: 0;
        right: 0;
        top: 0;
        width: 15px;
    }
    .ScrollbarLayout_mainVertical.public_Scrollbar_mainActive,
    .ScrollbarLayout_mainVertical:hover {
        width: 17px;
    }
    .ScrollbarLayout_mainHorizontal {
        bottom: 0;
        height: 15px;
        left: 0;
    }
    .ScrollbarLayout_mainHorizontal.public_Scrollbar_mainActive,
    .ScrollbarLayout_mainHorizontal:hover {
        height: 17px;
    }
    .ScrollbarLayout_face {
        left: 0;
        overflow: hidden;
        position: absolute;
        z-index: 1;
    }
    .ScrollbarLayout_face::after {
        border-radius: 6px;
        content: "";
        display: block;
        position: absolute;
        transition: background-color 0.25s ease 0s;
    }
    .ScrollbarLayout_faceHorizontal {
        bottom: 0;
        left: 0;
        top: 0;
    }
    .ScrollbarLayout_faceHorizontal::after {
        bottom: 4px;
        left: 0;
        top: 4px;
        width: 100%;
    }
    .ScrollbarLayout_faceVertical {
        left: 0;
        right: 0;
        top: 0;
    }
    .ScrollbarLayout_faceVertical::after {
        height: 100%;
        left: 4px;
        right: 4px;
        top: 0;
    }
    .fixedDataTableCellGroupLayout_cellGroup {
        backface-visibility: hidden;
        left: 0;
        overflow: hidden;
        position: absolute;
        top: 0;
        white-space: nowrap;
    }
    .fixedDataTableCellGroupLayout_cellGroup > .public_fixedDataTableCell_main {
        display: inline-block;
        vertical-align: top;
        white-space: normal;
    }
    .fixedDataTableCellGroupLayout_cellGroupWrapper {
        position: absolute;
        top: 0;
    }
    .fixedDataTableCellLayout_main {
        border-right-style: solid;
        border-width: 0 1px 0 0;
        box-sizing: border-box;
        display: block;
        overflow: hidden;
        position: absolute;
        white-space: normal;
    }
    .fixedDataTableCellLayout_lastChild {
        border-width: 0 1px 1px 0;
    }
    .fixedDataTableCellLayout_alignRight {
        text-align: right;
    }
    .fixedDataTableCellLayout_alignCenter {
        text-align: center;
    }
    .fixedDataTableCellLayout_wrap1 {
        display: table;
    }
    .fixedDataTableCellLayout_wrap2 {
        display: table-row;
    }
    .fixedDataTableCellLayout_wrap3 {
        display: table-cell;
        vertical-align: middle;
    }
    .fixedDataTableCellLayout_columnResizerContainer {
        position: absolute;
        right: 0;
        width: 6px;
        z-index: 1;
    }
    .fixedDataTableCellLayout_columnResizerContainer:hover {
        cursor: ew-resize;
    }
    .fixedDataTableCellLayout_columnResizerContainer:hover .fixedDataTableCellLayout_columnResizerKnob {
        visibility: visible;
    }
    .fixedDataTableCellLayout_columnResizerKnob {
        position: absolute;
        right: 0;
        visibility: hidden;
        width: 4px;
    }
    .fixedDataTableColumnResizerLineLayout_mouseArea {
        cursor: ew-resize;
        position: absolute;
        right: -5px;
        width: 12px;
    }
    .fixedDataTableColumnResizerLineLayout_main {
        border-right-style: solid;
        border-right-width: 1px;
        box-sizing: border-box;
        position: absolute;
        z-index: 10;
    }
    .fixedDataTableColumnResizerLineLayout_hiddenElem,
    body[dir="rtl"] .fixedDataTableColumnResizerLineLayout_main {
        display: none !important;
    }
    .fixedDataTableLayout_main {
        border-style: solid;
        border-width: 1px;
        box-sizing: border-box;
        overflow: hidden;
        position: relative;
    }
    .fixedDataTableLayout_hasBottomBorder,
    .fixedDataTableLayout_header {
        border-bottom-style: solid;
        border-bottom-width: 1px;
    }
    .fixedDataTableLayout_footer .public_fixedDataTableCell_main {
        border-top-style: solid;
        border-top-width: 1px;
    }
    .fixedDataTableLayout_bottomShadow,
    .fixedDataTableLayout_topShadow {
        height: 4px;
        left: 0;
        position: absolute;
        right: 0;
        z-index: 1;
    }
    .fixedDataTableLayout_bottomShadow {
        margin-top: -4px;
    }
    .fixedDataTableLayout_rowsContainer {
        overflow: hidden;
        position: relative;
    }
    .fixedDataTableLayout_horizontalScrollbar {
        bottom: 0;
        position: absolute;
    }
    .fixedDataTableRowLayout_main {
        box-sizing: border-box;
        overflow: hidden;
        position: absolute;
        top: 0;
    }
    .fixedDataTableRowLayout_body {
        left: 0;
        position: absolute;
        top: 0;
    }
    .fixedDataTableRowLayout_fixedColumnsDivider {
        backface-visibility: hidden;
        border-left-style: solid;
        border-left-width: 1px;
        left: 0;
        position: absolute;
        top: 0;
        width: 0;
    }
    .fixedDataTableRowLayout_columnsShadow {
        width: 4px;
    }
    .fixedDataTableRowLayout_rowWrapper {
        position: absolute;
        top: 0;
    }
    .Badge {
        background-color: #444;
        border-radius: 4px;
        color: #fff;
        font-size: 0.6rem;
        font-weight: 700;
        padding: 0.5em;
        text-transform: uppercase;
    }
    .Badge.Badge--permissions {
        background-color: #509EE7;
    }
    .Badge.Badge--headsUp {
        background-color: #f5a623;
    }
    .Breadcrumbs {
        align-items: center;
        color: #bfc1c2;
        display: flex;
        padding-bottom: 2.075em;
        padding-top: 2.075em;
    }
    .Breadcrumb {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .Breadcrumb-divider {
        margin-left: 0.75em;
        margin-right: 0.75em;
    }
    .Breadcrumb.Breadcrumb--path {
        color: currentcolor;
        transition: color 0.3s linear 0s;
    }
    .Breadcrumb.Breadcrumb--path:hover {
        color: #636060;
        transition: color 0.3s linear 0s;
    }
    .Breadcrumb.Breadcrumb--page {
        color: #636060;
    }
    .Button {
        background: #fbfcfd none repeat scroll 0 0;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        color: #444;
        cursor: pointer;
        display: inline-block;
        font-family: Lato;
        font-weight: 700;
        padding: 0.5rem 0.75rem;
        text-decoration: none;
    }
    @media screen and (min-width: 80em) {
        .Button {
            padding: 0.75rem 1rem;
        }
    }
    @media screen and (min-width: 120em) {
        .Button {
            padding: 1rem 1.5rem;
        }
    }
    .Button:hover {
        transition: border 0.3s linear 0s;
    }
    .Button--small {
        font-size: 0.6rem;
        padding: 0.4rem 0.75rem;
    }
    .Button--medium {
        font-size: 0.8rem;
        padding: 0.5rem 1rem;
    }
    .Button-normal {
        font-weight: 400;
    }
    .Button--primary {
        background: #509ee3 none repeat scroll 0 0;
        border: 1px solid #509ee3;
        color: #fff;
    }
    .Button--primary:hover {
        background-color: #488ecc;
        border-color: #488ecc;
        color: #fff;
    }
    .Button--warning {
        background: #e35050 none repeat scroll 0 0;
        border: 1px solid #e35050;
        color: #fff;
    }
    .Button--warning:hover {
        background-color: #cc4848;
        border-color: #cc4848;
        color: #fff;
    }
    .Button--cancel {
        border-radius: 99px;
    }
    .Button--white {
        background-color: #fff;
        border-color: #aeaeae;
        color: #aeaeae;
    }
    .Button--purple {
        background-color: #509EE7;
        border: 1px solid #509EE7;
        color: #fff;
    }
    .Button--Grey{
        background-color: #74AFAD;
        border: 1px solid #74AFAD;
        color: #fff; 

    }
    .Button--borderless {
        background: transparent none repeat scroll 0 0;
        border: medium none;
        color: #959595;
    }
    .Button--borderless:hover {
        color: #7c7c7c;
    }
    .Button-group {
        border: 1px solid #b9b9b9;
        border-radius: 4px;
        clear: both;
        display: inline-block;
        overflow: hidden;
    }
    .Button-group .Button {
        border-bottom: medium none;
        border-radius: 0;
        border-right: medium none;
        border-top: medium none;
        box-shadow: none;
        float: left;
        margin: 0;
    }
    .Button-group .Button--active {
        background-color: #9cc177;
        color: #fff;
    }
    .Button-group .Button:first-child {
        border-left: medium none;
    }
    .Button-group--blue {
        border-color: #c2d8f2;
    }
    .Button-group--blue .Button {
        color: #939bb2;
    }
    .Button-group--blue .Button--active {
        background-color: #e3eefa;
        color: #4a90e2;
    }
    .Button-group--brand {
        border-color: #fff;
    }
    .Button-group--brand .Button {
        background-color: #e5e5e5;
        border-color: #fff;
        color: #509ee3;
    }
    .Button-group--brand .Button--active {
        background-color: #509ee3;
        color: #fff;
    }
    .Button:disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }
    .Button--selected,
    .Button--selected:hover {
        background-color: #f4f6f8;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.12) inset;
    }
    .Button--danger {
        background-color: #ef8c8c;
        border-color: #ef8c8c;
        color: #fff;
    }
    .Button--success {
        background-color: #9cc177;
        border-color: #9cc177;
        color: #fff;
    }
    .Button--success-new {
        border-color: #9cc177;
        color: #9cc177;
        font-weight: 700;
    }
    .Button-toggle {
        border-radius: 40px;
        color: #797979;
        line-height: 1;
        transition: background 0.2s linear 0.2s, border 0.2s linear 0.2s;
        width: 3rem;
    }
    .Button-toggle,
    .Button-toggleIndicator {
        border: 1px solid #ddd;
        display: flex;
    }
    .Button-toggleIndicator {
        align-items: center;
        background-color: #fff;
        border-radius: 99px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        justify-content: center;
        margin-left: 0;
        padding: 0.25rem;
        transition: margin 0.3s linear 0s;
    }
    .Button-toggle.Button--toggled .Button-toggleIndicator {
        margin-left: 50%;
        transition: margin 0.3s linear 0s;
    }
    .Button-toggle.Button--toggled {
        background-color: #509ee3;
        border-color: #509ee3;
        color: #509ee3;
        transition: background 0.2s linear 0.2s, border 0.2s linear 0.2s;
    }
    .Button--withIcon {
        line-height: 1;
    }
    .Calendar-week {
        display: flex;
    }
    .Calendar-day,
    .Calendar-day-name {
        flex: 1 1 0;
    }
    .Calendar-day {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-color: hsla(0, 0%, 78%, 0.5);
        border-image: none;
        border-radius: 0;
        border-style: solid;
        border-width: 1px 0 0 1px;
        color: #aeaeae;
        position: relative;
    }
    .Calendar-day:last-child {
        border-right-width: 1px;
    }
    .Calendar-week:last-child .Calendar-day {
        border-bottom-width: 1px;
    }
    .Calendar-day-name {
        cursor: inherit;
    }
    .Calendar-day--this-month {
        color: currentcolor;
    }
    .Calendar-day--today {
        font-weight: 700;
    }
    .Calendar-day:hover {
        color: #509EE7;
    }
    .Calendar-day-name {
        color: inherit !important;
    }
    .Calendar-day--selected,
    .Calendar-day--selected-end {
        background-color: #509EE7;
        color: #fff !important;
        z-index: 1;
    }
    .Calendar-day--in-range {
        background-color: #e3daeb;
    }
    .Calendar-day--in-range::after,
    .Calendar-day--selected-end::after,
    .Calendar-day--selected::after {
        border: 2px solid #7f6794;
        border-radius: 4px;
        bottom: -1px;
        content: "";
        left: -2px;
        position: absolute;
        right: -2px;
        top: -2px;
        z-index: 2;
    }
    .Calendar-day--in-range::after {
        border-left-color: transparent;
        border-radius: 0;
        border-right-color: transparent;
    }
    .Calendar-day--week-start.Calendar-day--in-range::after {
        border-bottom-left-radius: 4px;
        border-left-color: #7f6794;
        border-top-left-radius: 4px;
    }
    .Calendar-day--week-end.Calendar-day--in-range::after {
        border-bottom-right-radius: 4px;
        border-right-color: #7f6794;
        border-top-right-radius: 4px;
    }
    .circle-button {
        background-color: #fff;
        border: 2px solid #dfdfdf;
        border-radius: 99px;
        color: #aeaeae;
        display: block;
        font-size: 20px;
        height: 24px;
        line-height: 20px;
        text-align: center;
        vertical-align: middle;
        width: 24px;
        z-index: 2;
    }
    .circle-button:hover {
        border-color: #509EE7;
        color: #509EE7;
    }
    .circle-button--top {
        position: absolute;
        top: -12px;
    }
    .circle-button--bottom {
        bottom: -12px;
        position: absolute;
    }
    .circle-button--left {
        left: -12px;
        position: absolute;
    }
    .circle-button--right {
        position: absolute;
        right: -12px;
    }
    .Card {
        position: relative;
    }
    .Card-footing {
        color: #999;
        font-size: 0.8rem;
    }
    .Card-title {
        color: #3f3a3a;
        font-size: 0.8em;
    }
    .Card-dataSource {
        color: #999;
        padding-top: 0.5em;
    }
    .Card-defaultBox {
        height: 500px;
    }
    @media screen and (min-width: 60em) {
        .Card-title {
            font-size: 0.8em;
        }
    }
    .Card--errored {
        min-height: 80px;
    }
    .Card-scalarValue {
        overflow: hidden;
    }
    @media screen and (min-width: 80em) {
        .Card-scalarValue {
            font-size: 2.4em;
        }
    }
    @media screen and (min-width: 120em) {
        .Card-scalarValue {
            font-size: 3.4em;
        }
    }
    .CardSettings-group,
    .CardSettings-groupTitle {
        border-bottom: 1px solid #ddd;
    }
    .CardSettings-groupTitle {
        padding: 0.5em;
    }
    .CardSettings-content {
        background-color: #fafafa;
        padding: 2em;
    }
    .CardSettings {
        border-top: 1px solid #ddd;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.12) inset;
    }
    .CardSettings-label {
        color: #666;
        font-size: 1.15em;
        margin-left: 0.5em;
    }
    .CardSettings-colorBlock {
        border-radius: 4px;
        display: inline-block;
        height: 2.5em;
        margin-right: 1em;
        width: 2.5em;
    }
    .CardSettings-colorBlock:last-child {
        margin-right: 0;
    }
    .Card--scalar {
        padding: 1em;
    }
    .ColumnarSelector {
        background-color: #fcfcfc;
        display: flex;
        font-weight: 700;
    }
    .ColumnarSelector-column {
        flex: 1 1 0;
        max-height: 340px;
        min-width: 180px;
    }
    .ColumnarSelector-rows {
        padding-bottom: 0.5rem;
        padding-top: 0.5rem;
    }
    .ColumnarSelector-title {
        color: #aeaeae;
        font-size: 10px;
        font-weight: 700;
        padding: 0.5rem 0.5rem 0.5rem 1.5rem;
        text-transform: uppercase;
    }
    .ColumnarSelector-section:first-child .ColumnarSelector-title {
        padding-top: 1.5rem;
    }
    .ColumnarSelector-description {
        color: #aeaeae;
        margin-top: 0.5em;
        max-width: 270px;
    }
    .ColumnarSelector-row {
        align-items: center;
        display: flex;
        padding: 0.75rem 24px 0.75rem 1.5rem;
    }
    .ColumnarSelector-row:hover {
        background-color: #509ee3 !important;
        color: #fff !important;
    }
    .ColumnarSelector-row:hover .ColumnarSelector-description {
        color: hsla(0, 0%, 100%, 0.5);
    }
    .ColumnarSelector-row--selected {
        background: #fff none repeat scroll 0 0;
        border-bottom: 1px solid #f0f0f0;
        border-top: 1px solid #f0f0f0;
        color: inherit !important;
    }
    .ColumnarSelector-row .Icon-check {
        margin-right: 1rem;
        visibility: hidden;
    }
    .ColumnarSelector-row.ColumnarSelector-row--selected .Icon-check {
        visibility: visible;
    }
    .ColumnarSelector-column:first-child {
        z-index: 1;
    }
    .ColumnarSelector-column:last-child {
        background-color: #fff;
        border-left: 1px solid #f0f0f0;
        left: -1px;
        position: relative;
    }
    .ColumnarSelector-column:last-child .ColumnarSelector-row--selected {
        background: inherit;
        border-bottom: medium none;
        border-top: medium none;
        color: #509ee3;
    }
    .Dashboard {
        background-color: #f9fbfc;
    }
    .DashboardHeader {
        background-color: #fff;
        border-bottom: 1px solid #f0f0f0;
    }
    .Dash-wrapper {
        width: 100%;
    }
    @media screen and (min-width: 40em) {
        .Dash-wrapper {
            max-width: 752px;
        }
    }
    @media screen and (min-width: 60em) {
        .Dash-wrapper {
            max-width: 940px;
        }
    }
    @media screen and (min-width: 80em) {
        .Dash-wrapper {
            max-width: 1140px;
        }
    }
    .Dashboard.Dashboard--fullscreen .Header-button {
        color: #d2dbe4;
    }
    .Dashboard.Dashboard--fullscreen .DashboardHeader {
        background-color: transparent;
        border: medium none;
    }
    .Dashboard.Dashboard--fullscreen .Header-title-description {
        display: none;
    }
    .Dashboard.Dashboard--night {
        background-color: #222527;
    }
    .Dashboard.Dashboard--night .Header-button,
    .Dashboard.Dashboard--night .Header-button svg {
        color: hsla(0, 0%, 59%, 0.3);
    }
    .Dashboard.Dashboard--fullscreen .fullscreen-normal-text {
        color: #3f3a3a;
        transition: color 1s linear 0s;
    }
    .Dashboard.Dashboard--night.Dashboard--fullscreen .fullscreen-night-text {
        color: hsla(0, 0%, 100%, 0.86);
        transition: color 1s linear 0s;
    }
    .Dashboard.Dashboard--night .DashCard .Card svg text {
        fill: hsla(0, 0%, 100%, 0.86) !important;
    }
    .Dashboard.Dashboard--night .DashCard .Card {
        background-color: #363a3d;
        border: 1px solid #2e3134;
    }
    .Dashboard.Dashboard--night .enable-dots-onhover .dc-tooltip circle.dot:hover,
    .Dashboard.Dashboard--night .enable-dots .dc-tooltip circle.dot {
        fill: currentcolor;
    }
    .Dashboard.Dashboard--fullscreen,
    .Dashboard.Dashboard--fullscreen .DashCard .Card {
        transition: background-color 1s linear 0s, border 1s linear 0s;
    }
    .DashboardGrid {
        margin-top: 5px;
    }
    .DashCard {
        position: relative;
        z-index: 1;
    }
    .DashCard .Card {
        background-color: #fff;
        border: 1px solid #dbdbdb;
        bottom: 0;
        left: 0;
        overflow: hidden;
        position: absolute;
        right: 0;
        top: 0;
    }
    .Card-outer {
        height: 100%;
        overflow: hidden;
        width: 100%;
    }
    .Dash--editing .DashCard .Card {
        pointer-events: none;
        transition: border 0.3s ease 0s, background-color 0.3s ease 0s;
    }
    @keyframes fade-out-yellow {
        0% {
            background-color: #fffaf3;
        }
        100% {
            background-color: #fff;
        }
    }
    .Dash--editing .DashCard .Card.Card--recent {
        animation-duration: 30s;
        animation-name: fade-out-yellow;
    }
    .Dash--editing .DashCard:hover .Card .Card-heading {
        z-index: 2;
    }
    .DashCard .gm-bundled-control,
    .DashCard .gm-style-mtc,
    .DashCard .PinMapUpdateButton {
        opacity: 0.01;
        transition: opacity 0.3s linear 0s;
    }
    .DashCard:hover .gm-bundled-control,
    .DashCard:hover .gm-style-mtc,
    .DashCard:hover .PinMapUpdateButton {
        opacity: 1;
    }
    .Dash--editing .PinMap {
        pointer-events: all;
    }
    .PinMapUpdateButton--disabled {
        color: #dfdfdf;
        pointer-events: none;
    }
    .Dash--editing .DashCard .Card {
        -moz-user-select: none;
    }
    .DashCard .Card {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }
    .Dash--editing .DashCard.dragging .Card {
        box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.1);
    }
    .Dash--editing .DashCard.dragging,
    .Dash--editing .DashCard.resizing {
        z-index: 2;
    }
    .Dash--editing .DashCard.dragging .Card,
    .Dash--editing .DashCard.resizing .Card {
        background-color: #e5f1fb !important;
        border: 1px solid #509ee3;
    }
    .DashCard .DashCard-actions {
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s linear 0s;
    }
    .Dash--editing .DashCard:hover .DashCard-actions {
        height: initial;
        opacity: 1;
        pointer-events: all;
    }
    .Dash--editing .DashCard.dragging .DashCard-actions,
    .Dash--editing .DashCard.resizing .DashCard-actions {
        opacity: 0;
        transition: opacity 0.3s linear 0s;
    }
    .Dash--editing .DashCard {
        transition: transform 0.3s ease 0s, -webkit-transform 0.3s ease 0s;
    }
    .Dash--editing .DashCard.dragging,
    .Dash--editing .DashCard.resizing {
        transition: transform 0s ease 0s, -webkit-transform 0s ease 0s;
    }
    .Dash--editing .DashCard {
        cursor: move;
    }
    .Dash--editing .DashCard .react-resizable-handle {
        bottom: 0;
        cursor: nwse-resize;
        height: 40px;
        position: absolute;
        right: 0;
        width: 40px;
    }
    .Dash--editing .DashCard .react-resizable-handle::after {
        border-bottom: 2px solid #c6c6c6;
        border-bottom-right-radius: 2px;
        border-right: 2px solid #c6c6c6;
        bottom: 10px;
        content: "";
        height: 8px;
        opacity: 0.01;
        position: absolute;
        right: 10px;
        transition: opacity 0.2s ease 0s;
        width: 8px;
    }
    .Dash--editing .DashCard .react-resizable-handle:hover::after {
        border-color: #959595;
    }
    .Dash--editing .DashCard:hover .react-resizable-handle::after {
        opacity: 1;
    }
    .Dash--editing .DashCard.dragging .react-resizable-handle::after,
    .Dash--editing .DashCard.resizing .react-resizable-handle::after {
        opacity: 0.01;
    }
    .Dash--editing .react-grid-placeholder {
        background-color: #f2f2f2;
        transition: all 0.15s linear 0s;
        z-index: 0;
    }
    .Dash--editing .Card-title {
        pointer-events: none;
    }
    .Dash--editing.Dash--dragging .DashCard-actions {
        pointer-events: none !important;
    }
    .Modal.AddSeriesModal {
        height: 80%;
        max-height: 600px;
        max-width: 1024px;
        width: 80%;
    }
    .dc-chart .grid-line.horizontal {
        stroke: hsla(0, 0%, 59%, 0.2);
        stroke-dasharray: 5, 5;
    }
    .dc-chart .axis {
        z-index: -1;
    }
    .dc-chart .axis .domain,
    .dc-chart .axis .tick line {
        stroke: #ededed;
    }
    .dc-chart .axis .tick text {
        fill: #c5c6c8;
    }
    .dc-chart .axis.y .domain,
    .dc-chart .axis.y .tick line,
    .dc-chart .axis.yr .domain,
    .dc-chart .axis.yr .tick line {
        display: none;
    }
    .dc-chart .x-axis-label,
    .dc-chart .y-axis-label {
        fill: #a2a2a2;
    }
    .dc-chart .grid-line.horizontal line:first-child,
    .dc-chart .tick line {
        display: none;
    }
    .dc-chart rect.bar:hover {
        fill-opacity: 1;
    }
    .enable-dots .dc-tooltip circle.dot {
        fill: #fff;
        fill-opacity: 1 !important;
        stroke: currentcolor;
        stroke-opacity: 1 !important;
        stroke-width: 2;
    }
    .enable-dots .dc-tooltip circle.dot.hover,
    .enable-dots .dc-tooltip circle.dot:hover {
        fill: currentcolor;
    }
    .enable-dots-onhover .dc-tooltip circle.dot.hover,
    .enable-dots-onhover .dc-tooltip circle.dot:hover {
        fill: #fff;
        fill-opacity: 1 !important;
        stroke: currentcolor;
        stroke-opacity: 1 !important;
        stroke-width: 2;
    }
    .dc-chart .area,
    .dc-chart .bar,
    .dc-chart .dot,
    .dc-chart .line {
        transition: opacity 0.1s linear 0s;
    }
    .dc-chart .axis.y,
    .dc-chart .axis.yr,
    .dc-chart .y-axis-label,
    .dc-chart .yr-axis-label {
        transition: opacity 0.25s linear 0s;
    }
    .mute-0 .sub._0 .bar,
    .mute-0 .sub._0 .dot,
    .mute-0 .sub._0 .line,
    .mute-0 svg > g > .chart-body .dc-tooltip._0 .dot,
    .mute-0 svg > g > .chart-body .stack._0 .area,
    .mute-0 svg > g > .chart-body .stack._0 .line,
    .mute-1 .sub._1 .bar,
    .mute-1 .sub._1 .dot,
    .mute-1 .sub._1 .line,
    .mute-1 svg > g > .chart-body .dc-tooltip._1 .dot,
    .mute-1 svg > g > .chart-body .stack._1 .area,
    .mute-1 svg > g > .chart-body .stack._1 .line,
    .mute-2 .sub._2 .bar,
    .mute-2 .sub._2 .dot,
    .mute-2 .sub._2 .line,
    .mute-2 svg > g > .chart-body .dc-tooltip._2 .dot,
    .mute-2 svg > g > .chart-body .stack._2 .area,
    .mute-2 svg > g > .chart-body .stack._2 .line,
    .mute-3 .sub._3 .bar,
    .mute-3 .sub._3 .dot,
    .mute-3 .sub._3 .line,
    .mute-3 svg > g > .chart-body .dc-tooltip._3 .dot,
    .mute-3 svg > g > .chart-body .stack._3 .area,
    .mute-3 svg > g > .chart-body .stack._3 .line,
    .mute-4 .sub._4 .bar,
    .mute-4 .sub._4 .dot,
    .mute-4 .sub._4 .line,
    .mute-4 svg > g > .chart-body .dc-tooltip._4 .dot,
    .mute-4 svg > g > .chart-body .stack._4 .area,
    .mute-4 svg > g > .chart-body .stack._4 .line,
    .mute-5 .sub._5 .bar,
    .mute-5 .sub._5 .dot,
    .mute-5 .sub._5 .line,
    .mute-5 svg > g > .chart-body .dc-tooltip._5 .dot,
    .mute-5 svg > g > .chart-body .stack._5 .area,
    .mute-5 svg > g > .chart-body .stack._5 .line {
        opacity: 0.25;
    }
    .mute-yl .dc-chart .axis.y,
    .mute-yl .dc-chart .y-axis-label.y-label,
    .mute-yr .dc-chart .axis.yr,
    .mute-yr .dc-chart .y-axis-label.yr-label {
        opacity: 0;
    }
    .voronoi {
        fill: transparent;
    }
    @media screen and (min-width: 1280px) {
        .Dashboard.Dashboard--fullscreen {
            font-size: 1.2em;
        }
        .Dashboard.Dashboard--fullscreen .fullscreen-text-small .LegendItem,
        .Dashboard.Dashboard--fullscreen .Header-title-name {
            font-size: 1em;
        }
    }
    @media screen and (min-width: 1540px) {
        .Dashboard.Dashboard--fullscreen {
            font-size: 1.6em;
        }
    }
    .Dropdown {
        position: relative;
    }
    .Dropdown-content {
        background-clip: padding-box;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.063);
        border-radius: 4px;
        box-shadow: 0 0 2px rgba(0, 0, 0, 0.12);
        margin-top: 18px;
        min-width: 200px;
        opacity: 0;
        padding-bottom: 1em;
        padding-top: 1em;
        pointer-events: none;
        position: absolute;
        top: 40px;
        z-index: 20;
    }
    .Dropdown-content::before {
        border-left: 5px solid transparent;
        border-right: 5px solid red;
        content: "";
        display: block;
        position: absolute;
        right: 0;
        top: -20px;
    }
    .Dropdown--showing.Dropdown-content,
    .Dropdown.open .Dropdown-content {
        margin-top: 0;
        opacity: 1;
        pointer-events: all;
        transition: opacity 0.3s linear 0s, margin 0.2s linear 0s;
    }
    .Dropdown-item {
        line-height: 1;
        padding: 1rem 32px 1rem 2rem;
    }
    .Dropdown .Dropdown-item .link:hover {
        text-decoration: none;
    }
    .Dropdown-item:hover {
        background-color: #509ee3;
        color: #fff;
    }
    .Dropdown .Dropdown-item:hover {
        text-decoration: none;
    }
    .EntityField {
        border-bottom: 1px solid #f0f0f0;
        color: #777;
        padding: 12px 0 24px;
        position: relative;
    }
    .EntityField:hover {
        background-color: #fafafa;
    }
    .EntityInfo {
        margin-left: 64px;
    }
    .EntityFieldName {
        color: #777;
        font-size: 18px;
        font-weight: 700;
    }
    .EntityDescription {
        color: #999;
        display: block;
    }
    .EntityVisibility {
        margin: 17px 0 0 24px;
    }
    .EntityOriginalType {
        margin-left: 11px;
        margin-top: 11px;
    }
    .EntityCustomType {
        margin: 14px 24px 0 0;
    }
    .EntityFieldHidden {
        opacity: 0.4;
    }
    .CustomTypeApplied {
        border-color: #4a90e2;
        color: #4a90e2;
    }
    .EditedEntity {
        color: #4a90e2;
        position: relative;
    }
    .EntityField:hover .Drag-handle {
        display: block;
    }
    .Drag-handle {
        left: 5px;
        margin-top: -21px;
        position: absolute;
        top: 50%;
    }
    .Form-new {
        padding-top: 2rem;
    }
    .Form-label {
        color: #949494;
        display: block;
        font-size: 1.2rem;
    }
    .Form-field {
        color: #6c6c6c;
        margin-bottom: 1.5rem;
        position: relative;
    }
    .Form-field .Form-label {
        color: currentcolor;
        display: block;
        font-size: 0.85em;
        font-weight: 700;
    }
    .Form-field.Form--fieldError {
        color: #ef8c8c;
    }
    .Form-input {
        background-color: transparent;
        border: medium none;
        font-family: Lato;
        line-height: 1;
        padding-bottom: 0.6rem;
        padding-top: 0.6rem;
        transition: color 0.3s linear 0s;
    }
    .Form-message {
        opacity: 0;
        transition: none 0s ease 0s;
    }
    .Form-message.Form-message--visible {
        opacity: 1;
        transition: opacity 0.5s linear 0s;
    }
    .Form-input {
        font-size: 1rem;
    }
    @media screen and (min-width: 60em) {
        .Form-input {
            font-size: 1.25rem;
        }
    }
    @media screen and (min-width: 80em) {
        .Form-input {
            font-size: 1.571rem;
        }
    }
    .Form-input:focus {
        outline: medium none;
    }
    .Form-offset {
        padding-left: 2.4rem;
    }
    .Form-charm {
        background-color: #ddd;
        bottom: 0;
        box-sizing: border-box;
        display: block;
        height: 3em;
        left: 0;
        opacity: 0;
        position: absolute;
        transition: opacity 0.3s linear 0s;
        width: 0.15em;
    }
    .Form-field.Form--fieldError .Form-charm {
        background-color: #ef8c8c;
        opacity: 1;
    }
    .Form-input:focus + .Form-charm {
        background-color: #509ee3;
        opacity: 1;
    }
    .Form-field:hover .Form-input {
        background: rgba(0, 0, 0, 0.02) none repeat scroll 0 0;
        color: #ddd;
    }
    .Form-field:hover .Form-input.ng-dirty {
        background-color: #fff;
        color: #222;
    }
    .Form-field:hover .Form-charm {
        opacity: 1;
    }
    .Form-field:hover .Form-input:focus {
        background-color: transparent;
        color: #444;
        transition: background 0.3s linear 0s;
    }
    .Form-group {
        padding: 1em;
    }
    .Form-group,
    .Form-groupDisabled {
        transition: opacity 0.3s linear 0s;
    }
    .Form-groupDisabled {
        opacity: 0.2;
        pointer-events: none;
    }
    .Form-actions {
        align-items: center;
        display: flex;
        padding-bottom: 2.4rem;
        padding-left: 2.4rem;
    }
    .FormTitleSeparator {
        border-bottom: 1px solid #e8e8e8;
        position: relative;
    }
    :-moz-placeholder,
    *::-moz-placeholder {
        color: silver;
        opacity: 1;
    }
    .NewForm .Form-label {
        color: #aeaeae;
        margin-bottom: 0.5em;
        text-transform: uppercase;
    }
    .NewForm .Form-input {
        background-color: #fcfcfc;
        border: 1px solid #eaeaea;
        border-radius: 4px;
        color: #727479;
        font-size: 16px;
        padding: 0.5em;
    }
    .NewForm .Form-input:focus {
        border-color: #509ee3;
        box-shadow: none;
        outline: 0 none;
    }
    .NewForm .Form-header {
        padding: 2rem;
    }
    .NewForm .Form-inputs {
        padding-left: 2rem;
        padding-right: 2rem;
    }
    .NewForm .Form-actions {
        border-top: 1px solid #eaeaea;
        padding: 1.2rem 32px 1.2rem 2rem;
    }
    .Header-title {
        width: 455px;
    }
    .Header-title-name {
        color: #797979;
        font-size: 1.24em;
    }
    .Header-attribution {
        color: #adadad;
        display: none;
        margin-bottom: 0.5em;
    }
    .Header-buttonSection {
        border-right: 1px solid rgba(0, 0, 0, 0.2);
        margin-right: 1em;
        padding-right: 1em;
    }
    .Header-buttonSection:last-child {
        border-right: medium none;
        margin-right: 0;
        padding-right: 0;
    }
    .Header-button {
        margin-right: 1.5em;
    }
    .Header-button:last-child {
        margin-right: 0;
    }
    .EditHeader {
        background-color: #6cafed;
    }
    .EditHeader-title {
        color: #fff;
    }
    .EditHeader-subtitle {
        color: hsla(0, 0%, 100%, 0.5);
    }
    .EditHeader .Button {
        background-color: hsla(0, 0%, 100%, 0.5);
        border: medium none;
        color: #509ee3;
        font-size: 0.75rem;
        font-weight: 400;
        margin-left: 0.75em;
        text-transform: uppercase;
    }
    .EditHeader .Button,
    .EditHeader .Button--primary {
        background-color: #fff;
    }
    .EditHeader .Button:hover {
        background-color: #509ee3;
        color: #fff;
    }
    .IconWrapper {
        font-size: 0;
    }
    .Logo .Icon {
        height: 42.5px;
        width: 33px;
    }
    @keyframes icon-pulse {
        0% {
            box-shadow: 0 0 5px #509ee3;
        }
        50% {
            box-shadow: 0 0 5px rgba(80, 158, 227, 0.25);
        }
        100% {
            box-shadow: 0 0 5px #509ee3;
        }
    }
    .Icon--pulse {
        animation-duration: 2s;
        animation-iteration-count: infinite;
        animation-name: icon-pulse;
        animation-timing-function: linear;
        border-radius: 99px;
        box-shadow: 0 0 5px #509ee3;
        padding: 0.75em;
    }
    @media screen and (min-width: 60em) {
        .Logo .Icon {
            height: 85px;
            width: 66px;
        }
    }
    .MB-DataTable-header:hover {
        cursor: pointer;
    }
    .MB-DataTable-header .Icon {
        opacity: 0;
    }
    .MB-DataTable-header--sorted .Icon,
    .MB-DataTable-header:hover .Icon {
        opacity: 1;
        transition: opacity 0.3s linear 0s;
    }
    .PagingButtons {
        border: 1px solid #ddd;
    }
    .MB-DataTable-header--sorted {
        color: #509ee3;
    }
    .MB-DataTable .public_fixedDataTable_main {
        border-color: #cdcdcd;
    }
    .MB-DataTable .public_fixedDataTableCell_main {
        border-color: transparent #e8e8e8 #e8e8e8 transparent;
        border-style: solid;
        border-width: 1px;
    }
    .MB-DataTable .public_fixedDataTableCell_main:hover {
        border-color: #509ee3;
        color: #509ee3;
        cursor: pointer;
    }
    .MB-DataTable .public_fixedDataTableRow_highlighted,
    .MB-DataTable .public_fixedDataTableRow_highlighted .public_fixedDataTableCell_main {
        background-color: #fff;
    }
    .MB-DataTable .public_fixedDataTable_header,
    .MB-DataTable .public_fixedDataTable_header .public_fixedDataTableCell_main {
        background-color: #fff;
        background-image: none;
    }
    .MB-DataTable .public_fixedDataTable_header .public_fixedDataTableCell_main:hover {
        border-color: #e8e8e8;
    }
    .MB-DataTable .public_fixedDataTableCell_cellContent {
        display: block;
    }
    .MB-DataTable .cellData {
        overflow-x: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .MB-DataTable.MB-DataTable--ready .public_fixedDataTable_bodyRow .cellData,
    .MB-DataTable.MB-DataTable--ready .public_fixedDataTable_bodyRow .public_fixedDataTableCell_cellContent,
    .MB-DataTable.MB-DataTable--ready .public_fixedDataTable_bodyRow .public_fixedDataTableCell_wrap1,
    .MB-DataTable.MB-DataTable--ready .public_fixedDataTable_bodyRow .public_fixedDataTableCell_wrap2,
    .MB-DataTable.MB-DataTable--ready .public_fixedDataTable_bodyRow .public_fixedDataTableCell_wrap3 {
        display: block;
    }
    .Modal {
        background-color: #fff;
        border: 1px solid #d9d9d9;
        border-radius: 4px;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.12);
        left: 50%;
        margin: auto;
        max-height: 90%;
        outline: medium none;
        overflow-y: auto;
        position: fixed;
        top: 50%;
        transform: translate3d(-50%, -50%, 0px);
        width: 640px;
    }
    .Modal.Modal--small {
        width: 480px;
    }
    .Modal-backdrop {
        background-color: hsla(0, 0%, 100%, 0.6);
        bottom: 0;
        left: 0;
        position: fixed;
        right: 0;
        top: 0;
    }
    .Modal-backdrop.Modal-appear,
    .Modal-backdrop.Modal-enter {
        background-color: hsla(0, 0%, 100%, 0.01);
        transition: background-color 0.2s ease-in-out 0s;
    }
    .Modal-backdrop.Modal-appear-active,
    .Modal-backdrop.Modal-enter-active,
    .Modal-backdrop.Modal-leave {
        background-color: hsla(0, 0%, 100%, 0.6);
    }
    .Modal-backdrop.Modal-leave {
        transition: background-color 0.2s ease-in-out 0s;
    }
    .Modal-backdrop.Modal-leave-active {
        background-color: hsla(0, 0%, 100%, 0.01);
    }
    .Modal-backdrop.Modal-appear .Modal,
    .Modal-backdrop.Modal-enter .Modal {
        opacity: 0.01;
        transform: translate(-50%, -55%);
        transition: opacity 0.2s linear 0s, transform 0.2s ease-in-out 0s, -webkit-transform 0.2s ease-in-out 0s;
    }
    .Modal-backdrop.Modal-appear-active .Modal,
    .Modal-backdrop.Modal-enter-active .Modal,
    .Modal-backdrop.Modal-leave .Modal {
        opacity: 1;
        transform: translate(-50%, -50%);
    }
    .Modal-backdrop.Modal-leave .Modal {
        transition: opacity 0.2s linear 0s, transform 0.2s ease-in-out 0s, -webkit-transform 0.2s ease-in-out 0s;
    }
    .Modal-backdrop.Modal-leave-active .Modal {
        opacity: 0.01;
        transform: translate(-50%, -55%);
    }
    .PageFlag {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        background-color: #358df8;
        border-bottom-right-radius: 8px;
        border-color: #fff;
        border-image: none;
        border-style: solid;
        border-top-right-radius: 8px;
        border-width: 3px 3px 3px 1px;
        box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.5);
        box-sizing: content-box;
        color: #fff;
        display: inline-block;
        font-weight: 700;
        height: 24px;
        line-height: 24px;
        margin-left: 15px;
        min-width: 50px;
        padding-left: 0.5em;
        padding-right: 0.75em;
        position: relative;
        transition: left 0.5s ease-in-out 0s, top 0.5s ease-in-out 0s;
    }
    .PageFlag::after,
    .PageFlag::before {
        content: " ";
        height: 0;
        position: absolute;
        width: 0;
    }
    .PageFlag::after {
        border-bottom: 12px solid transparent;
        border-right: 12px solid #358df8;
        border-top: 12px solid transparent;
        left: -12px;
    }
    .PageFlag::before {
        border-bottom: 15px solid transparent;
        border-right: 15px solid #fff;
        border-top: 15px solid transparent;
        content: " ";
        left: -16px;
        top: -3px;
    }
    .PageFlag--large {
        height: 42px;
        line-height: 42px;
    }
    .PageFlag--large::after {
        border-width: 21px;
        left: -21px;
    }
    .PageFlag--large::before {
        border-width: 24px;
        left: -25px;
    }
    .PageFlag-enter {
        opacity: 0.01;
        transform: translateX(15px);
        transition: opacity 0.2s linear 0s, transform 0.2s linear 0s, -webkit-transform 0.2s linear 0s;
    }
    .PageFlag-enter-active,
    .PageFlag-leave {
        opacity: 1;
        transform: translateX(0px);
    }
    .PageFlag-leave {
        transition: opacity 0.2s linear 0s, transform 0.2s linear 0s, -webkit-transform 0.2s linear 0s;
    }
    .PageFlag-leave-active {
        opacity: 0.01;
        transform: translateX(15px);
    }
    .bounce-left {
        animation-duration: 1s;
        animation-name: bounceleft;
    }
    @keyframes bounceleft {
        0%, 5% {
            transform: translateX(50px);
        }
        15% {
            transform: translateX(0px);
        }
        30% {
            transform: translateX(25px);
        }
        40% {
            transform: translateX(0px);
        }
        50% {
            transform: translateX(15px);
        }
        70% {
            transform: translateX(0px);
        }
        80% {
            transform: translateX(7px);
        }
        90% {
            transform: translateX(0px);
        }
        95% {
            transform: translateX(3px);
        }
        97% {
            transform: translateX(0px);
        }
        99% {
            transform: translateX(1px);
        }
        100% {
            transform: translateX(0px);
        }
    }
    .PopoverContainer {
        pointer-events: none;
        position: absolute;
        z-index: 2147483647;
    }
    .PopoverBody {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 1px 7px rgba(0, 0, 0, 0.18);
        display: flex;
        flex-direction: column;
        min-width: 1em;
        pointer-events: auto;
        position: relative;
    }
    .PopoverBody.PopoverBody--tooltip {
        background-color: #4c4747;
        border: medium none;
        color: #fff;
        font-weight: 700;
        pointer-events: none;
    }
    .PopoverBody--withArrow::after,
    .PopoverBody--withArrow::before {
        border: 10px solid transparent;
        content: "";
        display: block;
        position: absolute;
    }
    .PopoverBody .Form-input {
        font-size: 1rem;
    }
    .PopoverBody .Form-field {
        margin-bottom: 0.75rem;
    }
    .PopoverHeader {
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        min-width: 400px;
    }
    .PopoverHeader-item {
        border-bottom: 2px solid transparent;
        color: #aeaeae;
        flex: 1 1 0;
        font-size: 0.8em;
        font-weight: 700;
        padding: 1em;
        position: relative;
        text-align: center;
        text-transform: uppercase;
        top: 1px;
    }
    .PopoverHeader-item.selected {
        border-color: currentcolor;
        color: currentcolor;
    }
    .PopoverHeader-item--withArrow {
        margin-right: 8px;
    }
    .PopoverHeader-item--withArrow::after,
    .PopoverHeader-item--withArrow::before {
        border: 8px solid transparent;
        content: "";
        display: block;
        margin-top: -8px;
        position: absolute;
        top: 50%;
    }
    .PopoverHeader-item--withArrow::before {
        border-left-color: #ddd;
        right: -16px;
    }
    .PopoverHeader-item--withArrow::after {
        border-left-color: #fff;
        right: -15px;
    }
    .tether-element-attached-top .PopoverBody--withArrow::before {
        border-bottom-color: #ddd;
        top: -20px;
    }
    .tether-element-attached-top .PopoverBody--tooltip::before {
        border-bottom: medium none;
    }
    .tether-element-attached-top .PopoverBody--withArrow::after {
        border-bottom-color: #fff;
        top: -18px;
    }
    .tether-element-attached-top .PopoverBody--tooltip::after {
        border-bottom-color: #4c4747;
    }
    .tether-element-attached-bottom .PopoverBody--withArrow::before {
        border-top-color: #ddd;
        bottom: -20px;
    }
    .tether-element-attached-bottom .PopoverBody--tooltip::before {
        border-top: medium none;
    }
    .tether-element-attached-bottom .PopoverBody--withArrow::after {
        border-top-color: #fff;
        bottom: -18px;
    }
    .tether-element-attached-bottom .PopoverBody--tooltip::after {
        border-top-color: #4c4747;
    }
    .tether-target-attached-right .PopoverBody--withArrow::after,
    .tether-target-attached-right .PopoverBody--withArrow::before {
        right: 12px;
    }
    .tether-element-attached-center .PopoverBody--withArrow::after,
    .tether-element-attached-center .PopoverBody--withArrow::before {
        left: -10px;
        margin-left: 50%;
    }
    .tether-element-attached-right .PopoverBody--withArrow::after,
    .tether-element-attached-right .PopoverBody--withArrow::before {
        right: 12px;
    }
    .tether-element-attached-left .PopoverBody--withArrow::after,
    .tether-element-attached-left .PopoverBody--withArrow::before {
        left: 12px;
    }
    #popover-event-target {
        height: 6px;
        pointer-events: none;
        position: fixed;
        width: 6px;
    }
    .Select {
        color: #777;
        display: inline-block;
        position: relative;
    }
    .Select::after,
    .Select::before {
        content: "";
        height: 0;
        pointer-events: none;
        position: absolute;
        right: 1em;
        top: 50%;
        width: 0;
    }
    .Select::before {
        border-bottom: 0.3rem solid #cacaca;
        margin-top: -0.25rem;
    }
    .Select::after,
    .Select::before {
        border-left: 0.3rem solid transparent;
        border-right: 0.3rem solid transparent;
    }
    .Select::after {
        border-top: 0.3rem solid #cacaca;
        margin-top: 0.2rem;
    }
    .Select select {
        -moz-appearance: none;
        background: #fff none repeat scroll 0 0;
        border: 1px solid #d9d9d9;
        border-radius: 4px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.12);
        color: #777;
        display: inline-block;
        font-size: 0.8em;
        line-height: 1;
        padding: 1rem 3rem 1rem 1rem;
        width: 100%;
    }
    .Select--blue select {
        background-color: #e3eef9;
        border-color: #c3d8f1;
        color: #4e92df;
    }
    .Select--blue::after {
        border-top: 0.3rem solid #4e92df;
    }
    .Select--blue::before {
        border-bottom: 0.3rem solid #4e92df;
    }
    .Select--purple select {
        background-color: #e7dfef;
        border-color: #cbbadb;
        color: #a88ac3;
    }
    .Select--purple::after {
        border-top: 0.3rem solid #a88ac3;
    }
    .Select--purple::before {
        border-bottom: 0.3rem solid #a88ac3;
    }
    .Select--small select {
        font-size: 0.7em;
        line-height: 1.5em;
        padding: 0.25rem 1.5rem 0.25rem 0.5rem;
    }
    .Select--small::after {
        margin-top: -0.1rem;
        right: 0.5em;
    }
    .Select--small::before {
        border-bottom: medium none;
    }
    .Select select:focus {
        outline: medium none;
    }
    .SortableItemList-list {
        overflow-y: auto;
    }
    .LoadingSpinner {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        animation: 0.8s linear 0s normal none infinite running LoadingSpinner-transition;
        border-color: currentcolor transparent transparent;
        border-image: none;
        border-radius: 99px;
        border-style: solid;
        border-width: 4px;
        box-sizing: border-box;
        display: inline-block;
        height: 32px;
        width: 32px;
    }
    .LoadingSpinner::after {
        -moz-border-bottom-colors: inherit;
        -moz-border-left-colors: inherit;
        -moz-border-right-colors: inherit;
        -moz-border-top-colors: inherit;
        border-color: currentcolor;
        border-image: inherit;
        border-radius: inherit;
        border-style: inherit;
        border-width: inherit;
        box-sizing: inherit;
        content: "";
        display: inherit;
        height: inherit;
        left: -4px;
        opacity: 0.25;
        position: relative;
        top: -4px;
        width: inherit;
    }
    @keyframes LoadingSpinner-transition {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(1turn);
        }
    }
    .TableWrapper {
        border: 1px solid #d9d9d9;
        overflow-x: scroll;
        width: 100%;
    }
    .Table,
    th {
        text-align: left;
    }
    .Table {
        border-collapse: collapse;
        border-spacing: 0;
        font-family: Lato,Helvetica Neue,Helvetica,sans-serif;        
        font-size: 0.875rem;
        line-height: 0.76rem;
        width: 100%;
    }
    .Table--bordered {
        border: 1px solid black;
    }
    .Table tr {
        border-bottom: 1px solid black;
    }
    .Table tr:nth-child(2n) {
        background-color: rgba(0, 0, 0, 0.02);
    }
    .Table td,
    .Table th {
        border-left: 2px solid black;
        border-right: 2px solid black;
        padding: 1em;
    }
    .EntityImage {
        background-color: #fafafa;
        border-radius: 99px;
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.12);
    }
    .EntityImage--small {
        height: 24px;
        width: 24px;
    }
    .EntityImage--large {
        height: 64px;
        width: 64px;
    }
    .EntityTableWrapper {
        margin: 1em;
    }
    .EntityName {
        margin-top: 0.25em;
    }
    .EntityTable tbody {
        color: #555f6b;
    }
    .EntityTable td {
        border: 1px solid #e7e7e7;
        padding: 5px;
    }
    @media screen and (min-width: 80em) {
        .EntityTable td {
            padding: 10px;
        }
    }
    #loader-icon {
        position: fixed;
        top: 50%;
        width: 100%;
        height: 100%;
        text-align: center;
        display: none;
    }
    .EntityTable .EntityTable--columnSelected {
        color: #4a90e2;
    }
    .EntityTable tbody tr:hover {
        background-color: #e3f0ff;
    }
    .EntityTable th {
        color: #555f6b;
        padding: 1em;
    }
    .EntityTable thead th:hover {
        cursor: pointer;
    }
    .Message {
        margin-top: 1em;
        padding-left: 1.5em;
    }
    .Message-sender {
        font-size: 0.8em;
    }
    .Message-text {
        color: #666;
        line-height: 1.5em;
        margin-top: 0.25em;
        max-width: 65%;
    }
    .Message--alt .Message-text {
        color: #4a90e2;
    }
    .Timestamp {
        color: #999;
        font-size: 0.8em;
    }
    .AdminNav {
        background: #6f7a8b none repeat scroll 0 0;
        color: #fff;
        font-size: 0.85rem;
        padding-bottom: 1.825em;
        padding-top: 1.825em;
    }
    .AdminGear {
        margin-right: 0.5em;
        margin-top: 0.25em;
    }
    .AdminNav .NavItem {
        color: hsla(0, 0%, 100%, 0.63);
    }
    .AdminNav .NavItem.is--selected,
    .AdminNav .NavItem:hover {
        color: #fff;
    }
    .AdminNav .NavItem.is--selected::after,
    .AdminNav .NavItem:hover::after {
        display: none;
    }
    .AdminNav .NavDropdown .NavDropdown-content-layer,
    .AdminNav .NavDropdown.open .NavDropdown-button {
        background-color: #8993a1;
    }
    .AdminNav .Dropdown-item:hover {
        background-color: #6f7a8b;
    }
    .AdminHoverItem:hover,
    .HoverItem:hover {
        background-color: #f3f8fd;
        transition: background 0.2s linear 0s;
    }
    .AdminNav .Dropdown-chevron {
        color: #fff;
    }
    .Actions {
        background-color: hsla(0, 0%, 95%, 0.46);
        border: 1px solid #e0e0e0;
        padding: 2em;
    }
    .Actions-group {
        margin-bottom: 2em;
    }
    .Actions-group:last-child {
        margin-bottom: 0;
    }
    .Actions-group.Actions--dangerZone {
        color: #ef8c8c;
    }
    .Actions-groupLabel {
        font-size: 0.85em;
        margin-bottom: 1em;
    }
    .ContentTable {
        border-collapse: collapse;
        border-spacing: 0;
        text-align: left;
        width: 100%;
    }
    .ContentTable thead {
        border-bottom: 1px solid #d8d8d8;
    }
    .AdminBadge {
        background-color: #509EE7;
        border-radius: 4px;
        color: #fff;
        padding: 0.25em;
    }
    .PageHeader {
        padding-bottom: 2.375rem;
        padding-top: 2.375rem;
    }
    .PageTitle {
        margin: 0;
    }
    .Table-actions {
        text-align: right;
    }
    .ContentTable .Table-actions {
        opacity: 0;
    }
    .ContentTable td,
    .ContentTable th {
        padding: 1em;
    }
    .ContentTable tbody tr:hover {
        background-color: rgba(74, 144, 226, 0.04);
    }
    .ContentTable tr:hover .Table-actions {
        opacity: 1;
        transition: opacity 0.2s linear 0s;
    }
    .DatabaseList,
    .TableFieldList {
        height: 100%;
        left: 0;
        overflow-y: scroll;
        padding-bottom: 3em;
        position: absolute;
        right: 0;
    }
    .DatabaseListItem .h4 {
        line-height: 0.8em;
    }
    .DatabaseListItem.DatabaseListItem--active {
        background-color: #e3eefa;
        color: #4a90e2;
    }
    #id_sql {
        height: 200px;
    }
    .DatabaseTablesAdmin {
        overflow: hidden;
    }
    .TableField {
        border-bottom: 1px solid #f0f0f0;
        padding-left: 3em;
    }
    .TableField-name {
        color: #676c72;
    }
    .DatabaseTablesAdmin .editable-click {
        border-bottom: medium none;
        font-size: 0.8em;
        font-style: normal;
    }
    .DatabaseTablesAdmin .editable-click:hover,
    .DatabaseTablesAdmin .editable-empty:hover {
        color: inherit !important;
        font-style: normal;
    }
    .DatabaseTablesAdmin .editable-empty {
        font-style: normal;
    }
    .Select--unselected {
        border-style: dotted !important;
    }
    .ScrollShadow {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
    .AdminList {
        background-color: #f9fbfc;
        border: 1px solid #f0f0f0;
        border-radius: 4px;
        box-shadow: -1px -1px 3px rgba(0, 0, 0, 0.05) inset;
        padding-bottom: 0.75em;
        width: 266px;
    }
    .AdminList-search {
        position: relative;
    }
    .AdminList-search .Icon {
        bottom: 0;
        color: silver;
        margin: auto auto auto 1em;
        position: absolute;
        top: 0;
    }
    .AdminList-search .AdminInput {
        border-bottom-color: #f0f0f0;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
        font-size: 18px;
        padding: 0.5em 0.5em 0.5em 2em;
        width: 100%;
    }
    .AdminList-item {
        border: 1px solid transparent;
        border-radius: 4px;
        margin-bottom: 0.25em;
        padding: 0.75em 1em;
    }
    .AdminList-item.selected {
        color: #509ee3;
    }
    .AdminList-item.selected,
    .AdminList-item:hover {
        background-color: #fff;
        border-color: #f0f0f0;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        margin-left: -0.5em;
        margin-right: -0.5em;
        padding-left: 1.5em;
        padding-right: 1.5em;
    }
    .AdminList-section {
        color: #c6c6c6;
        font-size: smaller;
        font-weight: 700;
        margin-top: 1em;
        padding: 0.5em 1em;
        text-transform: uppercase;
    }
    .AdminList-item .ProgressBar {
        opacity: 0.2;
    }
    .AdminList-item.selected .ProgressBar {
        opacity: 1;
    }
    .AdminInput {
        background-color: #fcfcfc;
        border: 1px solid transparent;
        color: #727479;
        padding: 0.5rem;
    }
    .AdminInput:focus {
        border-color: #509ee3;
        box-shadow: none;
        outline: 0 none;
    }
    .AdminSelect {
        border: 1px solid #f0f0f0;
        border-radius: 4px;
        min-width: 90px;
        padding: 0.6em;
    }
    .AdminSelect,
    .AdminSelectBorderless {
        display: inline-block;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 3px;
    }
    .MetadataTable-title {
        background-color: #fcfcfc;
    }
    .TableEditor-table-name {
        font-size: 24px;
    }
    .TableEditor-field-name {
        font-size: 16px;
    }
    .TableEditor-field-description,
    .TableEditor-table-description {
        font-size: 14px;
    }
    .TableEditor-field-visibility .ColumnarSelector-row:hover {
        background-color: #509ee3 !important;
        color: #fff !important;
    }
    .TableEditor-field-type .ColumnarSelector-row:hover {
        background-color: #509ee3 !important;
        color: #fff !important;
    }
    .TableEditor-field-special-type .ColumnarSelector-row:hover,
    .TableEditor-field-target .ColumnarSelector-row:hover {
        background-color: #509ee3 !important;
        color: #fff !important;
    }
    .Toggle {
        background-color: #f7f7f7;
        border: 1px solid #eaeaea;
        border-radius: 99px;
        box-sizing: border-box;
        color: #509ee3;
        display: inline-block;
        height: 24px;
        position: relative;
        transition: all 0.3s ease 0s;
        width: 48px;
    }
    .Toggle.selected {
        background-color: currentcolor;
    }
    .Toggle::after {
        background-color: #d9d9d9;
        left: 1px;
        transition: all 0.3s ease 0s;
    }
    .Toggle.selected::after,
    .Toggle::after {
        border-radius: 99px;
        content: "";
        height: 20px;
        position: absolute;
        top: 1px;
        width: 20px;
    }
    .Toggle.selected::after {
        background-color: #fff;
        left: 25px;
    }
    .ProgressBar {
        border: 1px solid #6f7a8b;
        border-radius: 99px;
        height: 10px;
        position: relative;
        width: 55px;
    }
    .ProgressBar--mini {
        border-radius: 2px;
        height: 8px;
        width: 17px;
    }
    .ProgressBar-progress {
        background-color: #6f7a8b;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: inherit;
        border-top-left-radius: 0;
        border-top-right-radius: inherit;
        height: 100%;
        left: 0;
        position: absolute;
        top: 0;
    }
    .SaveStatus {
        line-height: 1;
    }
    .SaveStatus:last-child {
        border-right: medium none !important;
    }
    .SettingsInput {
        width: 400px;
    }
    .SettingsPassword {
        width: 200px;
    }
    .UserRolePopover .ColumnarSelector-column {
        min-height: 180px;
    }
    .UserActionsSelect {
        min-width: 180px;
        padding-top: 1em;
    }
    .AdminTable {
        border-collapse: collapse;
        border-spacing: 0;
        text-align: left;
        white-space: nowrap;
    }
    .AdminTable th {
        color: #959595;
        font-weight: 400;
        padding: 0.5rem;
        text-transform: uppercase;
    }
    .AdminTable thead {
        border-bottom: 1px solid #f0f0f0;
    }
    .AdminTable tbody tr:first-child td {
        padding-top: 0.5rem;
    }
    .arrow-right {
        position: relative;
    }
    .arrow-right::after,
    .arrow-right::before {
        border: 10px solid transparent;
        content: "";
        display: block;
        position: absolute;
    }
    .arrow-right::before {
        border-left-color: #ddd;
        right: -20px;
    }
    .arrow-right::after {
        border-left-color: #fff;
        right: -19px;
    }
    .arrow-right::after,
    .arrow-right::before {
        margin-top: -10px;
        top: 50%;
    }
    body,
    html {
        height: 100%;
    }
    body {
        color: #727479;
        display: flex;
        flex-direction: column;
        font-family: Lato, Helvetica Neue, Helvetica, sans-serif;
        font-size: 0.875em;
        margin: 0;
        text-rendering: optimizelegibility;
    }
    ol,
    ul {
        list-style-type: none;
    }
    button,
    ol,
    ul {
        margin: 0;
        padding: 0;
    }
    button {
        border: 0 none;
        font-size: 100%;
        outline: medium none;
    }
    a {
        color: inherit;
        cursor: pointer;
    }
    input,
    textarea {
        font-family: Lato, Helvetica Neue, Helvetica, sans-serif;
    }
    .disabled {
        opacity: 0.4;
        pointer-events: none;
    }
    .MB-lightBG {
        background-color: #f9fbfc;
    }
    .bordered {
        border: 1px solid #f0f0f0;
    }
    .border-bottom {
        border-bottom: 1px solid #f0f0f0;
    }
    .bordered .border-bottom:last-child {
        border-bottom: medium none;
    }
    .border-top {
        border-top: 1px solid #f0f0f0;
    }
    .bordered .border-top:first-child {
        border-top: medium none;
    }
    .border-column-divider {
        border-right: 1px solid #f0f0f0;
    }
    .border-column-divider:last-child {
        border-right: medium none;
    }
    .border-row-divider {
        border-bottom: 1px solid #f0f0f0;
    }
    .border-row-divider:last-child {
        border-bottom: medium none;
    }
    .border-right {
        border-right: 1px solid #f0f0f0;
    }
    .border-left {
        border-left: 1px solid #f0f0f0;
    }
    .border-light {
        border-color: hsla(0, 0%, 100%, 0.2) !important;
    }
    .border-dark {
        border-color: rgba(0, 0, 0, 0.2) !important;
    }
    .border-purple {
        border-color: #509EE7 !important;
    }
    .border-error {
        border-color: #ef8c8c !important;
    }
    .border-gold {
        border-color: #f9d45c !important;
    }
    .border-success {
        border-color: #9cc177 !important;
    }
    .border-brand {
        border-color: #509ee3 !important;
    }
    .border-brand-hover:hover {
        border-color: #509ee3;
    }
    .border-hover:hover {
        border-color: silver;
    }
    .borderless {
        border: medium none !important;
    }
    .border-dashed {
        border-style: dashed;
    }
    article,
    body,
    div,
    fieldset,
    footer,
    form,
    header,
    input,
    li,
    main,
    nav,
    section,
    span,
    table,
    textarea,
    ul {
        box-sizing: border-box;
    }
    .clearfix::after,
    .clearfix::before {
        content: " ";
        display: table;
    }
    .clearfix::after {
        clear: both;
    }
    .clearfix {} .text-default {
        color: #727479;
    }
    .text-brand,
    .text-brand-hover:hover {
        color: #509ee3;
    }
    .text-brand-darken,
    .text-brand-darken-hover:hover {
        color: #407eb6;
    }
    .text-brand-light,
    .text-brand-light-hover:hover {
        color: #cde3f8;
    }
    .bg-brand,
    .bg-brand-hover:hover {
        background-color: #74AFAD;
    }
    .text-success {
        color: #9cc177;
    }
    .bg-success {
        background-color: #9cc177;
    }
    .text-error,
    .text-error-hover:hover {
        color: #ef8c8c;
    }
    .bg-error,
    .bg-error-hover:hover {
        background-color: #ef8c8c;
    }
    .bg-error-input {
        background-color: #fce8e8;
    }
    .text-headsup {
        color: #f5a623;
    }
    .bg-headsup {
        background-color: #f5a623;
    }
    .text-warning {
        color: #e35050;
    }
    .bg-warning {
        background-color: #e35050;
    }
    .text-gold,
    .text-gold-hover:hover {
        color: #f9d45c;
    }
    .text-purple,
    .text-purple-hover:hover {
        color: #509EE7;
    }
    .text-purple-light,
    .text-purple-light-hover:hover {
        color: #c5abdb;
    }
    .text-green,
    .text-green-hover:hover {
        color: #9cc177;
    }
    .text-orange {
        color: #f9a354;
    }
    .text-slate {
        color: #9ba5b1;
    }
    .text-slate-light {
        color: #dfe8ea;
    }
    .bg-gold {
        background-color: #f9d45c;
    }
    .bg-purple {
        background-color: #509EE7;
    }
    .bg-purple-light {
        background-color: #c5abdb;
    }
    .bg-green {
        background-color: #9cc177;
    }
    .bg-alt {
        background-color: #f5f7f9;
    }
    .text-grey-1,
    .text-grey-1-hover:hover {
        color: #dfdfdf;
    }
    .text-grey-2,
    .text-grey-2-hover:hover {
        color: #c6c6c6;
    }
    .text-grey-3,
    .text-grey-3-hover:hover {
        color: #aeaeae;
    }
    .text-grey-4,
    .text-grey-4-hover:hover {
        color: #959595;
    }
    .bg-grey-0 {
        background-color: #f8f8f8;
    }
    .bg-grey-1 {
        background-color: #dfdfdf;
    }
    .bg-grey-2 {
        background-color: #c6c6c6;
    }
    .bg-grey-3 {
        background-color: #aeaeae;
    }
    .bg-grey-4 {
        background-color: #959595;
    }
    .text-dark {
        color: #4c545b;
    }
    .text-white,
    .text-white-hover:hover {
        color: #fff;
    }
    .bg-white {
        background-color: #fff;
    }
    .flex {
        display: flex;
    }
    .flex-full {
        flex: 1 1 0;
    }
    .flex-half {
        flex: 0.5 1 0;
    }
    .flex-no-shrink {
        flex-shrink: 0;
    }
    .align-center {
        align-items: center;
    }
    .align-baseline {
        align-items: baseline;
    }
    .justify-center {
        justify-content: center;
    }
    .justify-between {
        justify-content: space-between;
    }
    .align-start {
        align-items: flex-start;
    }
    .align-self-end {
        align-self: flex-end;
    }
    .flex-align-right {
        margin-left: auto;
    }
    @media screen and (min-width: 40em) {
        .sm-flex-align-right {
            margin-left: auto;
        }
    }
    @media screen and (min-width: 60em) {
        .md-flex-align-right {
            margin-left: auto;
        }
    }
    @media screen and (min-width: 80em) {
        .lg-flex-align-right {
            margin-left: auto;
        }
    }
    .layout-centered {
        align-items: center;
        justify-content: center;
    }
    @media screen and (min-width: 40em) {
        .sm-layout-centered {
            align-items: center;
            justify-content: center;
        }
    }
    @media screen and (min-width: 60em) {
        .md-layout-centered {
            align-items: center;
            justify-content: center;
        }
    }
    @media screen and (min-width: 80em) {
        .lg-layout-centered {
            align-items: center;
            justify-content: center;
        }
    }
    .flex-column {
        flex-direction: column;
    }
    @media screen and (min-width: 40em) {
        .sm-flex-column {
            flex-direction: column;
        }
    }
    @media screen and (min-width: 60em) {
        .md-flex-column {
            flex-direction: column;
        }
    }
    .flex-row {
        flex-direction: row;
    }
    .flex-wrap {
        flex-wrap: wrap;
    }
    .flex-reverse {
        flex-direction: row-reverse;
    }
    @media screen and (min-width: 40em) {
        .sm-flex-reverse {
            flex-direction: row-reverse;
        }
    }
    @media screen and (min-width: 60em) {
        .md-flex-reverse {
            flex-direction: row-reverse;
        }
    }
    @media screen and (min-width: 80em) {
        .lg-flex-reverse {
            flex-direction: row-reverse;
        }
    }
    @media screen and (min-width: 120em) {
        .xl-flex-reverse {
            flex-direction: row-reverse;
        }
    }
    .no-flex {
        flex: 0 1 0;
    }
    @media screen and (min-width: 60em) {
        .md-no-flex {
            flex: 0 1 0 !important;
        }
    }
    .float-left {
        float: left;
    }
    .float-right {
        float: right;
    }
    .Grid {
        display: flex;
        flex-wrap: wrap;
        list-style: outside none none;
        margin: 0;
        padding: 0;
    }
    .Grid--normal > .Grid-cell,
    .Grid-cell {
        flex: 1 1 0;
    }
    .Grid--flexCells > .Grid-cell {
        display: flex;
    }
    .Grid--top {
        align-items: flex-start;
    }
    .Grid--bottom {
        align-items: flex-end;
    }
    .Grid--center {
        align-items: center;
    }
    .Grid--justifyCenter {
        justify-content: center;
    }
    .Grid-cell--top {
        align-self: flex-start;
    }
    .Grid-cell--bottom {
        align-self: flex-end;
    }
    .Grid-cell--center {
        align-self: center;
    }
    .Grid-cell--autoSize {
        flex: 0 0 auto;
    }
    .Grid--fit > .Grid-cell {
        flex: 1 1 0;
    }
    .Grid--full > .Grid-cell {
        flex: 0 0 100%;
    }
    .Grid--1of2 > .Grid-cell {
        flex: 0 0 50%;
    }
    .Grid--1of3 > .Grid-cell {
        flex: 0 0 33.3333%;
    }
    .Grid--1of4 > .Grid-cell {
        flex: 0 0 25%;
    }
    @media (min-width: 40em) {
        .small-Grid--fit > .Grid-cell {
            flex: 1 1 0;
        }
        .small-Grid--full > .Grid-cell {
            flex: 0 0 100%;
        }
        .small-Grid--1of2 > .Grid-cell {
            flex: 0 0 50%;
        }
        .small-Grid--1of3 > .Grid-cell {
            flex: 0 0 33.3333%;
        }
        .small-Grid--1of4 > .Grid-cell {
            flex: 0 0 25%;
        }
    }
    @media (min-width: 60em) {
        .md-Grid--fit > .Grid-cell {
            flex: 1 1 0;
        }
        .md-Grid--full > .Grid-cell {
            flex: 0 0 100%;
        }
        .md-Grid--1of2 > .Grid-cell {
            flex: 0 0 50%;
        }
        .md-Grid--1of3 > .Grid-cell {
            flex: 0 0 33.3333%;
        }
        .md-Grid--1of4 > .Grid-cell {
            flex: 0 0 25%;
        }
    }
    @media (min-width: 80em) {
        .large-Grid--fit > .Grid-cell {
            flex: 1 1 0;
        }
        .large-Grid--full > .Grid-cell {
            flex: 0 0 100%;
        }
        .large-Grid--1of2 > .Grid-cell {
            flex: 0 0 50%;
        }
        .large-Grid--1of3 > .Grid-cell {
            flex: 0 0 33.3333%;
        }
        .large-Grid--1of4 > .Grid-cell {
            flex: 0 0 25%;
        }
    }
    .Grid--gutters {
        margin: -1em 0 1em -1em;
    }
    .Grid--gutters > .Grid-cell {
        padding: 1em 0 0 1em;
    }
    .Grid--guttersLg {
        margin: -1.5em 0 1.5em -1.5em;
    }
    .Grid--guttersLg > .Grid-cell {
        padding: 1.5em 0 0 1.5em;
    }
    .Grid--guttersXl {
        margin: -2em 0 2em -2em;
    }
    .Grid--guttersXl > .Grid-cell {
        padding: 2em 0 0 2em;
    }
    @media (min-width: 40em) {
        .small-Grid--gutters {
            margin: -1em 0 1em -1em;
        }
        .small-Grid--gutters > .Grid-cell {
            padding: 1em 0 0 1em;
        }
        .small-Grid--guttersLg {
            margin: -1.5em 0 1.5em -1.5em;
        }
        .small-Grid--guttersLg > .Grid-cell {
            padding: 1.5em 0 0 1.5em;
        }
        .small-Grid--guttersXl {
            margin: -2em 0 2em -2em;
        }
        .small-Grid--guttersXl > .Grid-cell {
            padding: 2em 0 0 2em;
        }
        .sm-Grid--normal > .Grid-cell {
            flex: 1 1 0;
        }
    }
    @media (min-width: 60em) {
        .md-Grid--gutters {
            margin: -1em 0 1em -1em;
        }
        .md-Grid--gutters > .Grid-cell {
            padding: 1em 0 0 1em;
        }
        .md-Grid--guttersLg {
            margin: -1.5em 0 1.5em -1.5em;
        }
        .md-Grid--guttersLg > .Grid-cell {
            padding: 1.5em 0 0 1.5em;
        }
        .md-Grid--guttersXl {
            margin: -2em 0 2em -2em;
        }
        .md-Grid--guttersXl > .Grid-cell {
            padding: 2em 0 0 2em;
        }
        .md-Grid--normal > .Grid-cell {
            flex: 1 1 0;
        }
    }
    @media (min-width: 80em) {
        .large-Grid--gutters {
            margin: -1em 0 1em -1em;
        }
        .large-Grid--gutters > .Grid-cell {
            padding: 1em 0 0 1em;
        }
        .large-Grid--guttersLg {
            margin: -1.5em 0 1.5em -1.5em;
        }
        .large-Grid--guttersLg > .Grid-cell {
            padding: 1.5em 0 0 1.5em;
        }
        .large-Grid--guttersXl {
            margin: -2em 0 2em -2em;
        }
        .large-Grid--guttersXl > .Grid-cell {
            padding: 2em 0 0 2em;
        }
    }
    .Grid-cell.Cell--1of3 {
        flex: 0 0 33.3333%;
    }
    @media screen and (min-width: 40em) {
        .Grid-cell.sm-Cell--1of3 {
            flex: 0 0 33.3333%;
        }
    }
    @media screen and (min-width: 60em) {
        .Grid-cell.md-Cell--1of3 {
            flex: 0 0 33.3333%;
        }
    }
    @media screen and (min-width: 80em) {
        .Grid-cell.lg-Cell--1of3 {
            flex: 0 0 33.3333%;
        }
    }
    @media screen and (min-width: 120em) {
        .Grid-cell.xl-Cell--1of3 {
            flex: 0 0 33.3333%;
        }
    }
    .h1,
    .h2,
    .h3,
    .h4,
    .h5,
    .h6,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        margin-bottom: 0;
        margin-top: 0;
    }
    .h1 {
        font-size: 2em;
    }
    .h2 {
        font-size: 1.5em;
    }
    .h3 {
        font-size: 1.17em;
    }
    .h4 {
        font-size: 1.12em;
    }
    .h5 {
        font-size: 0.83em;
    }
    .h6 {
        font-size: 0.75em;
    }
    .hide {
        display: none !important;
    }
    .show {} .lg-show,
    .md-show,
    .sm-show,
    .xl-show {
        display: none;
    }
    @media screen and (min-width: 40em) {
        .sm-hide {
            display: none !important;
        }
    }
    @media screen and (min-width: 40em) {
        .sm-show {
            display: inherit !important;
        }
    }
    @media screen and (min-width: 60em) {
        .md-hide {
            display: none !important;
        }
    }
    @media screen and (min-width: 60em) {
        .md-show {
            display: inherit !important;
        }
    }
    @media screen and (min-width: 80em) {
        .lg-hide {
            display: none !important;
        }
    }
    @media screen and (min-width: 80em) {
        .lg-show {
            display: inherit !important;
        }
    }
    @media not all {
        .xl-hide {
            display: none !important;
        }
    }
    @media screen and (min-width: 120em) {
        .xl-show {
            display: inherit !important;
        }
    }
    .input {
        border: 1px solid #d9d9d9;
        border-radius: 4px;
        padding: 0.8rem 1rem;
        transition: border 0.3s linear 0s;
    }
    .input--small {
        padding: 0.3rem 0.4rem;
    }
    .input--focus,
    .input:focus {
        border: 1px solid #4e82c0;
        outline: medium none;
        transition: border 0.3s linear 0s;
    }
    .input--borderless,
    .input--borderless:focus {
        border: medium none !important;
        box-shadow: none;
        outline: 0 none;
    }
    .input:disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }
    .no-focus:focus {
        outline: 0 none;
    }
    .wrapper {
        margin: 0 auto;
        width: 100%;
    }
    @media screen and (min-width: 40em) {
        .wrapper {
            padding-left: 2em;
            padding-right: 2em;
        }
    }
    @media screen and (min-width: 60em) {
        .wrapper {
            padding-left: 3em;
            padding-right: 3em;
        }
    }
    .full-height {
        height: 100%;
    }
    .viewport-height {
        height: 100vh;
    }
    .scroll-y {
        overflow-y: auto;
    }
    .scroll-x {
        overflow-x: auto;
    }
    .block {
        display: block;
    }
    .inline-block {
        display: inline-block;
    }
    .table {
        display: table;
    }
    .full {
        width: 100%;
    }
    .half {
        width: 50%;
    }
    .fixed {
        position: fixed;
    }
    .relative {
        position: relative;
    }
    .absolute {
        position: absolute;
    }
    .top {
        top: 0;
    }
    .right {
        right: 0;
    }
    .bottom {
        bottom: 0;
    }
    .left {
        left: 0;
    }
    @media screen and (min-width: 60em) {
        .wrapper.wrapper--trim {
            max-width: 940px;
        }
    }
    @media screen and (min-width: 60em) {
        .wrapper.wrapper--small {
            max-width: 752px;
        }
    }
    .spread {
        bottom: 0;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
    }
    .link,
    .no-decoration {
        text-decoration: none;
    }
    .link {
        color: #4a90e2;
    }
    .link:hover {
        text-decoration: underline;
    }
    .link--nohover:hover {
        text-decoration: none;
    }
    .expand-clickable {
        display: inline-block;
        margin: -0.5em;
        padding: 0.5em;
        position: relative;
        z-index: 1;
    }
    .rounded {
        border-radius: 4px;
    }
    .rounded-top {
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }
    .rounded-bottom {
        border-bottom-left-radius: 4px;
        border-bottom-right-radius: 4px;
    }
    .rounded-left {
        border-bottom-left-radius: 4px;
        border-top-left-radius: 4px;
    }
    .rounded-right {
        border-bottom-right-radius: 4px;
        border-top-right-radius: 4px;
    }
    .circular {
        border-radius: 99px !important;
    }
    .shadowed {
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.08);
    }
    .ml-auto {
        margin-left: auto;
    }
    .mr-auto {
        margin-right: auto;
    }
    .p0 {
        padding: 0;
    }
    .pt0 {
        padding-top: 0;
    }
    .pb0 {
        padding-bottom: 0;
    }
    .pl0 {
        padding-left: 0;
    }
    .pr0 {
        padding-right: 0;
    }
    .p1 {
        padding: 0.5rem;
    }
    .px1 {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    .py1 {
        padding-bottom: 0.5rem;
    }
    .pt1,
    .py1 {
        padding-top: 0.5rem;
    }
    .pb1 {
        padding-bottom: 0.5rem;
    }
    .pl1 {
        padding-left: 0.5rem;
    }
    .pr1 {
        padding-right: 0.5rem;
    }
    .p2 {
        padding: 1rem;
    }
    .px2 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    .py2 {
        padding-bottom: 1rem;
    }
    .pt2,
    .py2 {
        padding-top: 1rem;
    }
    .pb2 {
        padding-bottom: 1rem;
    }
    .pl2 {
        padding-left: 1rem;
    }
    .pr2 {
        padding-right: 1rem;
    }
    .p3 {
        padding: 1.5rem;
    }
    .px3 {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
    .py3 {
        padding-bottom: 1.5rem;
    }
    .pt3,
    .py3 {
        padding-top: 1.5rem;
    }
    .pb3 {
        padding-bottom: 1.5rem;
    }
    .pl3 {
        padding-left: 1.5rem;
    }
    .pr3 {
        padding-right: 1.5rem;
    }
    .p4 {
        padding: 2rem;
    }
    .px4 {
        padding-left: 2rem;
        padding-right: 2rem;
    }
    .py4 {
        padding-bottom: 2rem;
    }
    .pt4,
    .py4 {
        padding-top: 2rem;
    }
    .pb4 {
        padding-bottom: 2rem;
    }
    .pl4 {
        padding-left: 2rem;
    }
    .pr4 {
        padding-right: 2rem;
    }
    .m0 {
        margin: 0;
    }
    .mt0 {
        margin-top: 0;
    }
    .mb0 {
        margin-bottom: 0;
    }
    .ml0 {
        margin-left: 0;
    }
    .mr0 {
        margin-right: 0;
    }
    .m1 {
        margin: 0.5rem;
    }
    .mx1 {
        margin-left: 0.5rem;
        margin-right: 0.5rem;
    }
    .my1 {
        margin-bottom: 0.5rem;
    }
    .mt1,
    .my1 {
        margin-top: 0.5rem;
    }
    .mb1 {
        margin-bottom: 0.5rem;
    }
    .ml1 {
        margin-left: 0.5rem;
    }
    .mr1 {
        margin-right: 0.5rem;
    }
    .m2 {
        margin: 1rem;
    }
    .mx2 {
        margin-left: 1rem;
        margin-right: 1rem;
    }
    .my2 {
        margin-bottom: 1rem;
    }
    .mt2,
    .my2 {
        margin-top: 1rem;
    }
    .mb2 {
        margin-bottom: 1rem;
    }
    .ml2 {
        margin-left: 1rem;
    }
    .mr2 {
        margin-right: 1rem;
    }
    .m3 {
        margin: 1.5rem;
    }
    .mx3 {
        margin-left: 1.5rem;
        margin-right: 1.5rem;
    }
    .my3 {
        margin-bottom: 1.5rem;
    }
    .mt3,
    .my3 {
        margin-top: 1.5rem;
    }
    .mb3 {
        margin-bottom: 1.5rem;
    }
    .ml3 {
        margin-left: 1.5rem;
    }
    .mr3 {
        margin-right: 1.5rem;
    }
    .m4 {
        margin: 2rem;
    }
    .mx4 {
        margin-left: 2rem;
        margin-right: 2rem;
    }
    .my4 {
        margin-bottom: 2rem;
    }
    .mt4,
    .my4 {
        margin-top: 2rem;
    }
    .mb4 {
        margin-bottom: 2rem;
    }
    .ml4 {
        margin-left: 2rem;
    }
    .mr4 {
        margin-right: 2rem;
    }
    @media screen and (min-width: 40em) {
        .sm-p0 {
            padding: 0;
        }
        .sm-pt0 {
            padding-top: 0;
        }
        .sm-pb0 {
            padding-bottom: 0;
        }
        .sm-pl0 {
            padding-left: 0;
        }
        .sm-pr0 {
            padding-right: 0;
        }
        .sm-p1 {
            padding: 0.5rem;
        }
        .sm-px1 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        .sm-py1 {
            padding-bottom: 0.5rem;
        }
        .sm-pt1,
        .sm-py1 {
            padding-top: 0.5rem;
        }
        .sm-pb1 {
            padding-bottom: 0.5rem;
        }
        .sm-pl1 {
            padding-left: 0.5rem;
        }
        .sm-pr1 {
            padding-right: 0.5rem;
        }
        .sm-p2 {
            padding: 1rem;
        }
        .sm-px2 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .sm-py2 {
            padding-bottom: 1rem;
        }
        .sm-pt2,
        .sm-py2 {
            padding-top: 1rem;
        }
        .sm-pb2 {
            padding-bottom: 1rem;
        }
        .sm-pl2 {
            padding-left: 1rem;
        }
        .sm-pr2 {
            padding-right: 1rem;
        }
        .sm-p3 {
            padding: 1.5rem;
        }
        .sm-px3 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        .sm-py3 {
            padding-bottom: 1.5rem;
        }
        .sm-pt3,
        .sm-py3 {
            padding-top: 1.5rem;
        }
        .sm-pb3 {
            padding-bottom: 1.5rem;
        }
        .sm-pl3 {
            padding-left: 1.5rem;
        }
        .sm-pr3 {
            padding-right: 1.5rem;
        }
        .sm-p4 {
            padding: 2rem;
        }
        .sm-px4 {
            padding-left: 2rem;
            padding-right: 2rem;
        }
        .sm-py4 {
            padding-bottom: 2rem;
        }
        .sm-pt4,
        .sm-py4 {
            padding-top: 2rem;
        }
        .sm-pb4 {
            padding-bottom: 2rem;
        }
        .sm-pl4 {
            padding-left: 2rem;
        }
        .sm-pr4 {
            padding-right: 2rem;
        }
        .sm-m0 {
            margin: 0;
        }
        .sm-mt0 {
            margin-top: 0;
        }
        .sm-mb0 {
            margin-bottom: 0;
        }
        .sm-ml0 {
            margin-left: 0;
        }
        .sm-mr0 {
            margin-right: 0;
        }
        .sm-m1 {
            margin: 0.5rem;
        }
        .sm-mx1 {
            margin-left: 0.5rem;
            margin-right: 0.5rem;
        }
        .sm-my1 {
            margin-bottom: 0.5rem;
        }
        .sm-mt1,
        .sm-my1 {
            margin-top: 0.5rem;
        }
        .sm-mb1 {
            margin-bottom: 0.5rem;
        }
        .sm-ml1 {
            margin-left: 0.5rem;
        }
        .sm-mr1 {
            margin-right: 0.5rem;
        }
        .sm-m2 {
            margin: 1rem;
        }
        .sm-mx2 {
            margin-left: 1rem;
            margin-right: 1rem;
        }
        .sm-my2 {
            margin-bottom: 1rem;
        }
        .sm-mt2,
        .sm-my2 {
            margin-top: 1rem;
        }
        .sm-mb2 {
            margin-bottom: 1rem;
        }
        .sm-ml2 {
            margin-left: 1rem;
        }
        .sm-mr2 {
            margin-right: 1rem;
        }
        .sm-m3 {
            margin: 1.5rem;
        }
        .sm-mx3 {
            margin-left: 1.5rem;
            margin-right: 1.5rem;
        }
        .sm-my3 {
            margin-bottom: 1.5rem;
        }
        .sm-mt3,
        .sm-my3 {
            margin-top: 1.5rem;
        }
        .sm-mb3 {
            margin-bottom: 1.5rem;
        }
        .sm-ml3 {
            margin-left: 1.5rem;
        }
        .sm-mr3 {
            margin-right: 1.5rem;
        }
        .sm-m4 {
            margin: 2rem;
        }
        .sm-mx4 {
            margin-left: 2rem;
            margin-right: 2rem;
        }
        .sm-my4 {
            margin-bottom: 2rem;
        }
        .sm-mt4,
        .sm-my4 {
            margin-top: 2rem;
        }
        .sm-mb4 {
            margin-bottom: 2rem;
        }
        .sm-ml4 {
            margin-left: 2rem;
        }
        .sm-mr4 {
            margin-right: 2rem;
        }
    }
    @media screen and (min-width: 60em) {
        .md-p0 {
            padding: 0;
        }
        .md-pt0 {
            padding-top: 0;
        }
        .md-pb0 {
            padding-bottom: 0;
        }
        .md-pl0 {
            padding-left: 0;
        }
        .md-pr0 {
            padding-right: 0;
        }
        .md-p1 {
            padding: 0.5rem;
        }
        .md-px1 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        .md-py1 {
            padding-bottom: 0.5rem;
        }
        .md-pt1,
        .md-py1 {
            padding-top: 0.5rem;
        }
        .md-pb1 {
            padding-bottom: 0.5rem;
        }
        .md-pl1 {
            padding-left: 0.5rem;
        }
        .md-pr1 {
            padding-right: 0.5rem;
        }
        .md-p2 {
            padding: 1rem;
        }
        .md-px2 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .md-py2 {
            padding-bottom: 1rem;
        }
        .md-pt2,
        .md-py2 {
            padding-top: 1rem;
        }
        .md-pb2 {
            padding-bottom: 1rem;
        }
        .md-pl2 {
            padding-left: 1rem;
        }
        .md-pr2 {
            padding-right: 1rem;
        }
        .md-p3 {
            padding: 1.5rem;
        }
        .md-px3 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        .md-py3 {
            padding-bottom: 1.5rem;
        }
        .md-pt3,
        .md-py3 {
            padding-top: 1.5rem;
        }
        .md-pb3 {
            padding-bottom: 1.5rem;
        }
        .md-pl3 {
            padding-left: 1.5rem;
        }
        .md-pr3 {
            padding-right: 1.5rem;
        }
        .md-p4 {
            padding: 2rem;
        }
        .md-px4 {
            padding-left: 2rem;
            padding-right: 2rem;
        }
        .md-py4 {
            padding-bottom: 2rem;
        }
        .md-pt4,
        .md-py4 {
            padding-top: 2rem;
        }
        .md-pb4 {
            padding-bottom: 2rem;
        }
        .md-pl4 {
            padding-left: 2rem;
        }
        .md-pr4 {
            padding-right: 2rem;
        }
        .md-m0 {
            margin: 0;
        }
        .md-mt0 {
            margin-top: 0;
        }
        .md-mb0 {
            margin-bottom: 0;
        }
        .md-ml0 {
            margin-left: 0;
        }
        .md-mr0 {
            margin-right: 0;
        }
        .md-m1 {
            margin: 0.5rem;
        }
        .md-mx1 {
            margin-left: 0.5rem;
            margin-right: 0.5rem;
        }
        .md-my1 {
            margin-bottom: 0.5rem;
        }
        .md-mt1,
        .md-my1 {
            margin-top: 0.5rem;
        }
        .md-mb1 {
            margin-bottom: 0.5rem;
        }
        .md-ml1 {
            margin-left: 0.5rem;
        }
        .md-mr1 {
            margin-right: 0.5rem;
        }
        .md-m2 {
            margin: 1rem;
        }
        .md-mx2 {
            margin-left: 1rem;
            margin-right: 1rem;
        }
        .md-my2 {
            margin-bottom: 1rem;
        }
        .md-mt2,
        .md-my2 {
            margin-top: 1rem;
        }
        .md-mb2 {
            margin-bottom: 1rem;
        }
        .md-ml2 {
            margin-left: 1rem;
        }
        .md-mr2 {
            margin-right: 1rem;
        }
        .md-m3 {
            margin: 1.5rem;
        }
        .md-mx3 {
            margin-left: 1.5rem;
            margin-right: 1.5rem;
        }
        .md-my3 {
            margin-bottom: 1.5rem;
        }
        .md-mt3,
        .md-my3 {
            margin-top: 1.5rem;
        }
        .md-mb3 {
            margin-bottom: 1.5rem;
        }
        .md-ml3 {
            margin-left: 1.5rem;
        }
        .md-mr3 {
            margin-right: 1.5rem;
        }
        .md-m4 {
            margin: 2rem;
        }
        .md-mx4 {
            margin-left: 2rem;
            margin-right: 2rem;
        }
        .md-my4 {
            margin-bottom: 2rem;
        }
        .md-mt4,
        .md-my4 {
            margin-top: 2rem;
        }
        .md-mb4 {
            margin-bottom: 2rem;
        }
        .md-ml4 {
            margin-left: 2rem;
        }
        .md-mr4 {
            margin-right: 2rem;
        }
    }
    @media screen and (min-width: 80em) {
        .lg-p0 {
            padding: 0;
        }
        .lg-pt0 {
            padding-top: 0;
        }
        .lg-pb0 {
            padding-bottom: 0;
        }
        .lg-pl0 {
            padding-left: 0;
        }
        .lg-pr0 {
            padding-right: 0;
        }
        .lg-p1 {
            padding: 0.5rem;
        }
        .lg-px1 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        .lg-py1 {
            padding-bottom: 0.5rem;
        }
        .lg-pt1,
        .lg-py1 {
            padding-top: 0.5rem;
        }
        .lg-pb1 {
            padding-bottom: 0.5rem;
        }
        .lg-pl1 {
            padding-left: 0.5rem;
        }
        .lg-pr1 {
            padding-right: 0.5rem;
        }
        .lg-p2 {
            padding: 1rem;
        }
        .lg-px2 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .lg-py2 {
            padding-bottom: 1rem;
        }
        .lg-pt2,
        .lg-py2 {
            padding-top: 1rem;
        }
        .lg-pb2 {
            padding-bottom: 1rem;
        }
        .lg-pl2 {
            padding-left: 1rem;
        }
        .lg-pr2 {
            padding-right: 1rem;
        }
        .lg-p3 {
            padding: 1.5rem;
        }
        .lg-px3 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        .lg-py3 {
            padding-bottom: 1.5rem;
        }
        .lg-pt3,
        .lg-py3 {
            padding-top: 1.5rem;
        }
        .lg-pb3 {
            padding-bottom: 1.5rem;
        }
        .lg-pl3 {
            padding-left: 1.5rem;
        }
        .lg-pr3 {
            padding-right: 1.5rem;
        }
        .lg-p4 {
            padding: 2rem;
        }
        .lg-px4 {
            padding-left: 2rem;
            padding-right: 2rem;
        }
        .lg-py4 {
            padding-bottom: 2rem;
        }
        .lg-pt4,
        .lg-py4 {
            padding-top: 2rem;
        }
        .lg-pb4 {
            padding-bottom: 2rem;
        }
        .lg-pl4 {
            padding-left: 2rem;
        }
        .lg-pr4 {
            padding-right: 2rem;
        }
        .lg-m0 {
            margin: 0;
        }
        .lg-mt0 {
            margin-top: 0;
        }
        .lg-mb0 {
            margin-bottom: 0;
        }
        .lg-ml0 {
            margin-left: 0;
        }
        .lg-mr0 {
            margin-right: 0;
        }
        .lg-m1 {
            margin: 0.5rem;
        }
        .lg-mx1 {
            margin-left: 0.5rem;
            margin-right: 0.5rem;
        }
        .lg-my1 {
            margin-bottom: 0.5rem;
        }
        .lg-mt1,
        .lg-my1 {
            margin-top: 0.5rem;
        }
        .lg-mb1 {
            margin-bottom: 0.5rem;
        }
        .lg-ml1 {
            margin-left: 0.5rem;
        }
        .lg-mr1 {
            margin-right: 0.5rem;
        }
        .lg-m2 {
            margin: 1rem;
        }
        .lg-mx2 {
            margin-left: 1rem;
            margin-right: 1rem;
        }
        .lg-my2 {
            margin-bottom: 1rem;
        }
        .lg-mt2,
        .lg-my2 {
            margin-top: 1rem;
        }
        .lg-mb2 {
            margin-bottom: 1rem;
        }
        .lg-ml2 {
            margin-left: 1rem;
        }
        .lg-mr2 {
            margin-right: 1rem;
        }
        .lg-m3 {
            margin: 1.5rem;
        }
        .lg-mx3 {
            margin-left: 1.5rem;
            margin-right: 1.5rem;
        }
        .lg-my3 {
            margin-bottom: 1.5rem;
        }
        .lg-mt3,
        .lg-my3 {
            margin-top: 1.5rem;
        }
        .lg-mb3 {
            margin-bottom: 1.5rem;
        }
        .lg-ml3 {
            margin-left: 1.5rem;
        }
        .lg-mr3 {
            margin-right: 1.5rem;
        }
        .lg-m4 {
            margin: 2rem;
        }
        .lg-mx4 {
            margin-left: 2rem;
            margin-right: 2rem;
        }
        .lg-my4 {
            margin-bottom: 2rem;
        }
        .lg-mt4,
        .lg-my4 {
            margin-top: 2rem;
        }
        .lg-mb4 {
            margin-bottom: 2rem;
        }
        .lg-ml4 {
            margin-left: 2rem;
        }
        .lg-mr4 {
            margin-right: 2rem;
        }
    }
    @media screen and (min-width: 120em) {
        .xl-p0 {
            padding: 0;
        }
        .xl-pt0 {
            padding-top: 0;
        }
        .xl-pb0 {
            padding-bottom: 0;
        }
        .xl-pl0 {
            padding-left: 0;
        }
        .xl-pr0 {
            padding-right: 0;
        }
        .xl-p1 {
            padding: 0.5rem;
        }
        .xl-px1 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        .xl-py1 {
            padding-bottom: 0.5rem;
        }
        .xl-pt1,
        .xl-py1 {
            padding-top: 0.5rem;
        }
        .xl-pb1 {
            padding-bottom: 0.5rem;
        }
        .xl-pl1 {
            padding-left: 0.5rem;
        }
        .xl-pr1 {
            padding-right: 0.5rem;
        }
        .xl-p2 {
            padding: 1rem;
        }
        .xl-px2 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .xl-py2 {
            padding-bottom: 1rem;
        }
        .xl-pt2,
        .xl-py2 {
            padding-top: 1rem;
        }
        .xl-pb2 {
            padding-bottom: 1rem;
        }
        .xl-pl2 {
            padding-left: 1rem;
        }
        .xl-pr2 {
            padding-right: 1rem;
        }
        .xl-p3 {
            padding: 1.5rem;
        }
        .xl-px3 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        .xl-py3 {
            padding-bottom: 1.5rem;
        }
        .xl-pt3,
        .xl-py3 {
            padding-top: 1.5rem;
        }
        .xl-pb3 {
            padding-bottom: 1.5rem;
        }
        .xl-pl3 {
            padding-left: 1.5rem;
        }
        .xl-pr3 {
            padding-right: 1.5rem;
        }
        .xl-p4 {
            padding: 2rem;
        }
        .xl-px4 {
            padding-left: 2rem;
            padding-right: 2rem;
        }
        .xl-py4 {
            padding-bottom: 2rem;
        }
        .xl-pt4,
        .xl-py4 {
            padding-top: 2rem;
        }
        .xl-pb4 {
            padding-bottom: 2rem;
        }
        .xl-pl4 {
            padding-left: 2rem;
        }
        .xl-pr4 {
            padding-right: 2rem;
        }
        .xl-m0 {
            margin: 0;
        }
        .xl-mt0 {
            margin-top: 0;
        }
        .xl-mb0 {
            margin-bottom: 0;
        }
        .xl-ml0 {
            margin-left: 0;
        }
        .xl-mr0 {
            margin-right: 0;
        }
        .xl-m1 {
            margin: 0.5rem;
        }
        .xl-mx1 {
            margin-left: 0.5rem;
            margin-right: 0.5rem;
        }
        .xl-my1 {
            margin-bottom: 0.5rem;
        }
        .xl-mt1,
        .xl-my1 {
            margin-top: 0.5rem;
        }
        .xl-mb1 {
            margin-bottom: 0.5rem;
        }
        .xl-ml1 {
            margin-left: 0.5rem;
        }
        .xl-mr1 {
            margin-right: 0.5rem;
        }
        .xl-m2 {
            margin: 1rem;
        }
        .xl-mx2 {
            margin-left: 1rem;
            margin-right: 1rem;
        }
        .xl-my2 {
            margin-bottom: 1rem;
        }
        .xl-mt2,
        .xl-my2 {
            margin-top: 1rem;
        }
        .xl-mb2 {
            margin-bottom: 1rem;
        }
        .xl-ml2 {
            margin-left: 1rem;
        }
        .xl-mr2 {
            margin-right: 1rem;
        }
        .xl-m3 {
            margin: 1.5rem;
        }
        .xl-mx3 {
            margin-left: 1.5rem;
            margin-right: 1.5rem;
        }
        .xl-my3 {
            margin-bottom: 1.5rem;
        }
        .xl-mt3,
        .xl-my3 {
            margin-top: 1.5rem;
        }
        .xl-mb3 {
            margin-bottom: 1.5rem;
        }
        .xl-ml3 {
            margin-left: 1.5rem;
        }
        .xl-mr3 {
            margin-right: 1.5rem;
        }
        .xl-m4 {
            margin: 2rem;
        }
        .xl-mx4 {
            margin-left: 2rem;
            margin-right: 2rem;
        }
        .xl-my4 {
            margin-bottom: 2rem;
        }
        .xl-mt4,
        .xl-my4 {
            margin-top: 2rem;
        }
        .xl-mb4 {
            margin-bottom: 2rem;
        }
        .xl-ml4 {
            margin-left: 2rem;
        }
        .xl-mr4 {
            margin-right: 2rem;
        }
    }
    .text-centered {
        text-align: center;
    }
    @media screen and (min-width: 40em) {
        .sm-text-centered {
            text-align: center;
        }
    }
    @media screen and (min-width: 60em) {
        .md-text-centered {
            text-align: center;
        }
    }
    @media screen and (min-width: 80em) {
        .lg-text-centered {
            text-align: center;
        }
    }
    @media screen and (min-width: 120em) {
        .xl-text-centered {
            text-align: center;
        }
    }
    .text-left {
        text-align: left;
    }
    @media screen and (min-width: 40em) {
        .sm-text-left {
            text-align: left;
        }
    }
    @media screen and (min-width: 60em) {
        .md-text-left {
            text-align: left;
        }
    }
    @media screen and (min-width: 80em) {
        .lg-text-left {
            text-align: left;
        }
    }
    @media screen and (min-width: 120em) {
        .xl-text-left {
            text-align: left;
        }
    }
    .text-right {
        text-align: right;
    }
    @media screen and (min-width: 40em) {
        .sm-text-right {
            text-align: right;
        }
    }
    @media screen and (min-width: 60em) {
        .md-text-right {
            text-align: right;
        }
    }
    @media screen and (min-width: 80em) {
        .lg-text-right {
            text-align: right;
        }
    }
    @media screen and (min-width: 120em) {
        .xl-text-right {
            text-align: right;
        }
    }
    .text-uppercase {
        text-transform: uppercase;
    }
    .text-lowercase {
        text-transform: lowercase;
    }
    .text-light {
        font-weight: 300;
    }
    .text-normal {
        font-weight: 400;
    }
    .text-strong {} .text-bold {
        font-weight: 700;
    }
    .text-italic {
        font-style: italic;
    }
    .text-body {
        color: #8e9ba9;
        font-size: 1.286em;
        line-height: 1.457em;
    }
    .text-current {
        color: currentcolor;
    }
    .text-underline,
    .text-underline-hover:hover {
        text-decoration: underline;
    }
    .text-ellipsis {
        text-overflow: ellipsis;
    }
    .transition-color {
        transition: color 0.3s linear 0s;
    }
    .transition-background {
        transition: background 0.2s linear 0s;
    }
    .transition-shadow {
        transition: box-shadow 0.2s linear 0s;
    }
    .transition-all {
        transition: all 0.2s linear 0s;
    }
    .editable-click,
    .editable-empty,
    a.editable-click,
    a.editable-empty {
        color: #666;
    }
    .editable-input {
        border: 1px solid #d9d9d9;
        min-width: 200px;
        outline: medium none;
        padding: 0.8rem 1rem;
    }
    .editable-textarea .editable-input {
        display: block;
    }
    .Nav {
        z-index: 2;
    }
    .CheckBg {
        background-image: url("/app/components/icons/assets/header_rect.svg");
        background-repeat: repeat;
    }
    .CheckBg-offset {} .NavItem {
        border-radius: 8px;
    }
    .NavItem.NavItem--selected,
    .NavItem:hover {
        background-color: hsla(0, 0%, 100%, 0.08);
    }
    .NavNewQuestion {
        box-shadow: 0 2px 2px 0 rgba(77, 136, 189, 0.69);
    }
    .NavNewQuestion:hover {
        box-shadow: 0 3px 2px 2px rgba(77, 136, 189, 0.75);
        color: #3875ac;
    }
    .Greeting {
        padding-bottom: 3rem;
        padding-top: 2rem;
    }
    @media screen and (min-width: 120em) {
        .Greeting {
            padding-bottom: 6em;
            padding-top: 6em;
        }
    }
    .bullet {
        margin-left: 1.2em;
        position: relative;
    }
    .bullet::before {
        color: #74AFAD;
        content: "•";
        left: -0.85em;
        margin-top: 16px;
        position: absolute;
        top: 0;
    }
    .NavDropdown {
        position: relative;
    }
    .NavDropdown.open {
        z-index: 100;
    }
    .NavDropdown .NavDropdown-content {
        display: none;
    }
    .NavDropdown.open .NavDropdown-content {
        display: inherit;
    }
    .NavDropdown .NavDropdown-button {
        border-radius: 8px;
        position: relative;
    }
    .NavDropdown .NavDropdown-content {
        border-radius: 4px;
        min-width: 200px;
        position: absolute;
        top: 38px;
    }
    .NavDropdown .NavDropdown-content.NavDropdown-content--dashboards {
        top: 33px;
    }
    .NavDropdown .NavDropdown-button::before,
    .NavDropdown .NavDropdown-content::before {
        background-clip: padding-box;
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.12);
        content: "";
        height: 100%;
        left: 0;
        position: absolute;
        top: 0;
        width: 100%;
    }
    .NavDropdown .NavDropdown-content::before {
        border-radius: 4px;
        z-index: -2;
    }
    .NavDropdown .NavDropdown-button::before {
        border-radius: 8px;
        z-index: -1;
    }
    .NavDropdown .NavDropdown-content-layer {
        overflow: hidden;
        position: relative;
        z-index: 1;
    }
    .NavDropdown .NavDropdown-button-layer {
        position: relative;
        z-index: 2;
    }
    .NavDropdown .NavDropdown-content-layer,
    .NavDropdown.open .NavDropdown-button {
        background-color: #74AFAD;
    }
    .NavDropdown .NavDropdown-content-layer {
        border-radius: 4px;
        padding-top: 10px;
    }
    .NavDropdown .DashboardList {
        min-width: 332px;
    }
    .QuestionCircle {
        border: 3px solid currentcolor;
        border-radius: 99px;
        display: inline-block;
        font-size: 3.25rem;
        height: 73px;
        text-align: center;
        width: 73px;
    }
    .IconCircle {
        border: 1px solid currentcolor;
        border-radius: 99px;
        line-height: 0;
        padding: 0.5rem;
    }
    @keyframes pop {
        0% {
            transform: scale(0.75);
        }
        75% {
            transform: scale(1.0625);
        }
        100% {
            transform: scale(1);
        }
    }
    .animate-pop {
        animation-duration: 0.15s;
        animation-name: popin;
        animation-timing-function: ease-out;
    }
    .AdminLink {
        opacity: 0.435;
    }
    .AdminLink:hover {
        opacity: 1;
    }
    .break-word {
        word-wrap: break-word;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    .tooltip {
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.12);
        color: #ddd;
        position: absolute;
    }
    .TableDescription {
        line-height: 1.4;
        max-width: 42rem;
    }
    .Layout-sidebar {
        background-color: #f9fbfc;
        border-left: 2px solid #f0f0f0;
        min-height: 100vh;
        width: 346px;
    }
    .Layout-mainColumn {
        margin-left: auto;
        margin-right: auto;
        max-width: 700px;
    }
    .Sidebar-header {
        font-size: 13px;
        letter-spacing: 0.5px;
        line-height: 1;
        text-transform: uppercase;
    }
    .Login-wrapper {
        margin: 0 auto;
        max-width: 1240px;
    }
    .Login-content {
        position: relative;
        z-index: 1000;
    }
    .Login-header {
        color: #6a6a6a;
    }
    .brand-scene {
        height: 180px;
        overflow: hidden;
        z-index: 4;
    }
    .brand-boat-container {
        bottom: 0;
        margin-bottom: 0.5em;
        position: absolute;
        z-index: 6;
    }
    .brand-boat {
        animation: 2s ease-in-out 0s alternate none infinite running boat_rock;
        transform-origin: 50% bottom 0;
    }
    @keyframes boat_trip {
        0% {
            margin-left: -2%;
        }
        10% {
            margin-left: 5%;
        }
        100% {
            margin-left: 120%;
        }
    }
    @keyframes boat_lost {
        0% {
            margin-left: 40%;
        }
        0%,
        45% {
            transform: rotateY(0deg);
        }
        45% {
            margin-left: 60%;
        }
        50% {
            margin-left: 60%;
        }
        50%,
        95% {
            transform: rotateY(180deg);
        }
        95%,
        100% {
            margin-left: 40%;
        }
        100% {
            transform: rotateY(0deg);
        }
    }
    @keyframes boat_rock {
        0% {
            transform: rotate(-10deg);
        }
        100% {
            transform: rotate(10deg);
        }
    }
    .brand-illustration {
        bottom: 15px;
        display: flex;
        height: 180px;
        margin: 0 auto;
        position: absolute;
        z-index: 5;
    }
    .brand-bridge {
        margin-left: -140px;
    }
    .brand-mountain-1 {
        position: relative;
        z-index: 50;
    }
    .NotFoundScene .brand-bridge,
    .NotFoundScene .brand-illustration,
    .NotFoundScene .brand-mountain-1 {
        display: none;
    }
    .NotFoundScene .brand-boat-container {
        animation: 30s linear 0s normal none infinite running boat_lost;
    }
    .brand-mountain-2 {
        margin-left: -170px;
        transform: scaleX(-1);
    }
    .SuccessGroup {
        align-items: center;
        flex-direction: column;
        padding: 4em;
    }
    .SuccessGroup,
    .SuccessMark {
        color: #9cc177;
        display: flex;
    }
    .SuccessMark {
        border: 3px solid #9cc177;
        border-radius: 99px;
        line-height: 1;
        padding: 1em;
    }
    .SuccessText {
        font-weight: 700;
        margin-top: 1em;
        text-align: center;
    }
    .ForgotForm,
    .SuccessGroup {
        position: relative;
        z-index: 10;
    }
    .PulseEdit-footer,
    .PulseEdit-header {
        margin: 0 auto;
        padding-left: 180px;
        padding-right: 180px;
        width: 100%;
    }
    .PulseEdit-content {
        margin-left: 180px;
        max-width: 550px;
    }
    .PulseButton {
        color: #79827f;
        font-weight: 700;
    }
    .PulseButton,
    .PulseEdit .AdminSelect,
    .PulseEdit .border-bottom,
    .PulseEdit .border-row-divider,
    .PulseEdit .bordered,
    .PulseEdit .input {
        border-color: #dee4e2;
        border-width: 2px;
    }
    .PulseEdit .AdminSelect {
        padding: 1em;
    }
    .PulseEdit .input--focus,
    .PulseEdit .input:focus {
        border-color: #61a7e5 !important;
        border-width: 2px;
    }
    .PulseListItem button {
        font-family: Lato, Helvetica, sans-serif;
    }
    .bg-grey-0 {
        background-color: #fcfcfd;
    }
    .PulseEditButton {
        opacity: 0;
        transition: opacity 0.3s linear 0s;
    }
    .PulseListItem {
        overflow: hidden;
    }
    .PulseListItem:hover .PulseEditButton {
        opacity: 1;
    }
    .PulseListItem.PulseListItem--focused {
        border-color: #509ee3;
        box-shadow: 0 0 3px #509ee3;
    }
    .DangerZone:hover {
        border-color: #ef8c8c;
        transition: border 0.3s ease-in 0s;
    }
    .DangerZone .Button--danger {
        background: #fbfcfd none repeat scroll 0 0;
        border: 1px solid #ddd;
        color: #444;
        opacity: 0.4;
    }
    .DangerZone:hover .Button--danger {
        background-color: #ef8c8c;
        border-color: #ef8c8c;
        color: #fff;
        opacity: 1;
    }
    .Modal.WhatsAPulseModal {
        width: auto;
    }
    #react_qb_viz {
        flex-grow: 1;
    }
    .QueryBuilder {
        transition: margin-right 0.35s ease 0s;
    }
    .QueryBuilder--showDataReference {
        margin-right: 300px;
    }
    .QueryHeader-details {
        align-items: center;
        display: flex;
    }
    .QueryHeader-section {
        border-right: 1px solid rgba(0, 0, 0, 0.2);
        margin-right: 1em;
        padding-right: 1em;
    }
    .QueryHeader-section:last-child {
        border-right: medium none;
    }
    .Icon-addToDash,
    .Icon-download {
        fill: #919191;
        transition: fill 0.3s linear 0s;
    }
    .Icon-addToDash:hover,
    .Icon-download:hover {
        fill: #509ee3;
        transition: fill 0.3s linear 0s;
    }
    .Query-section {
        align-items: center;
        display: flex;
    }
    .Query-section.Query-section--right {
        justify-content: flex-end;
    }
    .QueryName {
        font-size: 1.2rem;
        font-weight: 200;
        margin-bottom: 0;
        margin-top: 0;
    }
    .Query-label {
        color: #aeaeae;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .Query-filters {
        max-width: 400px;
    }
    .Query-filterList {
        min-height: 55px;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
    }
    .Query-filter,
    .Query-filterList {
        display: flex;
    }
    .Query-filter {
        border: 2px solid transparent;
        border-radius: 4px;
        flex-shrink: 0;
        font-size: 0.75em;
    }
    .Query-filter.selected {
        border-color: #c5abdb;
    }
    .Filter-section {
        align-items: center;
        display: flex;
        flex-shrink: 0;
    }
    .Query-filter .input {
        background-color: transparent;
        border: medium none;
        border-radius: 0;
        font-size: inherit;
        padding: 0;
        width: 150px;
    }
    .QueryTable-wrapper {
        border-top: 1px solid #e8e8e8;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        margin-bottom: 3px;
        overflow: scroll;
    }
    .TooltipFilterList .Query-filter {
        padding-bottom: 0 !important;
        padding-left: 0 !important;
    }
    .TooltipFilterList .Query-filterList {
        flex-direction: column;
    }
    .TooltipFilterList .Query-section {
        margin-left: -0.5rem;
    }
    .SelectionModule {
        color: #509ee3;
    }
    .SelectionList {
        max-height: 340px;
        overflow-y: auto;
        padding-top: 5px;
    }
    .SelectionItems {
        max-width: 320px;
    }
    .SelectionItems.SelectionItems--open {
        opacity: 1;
        pointer-events: all;
        transition: opacity 0.3s linear 0s;
    }
    .SelectionItems.SelectionItems--expanded {
        max-height: inherit;
    }
    .SelectionItem {
        align-items: center;
        background-color: #fff;
        cursor: pointer;
        display: flex;
        padding: 0.75rem 1.5rem 0.75rem 0.75rem;
    }
    .SelectionItem:hover {
        background-color: currentcolor;
    }
    .SelectionItem .Icon {
        color: currentcolor;
        margin-left: 0.5rem;
        margin-right: 0.75rem;
    }
    .SelectionItem .Icon-check {
        opacity: 0;
    }
    .SelectionItem .Icon-chevrondown {
        opacity: 1;
    }
    .SelectionItem:hover .Icon {
        color: #fff !important;
    }
    .SelectionItem:hover .SelectionModule-description,
    .SelectionItem:hover .SelectionModule-display {
        color: #fff;
    }
    .SelectionItem.SelectionItem--selected .Icon-check {
        opacity: 1;
    }
    .SelectionModule-display {
        color: currentcolor;
        margin-bottom: 0.25em;
    }
    .SelectionModule-description {
        color: #959595;
        font-size: 0.8rem;
    }
    .Visualization,
    .Visualization.Visualization--loading {
        transition: background 0.3s linear 0s;
        margin-top: 20px;
        -ms-overflow-style: scrollbar;

    }
    .Visualization--scalar,
    .Visualization.Visualization--error {
        justify-content: center;
    }
    .Visualization--scalar {
        font-size: 8rem;
        font-weight: 200;
    }
    .Card-outer {
        align-items: center;
        display: flex;
        height: 100%;
        justify-content: flex-start;
        overflow: hidden;
        width: 100%;
    }
    .Loading {
        background-color: hsla(0, 0%, 100%, 0.82);
    }
    .QueryError {
        flex-direction: column;
        justify-content: center;
        margin-left: auto;
        margin-right: auto;
        max-width: 500px;
    }
    .QueryError-iconWrapper {
        border: 4px solid #ef8c8c;
        border-radius: 99px;
        margin-bottom: 2em;
        padding: 2em;
    }
    .QueryError-image {
        background-repeat: no-repeat;
        margin-bottom: 1rem;
    }
    .QueryError-image--noRows {
        background-image: url("/app/img/no_results.svg");
        height: 120px;
        width: 120px;
    }
    .QueryError-image--queryError {
        background-image: url("/app/img/no_understand.svg");
        height: 120px;
        width: 120px;
    }
    .QueryError-image--serverError {
        background-image: url("/app/img/blown_up.svg");
        height: 148px;
        width: 120px;
    }
    .QueryError-image--timeout {
        background-image: url("/app/img/stopwatch.svg");
        height: 120px;
        width: 120px;
    }
    .QueryError-message {
        max-width: 100%;
    }
    .QueryError-messageText {
        line-height: 1.4;
    }
    .QueryError-adminEmail {
        border: 1px solid #c5c5c5;
        border-radius: 4px;
        display: inline-block;
        margin-top: 1rem;
        padding: 0.5rem 2rem;
        position: relative;
    }
    .QueryError-adminEmail::before {
        background-color: #fff;
        content: "Admin Email";
        font-size: 10px;
        left: 50%;
        margin-left: -41px;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
        position: absolute;
        text-align: center;
        text-transform: uppercase;
        top: -0.75em;
    }
    .QueryError2 {
        margin-left: auto;
        margin-right: auto;
        padding-top: 4rem;
    }
    .QueryError2-details {
        max-width: 500px;
    }
    .QueryError2-detailBody {
        background-color: #f8f8f8;
        max-height: 15rem;
        overflow: auto;
    }
    .GuiBuilder {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        display: flex;
        flex-direction: column;
        font-size: 0.9em;
        position: relative;
        z-index: 2;
    }
    @media screen and (min-width: 60em) {
        .GuiBuilder {
            font-size: 1em;
        }
    }
    .GuiBuilder-row {
        border-bottom: 1px solid #e0e0e0;
    }
    .GuiBuilder-row:last-child {
        border-bottom-color: transparent;
    }
    .GuiBuilder-data {
        border-right: 1px solid #e0e0e0;
    }
    .GuiBuilder-filtered-by {
        border-right: 1px solid transparent;
    }
    .GuiBuilder-sort-limit {
        border-left: 1px solid #e0e0e0;
    }
    .GuiBuilder.GuiBuilder--expand {
        flex-direction: row;
    }
    .GuiBuilder.GuiBuilder--expand .GuiBuilder-row:last-child {
        border-bottom-color: #e0e0e0;
        border-right-color: transparent;
    }
    .GuiBuilder.GuiBuilder--expand .GuiBuilder-filtered-by {
        border-right-color: #e0e0e0;
    }
    .GuiBuilder-section {
        min-height: 55px;
        min-width: 120px;
        position: relative;
    }
    .GuiBuilder-section-label {
        background-color: #fff;
        left: 10px;
        padding-left: 10px;
        padding-right: 10px;
        position: absolute;
        top: -7px;
    }
    .QueryOption {
        color: #c6c6c6;
        font-weight: 700;
    }
    .QueryOption:hover {
        cursor: pointer;
    }
    .AddToDashSuccess {
        max-width: 260px;
        text-align: center;
    }
    .GuiBuilder-data {
        z-index: 1;
    }
    .Filter-section-field,
    .Filter-section-field .QueryOption,
    .Filter-section-operator {
        color: #509EE7;
    }
    .Filter-section-operator .QueryOption {
        color: #509EE7;
        text-transform: lowercase;
    }
    .Filter-section-value .QueryOption {
        background-color: #509EE7;
        border: 1px solid #76608a;
        border-radius: 6px;
        color: #fff;
        margin-bottom: 0.2em;
        padding: 0.3em 0.5em;
    }
    .Filter-section-value {
        padding-bottom: 0.25em;
        padding-right: 0.5em;
    }
    .Filter-section-sort-direction.selected .QueryOption,
    .Filter-section-sort-field.selected .QueryOption {
        color: inherit;
    }
    .FilterPopover .ColumnarSelector-row--selected,
    .FilterPopover .PopoverHeader-item.selected {
        color: #509EE7 !important;
    }
    .FilterPopover .ColumnarSelector-row:hover {
        background-color: #509EE7 !important;
    }
    .View-section-aggregation,
    .View-section-aggregation-target,
    .View-section-aggregation-target.selected .QueryOption,
    .View-section-aggregation.selected .QueryOption,
    .View-section-breakout,
    .View-section-breakout.selected .QueryOption {
        color: #9cc177;
    }
    .GuiBuilder-sort-limit {
        min-width: 0;
    }
    .EllipsisButton {
        font-size: 3em;
        position: relative;
        top: -0.8rem;
    }
    .NativeQueryEditor .GuiBuilder-data {
        border-right: medium none;
    }
    .VisualizationSettings .GuiBuilder-section {
        border-right: medium none !important;
    }
    .ChartType-button {
        background-color: #fff;
        border: 1px solid #ccdff6;
        border-radius: 38px;
        height: 38px;
        width: 38px;
    }
    .ChartType-popover {
        min-width: 15em !important;
    }
    .ChartType--selected {
        background-color: #4a90e2;
        color: #fff;
    }
    .ChartType--notSensible {
        opacity: 0.5;
    }
    .ColorWell {
        height: 18px;
        margin: 3px 0.3rem 3px 3px;
        width: 18px;
    }
    .RunButton {
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.22);
        margin-top: -10px;
        opacity: 1;
        transition: margin-top 0.5s ease 0s, opacity 0.5s ease 0s;
        z-index: 1;
    }
    .RunButton.RunButton--hidden {
        margin-top: -110px;
        opacity: 0;
    }
    .DataReference {
        background-color: #f9fbfc;
        height: 100%;
        overflow: hidden;
        position: absolute;
        right: 0;
        top: 0;
        width: 300px;
        z-index: -1;
    }
    .DataReference-container {
        width: 300px;
    }
    .DataReference h1 {
        font-size: 20pt;
    }
    .DataRefererenceQueryButton-circle {
        align-items: center;
        border: 1px solid currentcolor;
        border-radius: 99px;
        display: flex;
        height: 1.25rem;
        justify-content: center;
        width: 1.25rem;
    }
    .DataRefererenceQueryButton-text {
        max-width: 160px;
    }
    .DataReference-paneCount {
        padding-right: 0.6em;
    }
    .ObjectDetail {
        border: 1px solid #dedede;
        margin: 0 auto 2rem;
        width: 100%;
    }
    @media screen and (min-width: 120em) {
        .ObjectDetail {
            max-width: 1140px;
        }
    }
    .ObjectDetail-headingGroup {
        border-bottom: 1px solid #dedede;
    }
    .ObjectDetail-infoMain {
        border-right: 1px solid #dedede;
        font-size: 1rem;
        margin-left: 2.4rem;
    }
    .ObjectJSON {
        background-color: #f8f8f8;
        border: 1px solid #dedede;
        border-radius: 2px;
        max-height: 200px;
        overflow: scroll;
        padding: 1em;
    }
    .ace_gutter-cell {
        color: #aeaeae;
        display: block;
        font-size: 10px;
        font-weight: 700;
        padding-left: 0;
        padding-right: 0;
        padding-top: 2px;
        text-align: center;
    }
    .ace_gutter-layer {
        background-color: #f9fbfc;
        border-right: 1px solid #f0f0f0;
    }
    .PopoverBody.AddToDashboard {
        min-width: 25em;
    }
    .MB-DataTable.MB-DataTable--pivot .public_fixedDataTableCell_main:first-child {
        border-right: 1px solid #959595;
        font-weight: 700;
    }
    .List {
        padding: 0.5rem;
    }
    .List-item .List-item-arrow .Icon,
    .List-section-header .Icon {
        color: #727479;
    }
    .List-item .Icon {
        color: #dfe8ea;
    }
    .List-section-header {
        border: 2px solid transparent;
        color: #727479;
    }
    .List-section--open .List-section-header,
    .List-section--open .List-section-header .List-section-icon .Icon,
    .List-section .List-section-header:hover,
    .List-section .List-section-header:hover .Icon,
    .List-section .List-section-header:hover .List-section-title {
        color: currentcolor;
    }
    .List-section--open .List-section-header .List-section-title {
        color: #727479;
    }
    .List-section-title {
        max-width: 230px;
        word-wrap: break-word;
    }
    .List-item {
        border: 2px solid transparent;
        border-radius: 6px;
        display: flex;
        margin-bottom: 2px;
        margin-top: 2px;
    }
    .List-item--segment .Icon,
    .List-item--segment .List-item-title {
        color: #509EE7;
    }
    .List-item--selected,
    .List-item:hover {
        background-color: currentcolor;
        border-color: rgba(0, 0, 0, 0.2);
    }
    .List-item-title {
        color: #727479;
    }
    .List-item--selected .Icon,
    .List-item--selected .List-item-title,
    .List-item:hover .Icon,
    .List-item:hover .List-item-title {
        color: #fff;
    }
    .FieldList-grouping-trigger {
        display: flex;
        visibility: hidden;
    }
    .List-item--selected .FieldList-grouping-trigger,
    .List-item:hover .FieldList-grouping-trigger {
        border-left: 2px solid rgba(0, 0, 0, 0.1);
        color: hsla(0, 0%, 100%, 0.5);
        visibility: visible;
    }
    .QuestionTooltipTarget {
        align-items: center;
        border: 2px solid currentcolor;
        border-radius: 99px;
        color: #e1e1e1;
        cursor: pointer;
        display: flex;
        height: 20px;
        justify-content: center;
        opacity: 0.7;
        width: 20px;
    }
    .QuestionTooltipTarget::after {
        content: "?";
        font-size: 13px;
        font-weight: 700;
    }
    .FilterRemove-field {
        align-items: center;
        background-color: #509EE7;
        border: 1px solid #509EE7;
        border-radius: 99px;
        display: flex;
        height: 20px;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease-out 0s;
        width: 20px;
    }
    .FilterInput:hover .FilterRemove-field {
        opacity: 1;
    }
    #react_qb_viz .ScalarValue {
        font-size: 5em;
    }
    .SetupSteps {
        margin-top: 4rem;
    }
    .SetupNav {
        border-bottom: 1px solid #f5f5f5;
    }
    .Setup-brandWordMark {
        font-size: 1.688rem;
    }
    .SetupStep {
        border: 1px solid #d7d7d7;
        flex: 1 1 0;
        margin-bottom: 1.714rem;
    }
    .SetupStep.SetupStep--active {
        color: #509ee3;
    }
    .SetupStep.SetupStep--completed {
        color: #9cc177;
    }
    .SetupStep.SetupStep--todo {
        background-color: #edf2f8;
        border-style: dashed;
        color: #509ee3;
    }
    .SetupStep-indicator {
        background-color: #fff;
        border-color: #c6c6c6;
        border-radius: 99px;
        font-weight: 700;
        height: 3em;
        left: -1.5em;
        line-height: 1;
        margin-top: -3px;
        width: 3em;
    }
    .SetupStep-check {
        color: #fff;
        display: none;
    }
    .SetupStep-title {
        color: currentcolor;
    }
    .SetupStep.SetupStep--active .SetupStep-indicator {
        color: #509ee3;
    }
    .SetupStep.SetupStep--completed .SetupStep-indicator {
        background-color: #c8e1b0;
        border-color: #9cc177;
    }
    .SetupStep.SetupStep--completed .SetupStep-check {
        display: block;
    }
    .SetupStep.SetupStep--completed .SetupStep-number {
        display: none;
    }
    .SetupCompleted {
        text-align: center;
    }
    .SetupCompleted .SetupStep-title {
        font-size: 2rem;
        line-height: 2rem;
    }
    .SetupHelp {
        color: #8e9ba9;
    }
    .TutorialModal {
        width: 440px;
    }
    ._3TLsalUZYdJqkR3JEsP5Cb {
        cursor: pointer;
    }
    /* tables still need 'cellspacing="0"' in the markup */
    table {
        border-collapse: collapse;
        border-spacing: 0;
    }

    /* add some styling to the table, padding etc*/
    table thead th{
        padding:3px 10px;
        border-bottom:1px solid #000000;
        background:#74AFAD;
        background-size: 50%;
    }
    table tbody td{
        padding:3px 10px;
        white-space: no

    }
    table tbody tr:nth-of-type(2n+1) td{
        background:#CCCCCC;
    }

    tfoot td{
        background: #ccc;
    }
    #three tbody tr:nth-of-type(2n+1) td{
        background:#82CE76;
    }
    .drag{
        background:#CCCCCC !important;
        color:#cCCCCC;
    }

    .dragtable-drag-handle{
        height:.5em;
        width: 5px;
        float: right;
        background:green;
    }
    td div{


        overflow: hidden;

        -webkit-transition: max-height 1.5s cubic-bezier(0, 1.05, 0, 1);
        -moz-transition: max-height 1.5s cubic-bezier(0, 1.05, 0, 1);
        transition: max-height 1.5s ease cubic-bezier(0, 1.05, 0, 1);
        max-height: 38px;
        max-width: 200px;

    }

    td div:hover{
        -webkit-transition: max-height 2s ease;
        -moz-transition: max-height 2s ease;
        transition: max-height 2s ease;
        cursor: hand;
        cursor: pointer;
        opacity: .9;
        max-height: 800px;
    }

    .test3{
        /*border-right: 5px solid red !important;*/
    }
    select {
        border: 0 !important;
        -webkit-appearance: none;
        -moz-appearance: none;
        background: #0088cc url(img/demo/select-arrow.png) no-repeat 90% center;
        width: 100px;
        text-indent: 0.01px;
        text-overflow: "";
        color: #FFF;
        border-radius: 15px;
        padding: 5px;
        box-shadow: inset 0 0 5px rgba(000,000,000, 0.5);
        border-radius: 10px 0;
    }
    .withIE{
        margin-top:78px;
    }
    .formLink{
        color:blue;
    }

.closeTable{
    display:block;
    float:right;
    width:30px;
    height:29px;
    background:url(close.png) no-repeat center center;
}


</style>

<script type="text/javascript" src="jquery-1.7.2.js"></script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>    
<script type="text/javascript" src="src/js/jquery.dragtable.js"></script>

<link rel="stylesheet" href="src/css/dragtable-default.css" type="text/css" />
<script>

    jQuery.fn.outerHTML = function (s) {
        return s
                ? this.before(s).remove()
                : jQuery("<p>").append(this.eq(0).clone()).html();
    };
    var i = 0;

    $(document).ready(function () {

        function isIE() {
            return ((navigator.appName == 'Microsoft Internet Explorer') || ((navigator.appName == 'Netscape') && (new RegExp("Trident/.*rv:([0-9]{1,}[\.0-9]{0,})").exec(navigator.userAgent) != null)));
        }
        var queryMain = "";
        var ua = window.navigator.userAgent;
        msie = ua.indexOf("MSIE ");
        if (isIE()) // If Internet Explorer, return version number
        {
            //alert(navigator.appName);

            $('.withoutIE').remove();

        } else {
            //alert('.withoutIE');

            $('.withIE').remove();

            $('table').each(function () {

                $(this).dragtable({
                    placeholder: 'dragtable-col-placeholder test3',
                    items: 'thead th:not( .notdraggable ):not( :has( .dragtable-drag-handle ) ), .dragtable-drag-handle',
                    scroll: true
                });
            });
        }
        function hideAll() {
            $(".outerNav").hide();
            $(".outerNav_").hide();


            $(".innerNav").hide();
            $("#509797").hide();
            $("#beforeColoumnContainer").hide();
            $(".rawSecondLevel").hide();
            $("afterSortClick").hide();
            $(".groupingTags").hide();
            $("#sortSpan").hide();
            $("#sortColoumnList").hide();
            $("#groupByContainer").hide();

            $("#rawDataList").hide();
            $(".afterFilter").hide();
            $(".beforeColoumn").hide();
            $("#afterColoumn").hide();
        }

        // var json='{  	"database2": {  		"window": {  			"title": "int",  			"name": "date",  			"width": "date",  			"height": "var"  		},  		"image": {  			"src": "int",  			"name": "var",  			"hOffset": "var",  			"vOffset": "date",  			"alignment": "int"  		},  		"text": {  			"data": "date",  			"size": "int",  			"style": "int",  			"name": "string",  			"hOffset": "string",  			"vOffset": "int",  			"alignment": "string",  			"onMouseUp": "date"  		}  	},  	"database1": {  		"window1": {  			"title": "int",  			"name": "date",  			"width": "date",  			"height": "var"  		},  		"image1": {  			"src": "int",  			"name": "var",  			"hOffset": "var",  			"vOffset": "date",  			"alignment": "int"  		},  		"text1": {  			"data": "date",  			"size": "int",  			"style": "int",  			"name": "string",  			"hOffset": "string",  			"vOffset": "int",  			"alignment": "string",  			"onMouseUp": "date"  		}  	}  }';

        // var json = '{"postgres":{"company":{"id":"integer","name":"text"},"Staff":{"EmpId":"char","Name":"ARRAY","Address":"ARRAY","UID":"integer"},"POSTTYPE":{"ID":"text","POSTTYPE":"text","TITLE":"text"}}}';
        var result = <?php echo str_replace('""', '"', stripslashes(json_encode($associativeArrayMainD))); ?>;
        //alert(json.to);
        //var result = $.parseJSON(json);
        hideAll();
        $.each(result, function (k, v) {

            $("#databaseListDummy .List-section-title").text(k);
            var dummyDB = $("#databaseListDummy").clone();
            dummyDB.removeAttr("id");
            dummyDB.prop("class", "outerNav1");
            dummyDB.css('display', 'block');
            $("#databaseListDummyContainer").append(dummyDB[0]['outerHTML']);

            $("#databaseListDummy2 .List-section-title").text(k);
            dummyDB = $("#databaseListDummy2").clone();
            dummyDB.removeAttr("id");
            dummyDB.prop("class", "outerNav2");
            dummyDB.css('display', 'block');
            $("#databaseListDummyContainer2").append(dummyDB[0]['outerHTML']);

            var dummyInnerNav = $(".innerNav").clone();
            dummyInnerNav.removeClass("innerNav");
            dummyInnerNav.addClass("innerNav" + k);
            $("#inoutNavContainer").append(dummyInnerNav[0]['outerHTML']);
            $(".innerNav" + k + " .outerNavPointer").text(k);

            var rowResult = $.parseJSON(JSON.stringify(v));
            $.each(rowResult, function (k1, v1) {
                $(".innerNav li h4").text(k1);
                var li = $(".innerNav li").clone();
                li.children().attr("data-val", k);
                li.css('display', 'block');
                li.css('display', 'block');

                $(".innerNav" + k + " ul").append(li[0]['outerHTML']);
                var colResult = $.parseJSON(JSON.stringify(v1));
                var dummyColNav = $(".beforeColoumn").clone();
                dummyColNav.removeClass("beforeColoumn");
                dummyColNav.addClass("beforeColoumn" + k1);
                $("#beforeColoumnContainer").append(dummyColNav[0]['outerHTML']);
                $(".beforeColoumn" + k1 + " .text-default").text(k1);
                var dummyColNav = $(".sortColoumn").clone();
                dummyColNav.removeClass("sortColoumn");
                dummyColNav.addClass("sortColoumn" + k1);
                $("#sortColoumnContainer").append(dummyColNav[0]['outerHTML']);
                $(".sortColoumn" + k1 + " .text-default").text(k1);
                var dummyColNav = $(".groupLists").clone();
                dummyColNav.removeClass("groupLists");
                dummyColNav.addClass("groupLists" + k1);
                $("#groupByContainer").append(dummyColNav[0]['outerHTML']);
                $(".groupLists" + k1 + " .text-default").text(k1);
                $.each(colResult, function (k2, v2) {
                    var dummyColNavAft = $("#afterColoumn").clone();
                    dummyColNavAft.removeAttr("id");
                    dummyColNavAft.addClass("afterColoumn" + k1 + "_" + k2);
                    $("#beforeColoumnContainer").append(dummyColNavAft[0]['outerHTML']);
                    $(".afterColoumn" + k1 + "_" + k2 + " h3.inline-block").text(k1);
                    $(".afterColoumn" + k1 + "_" + k2 + " .coloumnBack").attr("data-colName", "afterColoumn" + k1 + "_" + k2);
                    $(".afterColoumn" + k1 + "_" + k2 + " .addFilterButton").attr("data-colName", "afterColoumn" + k1 + "_" + k2);
                    $(".afterColoumn" + k1 + "_" + k2 + " .addCustomDateFilter").attr("data-colName", "afterColoumn" + k1 + "_" + k2);
                    $(".afterColoumn" + k1 + "_" + k2 + " .addFilterButton").attr("data-tableName", k1);
                    $(".afterColoumn" + k1 + "_" + k2 + " .addFilterButton").attr("data-ColoumnName", k2);


                    $(".afterColoumn" + k1 + "_" + k2 + " .text-default").text(k2);
                    $(".sortColoumn li h4").text(k2);
                    $(".beforeColoumn li h4").text(k2);
                    $(".groupLists li h4").text(k2);
                    var cloneIcon;
                    if (v2 === "string")
                        cloneIcon = $("#iconContainer .Icon-string").clone(true);
                    else if (v2 === "integer")
                        cloneIcon = $("#iconContainer .Icon-int").clone(true);
                    else
                        cloneIcon = $("#iconContainer .Icon-calendar").clone(true);
                    $(".sortColoumn li svg").remove();
                    var someHtml = $(".sortColoumn li a").html();
                    //console.log(  $(".sortColoumn li a").outerHTML());
                    $(".sortColoumn li a").empty();
                    $(".sortColoumn li a").append(cloneIcon.outerHTML() + someHtml);
                    $(".beforeColoumn li svg").remove();
                    $(".beforeColoumn li a").empty();
                    $(".beforeColoumn li a").append(cloneIcon.outerHTML() + someHtml);
                    $(".groupLists li svg").remove();
                    $(".groupLists li a").empty();
                    $(".groupLists li a").append(cloneIcon.outerHTML() + someHtml);
                    var li1 = $(".sortColoumn li").clone(true);
                    var li2 = $(".beforeColoumn li").clone(true);
                    var li3 = $(".groupLists li").clone(true);
                    // console.log(li2.html());
                    li1.children().attr("data-val", k1);
                    //console.log(k2);
                    li1.css('display', 'block');
                    $(".sortColoumn" + k1 + " ul").append(li1);
                    li2.children().attr("data-val", k1);
                    //console.log(k2);
                    li2.css('display', 'block');
                    $(".beforeColoumn" + k1 + " ul").append(li2);
                    li3.children().attr("data-val", k1);
                    //console.log(k2);
                    li3.css('display', 'block');
                    $(".groupLists" + k1 + " ul").append(li3);
                });
            });
        });
        $("#selectTable").click(function () {
            $(".outerNav").toggle();
        });
        $("#selectTable2").click(function () {
            $(".outerNav_").css({
                'position': 'absolute',
                'left': $(this).offset().left,
                'top': $("#react_qb_editor").height()
            }).show();
        });

        $(".outerNav1").click(function () {
            $(".innerNav" + $(this).text().trim()).show();
            $(".outerNav").hide();


        });
        $(".outerNav2").click(function () {
            $("#tableNameText2").text($(this).text().trim());
            $.each(result, function (k, v) {

                if ($("#tableNameText2").text().trim() === k.trim())
                {
                    var rowResult = $.parseJSON(JSON.stringify(v));
                    $.each(rowResult, function (k1, v1) {
                        $("#joinTableNameContainer .selectJoinTable").append("<option value='" + k1.trim() + "'>" + k1.trim() + "</option>");


                    });

                }
            });
            $("#joinTableNameContainer").show();

            $(".outerNav_").hide();
        });
        $("#joinType").change(function () {
            $("#selectTable2").show();

        });
        $('#joinTableNameContainer .selectJoinTable').change(function () {
            var first = 0;
            var second = 0;

            $.each(result, function (k, v) {
                if ($("#tableNameText2").text().trim() === k.trim())
                {
                    var rowResult = $.parseJSON(JSON.stringify(v));
                    $.each(rowResult, function (k1, v1) {

                        if ($("#selectSecondTable").val().trim() === k1.trim())
                        {
                            $("#joinSecondColoumnNameContainer").find("option").text("Select Coloumn Name for Table:" + $("#selectSecondTable").val());

                            var rowResult2 = $.parseJSON(JSON.stringify(v1));

                            $.each(rowResult2, function (k2, v2) {


                                $("#joinSecondColoumnNameContainer .selectJoinTable").append("<option value='" + k2.trim() + "'>" + k2.trim() + "</option>");
                                first = 1;
                            });

                        } else if ($("#tableNameText").text().trim() === k1.trim())
                        {
                            $("#joinFirstColoumnNameContainer").find("option").text("Select Coloumn Name for Table:" + $("#tableNameText").text().trim());

                            var rowResult2 = $.parseJSON(JSON.stringify(v1));

                            $.each(rowResult2, function (k2, v2) {


                                $("#joinFirstColoumnNameContainer .selectJoinTable").append("<option value='" + k2.trim() + "'>" + k2.trim() + "</option>");
                                second = 1;
                            });

                        }

                    });
                }
            });
            $("#SecondContainer").show();

        });
        $(".backOuter").click(function () {
            // alert("asd");
            $(".innerNav" + $(this).text().trim()).hide();
            $(".outerNav").show();
        });
        $(".tableName").click(function () {
            $("#filterWala").removeClass("disabled");
            $(".innerNav" + $(this).attr("data-val")).hide();
            $("#tableNameText").text($(this).text());
            $("#tableNameText").attr("data-attr", $(this).attr("data-val").trim());
        });
        $("#selectFilters").click(function () {
            //  alert(".beforeColoumn"+ $("#tableNameText").text().trim())
            $("#beforeColoumnContainer").toggle();
            $(".beforeColoumn" + $("#tableNameText").text().trim()).toggle();
//            if ($("#selectSecondTable").val().trim().length > 0)
//            {
//                console.log(".beforeColoumn" + $("#selectSecondTable").val().trim());
//                $(".beforeColoumn" + $("#selectSecondTable").val().trim()).toggle();
//
//
//            }


        });
        $("#beforeColoumnContainer .List-item").click(function () {
            $(".afterColoumn" + $("#tableNameText").text().trim() + "_" + $(this).text().trim()).show();
            $(".beforeColoumn" + $("#tableNameText").text().trim()).hide();
            $(".afterColoumn" + $("#tableNameText").text().trim() + "_" + $(this).text().trim()).find(".buttonContainer").each(function () {
                $(this).hide();
            });
            if ($(this).find("svg").attr("class").indexOf("Icon-int") >= 0)
            {

                $(".afterColoumn" + $("#tableNameText").text().trim() + "_" + $(this).text().trim()).find(".buttonContainerInt").show();
            } else if ($(this).find("svg").attr("class").indexOf("Icon-calendar") >= 0)
            {
                $(".afterColoumn" + $("#tableNameText").text().trim() + "_" + $(this).text().trim()).find(".buttonContainerCal").show();
                $(".afterColoumn" + $("#tableNameText").text().trim() + "_" + $(this).text().trim()).find(".forDateOnly").show();
               $(".afterColoumn" + $("#tableNameText").text().trim() + "_" + $(this).text().trim()).find(".forDateOnly .relativeDate").trigger('click');
               $(".afterColoumn" + $("#tableNameText").text().trim() + "_" + $(this).text().trim()).find(".FilterInput").hide();
            } else
            {
                $(".afterColoumn" + $("#tableNameText").text().trim() + "_" + $(this).text().trim()).find(".buttonContainerString").show();
            }
        });
        $(".addFilterButton").click(function () {
            i++;
            var dummyColFilAft = $(".afterFilter").clone(true);
            dummyColFilAft.removeClass("afterFilter");
            var tableName = $(this).attr("data-colName").replace(/ /g, '');
            dummyColFilAft.addClass("afterFilter_" + tableName + "_" + i);
            dummyColFilAft.css('display', 'block');
            $("#filterWala").append(dummyColFilAft);
            var dumTbl = $(this).attr("data-tableName").replace(/ /g, '')
            $(".afterFilter_" + tableName + "_" + i + " .QueryOption .colQuery").text($("." + tableName + " .text-default").text());
            //console.log("\""+dumTbl+"\".\""+$("." + tableName + " .text-default").text()+"\"");
            // alert("\""+tableName+"\".\""+$("." + tableName + " .text-default").text()+"\"");
            $(".afterFilter_" + tableName + "_" + i + " .QueryOption .colQuery").attr("data-attr", "\"" + dumTbl + "\".\"" + $("." + tableName + " .text-default").text() + "\"");
            $(".afterFilter_" + tableName + "_" + i + " .midQuery").text($("." + tableName + " .buttonContainer .Button--purple").text());
            $(".afterFilter_" + tableName + "_" + i + " .midQuery").attr("data-reactid", $("." + tableName + " .buttonContainer .Button--purple").attr("data-reactid"));
            $(".afterFilter_" + tableName + "_" + i + " .valQuery").text($("." + tableName + " .FilterInputText").val());
            $(".afterFilter_" + tableName + "_" + i + " .Query-filter-close").attr("data-attr", "afterFilter_" + tableName + "_" + i)
            var qVal = $("." + tableName + " .buttonContainer .Button--purple").attr("data-reactid").replace("##addText##", $("." + tableName + " .FilterInputText").val()).replace("##addVar##", "\"" + dumTbl + "\".\"" + $("." + tableName + " .text-default").text() + "\"").replace("##addVar##", "\"" + dumTbl + "\".\"" + $("." + tableName + " .text-default").text() + "\"");
            $(".afterFilter_" + tableName + "_" + i + " .valQuery").attr("data-attr", qVal);
            // alert(tableName);
            $(".afterFilter_" + tableName + "_" + i).show();
            $("#beforeFilter").hide();
            $("." + tableName).hide();
            $("#beforeColoumnContainer").hide();
        });

        $(".addCustomDateFilter").click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            i++;
            var dummyColFilAft = $(".afterFilter").clone(true);
            dummyColFilAft.removeClass("afterFilter");
            var tableName = $(this).attr("data-colName").replace(/ /g, '');
            dummyColFilAft.addClass("afterFilter_" + tableName + "_" + i);
            dummyColFilAft.css('display', 'block');
            $("#filterWala").append(dummyColFilAft);
            var dumTbl = $("#tableNameText").text().trim();
            $(".afterFilter_" + tableName + "_" + i + " .QueryOption .colQuery").text($("." + tableName + " .text-default").text());
            var refTabName = "\"" + dumTbl + "\".\"" + $("." + tableName + " .text-default").text() + "\"";
            $(".afterFilter_" + tableName + "_" + i + " .QueryOption .colQuery").attr("data-attr", refTabName);
            $(".afterFilter_" + tableName + "_" + i + " .midQuery").text("Between");
            $(".afterFilter_" + tableName + "_" + i + " .midQuery").attr("data-reactid", "");
            var valueS = $("." + tableName + " #dateRangeStart").val();
            var valueE = $("." + tableName + " #dateRangeEnd").val();
            var dateQuery = $(this).attr("data-attr").replace("##firstVal##", valueS.trim()).replace("##secVal##", valueE.trim()).replace("##addText##", refTabName).replace("##addText##", refTabName);
            $(".afterFilter_" + tableName + "_" + i + " .valQuery").text(valueS + "-" + valueE);
            $(".afterFilter_" + tableName + "_" + i + " .Query-filter-close").attr("data-attr", "afterFilter_" + tableName + "_" + i)
            // var qVal = $("." + tableName + " .buttonContainer .Button--purple").attr("data-reactid").replace("##addText##", $("." + tableName + " .FilterInputText").val()).replace("##addVar##", "\"" + dumTbl + "\".\"" + $("." + tableName + " .text-default").text() + "\"").replace("##addVar##", "\"" + dumTbl + "\".\"" + $("." + tableName + " .text-default").text() + "\"");
            $(".afterFilter_" + tableName + "_" + i + " .valQuery").attr("data-attr", dateQuery);
            $(".afterFilter_" + tableName + "_" + i).show();
            $("#beforeFilter").hide();
            $("." + tableName).hide();
            $("#beforeColoumnContainer").hide();
        });

        $(".Query-filter-close").click(function () {
            //alert("."+$(this).attr("data-attr"));
            var tableName = $(this).attr("data-attr").replace(/ /g, '');
            $("." + tableName).remove();
        });
        $(".coloumnBack").click(function () {
            //  alert($("#tableNameText").text().trim());

            $("." + $(this).attr("data-colName")).hide();
            $(".beforeColoumn" + $("#tableNameText").text().trim()).show();
        });
        $("#rawDataGroup").click(function () {
            $("#rawDataList").toggle();
        });
        $("#groupByButton").click(function () {
            // alert("asd");
            $(".groupLists" + $("#tableNameText").text().trim()).show();
            $("#groupByContainer").toggle();
        });
        $("#rawDataList li").click(function () {

            if (($(this).attr("data-attr").trim() === "*") || ($(this).attr("data-attr").toLowerCase() === "count(*) as count")) {
                $("#rawDataTextField").text($(this).attr("data-attr"));
            } else if ($(this).attr("data-attr").trim().toLowerCase() === "count(distinct ##addtext##)") {
                $("#rawDataTextField").text($(this).text().trim());
                $(".rawSecondLevel").show();
                var clonedColoumnList = $(".groupLists" + $("#tableNameText").text().trim()).clone(true);
                $(".rawSecondLevel .inline-block").text($(this).text().trim());

                clonedColoumnList.removeClass("groupLists" + $("#tableNameText").text().trim());
                clonedColoumnList.find("li").attr("data-attr", "rawDataOne");
                clonedColoumnList.find("li").attr("data-tblName", $("#tableNameText").text().trim());
                clonedColoumnList.find("li").attr("data-val", $(this).attr("data-attr"));
                clonedColoumnList.addClass("rawDataListDummy");
                $("#ColoumnListContents").empty();
                $("#ColoumnListContents").append(clonedColoumnList);
                $(".rawDataListDummy").show();
            } else
            {
                $("#rawDataTextField").text($(this).text().trim());
                $(".rawSecondLevel").show();
                $(".rawSecondLevel .inline-block").text($(this).text().trim());

                var clonedColoumnList = $(".groupLists" + $("#tableNameText").text().trim()).clone(true);
                clonedColoumnList.removeClass("groupLists" + $("#tableNameText").text().trim());
                clonedColoumnList.find("li").attr("data-attr", "rawDataOne");
                clonedColoumnList.find("li").attr("data-tblName", $("#tableNameText").text().trim());
                clonedColoumnList.find("li").attr("data-val", $(this).attr("data-attr"));
                clonedColoumnList.find("li .Icon-string").each(function () {
                    $(this).parent().parent().hide();
                });
                clonedColoumnList.find("li .Icon-calendar").each(function () {
                    $(this).parent().parent().hide();
                });
                ;

                clonedColoumnList.addClass("rawDataListDummy");
                $("#ColoumnListContents").empty();
                $("#ColoumnListContents").append(clonedColoumnList);
                $(".rawDataListDummy").show();
            }
            $("#rawDataList").hide();
        });
        $(".rawSecondLevel .text-grey-3").click(function () {
            $(".rawSecondLevel").toggle();
            $(".rawDataList").toggle();
        });
        $("#groupByContainer li").click(function () {
            if ($(this).attr("data-attr") === "rawDataOne")
            {
                var mainChar = "\"" + $(this).attr("data-tblName") + "\".\"" + $(this).text().trim() + "\"";
                var someData = $("#rawDataTextField").text();
                var upperCase = new RegExp('[A-Z]');
                var text = "";
                if (mainChar.match(upperCase))
                    text = $(this).attr("data-val").replace('##addText##', "\"" + mainChar + "\"");
                else
                    text = $(this).attr("data-val").replace('##addText##', mainChar);

                $("#rawDataTextField").text(text);
                $(".rawSecondLevel").hide();
            } else {
                $(".groupingTags .QueryOption span").text($(this).text().trim());
                $(".groupingTags .QueryOption").attr("data-attr", "\"" + $("#tableNameText").text().trim() + "\".\"" + $(this).text().trim() + "\"");
                $(".groupingTags .groupingTagAnchor").attr("data-attr", "groupingTags_" + $(this).text().trim());
                var grpClone = $(".groupingTags").clone(true);
                grpClone.removeClass("groupingTags");
                grpClone.addClass("groupingTags_" + $(this).text().trim());
                grpClone.addClass("groupingTagsLive");
                $(".groupingTags_" + $(this).text().trim()).remove();
                $(".groupingTags").parent().append(grpClone);
                $(".groupingTags_" + $(this).text().trim()).show();
                //$("#groupByButton").hide();
                $("#groupByContainer").hide();
            }

        });
        //  $(".").show();
        $(".groupingTagAnchor").click(function () {
            $("." + $(this).attr("data-attr")).hide();
            $("#groupByButton").show();
        });
        $("#sortButton").click(function () {
            //alert("das");
            $("#sortSpan").show();
        });
        $("#sortFieldPicker").click(function () {

            // alert("da");
            $(".sortColoumn" + $("#tableNameText").text().trim()).show();
            $("#sortColoumnContainer").toggle();
        });
        $("#sortColoumnContainer .List-item").click(function () {
            var someData = $(this).text();
            // alert(someData);

            $("#sortTag").text(someData);
            $("#sortTag").attr("data-attr", "\"" + $("#tableNameText").text().trim() + "\".\"" + someData.trim() + "\"")
            $("#beforeSortClick").hide();
            $("#afterSortClick").show();
            $("#sortColoumnContainer").hide();
            //$(".sortColoumn"+ $("#tableNameText").text().trim()).hide();


        });
        $("#removeSortTag").click(function () {
            $("#afterSortClick").hide();
            $("beforeSortClick").show();
            $("#sortTag").text("");

        });
        $("#sortOrder").click(function () {
            if ($("#sortOrder").text().trim() === "ascending") {
                $("#sortOrder").text("descending");
                $("#sortOrder").attr("data-attr", "DESC");
            } else {
                $("#sortOrder").attr("data-attr", "ASC");
                $("#sortOrder").text("ascending");
            }

        });
        $("#limit>ul>li").click(function () {
            $("#limit>ul>li.Button--active").removeClass("Button--active");
            $(this).addClass("Button--active");
        });


        $(".filterButtonList button").click(function () {
            $(".filterButtonList button.Button--purple").removeClass("Button--purple");
            $(this).addClass("Button--purple");
        });
        $(".forDateOnly button").click(function () {
            $(".forDateOnly button.Button--Grey").removeClass("Button--Grey");
            $(this).addClass("Button--Grey");
            var parSome = $(this).parent().parent();
            if ($(this).hasClass("specificDate"))
            {
                parSome.find(".buttonContainerCal").hide();
               // parSome.find(".FilterInput").hide();
                parSome.find(".FilterPopover-footer").hide();
                parSome.find(".forCustomDateOnly").show();

            } else
            {
                parSome.find(".buttonContainerCal").show();
               // parSome.find(".FilterInput").show();
                parSome.find(".FilterPopover-footer").show();
                parSome.find(".forCustomDateOnly").hide();

            }
        });

        $("#saveQuery").click(function () {
            // aler("");
            $(".Modal1").css("z-index", 9);
            $(".Modal1").show();
        });
        $("#closeSaveDiv").click(function () {
            $(".Modal1").css("z-index", 0);
            $(".Modal1").hide();
        });

        $("#formMain").submit(function () {
            /*
             var str = $(this).serialize();
             $.ajax('action2.php', str, function(result){
             // the result variable will contain any text echoed by getResult.php
             });
             return(false);*/
            // var selectClause = " * ";
            var secselectClause = " * ";
            var whereclause = "";
            var firstTime = new Boolean(true);
            $('.Query-filters:visible').each(function (i, obj) {
                if (firstTime)
                    whereclause += " Where ";
                else
                    whereclause += " AND ";

                // whereclause += $(this).find(".colQuery").attr("data-attr");
                whereclause += $(this).find(".valQuery").attr("data-attr");
                firstTime = false;
                //test
            });
            var firstTime = new Boolean(true);
            $('.groupingTagsLive:visible').each(function (i, obj) {
                if (firstTime) {
                    whereclause += " group by " + $(this).find(".QueryOption").attr("data-attr").trim();
                    secselectClause = $(this).find(".QueryOption").attr("data-attr").trim();
                } else {
                    whereclause += " , " + $(this).find(".QueryOption").attr("data-attr").trim();

                    secselectClause += " , " + $(this).find(".QueryOption").attr("data-attr").trim();
                }
                firstTime = false;
                //test
            });
            var aggData = "";
            if ($("#rawDataTextField").text().trim() === "Raw data") {

            } else {
                if (secselectClause.trim() === "*")
                    secselectClause = $("#rawDataTextField").text();
                else
                    secselectClause += " , " + $("#rawDataTextField").text();

            }
            var sortInfo = ""
            if ($("#afterSortClick #sortTag").text().trim().length > 0) {
                //alert($("#sortTag").text()+$("#sortOrder").text());
                sortInfo = " order by " + "\"" + $("#sortTag").text().trim() + "\"" + " " + $("#sortOrder").attr("data-attr").trim();
                // selectClause += " ,"+$("#sortTag").text().trim();
            }
            var limit = "";
            if ($("#limit .Button--active").text().trim() === "None") {
            } else {
                limit = " LIMIT " + $("#limit .Button--active").text();
            }
            var joinclause = "";
            var tableNameToSend = $("#tableNameText").text().trim();

            if ($("#selectSecondTable").val().trim().length > 0)
            {
                tableNameToSend += " , " + $("#selectSecondTable").val()
                //alert($("#selectSecondTableCustomers").val());
                joinclause += $("#joinType").val() + " \"" + $("#selectSecondTable").val() + "\" ON \"" + $("#tableNameText").text().trim() + "\"." + "\"" + $("#selectFirstJoinCol").val() + "\" = \"" + $("#selectSecondTable").val() + "\"." + "\"" + $("#selectSecondJoinCol").val() + "\"";
            }
            queryMain = "Select " + secselectClause + " from \"" + $("#tableNameText").text().trim() + "\"" + joinclause + whereclause + sortInfo + limit;
            //alert(queryMain);
            //alert($("#tableNameText").text().trim());
            var dataBaseName = $("#tableNameText").attr("data-attr");
            $.ajax({
                url: 'action2.php',
                type: "GET",
                data: {
                    queryString: queryMain,
                    tableName: tableNameToSend,
                    selectTags: secselectClause,
                    databaseName: dataBaseName
                },
                beforeSend: function () {
                    $('#loader-icon').show();

                },
                complete: function () {
                    $('#loader-icon').hide();


                },
                success: function (data) {
                    // console.log(data);
                    $('.Visualization').empty();
                    $('.Visualization').append(data);
                    $('#loader-icon').hide();

                    if (msie > 0) // If Internet Explorer, return version number
                    {

                    } else {
                        //alert('.Visualization');
                        $('table').each(function () {

                            $(this).dragtable({
                                placeholder: 'dragtable-col-placeholder test3',
                                items: 'thead th:not( .notdraggable ):not( :has( .dragtable-drag-handle ) ), .dragtable-drag-handle',
                                scroll: true
                            });
                        });
                    }



                },
                error: function () {}
            });
        });
        $("#closeTable").click(function(){
         $("#formAfterClick").hide();          
        });
        $("#tog_name").click(function () {
            $("#tog_section").toggle();
        });
        $(".Icon-download").click(function ()
        {
            $('#hidden-type').val($('.Visualization').html());
            $('#export-form').submit();
            $('#hidden-type').val('');
            /*	$.ajax({
             url: 'csvDownload.php',
             type: "POST",
             data: {
             table:  $('.Visualization').html()
             },
             beforeSend: function() {},
             complete: function() {},
             success: function(data) {
             console.log(data);
             
             },
             error: function() {}
             });	*/

        });

        $('#refresh').click(function () {
            location.reload();
        });
        $("#saveTag").click(function ()
        {
            var coloumnName = "";
            $('#displayTable > thead > tr > th').each(function () {
                coloumnName += $(this).attr("data-attr").trim() + ",";
            });
            coloumnName = coloumnName.substring(0, coloumnName.length - 1);
            // alert(queryMain);
            //alert(coloumnName);
            //alert($('#tagName').val());
            //alert($('#tagDescription').val());

            $.ajax({
                url: 'saveTag.php',
                type: "GET",
                data: {
                    queryColTagForm: coloumnName,
                    queryMain: $('#queryForTagForm').val(),
                    tagName: $('#tagName').val(),
                    tagDescription: $('#tagDescription').val()
                },
                beforeSend: function () {},
                complete: function () {},
                success: function (data) {
                    queryMain = "";
                    //alert(data);

                    $('.Visualization').empty();
                    $('.Visualization').append(data);
                    $('#tagName').val("");
                    $('#tagDescription').val("");
                    $('#queryColTagForm').val("");
                    $('#queryForTagForm').val("");
                    $(".Modal1").hide();
                },
                error: function () {

                    alert("error");
                }
            });

        });


        $(document).mouseup(function (e)
        {
            var container = $(".PopoverBody--withArrow");

            if (!container.is(e.target) // if the target of the click isn't the container...
                    && container.has(e.target).length === 0) // ... nor a descendant of the container
            {
                container.hide();
               // $(".forCustomDateOnly").hide();
                
            }
            container = $("#sortSpan");

            if (!container.is(e.target) // if the target of the click isn't the container...
                    && container.has(e.target).length === 0) // ... nor a descendant of the container
            {
                container.hide();
               // $(".forCustomDateOnly").hide();
            }
            container = $("#formAfterClick");

            if (!container.is(e.target) // if the target of the click isn't the container...
                    && container.has(e.target).length === 0) // ... nor a descendant of the container
            {
                container.hide();
             //   $(".forCustomDateOnly").hide();
            }


        });

        function exportTableToCSV($table, filename) {
            var $rows = $table.find('tr:has(td)'),
                    // Temporary delimiter characters unlikely to be typed by keyboard
                    // This is to avoid accidentally splitting the actual contents
                    tmpColDelim = String.fromCharCode(11), // vertical tab character
                    tmpRowDelim = String.fromCharCode(0), // null character

                    // actual delimiter characters for CSV format
                    colDelim = '","',
                    rowDelim = '"\r\n"',
                    // Grab text from table into CSV formatted string
                    csv = '"' + $rows.map(function (i, row) {
                        var $row = $(row),
                                $cols = $row.find('td');
                        return $cols.map(function (j, col) {
                            var $col = $(col),
                                    text = $col.text();
//console.log(text);
                            return text.replace('"', '""'); // escape double quotes

                        }).get().join(tmpColDelim);
                    }).get().join(tmpRowDelim)
                    .split(tmpRowDelim).join(rowDelim)
                    .split(tmpColDelim).join(colDelim) + '"',
                    // Data URI
                    csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
//alert(encodeURIComponent(csv));

            $(this).attr({
                'download': filename,
                'href': csvData,
                'target': '_blank'
            });
        }
        $(document).on('click', ".formLink", function () {
            //alert();
            $("#f_GridContainer").empty();
            var formAfterClick = $("#formAfterClick");
            var trPar = $(this).parent();
            var thlist = new Array();

            $(this).parent().parent().parent().find("th").each(function () {
                thlist.push($(this).text());

            });
            var tdlist = new Array();

            $("#tableName_Form").text($("#tableNameText").text().trim());
            $("#clickedId_Form").text($(this).text().trim());
            var Grid_mb2 = formAfterClick.find(".gridList_f");
            trPar.find("td").each(function () {
                tdlist.push($(this).text());

            });

            for (var i = 0; i < thlist.length; i++)
            {
                Grid_mb2.find(".f_colName").text(thlist[i]);
                Grid_mb2.find(".f_colVal").text(tdlist[i]);
                var cloneGr = Grid_mb2.clone(true)
                //  cloneGr.show();

                $("#f_GridContainer").append(cloneGr);
                // alert( + "===>" + );
            }
            $("#formAfterClick").show();
        });
        /*
         $('.Icon-reference').click(
         function() { 
         exportTableToCSV.apply(this, [$('#displayTable'), 'filename.csv']);
         });*/
    });</script>
<Html>
    <div mb-react-component="Navbar" ng-controller="Nav" class="Nav ng-scope">
        <nav class="CheckBg CheckBg-offset relative bg-brand sm-py2 sm-py1 xl-py3">
            <ul class="pl4 pr1 flex align-center">
                <li class="pl1"><a href="dash.php" class="NavItem cursor-pointer text-white text-bold no-decoration flex align-center px2 transition-background" style="padding-left:1.0rem;padding-right:1.0rem;padding-top:0.75rem;padding-bottom:0.75rem;" data-metabase-event="Navbar;Dashboard">Dashboard</a>
                </li>
                </li>
                <li class="pl3"><a href="#" class="NavNewQuestion rounded inline-block bg-white text-brand text-bold cursor-pointer px2 no-decoration transition-all" style="padding-left:1.0rem;padding-right:1.0rem;padding-top:0.75rem;padding-bottom:0.75rem;" data-metabase-event="Navbar;New Question"><span  >New </span><span   class="hide sm-show">Question</span></a>
                </li>
                <li class="flex-align-right transition-background">
                    <div class="inline-block text-white">
                        <div data-reactid=".0.0.5.0.0" class="NavDropdown inline-block cursor-pointer open" >
                            <a data-reactid=".0.0.5.0.0.0" class="NavDropdown-button NavItem flex align-center p2 transition-background" data-metabase-event="Navbar;Profile Dropdown;Toggle">
                                <div data-reactid=".0.0.5.0.0.0.0" class="NavDropdown-button-layer" >
                                    <div data-reactid=".0.0.5.0.0.0.0.0" class="flex align-center" >
                                        <div id="tog_name" data-reactid=".0.0.5.0.0.0.0.0.0" style="font-size:0.85rem;border-width:1px;border-style:solid;border-radius:99px;width:2rem;height:2rem;background-color:transparent;" class="flex align-center justify-center bg-brand"><?php echo $_SESSION['uname']; ?></div>
                                        <svg data-reactid=".0.0.5.0.0.0.0.0.1" name="chevrondown" fill="currentcolor" viewBox="0 0 32 32" height="8px" width="8px" class="Dropdown-chevron ml1">
                                        <path data-reactid=".0.0.5.0.0.0.0.0.1.0" d="M1 12 L16 26 L31 12 L27 8 L16 18 L5 8 z "/>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div data-reactid=".0.0.5.0.0.1" class="NavDropdown-content right" id="tog_section" style="display:none;">
                                <ul data-reactid=".0.0.5.0.0.1.0" class="NavDropdown-content-layer">
                                    <?php
                                    $a = trim("Admin");
                                    $b = trim($_SESSION['utype']);

                                    if ($a == $b) {
                                        echo '<li data-reactid=".0.0.5.0.0.1.0.1"><a data-reactid=".0.0.5.0.0.1.0.1.0" href="admin.php" class="Dropdown-item block text-white no-decoration" data-metabase-event="Navbar;Profile Dropdown;Enter Admin">Admin Panel</a></li>';
                                    } else {
                                        
                                    }
                                    ?>
                                    <li data-reactid=".0.0.5.0.0.1.0.5" class="border-top border-light"><a data-reactid=".0.0.5.0.0.1.0.5.0" href="logout.php" class="Dropdown-item block text-white no-decoration" data-metabase-event="Navbar;Profile Dropdown;Logout">Logout</a></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    <div class="QueryBuilder-section flex align-center py1 lg-py2 xl-py3 wrapper">
        <div class="Entity">
            <div class="flex align-baseline">
                <h1 class="Header-title-name my1">New question</h1>
                <span> </span>
            </div>
        </div>
        <div class="flex-align-right">
            <div class="flex align-center">
                <span data-reactid=".1.0.1.0.$0" class="Header-buttonSection"><a data-reactid=".1.0.1.0.$0.$save" id="saveQuery" class="no-decoration h4 px1 text-grey-4 text-brand-hover text-uppercase"><span data-reactid=".1.0.1.0.$0.$save.0">Save</span><span data-reactid=".1.0.1.0.$0.$save.1"></span></a></span>
             
                <span class="Header-buttonSection">
                    <a   title="Download Data" class="mx1 transition-color text-grey-4 text-brand-hover">
                        <svg data-reactid=".7.0.2.1.1.0" name="download" fill="currentcolor" viewBox="0 0 11 17" height="16px" width="16px" class="Icon Icon-download"><path data-reactid=".7.0.2.1.1.0.0" d="M4,8 L4,0 L7,0 L7,8 L10,8 L5.5,13.25 L1,8 L4,8 Z M11,14 L0,14 L0,17 L11,17 L11,14 Z"/></svg>                        </svg>
                    </a>
                </span>
            </div>
        </div>
    </div>
    <div class="z2" id="react_qb_editor">
        <div class="wrapper">
            <div class="GuiBuilder rounded shadowed GuiBuilder--expand">
                <div class="GuiBuilder-row flex">
                    <div class="GuiBuilder-section GuiBuilder-data flex align-center arrow-right">
                        <span class="GuiBuilder-section-label Query-label">Data</span>
                        <div>
                            <a id="selectTable" class="no-decoration flex align-center tether-target tether-element-attached-top tether-element-attached-left tether-target-attached-bottom tether-target-attached-center tether-enabled">
                                <span class="px2 py2 text-bold cursor-pointer text-default">
                                    <span   class="text-grey-4 no-decoration" id="tableNameText">Select a table</span>
                                    <svg name="chevrondown" fill="currentcolor" viewBox="0 0 32 32" height="8px" width="8px" class="ml1">
                                    <path d="M1 12 L16 26 L31 12 L27 8 L16 18 L5 8 z " />
                                    </svg>
                                </span>
                                <span class="hide"></span>
                            </a>
                        </div>
                    </div>
                    <div class="GuiBuilder-section GuiBuilder-filtered-by flex align-center">
                        <span class="GuiBuilder-section-label Query-label">Filtered by</span>
                        <div class="Query-section disabled" id="filterWala">
                            <div style = "display:none" class="Query-filters afterFilter">
                                <div class="Query-filterList scroll-show scroll-show--horizontal filterRow">
                                    <div class="Query-filter p1 pl2">
                                        <div>
                                            <div>
                                                <div style="padding:0.5em;padding-top:0.3em;padding-bottom:0.3em;padding-left:0;" class="flex align-center">
                                                    <div class="flex align-center">
                                                        <div class="Filter-section Filter-section-field selected"><span class="QueryOption"><span   class="colQuery">BTC selling price</span></span>
                                                        </div>
                                                    </div>
                                                    <div class="Filter-section Filter-section-operator"><span>&nbsp;</span><a class="QueryOption flex align-center midQuery">is not</a>
                                                    </div>
                                                </div>
                                                <div class="flex align-center flex-wrap">
                                                    <div class="Filter-section Filter-section-value"><span class="QueryOption valQuery">as</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="text-grey-2 no-decoration px1 flex align-center Query-filter-close">
                                            <svg name="close" fill="currentcolor" viewBox="0 0 32 32" height="14px" width="14px" class="Icon Icon-close">
                                            <path d="M4 8 L8 4 L16 12 L24 4 L28 8 L20 16 L28 24 L24 28 L16 20 L8 28 L4 24 L12 16 z " />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="mx2">
                                <a id="selectFilters" class="no-decoration flex align-center">
                                    <span class="text-grey-2 text-bold flex align-center text-grey-4-hover cursor-pointer no-decoration transition-color">
                                        <div   style="width:28px;height:28px;border-width:1px;border-style:solid;border-color:currentcolor;border-radius:3px;" class="flex layout-centered">
                                            <svg   name="add" fill="currentcolor" viewBox="0 0 32 32" height="14px" width="14px" class="Icon Icon-add">
                                            <path   d="M19,13 L19,2 L14,2 L14,13 L2,13 L2,18 L14,18 L14,30 L19,30 L19,18 L30,18 L30,13 L19,13 Z"/>
                                            </svg>
                                        </div>
                                        <span    id="beforeFilter" class="ml1">Add filters to narrow your answer</span>
                                    </span>
                                    <span class="hide"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="GuiBuilder-row flex flex-full">
                    <div class="GuiBuilder-section GuiBuilder-view flex align-center px1">
                        <span class="GuiBuilder-section-label Query-label">View</span>
                        <div class="Query-section Query-section-aggregation" id="rawDataGroup">
                            <div class="tether-target tether-element-attached-center tether-target-attached-center tether-element-attached-top tether-target-attached-bottom">
                                <div class="Query-section Query-section-aggregation cursor-pointer"><span id="rawDataTextField" class="View-section-aggregation QueryOption py1 pl1">Raw data</span>
                                </div>
                            </div>
                        </div>
                        <div class="Query-section Query-section-breakout ml1" id="groupByButton">
                            <div>
                                <span class="text-grey-2 text-bold flex align-center text-grey-4-hover cursor-pointer no-decoration transition-color">
                                    <div   style="width:28px;height:28px;border-width:1px;border-style:solid;border-color:currentcolor;border-radius:3px;" class="flex layout-centered">
                                        <svg   name="add" fill="currentcolor" viewBox="0 0 32 32" height="14px" width="14px" class="Icon Icon-add">
                                        <path   d="M19,13 L19,2 L14,2 L14,13 L2,13 L2,18 L14,18 L14,30 L19,30 L19,18 L30,18 L30,13 L19,13 Z"/>
                                        </svg>
                                    </div>
                                    <span   class="ml1">Add a grouping</span>
                                </span>
                            </div>
                        </div>
                        <div style="display:none" class="Query-section Query-section-breakout ml1 groupingTags">
                            <span class="text-bold">by</span>
                            <div class="flex align-center">
                                <div class="flex align-center">
                                    <div class="View-section-breakout SelectionModule p1 selected"><span class="QueryOption"><span  >title</span></span>
                                    </div>
                                    <a class="text-grey-2 no-decoration pr1 flex align-center groupingTagAnchor">
                                        <svg name="close" fill="currentcolor" viewBox="0 0 32 32" height="14px" width="14px" class="Icon Icon-close">
                                        <path d="M4 8 L8 4 L16 12 L24 4 L28 8 L20 16 L28 24 L24 28 L16 20 L8 28 L4 24 L12 16 z " />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-full"></div>
                    <div class="GuiBuilder-section GuiBuilder-sort-limit flex align-center"><a id="sortButton" class="no-decoration flex align-center"><span   class=" no-decoration text-brand text-bold ">Sort and LIMIT Options</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="joinContainer" style="display:none;"class="z2">
        <div class="wrapper">
            <div class="GuiBuilder rounded shadowed GuiBuilder--expand">
                <div class="GuiBuilder-row flex">
                    <div class="GuiBuilder-section GuiBuilder-data flex align-center arrow-right">
                        <span class="GuiBuilder-section-label Query-label">Data</span>
                        <div>
                            <span class="px2 py2 text-bold cursor-pointer text-default">
                                <select class="ui dropdown selectJoin" id="joinType">
                                    <option value="">Select Join</option>
                                    <option value="Join">Join</option>
                                    <option value="Full Outer Join">Outer Join</option>
                                    <option value="Inner Join">Inner Join</option>
                                    <option value="Left Join">Left Join</option>
                                    <option value="Right Join">Right Join</option>

                                </select>
                            </span>
                        </div>
                        <div>
                            <a style="display:none;"class="no-decoration flex align-center tether-target tether-element-attached-top tether-element-attached-left tether-target-attached-bottom tether-target-attached-center tether-enabled" id="selectTable2">
                                <span class="px2 py2 text-bold cursor-pointer text-default">
                                    <span id="tableNameText2" class="text-grey-4 no-decoration">Select Database</span>
                                    <svg class="ml1" width="8px" height="8px" viewBox="0 0 32 32" fill="currentcolor" name="chevrondown">
                                    <path d="M1 12 L16 26 L31 12 L27 8 L16 18 L5 8 z "/>
                                    </svg>
                                </span>
                                <span class="hide"></span>
                            </a>
                        </div>
                        <div style="display:none;" id="joinTableNameContainer">
                            <span class="px2 py2 text-bold cursor-pointer text-default">
                                <select class="ui dropdown selectJoinTable" id="selectSecondTable">
                                    <option value="">Select Table</option>

                                </select>
                            </span>
                        </div>
                        <div style="display:none;" id="SecondContainer">
                            <div>
                                <span class="px2 py2 text-bold cursor-pointer text-default">
                                    ON
                                </span>
                            </div>
                            <div id="joinFirstColoumnNameContainer">
                                <span class="px2 py2 text-bold cursor-pointer text-default">
                                    <select class="ui dropdown selectJoinTable"  id="selectFirstJoinCol">
                                        <option value=""></option>

                                    </select>
                                </span>
                            </div>
                            <div >
                                <span class="px2 py2 text-bold cursor-pointer text-default">
                                    Equals
                                </span>
                            </div>
                            <div  id="joinSecondColoumnNameContainer">
                                <span class="px2 py2 text-bold cursor-pointer text-default">
                                    <select class="ui dropdown selectJoinTable"  id="selectSecondJoinCol">
                                        <option value=""></option>

                                    </select>
                                </span>
                            </div>

                        </div>
                        <div >
                            <input type="submit" id="refresh"class="Button Button--primary circular" value="Refresh"></input>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="flex z1" id="react_qb_viz">
        <div class="wrapper full relative mb2 z1 flex flex-column">
            <div class="relative flex flex-no-shrink mt3 mb1">
                <span class="relative z3">
                    <noscript  ></noscript>
                </span>
                <form id="formMain" action="javascript:void(0);" method="post" >
                    <div class="absolute flex layout-centered left right z2">
                        <input type="submit" class="Button Button--primary circular RunButton">
                        </button>
                    </div>
                </form>
                <div class="absolute right z3 flex align-center"></div>
            </div>
            <div class="withoutIE flex flex-full z1 px1">

                <div data-reactid=".d.0.1.0.0.0:$1.0.0.1.0" class="flex-full relative border-bottom">
                    <div data-reactid=".d.0.1.0.0.0:$1.0.0.1.0.0" class="absolute top bottom left Visualization right scroll-x scroll-show scroll-show--horizontal scroll-show--hover">

                    </div>
                </div>    
            </div>
            <div data-reactid=".d.0.1.0.0.0:$1.0.0.1.0.0" class="withIE absolute top bottom left Visualization right scroll-x scroll-show scroll-show--horizontal scroll-show--hover">

            </div>
        </div>
    </div>
    <span class="PopoverContainer tether-element tether-element-attached-top tether-element-attached-left tether-target-attached-bottom tether-target-attached-center tether-enabled" id="inoutNavContainer" style="top: 0px; left: 0px; position: absolute; transform: translateX(85px) translateY(227px) translateZ(0px); z-index: 3;">
        <div   class="PopoverBody PopoverBody--withArrow outerNav">
            <div   style="width:300px;" class="text-brand " id="databaseListDummyContainer">
                <section style=" display:none;"   class="List-section List-section--open" id="databaseListDummy">
                    <div   class="p1 border-bottom">
                        <div   class="List-section-header px1 py1 cursor-pointer full flex align-center">
                            <span   class="List-section-icon mr2">
                                <svg   name="database" fill="currentcolor" viewBox="0 0 32 32" height="18" width="18" class="Icon text-default">
                                <path   d="M1.18693219e-08,10.5691766 C-1.48366539e-08,7.99678991 1.18693222e-08,4.59790181 1.18693222e-08,4.59790181 C1.18693222e-08,4.59790181 1.58917246,5.78437724e-10 15.711134,0 C29.8330955,-5.78436122e-10 32,4.16069339 32,4.59790181 L32,10.5405377 C32,10.5405377 30.5498009,15.2177783 16.5227645,15.2177785 C2.49572804,15.2177788 2.1498337e-08,11.4966675 1.18693219e-08,10.5691766 Z M0.265241902,22.2508255 C0.265241902,22.2508255 3.24765892e-17,22.3239396 0,22.9593732 L3.3438581e-16,28.3247528 C3.3438581e-16,28.3247528 1.42644742,32.8877413 15.943795,32.8877413 C30.4611426,32.8877413 32,28.3654698 32,28.3654698 C32,28.3654698 32,22.9095461 32,22.9095462 C32,22.3279008 31.6616273,22.2210746 31.6616273,22.2210746 C31.6616273,22.2210746 29.7117464,26.2784187 16.0116409,26.2784187 C2.31153546,26.2784187 0.265241902,22.2508255 0.265241902,22.2508255 Z M0.265241902,13.3619366 C0.265241902,13.3619366 3.24765892e-17,13.4350508 0,14.0704843 L3.3438581e-16,19.4358639 C3.3438581e-16,19.4358639 1.42644742,23.9988524 15.943795,23.9988524 C30.4611426,23.9988524 32,19.4765809 32,19.4765809 C32,19.4765809 32,14.0206573 32,14.0206573 C32,13.4390119 31.6616273,13.3321857 31.6616273,13.3321857 C31.6616273,13.3321857 29.7117464,17.3895298 16.0116409,17.3895298 C2.31153546,17.3895298 0.265241902,13.3619366 0.265241902,13.3619366 Z"/>
                                </svg>
                            </span>
                            <h3 class="List-section-title"></h3>
                        </div>
                    </div>
                </section>
            </div>

        </div>
        <div  style=" display:none;" class="PopoverBody PopoverBody--withArrow outerNav_">

            <div   style="width:300px;" class="text-brand " id="databaseListDummyContainer2">
                <section style=" display:none;"   class="List-section List-section--open" id="databaseListDummy2">
                    <div   class="p1 border-bottom">
                        <div   class="List-section-header px1 py1 cursor-pointer full flex align-center">
                            <span   class="List-section-icon mr2">
                                <svg   name="database" fill="currentcolor" viewBox="0 0 32 32" height="18" width="18" class="Icon text-default">
                                <path   d="M1.18693219e-08,10.5691766 C-1.48366539e-08,7.99678991 1.18693222e-08,4.59790181 1.18693222e-08,4.59790181 C1.18693222e-08,4.59790181 1.58917246,5.78437724e-10 15.711134,0 C29.8330955,-5.78436122e-10 32,4.16069339 32,4.59790181 L32,10.5405377 C32,10.5405377 30.5498009,15.2177783 16.5227645,15.2177785 C2.49572804,15.2177788 2.1498337e-08,11.4966675 1.18693219e-08,10.5691766 Z M0.265241902,22.2508255 C0.265241902,22.2508255 3.24765892e-17,22.3239396 0,22.9593732 L3.3438581e-16,28.3247528 C3.3438581e-16,28.3247528 1.42644742,32.8877413 15.943795,32.8877413 C30.4611426,32.8877413 32,28.3654698 32,28.3654698 C32,28.3654698 32,22.9095461 32,22.9095462 C32,22.3279008 31.6616273,22.2210746 31.6616273,22.2210746 C31.6616273,22.2210746 29.7117464,26.2784187 16.0116409,26.2784187 C2.31153546,26.2784187 0.265241902,22.2508255 0.265241902,22.2508255 Z M0.265241902,13.3619366 C0.265241902,13.3619366 3.24765892e-17,13.4350508 0,14.0704843 L3.3438581e-16,19.4358639 C3.3438581e-16,19.4358639 1.42644742,23.9988524 15.943795,23.9988524 C30.4611426,23.9988524 32,19.4765809 32,19.4765809 C32,19.4765809 32,14.0206573 32,14.0206573 C32,13.4390119 31.6616273,13.3321857 31.6616273,13.3321857 C31.6616273,13.3321857 29.7117464,17.3895298 16.0116409,17.3895298 C2.31153546,17.3895298 0.265241902,13.3619366 0.265241902,13.3619366 Z"/>
                                </svg>
                            </span>
                            <h3 class="List-section-title"></h3>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div style="display:none" class="PopoverBody PopoverBody--withArrow innerNav">
            <div style="width:300px;" class="text-brand ">
                <section class="List-section List-section--open">
                    <div class="p1 border-bottom">
                        <div class="px1 py1 flex align-center">
                            <h3 class="text-default">
                                <span   class="flex align-center">
                                    <span   class="flex align-center text-slate cursor-pointer backOuter">
                                        <svg   name="chevronleft" fill="currentcolor" viewBox="0 0 32 32" height="18" width="18" class="Icon Icon-chevronleft">
                                        <path   d="M20 1 L24 5 L14 16 L24 27 L20 31 L6 16 z"/>
                                        </svg>
                                        <span   class="ml1 outerNavPointer"></span>
                                    </span>
                                    <span  ></span>
                                </span>
                            </h3>
                        </div>
                    </div>
                    <div class="px1 pt1">
                      
                    </div>
                    <ul class="p1 border-bottom scroll-y scroll-show" style="max-height:400px;">
                        <li style=" display:none;" class="List-item flex">
                            <a style="padding-top:0.25rem;padding-bottom:0.25rem;" class="flex-full flex align-center px1 cursor-pointer tableName">
                                <svg name="table2" fill="currentcolor" viewBox="0 0 32 28" height="18" width="18" class="Icon Icon-table2">
                                <g fill-rule="evenodd" fill="currentcolor">
                                <path d="M10,19 L10,15 L3,15 L3,13 L10,13 L10,9 L12,9 L12,13 L20,13 L20,9 L22,9 L22,13 L29,13 L29,15 L22,15 L22,19 L29,19 L29,21 L22,21 L22,25 L20,25 L20,21 L12,21 L12,25 L10,25 L10,21 L3,21 L3,19 L10,19 L10,19 Z M12,19 L12,15 L20,15 L20,19 L12,19 Z M30.5,0 L32,0 L32,28 L30.5,28 L1.5,28 L0,28 L0,0 L1.5,0 L30.5,0 Z M29,3 L29,25 L3,25 L3,3 L29,3 Z M3,7 L29,7 L29,9 L3,9 L3,7 Z" />
                                </g>
                                </svg>
                                <h4 class="List-item-title ml2"></h4>
                            </a>
                        </li>
                    </ul>
                </section>
            </div>
        </div>
    </span>
    <span class="PopoverContainer tether-element tether-element-attached-center tether-target-attached-center tether-enabled tether-element-attached-top tether-target-attached-bottom" id="beforeColoumnContainer" style="top: 0px; left: 0px; position: absolute; transform: translateX(42px) translateY(217px) translateZ(0px); z-index: 3; display:none;">
        <div   style="display:none;"  class="PopoverBody PopoverBody--withArrow beforeColoumn">
            <div   style="" class="FilterPopover" >
                <div   style="width:300px;" class="text-purple" >
                    <section   class="List-section List-section--open">
                        <div   class="p1 border-bottom">
                            <div   class="px1 py1 flex align-center">
                                <span   class="List-section-icon mr2">
                                    <svg   name="table2" fill="currentcolor" viewBox="0 0 32 28" height="18" width="18" class="Icon Icon-table2">
                                    <g fill-rule="evenodd" fill="currentcolor">
                                    <path d="M10,19 L10,15 L3,15 L3,13 L10,13 L10,9 L12,9 L12,13 L20,13 L20,9 L22,9 L22,13 L29,13 L29,15 L22,15 L22,19 L29,19 L29,21 L22,21 L22,25 L20,25 L20,21 L12,21 L12,25 L10,25 L10,21 L3,21 L3,19 L10,19 L10,19 Z M12,19 L12,15 L20,15 L20,19 L12,19 Z M30.5,0 L32,0 L32,28 L30.5,28 L1.5,28 L0,28 L0,0 L1.5,0 L30.5,0 Z M29,3 L29,25 L3,25 L3,3 L29,3 Z M3,7 L29,7 L29,9 L3,9 L3,7 Z"/>
                                    </g>
                                    </svg>
                                </span>
                                <h3 class="text-default">Item</h3>
                            </div>
                        </div>
                        <ul class="p1 border-bottom scroll-y scroll-show" style="max-height:400px;">
                            <li style="display:none;" class="List-item flex">
                                <a style="padding-top:0.25rem;padding-bottom:0.25rem;" class="flex-full flex align-center px1 cursor-pointer">
                                    <svg name="string" fill="currentcolor" viewBox="0 0 24 24" height="18" width="18" class="Icon Icon-string">
                                    <path d="M14.022,18 L11.533,18 C11.2543319,18 11.0247509,17.935084 10.84425,17.80525 C10.6637491,17.675416 10.538667,17.5091677 10.469,17.3065 L9.652,14.8935 L4.389,14.8935 L3.572,17.3065 C3.50866635,17.4838342 3.38516758,17.6437493 3.2015,17.78625 C3.01783241,17.9287507 2.79300133,18 2.527,18 L0.019,18 L5.377,4.1585 L8.664,4.1585 L14.022,18 Z M5.13,12.7085 L8.911,12.7085 L7.638,8.918 C7.55566626,8.67733213 7.45908389,8.3939183 7.34825,8.06775 C7.23741611,7.7415817 7.12816721,7.3885019 7.0205,7.0085 C6.91916616,7.39483527 6.8146672,7.75266502 6.707,8.082 C6.5993328,8.41133498 6.49800047,8.69633213 6.403,8.937 L5.13,12.7085 Z M21.945,18 C21.6663319,18 21.4557507,17.9620004 21.31325,17.886 C21.1707493,17.8099996 21.0520005,17.6516679 20.957,17.411 L20.748,16.8695 C20.5009988,17.078501 20.2635011,17.2621659 20.0355,17.4205 C19.8074989,17.5788341 19.5715846,17.7134161 19.32775,17.82425 C19.0839154,17.9350839 18.8242514,18.0174164 18.54875,18.07125 C18.2732486,18.1250836 17.9676683,18.152 17.632,18.152 C17.1823311,18.152 16.7738352,18.0934173 16.4065,17.97625 C16.0391648,17.8590827 15.7272513,17.6865011 15.47075,17.4585 C15.2142487,17.2304989 15.016334,16.947085 14.877,16.60825 C14.737666,16.269415 14.668,15.8783355 14.668,15.435 C14.668,15.0866649 14.7566658,14.7288352 14.934,14.3615 C15.1113342,13.9941648 15.4184978,13.6600848 15.8555,13.35925 C16.2925022,13.0584152 16.8814963,12.8066677 17.6225,12.604 C18.3635037,12.4013323 19.297661,12.2873335 20.425,12.262 L20.425,11.844 C20.425,11.2676638 20.3062512,10.8512513 20.06875,10.59475 C19.8312488,10.3382487 19.4940022,10.21 19.057,10.21 C18.7086649,10.21 18.4236678,10.2479996 18.202,10.324 C17.9803322,10.4000004 17.7824175,10.4854995 17.60825,10.5805 C17.4340825,10.6755005 17.2646675,10.7609996 17.1,10.837 C16.9353325,10.9130004 16.7390011,10.951 16.511,10.951 C16.3083323,10.951 16.1357507,10.9019172 15.99325,10.80375 C15.8507493,10.7055828 15.7383337,10.5836674 15.656,10.438 L15.124,9.5165 C15.7193363,8.99083071 16.3795797,8.59975128 17.10475,8.34325 C17.8299203,8.08674872 18.6073292,7.9585 19.437,7.9585 C20.0323363,7.9585 20.5690809,8.05508237 21.04725,8.24825 C21.5254191,8.44141763 21.9307483,8.71058161 22.26325,9.05575 C22.5957517,9.40091839 22.8506658,9.81099763 23.028,10.286 C23.2053342,10.7610024 23.294,11.2803305 23.294,11.844 L23.294,18 L21.945,18 Z M18.563,16.2045 C18.9430019,16.2045 19.2754986,16.1380007 19.5605,16.005 C19.8455014,15.8719993 20.1336652,15.6566682 20.425,15.359 L20.425,13.991 C19.8359971,14.0163335 19.3515019,14.0669996 18.9715,14.143 C18.5914981,14.2190004 18.2906678,14.3139994 18.069,14.428 C17.8473322,14.5420006 17.6937504,14.6718326 17.60825,14.8175 C17.5227496,14.9631674 17.48,15.1214991 17.48,15.2925 C17.48,15.6281683 17.5718324,15.8640827 17.7555,16.00025 C17.9391676,16.1364173 18.2083316,16.2045 18.563,16.2045 L18.563,16.2045 Z" />
                                    </svg>
                                    <h4 class="List-item-title ml2">BTC selling price</h4>
                                </a>
                                <div class="flex align-center"></div>
                            </li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
        <div style="display:none" class="PopoverBody PopoverBody--withArrow" id="afterColoumn">
            <div style="" class="FilterPopover">
                <div style="width: 300px;">
                    <div class="FilterPopover-header text-grey-3 p1 mt1 flex align-center">
                        <a class="cursor-pointer flex align-center coloumnBack">
                            <svg name="chevronleft" fill="currentcolor" viewBox="0 0 32 32" height="18" width="18" class="Icon Icon-chevronleft">
                            <path d="M20 1 L24 5 L14 16 L24 27 L20 31 L6 16 z" />
                            </svg>
                            <h3 class="inline-block">Item</h3>
                        </a>
                        <h3 class="mx1">-</h3>
                        <h3 class="text-default">BTC selling price</h3>
                    </div>
                    <div style="display: none;" data-reactid=".h.$=10.0.1.0" class="border-bottom p1 forDateOnly"><button data-reactid=".h.$=10.0.1.0.0:$relative" class="Button Button-normal Button--medium relativeDate mr1 mb1 Button--Grey">Relative date</button><button  data-reactid=".h.$=10.0.1.0.0:$specific" class="Button Button-normal Button--medium mr1 specificDate mb1">Specific date</button></div>
                    <div class="filterButtonList">
                        <div data-reactid=".f.0.1.0"style="display: none;" class="border-bottom p1 buttonContainer buttonContainerString">
                            <button data-reactid="##addVar## = '##addText##'" class="Button Button-normal Button--medium mr1 mb1 Button--purple">Equal</button>
                            <button data-reactid="##addVar## <> '##addText##'" class="Button Button-normal Button--medium mr1 mb1">Not equal</button>
                            <button data-reactid="##addVar## > ''" class="Button Button-normal Button--medium mr1 mb1">Is empty</button>
                            <button data-reactid="##addVar## <> ''" class="Button Button-normal Button--medium mr1 mb1">Not empty</button>
                            <button data-reactid="##addVar## LIKE '%##addText##%'" class="Button Button-normal Button--medium mr1 mb1">Contains</button>
                            <button data-reactid="##addVar## NOT LIKE '%##addText##%'" class="Button Button-normal Button--medium mr1 mb1">Does not contain</button>
                            <button data-reactid="##addVar## LIKE '##addText##%'" class="Button Button-normal Button--medium mr1 mb1">Starts with</button>
                            <button data-reactid="##addVar## LIKE '%##addText##'" class="Button Button-normal Button--medium mr1 mb1">Ends with</button>
                        </div>
                        <div data-reactid=".g.0.1.0" style="display: none;"class="border-bottom p1 buttonContainer buttonContainerInt">
                            <button data-reactid="##addVar## = ##addText## " class="Button Button-normal Button--medium mr1 mb1 Button--purple">Equal</button>
                            <button data-reactid="##addVar## <> ##addText## " class="Button Button-normal Button--medium mr1 mb1">Not equal</button>
                            <button data-reactid="##addVar## > ##addText## " class="Button Button-normal Button--medium mr1 mb1">Greater than</button>
                            <button data-reactid="##addVar## < ##addText## " class="Button Button-normal Button--medium mr1 mb1">Less than</button>
                            <button data-reactid="##addVar## >= ##addText## " class="Button Button-normal Button--medium mr1 mb1">Greater than or equal to</button>
                            <button data-reactid="##addVar## <= ##addText## " class="Button Button-normal Button--medium mr1 mb1">Less than or equal to</button>
                            <button data-reactid="##addVar## IS NULL " class="Button Button-normal Button--medium mr1 mb1">Is empty</button>
                            <button data-reactid="##addVar## IS NOT NULL " class="Button Button-normal Button--medium mr1 mb1">Not empty</button>
                        </div>
                        <div data-reactid=".g.0.1.0"style="display: none;" class="border-bottom p1 buttonContainer buttonContainerCal">
                            <section data-reactid=".g.$=10.0.1.1.0"><span data-reactid=".g.$=10.0.1.1.0.$0" class="inline-block half pb1 pr1">
                                    <button data-reactid="DATE(##addVar##) = CURRENT_DATE" class="Button Button-normal Button--medium text-normal text-centered full">Today</button>
                                </span>
                                <span data-reactid=".g.$=10.0.1.1.0.$1" class="inline-block half pb1">
                                    <button data-reactid="DATE(##addVar##) = CURRENT_DATE - 1" class="Button Button-normal Button--medium text-normal text-centered full">Yesterday</button>
                                </span>
                                <span data-reactid=".g.$=10.0.1.1.0.$2" class="inline-block half pb1 pr1">
                                    <button data-reactid="DATE(##addVar##) > CURRENT_DATE- INTERVAL '7' DAY" class="Button Button-normal Button--medium text-normal text-centered full">Past 7 days</button></span>
                                <span data-reactid=".g.$=10.0.1.1.0.$3" class="inline-block half pb1">
                                    <button data-reactid="DATE(##addVar##) > CURRENT_DATE- INTERVAL '30' DAY" class="Button Button-normal Button--medium text-normal text-centered full">Past 30 days</button></span>
                            </section>
                            <section data-reactid=".g.$=10.0.1.1.1:$Last">
                                <div data-reactid=".g.$=10.0.1.1.1:$Last.0" class="border-bottom text-uppercase flex layout-centered mb2">
                                    <h6 data-reactid=".g.$=10.0.1.1.1:$Last.0.0" class="px2" style="position:relative;background-color:white;top:6px;">Last</h6>
                                </div>
                                <div data-reactid=".g.$=10.0.1.1.1:$Last.1" class="flex">
                                    <button data-reactid="DATE(##addVar##) BETWEEN CURRENT_DATE ::DATE-EXTRACT(DOW FROM CURRENT_DATE)::INTEGER-7 AND CURRENT_DATE::DATE-EXTRACT(DOW from CURRENT_DATE)::INTEGER" class="Button Button-normal Button--medium flex-full mb1 mr1" data-ui-tag="relative-date-shortcut-last-week">Week</button>
                                    <button data-reactid="Extract (YEAR from DATE(##addVar##)) = Extract (YEAR from CURRENT_DATE - INTERVAL '1 MONTH') AND Extract (MONTH from DATE(##addVar##)) = Extract (MONTH from CURRENT_DATE - INTERVAL '1 MONTH')" class="Button Button-normal Button--medium flex-full mb1 mr1" data-ui-tag="relative-date-shortcut-last-month">Month</button>
                                    <button data-reactid="DATE(##addVar##) >= date_trunc('year', CURRENT_DATE - INTERVAL '1 year' ) AND    DATE(##addVar##) <  date_trunc('year', CURRENT_DATE)" class="Button Button-normal Button--medium flex-full mb1" data-ui-tag="relative-date-shortcut-last-year">Year</button></div>
                            </section>
                            <section data-reactid=".g.$=10.0.1.1.1:$This">
                                <div data-reactid=".g.$=10.0.1.1.1:$This.0" class="border-bottom text-uppercase flex layout-centered mb2">
                                    <h6 data-reactid=".g.$=10.0.1.1.1:$This.0.0" class="px2" style="position:relative;background-color:white;top:6px;">This</h6>
                                </div>
                                <div data-reactid=".g.$=10.0.1.1.1:$This.1" class="flex">
                                    <button data-reactid="Extract(year from DATE(##addVar##)) =  Extract(year from CURRENT_DATE) AND Extract(week from DATE(##addVar##)) =  Extract(week from CURRENT_DATE)" class="Button Button-normal Button--medium flex-full mb1 mr1" data-ui-tag="relative-date-shortcut-this-week">Week</button>
                                    <button data-reactid="Extract(year from DATE(##addVar##)) =  Extract(year from CURRENT_DATE) AND Extract(month from DATE(##addVar##)) =  Extract(month from CURRENT_DATE)" class="Button Button-normal Button--medium flex-full mb1 mr1" data-ui-tag="relative-date-shortcut-this-month">Month</button>
                                    <button data-reactid="Extract(year from DATE(##addVar##)) =  Extract(year from CURRENT_DATE)" class="Button Button-normal Button--medium flex-full mb1" data-ui-tag="relative-date-shortcut-this-year">Year</button>
                                </div>
                            </section>


                        </div>
                        <div>
                            <ul>
                                <li class="FilterInput px1 pt1 relative">
                                    <input type="text" placeholder="Enter desired text" class="input block full border-purple FilterInputText">
                                </li>
                            </ul>
                            <div class="p1"></div>
                        </div>
                    </div>
                    <div class="FilterPopover-footer p1">
                        <button class="Button Button--purple full addFilterButton" data-ui-tag="add-filter">Add filter</button>
                    </div>


                    <div style="display: none;" class="p1 forCustomDateOnly">

                        <section  data-reactid=".g.$=10.0.1.1.1:$This">
                            <div data-reactid=".g.$=10.0.1.1.1:$This.1" class="flex">
                                <span>Start Date</span>
                                <input type="text"  class="input block full border-purple" name="dateRangeStart" id="dateRangeStart" value="01/01/2015" />

                            </div>
                            <div data-reactid=".g.$=10.0.1.1.1:$This.1" class="flex">
                                <span>End Date</span>
                                <input type="text" class="input block full border-purple"  name="dateRangeEnd" id="dateRangeEnd" value="01/01/2015" />

                            </div>
                        </section>
                        <button data-attr=" ##addText## >= '##firstVal##' AND ##addText## <= '##secVal##' " class="Button Button--purple full addCustomDateFilter" data-ui-tag="add-filter">Add Date</button>
                    </div>
                </div>
            </div>
        </div>
    </span>
    <span class="PopoverContainer tether-element tether-element-attached-center tether-target-attached-center tether-enabled tether-element-attached-top tether-target-attached-bottom" style="top: 0px; left: 0px; position: absolute; transform: translateX(267px) translateY(225px) translateZ(0px); z-index: 3;">
        <div  style="display:none" class="PopoverBody PopoverBody--withArrow FilterPopover" id="rawDataList">
            <div   style="width:300px;" class="text-green" >
                <section   class="List-section List-section--open">
                    <ul   class="p1 border-bottom scroll-y scroll-show" style="max-height:400px;">
                        <li   data-attr="Raw data" class="List-item flex List-item--selected">
                            <a   style="padding-top:0.25rem;padding-bottom:0.25rem;" class="flex-full flex align-center px1 cursor-pointer">
                                <h4   class="List-item-title ml2">Raw data</h4>
                            </a>
                            <div   class="p1"><span   class="QuestionTooltipTarget"><span   class="hide"></span></span>
                            </div>
                        </li>
                        <li data-attr="Count(*) as Count" class="List-item flex">
                            <a style="padding-top:0.25rem;padding-bottom:0.25rem;" class="flex-full flex align-center px1 cursor-pointer">
                                <h4 class="List-item-title ml2">Count of rows</h4>
                            </a>
                            <div class="p1"><span class="QuestionTooltipTarget"><span   class="hide"></span></span>
                            </div>
                        </li>
                        <li data-attr="Sum(##addText##)" class="List-item flex">
                            <a style="padding-top:0.25rem;padding-bottom:0.25rem;" class="flex-full flex align-center px1 cursor-pointer">
                                <h4 class="List-item-title ml2">Sum of ...</h4>
                            </a>
                            <div class="p1"><span class="QuestionTooltipTarget"><span   class="hide"></span></span>
                            </div>
                        </li>
                        <li data-attr="Avg(##addText##)" class="List-item flex">
                            <a style="padding-top:0.25rem;padding-bottom:0.25rem;" class="flex-full flex align-center px1 cursor-pointer">
                                <h4 class="List-item-title ml2">Average of ...</h4>
                            </a>
                            <div class="p1"><span class="QuestionTooltipTarget"><span   class="hide"></span></span>
                            </div>
                        </li>
                        <li data-attr="Count(Distinct ##addText##)" class="List-item flex">
                            <a style="padding-top:0.25rem;padding-bottom:0.25rem;" class="flex-full flex align-center px1 cursor-pointer">
                                <h4 class="List-item-title ml2">Number of distinct values of ...</h4>
                            </a>
                            <div class="p1"><span class="QuestionTooltipTarget"><span   class="hide"></span></span>
                            </div>
                        </li>
                        <li data-attr="STDDEV(##addText##)" class="List-item flex">
                            <a style="padding-top:0.25rem;padding-bottom:0.25rem;" class="flex-full flex align-center px1 cursor-pointer">
                                <h4 class="List-item-title ml2">Standard deviation of ...</h4>
                            </a>
                            <div class="p1"><span class="QuestionTooltipTarget"><span   class="hide"></span></span>
                            </div>
                        </li>
                        <li  data-attr="MIN(##addText##)" class="List-item flex">
                            <a style="padding-top:0.25rem;padding-bottom:0.25rem;" class="flex-full flex align-center px1 cursor-pointer">
                                <h4 class="List-item-title ml2">Minimum of ...</h4>
                            </a>
                            <div class="p1"><span class="QuestionTooltipTarget"><span   class="hide"></span></span>
                            </div>
                        </li>
                        <li data-attr="MAX(##addText##)" class="List-item flex">
                            <a style="padding-top:0.25rem;padding-bottom:0.25rem;" class="flex-full flex align-center px1 cursor-pointer">
                                <h4 class="List-item-title ml2">Maximum of ...</h4>
                            </a>
                            <div class="p1"><span class="QuestionTooltipTarget"><span   class="hide"></span></span>
                            </div>
                        </li>
                    </ul>
                </section>
            </div>
        </div>
        <div style="display:none" class="PopoverBody PopoverBody--withArrow FilterPopover rawSecondLevel">
            <div style="width:300px;">
                <div class="text-grey-3 p1 py2 border-bottom flex align-center">
                    <a class="cursor-pointer flex align-center">
                        <svg name="chevronleft" fill="currentcolor" viewBox="0 0 32 32" height="18" width="18" class="Icon Icon-chevronleft">
                        <path d="M20 1 L24 5 L14 16 L24 27 L20 31 L6 16 z" />
                        </svg>
                        <h3 class="inline-block pl1">Number of distinct values of ...</h3>
                    </a>
                </div>
                <div id="ColoumnListContents" style="width:300px;" class="text-green">
                    <section class="List-section List-section--open">
                        <div class="p1 border-bottom">
                            <div class="px1 py1 flex align-center">
                                <span class="List-section-icon mr2">
                                    <svg   name="table2" fill="currentcolor" viewBox="0 0 32 28" height="18" width="18" class="Icon Icon-table2">
                                    <g fill-rule="evenodd" fill="currentcolor">
                                    <path d="M10,19 L10,15 L3,15 L3,13 L10,13 L10,9 L12,9 L12,13 L20,13 L20,9 L22,9 L22,13 L29,13 L29,15 L22,15 L22,19 L29,19 L29,21 L22,21 L22,25 L20,25 L20,21 L12,21 L12,25 L10,25 L10,21 L3,21 L3,19 L10,19 L10,19 Z M12,19 L12,15 L20,15 L20,19 L12,19 Z M30.5,0 L32,0 L32,28 L30.5,28 L1.5,28 L0,28 L0,0 L1.5,0 L30.5,0 Z M29,3 L29,25 L3,25 L3,3 L29,3 Z M3,7 L29,7 L29,9 L3,9 L3,7 Z"/>
                                    </g>
                                    </svg>
                                </span>
                                <h3 class="text-default">window</h3>
                            </div>
                        </div>
                        <ul class="p1 border-bottom scroll-y scroll-show" style="max-height:400px;">
                            <li class="List-item flex">
                                <a style="padding-top:0.25rem;padding-bottom:0.25rem;" class="flex-full flex align-center px1 cursor-pointer">
                                    <svg name="string" fill="currentcolor" viewBox="0 0 24 24" height="18" width="18" class="Icon Icon-string">
                                    <path d="M14.022,18 L11.533,18 C11.2543319,18 11.0247509,17.935084 10.84425,17.80525 C10.6637491,17.675416 10.538667,17.5091677 10.469,17.3065 L9.652,14.8935 L4.389,14.8935 L3.572,17.3065 C3.50866635,17.4838342 3.38516758,17.6437493 3.2015,17.78625 C3.01783241,17.9287507 2.79300133,18 2.527,18 L0.019,18 L5.377,4.1585 L8.664,4.1585 L14.022,18 Z M5.13,12.7085 L8.911,12.7085 L7.638,8.918 C7.55566626,8.67733213 7.45908389,8.3939183 7.34825,8.06775 C7.23741611,7.7415817 7.12816721,7.3885019 7.0205,7.0085 C6.91916616,7.39483527 6.8146672,7.75266502 6.707,8.082 C6.5993328,8.41133498 6.49800047,8.69633213 6.403,8.937 L5.13,12.7085 Z M21.945,18 C21.6663319,18 21.4557507,17.9620004 21.31325,17.886 C21.1707493,17.8099996 21.0520005,17.6516679 20.957,17.411 L20.748,16.8695 C20.5009988,17.078501 20.2635011,17.2621659 20.0355,17.4205 C19.8074989,17.5788341 19.5715846,17.7134161 19.32775,17.82425 C19.0839154,17.9350839 18.8242514,18.0174164 18.54875,18.07125 C18.2732486,18.1250836 17.9676683,18.152 17.632,18.152 C17.1823311,18.152 16.7738352,18.0934173 16.4065,17.97625 C16.0391648,17.8590827 15.7272513,17.6865011 15.47075,17.4585 C15.2142487,17.2304989 15.016334,16.947085 14.877,16.60825 C14.737666,16.269415 14.668,15.8783355 14.668,15.435 C14.668,15.0866649 14.7566658,14.7288352 14.934,14.3615 C15.1113342,13.9941648 15.4184978,13.6600848 15.8555,13.35925 C16.2925022,13.0584152 16.8814963,12.8066677 17.6225,12.604 C18.3635037,12.4013323 19.297661,12.2873335 20.425,12.262 L20.425,11.844 C20.425,11.2676638 20.3062512,10.8512513 20.06875,10.59475 C19.8312488,10.3382487 19.4940022,10.21 19.057,10.21 C18.7086649,10.21 18.4236678,10.2479996 18.202,10.324 C17.9803322,10.4000004 17.7824175,10.4854995 17.60825,10.5805 C17.4340825,10.6755005 17.2646675,10.7609996 17.1,10.837 C16.9353325,10.9130004 16.7390011,10.951 16.511,10.951 C16.3083323,10.951 16.1357507,10.9019172 15.99325,10.80375 C15.8507493,10.7055828 15.7383337,10.5836674 15.656,10.438 L15.124,9.5165 C15.7193363,8.99083071 16.3795797,8.59975128 17.10475,8.34325 C17.8299203,8.08674872 18.6073292,7.9585 19.437,7.9585 C20.0323363,7.9585 20.5690809,8.05508237 21.04725,8.24825 C21.5254191,8.44141763 21.9307483,8.71058161 22.26325,9.05575 C22.5957517,9.40091839 22.8506658,9.81099763 23.028,10.286 C23.2053342,10.7610024 23.294,11.2803305 23.294,11.844 L23.294,18 L21.945,18 Z M18.563,16.2045 C18.9430019,16.2045 19.2754986,16.1380007 19.5605,16.005 C19.8455014,15.8719993 20.1336652,15.6566682 20.425,15.359 L20.425,13.991 C19.8359971,14.0163335 19.3515019,14.0669996 18.9715,14.143 C18.5914981,14.2190004 18.2906678,14.3139994 18.069,14.428 C17.8473322,14.5420006 17.6937504,14.6718326 17.60825,14.8175 C17.5227496,14.9631674 17.48,15.1214991 17.48,15.2925 C17.48,15.6281683 17.5718324,15.8640827 17.7555,16.00025 C17.9391676,16.1364173 18.2083316,16.2045 18.563,16.2045 L18.563,16.2045 Z" />
                                    </svg>
                                    <h4 class="List-item-title ml2">title</h4>
                                </a>
                                <div class="flex align-center"></div>
                            </li>
                            <li class="List-item flex">
                                <a style="padding-top:0.25rem;padding-bottom:0.25rem;" class="flex-full flex align-center px1 cursor-pointer">
                                    <svg name="string" fill="currentcolor" viewBox="0 0 24 24" height="18" width="18" class="Icon Icon-string">
                                    <path d="M14.022,18 L11.533,18 C11.2543319,18 11.0247509,17.935084 10.84425,17.80525 C10.6637491,17.675416 10.538667,17.5091677 10.469,17.3065 L9.652,14.8935 L4.389,14.8935 L3.572,17.3065 C3.50866635,17.4838342 3.38516758,17.6437493 3.2015,17.78625 C3.01783241,17.9287507 2.79300133,18 2.527,18 L0.019,18 L5.377,4.1585 L8.664,4.1585 L14.022,18 Z M5.13,12.7085 L8.911,12.7085 L7.638,8.918 C7.55566626,8.67733213 7.45908389,8.3939183 7.34825,8.06775 C7.23741611,7.7415817 7.12816721,7.3885019 7.0205,7.0085 C6.91916616,7.39483527 6.8146672,7.75266502 6.707,8.082 C6.5993328,8.41133498 6.49800047,8.69633213 6.403,8.937 L5.13,12.7085 Z M21.945,18 C21.6663319,18 21.4557507,17.9620004 21.31325,17.886 C21.1707493,17.8099996 21.0520005,17.6516679 20.957,17.411 L20.748,16.8695 C20.5009988,17.078501 20.2635011,17.2621659 20.0355,17.4205 C19.8074989,17.5788341 19.5715846,17.7134161 19.32775,17.82425 C19.0839154,17.9350839 18.8242514,18.0174164 18.54875,18.07125 C18.2732486,18.1250836 17.9676683,18.152 17.632,18.152 C17.1823311,18.152 16.7738352,18.0934173 16.4065,17.97625 C16.0391648,17.8590827 15.7272513,17.6865011 15.47075,17.4585 C15.2142487,17.2304989 15.016334,16.947085 14.877,16.60825 C14.737666,16.269415 14.668,15.8783355 14.668,15.435 C14.668,15.0866649 14.7566658,14.7288352 14.934,14.3615 C15.1113342,13.9941648 15.4184978,13.6600848 15.8555,13.35925 C16.2925022,13.0584152 16.8814963,12.8066677 17.6225,12.604 C18.3635037,12.4013323 19.297661,12.2873335 20.425,12.262 L20.425,11.844 C20.425,11.2676638 20.3062512,10.8512513 20.06875,10.59475 C19.8312488,10.3382487 19.4940022,10.21 19.057,10.21 C18.7086649,10.21 18.4236678,10.2479996 18.202,10.324 C17.9803322,10.4000004 17.7824175,10.4854995 17.60825,10.5805 C17.4340825,10.6755005 17.2646675,10.7609996 17.1,10.837 C16.9353325,10.9130004 16.7390011,10.951 16.511,10.951 C16.3083323,10.951 16.1357507,10.9019172 15.99325,10.80375 C15.8507493,10.7055828 15.7383337,10.5836674 15.656,10.438 L15.124,9.5165 C15.7193363,8.99083071 16.3795797,8.59975128 17.10475,8.34325 C17.8299203,8.08674872 18.6073292,7.9585 19.437,7.9585 C20.0323363,7.9585 20.5690809,8.05508237 21.04725,8.24825 C21.5254191,8.44141763 21.9307483,8.71058161 22.26325,9.05575 C22.5957517,9.40091839 22.8506658,9.81099763 23.028,10.286 C23.2053342,10.7610024 23.294,11.2803305 23.294,11.844 L23.294,18 L21.945,18 Z M18.563,16.2045 C18.9430019,16.2045 19.2754986,16.1380007 19.5605,16.005 C19.8455014,15.8719993 20.1336652,15.6566682 20.425,15.359 L20.425,13.991 C19.8359971,14.0163335 19.3515019,14.0669996 18.9715,14.143 C18.5914981,14.2190004 18.2906678,14.3139994 18.069,14.428 C17.8473322,14.5420006 17.6937504,14.6718326 17.60825,14.8175 C17.5227496,14.9631674 17.48,15.1214991 17.48,15.2925 C17.48,15.6281683 17.5718324,15.8640827 17.7555,16.00025 C17.9391676,16.1364173 18.2083316,16.2045 18.563,16.2045 L18.563,16.2045 Z" />
                                    </svg>
                                    <h4 class="List-item-title ml2">name</h4>
                                </a>
                                <div class="flex align-center"></div>
                            </li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
    </span>
    <span id="groupByContainer" class="PopoverContainer tether-element tether-element-attached-center tether-target-attached-center tether-enabled tether-element-attached-top tether-target-attached-bottom" style="top: 0px; left: 0px; display:none; position: absolute; transform: translateX(498px) translateY(223px) translateZ(0px); z-index: 3;">
        <div   style="display:none" class="PopoverBody PopoverBody--withArrow FieldPopover groupLists">
            <div   style="width:300px;" class="text-green">
                <section   class="List-section List-section--open">
                    <div   class="p1 border-bottom">
                        <div   class="px1 py1 flex align-center">
                            <span   class="List-section-icon mr2">
                                <svg   name="table2" fill="currentcolor" viewBox="0 0 32 28" height="18" width="18" class="Icon Icon-table2">
                                <g fill-rule="evenodd" fill="currentcolor">
                                <path d="M10,19 L10,15 L3,15 L3,13 L10,13 L10,9 L12,9 L12,13 L20,13 L20,9 L22,9 L22,13 L29,13 L29,15 L22,15 L22,19 L29,19 L29,21 L22,21 L22,25 L20,25 L20,21 L12,21 L12,25 L10,25 L10,21 L3,21 L3,19 L10,19 L10,19 Z M12,19 L12,15 L20,15 L20,19 L12,19 Z M30.5,0 L32,0 L32,28 L30.5,28 L1.5,28 L0,28 L0,0 L1.5,0 L30.5,0 Z M29,3 L29,25 L3,25 L3,3 L29,3 Z M3,7 L29,7 L29,9 L3,9 L3,7 Z"/>
                                </g>
                                </svg>
                            </span>
                            <h3 class="text-default">window</h3>
                        </div>
                    </div>
                    <ul class="p1 border-bottom scroll-y scroll-show" style="max-height:400px;">
                        <li style="display:none;" class="List-item flex">
                            <a style="padding-top:0.25rem;padding-bottom:0.25rem;" class="flex-full flex align-center px1 cursor-pointer">
                                <svg name="string" fill="currentcolor" viewBox="0 0 24 24" height="18" width="18" class="Icon Icon-string">
                                <path d="M14.022,18 L11.533,18 C11.2543319,18 11.0247509,17.935084 10.84425,17.80525 C10.6637491,17.675416 10.538667,17.5091677 10.469,17.3065 L9.652,14.8935 L4.389,14.8935 L3.572,17.3065 C3.50866635,17.4838342 3.38516758,17.6437493 3.2015,17.78625 C3.01783241,17.9287507 2.79300133,18 2.527,18 L0.019,18 L5.377,4.1585 L8.664,4.1585 L14.022,18 Z M5.13,12.7085 L8.911,12.7085 L7.638,8.918 C7.55566626,8.67733213 7.45908389,8.3939183 7.34825,8.06775 C7.23741611,7.7415817 7.12816721,7.3885019 7.0205,7.0085 C6.91916616,7.39483527 6.8146672,7.75266502 6.707,8.082 C6.5993328,8.41133498 6.49800047,8.69633213 6.403,8.937 L5.13,12.7085 Z M21.945,18 C21.6663319,18 21.4557507,17.9620004 21.31325,17.886 C21.1707493,17.8099996 21.0520005,17.6516679 20.957,17.411 L20.748,16.8695 C20.5009988,17.078501 20.2635011,17.2621659 20.0355,17.4205 C19.8074989,17.5788341 19.5715846,17.7134161 19.32775,17.82425 C19.0839154,17.9350839 18.8242514,18.0174164 18.54875,18.07125 C18.2732486,18.1250836 17.9676683,18.152 17.632,18.152 C17.1823311,18.152 16.7738352,18.0934173 16.4065,17.97625 C16.0391648,17.8590827 15.7272513,17.6865011 15.47075,17.4585 C15.2142487,17.2304989 15.016334,16.947085 14.877,16.60825 C14.737666,16.269415 14.668,15.8783355 14.668,15.435 C14.668,15.0866649 14.7566658,14.7288352 14.934,14.3615 C15.1113342,13.9941648 15.4184978,13.6600848 15.8555,13.35925 C16.2925022,13.0584152 16.8814963,12.8066677 17.6225,12.604 C18.3635037,12.4013323 19.297661,12.2873335 20.425,12.262 L20.425,11.844 C20.425,11.2676638 20.3062512,10.8512513 20.06875,10.59475 C19.8312488,10.3382487 19.4940022,10.21 19.057,10.21 C18.7086649,10.21 18.4236678,10.2479996 18.202,10.324 C17.9803322,10.4000004 17.7824175,10.4854995 17.60825,10.5805 C17.4340825,10.6755005 17.2646675,10.7609996 17.1,10.837 C16.9353325,10.9130004 16.7390011,10.951 16.511,10.951 C16.3083323,10.951 16.1357507,10.9019172 15.99325,10.80375 C15.8507493,10.7055828 15.7383337,10.5836674 15.656,10.438 L15.124,9.5165 C15.7193363,8.99083071 16.3795797,8.59975128 17.10475,8.34325 C17.8299203,8.08674872 18.6073292,7.9585 19.437,7.9585 C20.0323363,7.9585 20.5690809,8.05508237 21.04725,8.24825 C21.5254191,8.44141763 21.9307483,8.71058161 22.26325,9.05575 C22.5957517,9.40091839 22.8506658,9.81099763 23.028,10.286 C23.2053342,10.7610024 23.294,11.2803305 23.294,11.844 L23.294,18 L21.945,18 Z M18.563,16.2045 C18.9430019,16.2045 19.2754986,16.1380007 19.5605,16.005 C19.8455014,15.8719993 20.1336652,15.6566682 20.425,15.359 L20.425,13.991 C19.8359971,14.0163335 19.3515019,14.0669996 18.9715,14.143 C18.5914981,14.2190004 18.2906678,14.3139994 18.069,14.428 C17.8473322,14.5420006 17.6937504,14.6718326 17.60825,14.8175 C17.5227496,14.9631674 17.48,15.1214991 17.48,15.2925 C17.48,15.6281683 17.5718324,15.8640827 17.7555,16.00025 C17.9391676,16.1364173 18.2083316,16.2045 18.563,16.2045 L18.563,16.2045 Z" />
                                </svg>
                                <h4 class="List-item-title ml2">date</h4>
                            </a>
                            <div class="flex align-center"></div>
                        </li>
                    </ul>
                </section>
            </div>
        </div>
    </span>
    <span class="PopoverContainer tether-element tether-target-attached-center tether-element-attached-top tether-target-attached-bottom tether-element-attached-right tether-enabled" id="sortSpan" style="display:none;top: 0px; left: 0px; position: absolute; transform: translateX(917px) translateY(234px) translateZ(0px); z-index: 3;">
        <div   class="PopoverBody ">
            <div   class="px3 py1">
                <div   class="py1 border-bottom">
                    <div   class="Query-label mb1">Sort by:</div>
                    <a   id="sortFieldPicker" class="text-grey-2 text-bold flex align-center text-grey-4-hover cursor-pointer no-decoration transition-color">
                        <div   style="width:28px;height:28px;border-width:1px;border-style:solid;border-color:currentcolor;border-radius:3px;" class="flex layout-centered">
                            <svg   name="add" fill="currentcolor" viewBox="0 0 32 32" height="14px" width="14px" class="Icon Icon-add">
                            <path   d="M19,13 L19,2 L14,2 L14,13 L2,13 L2,18 L14,18 L14,30 L19,30 L19,18 L30,18 L30,13 L19,13 Z"/>
                            </svg>
                        </div>
                        <span id="beforeSortClick"    class="ml1">Pick a field to sort by</span>
                        <div id="afterSortClick" style="display:none;" class="flex align-center">
                            <div class="flex align-center">
                                <div class="flex align-center">
                                    <div class="Filter-section Filter-section-sort-field SelectionModule selected">
                                        <span class="QueryOption">
                                            <span id="sortTag"  >
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="SelectionModule selected Filter-section Filter-section-sort-direction">
                                <div class="SelectionModule-trigger flex align-center">
                                    <a id="sortOrder" class="QueryOption p1 flex align-center" data-attr="ASC">ascending</a>
                                </div>
                            </div>
                            <a id="removeSortTag">
                                <svg name="close" fill="currentcolor" viewBox="0 0 32 32" height="12px" width="12px" class="Icon Icon-close">
                                <path d="M4 8 L8 4 L16 12 L24 4 L28 8 L20 16 L28 24 L24 28 L16 20 L8 28 L4 24 L12 16 z " />
                                </svg>
                            </a>
                        </div>
                    </a>
                </div>
                <div id="limit" class="py1">
                    <div class="Query-label mb1">Limit:</div>
                    <ul class="Button-group Button-group--blue">
                        <li class="Button">None</li>
                        <li class="Button">1</li>
                        <li class="Button">10</li>
                        <li class="Button">25</li>
                        <li class="Button Button--active">100</li>
                        <li class="Button">1000</li>
                    </ul>
                </div>
            </div>
        </div>
    </span>
    <span class="PopoverContainer tether-element tether-element-attached-center tether-target-attached-center tether-enabled tether-element-attached-top tether-target-attached-bottom" id="sortColoumnContainer" style="top: 0px; left: 0px; position: absolute; transform: translateX(805px) translateY(302px) translateZ(0px); z-index: 4;">
        <div   style="display:none;"  class="PopoverBody PopoverBody--withArrow FieldPopover sortColoumn">
            <div   style="width:300px;" class="text-brand " >
                <section    class="List-section List-section--open">
                    <div   class="p1 border-bottom">
                        <div   class="px1 py1 flex align-center">
                            <span   class="List-section-icon mr2">
                                <svg   name="table2" fill="currentcolor" viewBox="0 0 32 28" height="18" width="18" class="Icon Icon-table2">
                                <g fill-rule="evenodd" fill="currentcolor">
                                <path d="M10,19 L10,15 L3,15 L3,13 L10,13 L10,9 L12,9 L12,13 L20,13 L20,9 L22,9 L22,13 L29,13 L29,15 L22,15 L22,19 L29,19 L29,21 L22,21 L22,25 L20,25 L20,21 L12,21 L12,25 L10,25 L10,21 L3,21 L3,19 L10,19 L10,19 Z M12,19 L12,15 L20,15 L20,19 L12,19 Z M30.5,0 L32,0 L32,28 L30.5,28 L1.5,28 L0,28 L0,0 L1.5,0 L30.5,0 Z M29,3 L29,25 L3,25 L3,3 L29,3 Z M3,7 L29,7 L29,9 L3,9 L3,7 Z"/>
                                </g>
                                </svg>
                            </span>
                            <h3 class="text-default">window</h3>
                        </div>
                    </div>
                    <ul class="p1 border-bottom scroll-y scroll-show" style="max-height:400px;">
                        <li style="display:none;" class="List-item flex">
                            <a style="padding-top:0.25rem;padding-bottom:0.25rem;" class="flex-full flex align-center px1 cursor-pointer">
                                <svg name="string" fill="currentcolor" viewBox="0 0 24 24" height="18" width="18" class="Icon Icon-string">
                                <path d="M14.022,18 L11.533,18 C11.2543319,18 11.0247509,17.935084 10.84425,17.80525 C10.6637491,17.675416 10.538667,17.5091677 10.469,17.3065 L9.652,14.8935 L4.389,14.8935 L3.572,17.3065 C3.50866635,17.4838342 3.38516758,17.6437493 3.2015,17.78625 C3.01783241,17.9287507 2.79300133,18 2.527,18 L0.019,18 L5.377,4.1585 L8.664,4.1585 L14.022,18 Z M5.13,12.7085 L8.911,12.7085 L7.638,8.918 C7.55566626,8.67733213 7.45908389,8.3939183 7.34825,8.06775 C7.23741611,7.7415817 7.12816721,7.3885019 7.0205,7.0085 C6.91916616,7.39483527 6.8146672,7.75266502 6.707,8.082 C6.5993328,8.41133498 6.49800047,8.69633213 6.403,8.937 L5.13,12.7085 Z M21.945,18 C21.6663319,18 21.4557507,17.9620004 21.31325,17.886 C21.1707493,17.8099996 21.0520005,17.6516679 20.957,17.411 L20.748,16.8695 C20.5009988,17.078501 20.2635011,17.2621659 20.0355,17.4205 C19.8074989,17.5788341 19.5715846,17.7134161 19.32775,17.82425 C19.0839154,17.9350839 18.8242514,18.0174164 18.54875,18.07125 C18.2732486,18.1250836 17.9676683,18.152 17.632,18.152 C17.1823311,18.152 16.7738352,18.0934173 16.4065,17.97625 C16.0391648,17.8590827 15.7272513,17.6865011 15.47075,17.4585 C15.2142487,17.2304989 15.016334,16.947085 14.877,16.60825 C14.737666,16.269415 14.668,15.8783355 14.668,15.435 C14.668,15.0866649 14.7566658,14.7288352 14.934,14.3615 C15.1113342,13.9941648 15.4184978,13.6600848 15.8555,13.35925 C16.2925022,13.0584152 16.8814963,12.8066677 17.6225,12.604 C18.3635037,12.4013323 19.297661,12.2873335 20.425,12.262 L20.425,11.844 C20.425,11.2676638 20.3062512,10.8512513 20.06875,10.59475 C19.8312488,10.3382487 19.4940022,10.21 19.057,10.21 C18.7086649,10.21 18.4236678,10.2479996 18.202,10.324 C17.9803322,10.4000004 17.7824175,10.4854995 17.60825,10.5805 C17.4340825,10.6755005 17.2646675,10.7609996 17.1,10.837 C16.9353325,10.9130004 16.7390011,10.951 16.511,10.951 C16.3083323,10.951 16.1357507,10.9019172 15.99325,10.80375 C15.8507493,10.7055828 15.7383337,10.5836674 15.656,10.438 L15.124,9.5165 C15.7193363,8.99083071 16.3795797,8.59975128 17.10475,8.34325 C17.8299203,8.08674872 18.6073292,7.9585 19.437,7.9585 C20.0323363,7.9585 20.5690809,8.05508237 21.04725,8.24825 C21.5254191,8.44141763 21.9307483,8.71058161 22.26325,9.05575 C22.5957517,9.40091839 22.8506658,9.81099763 23.028,10.286 C23.2053342,10.7610024 23.294,11.2803305 23.294,11.844 L23.294,18 L21.945,18 Z M18.563,16.2045 C18.9430019,16.2045 19.2754986,16.1380007 19.5605,16.005 C19.8455014,15.8719993 20.1336652,15.6566682 20.425,15.359 L20.425,13.991 C19.8359971,14.0163335 19.3515019,14.0669996 18.9715,14.143 C18.5914981,14.2190004 18.2906678,14.3139994 18.069,14.428 C17.8473322,14.5420006 17.6937504,14.6718326 17.60825,14.8175 C17.5227496,14.9631674 17.48,15.1214991 17.48,15.2925 C17.48,15.6281683 17.5718324,15.8640827 17.7555,16.00025 C17.9391676,16.1364173 18.2083316,16.2045 18.563,16.2045 L18.563,16.2045 Z" />
                                </svg>
                                <h4 class="List-item-title ml2">time</h4>
                            </a>
                            <div class="flex align-center"></div>
                        </li>
                    </ul>
                </section>
            </div>
        </div>
    </span>

    <form action="csvDownload.php" method="post" id="export-form">
        <input type="hidden" value='' id='hidden-type' name='ExportType'/>
    </form>


    <div style="display:none;" id="iconContainer" >
        <svg data-reactid=".d.0.0.$0.2.$0.0.0" name="string" fill="currentcolor" viewBox="0 0 24 24" height="18" width="18" class="Icon Icon-string"><path data-reactid=".d.0.0.$0.2.$0.0.0.0" d="M14.022,18 L11.533,18 C11.2543319,18 11.0247509,17.935084 10.84425,17.80525 C10.6637491,17.675416 10.538667,17.5091677 10.469,17.3065 L9.652,14.8935 L4.389,14.8935 L3.572,17.3065 C3.50866635,17.4838342 3.38516758,17.6437493 3.2015,17.78625 C3.01783241,17.9287507 2.79300133,18 2.527,18 L0.019,18 L5.377,4.1585 L8.664,4.1585 L14.022,18 Z M5.13,12.7085 L8.911,12.7085 L7.638,8.918 C7.55566626,8.67733213 7.45908389,8.3939183 7.34825,8.06775 C7.23741611,7.7415817 7.12816721,7.3885019 7.0205,7.0085 C6.91916616,7.39483527 6.8146672,7.75266502 6.707,8.082 C6.5993328,8.41133498 6.49800047,8.69633213 6.403,8.937 L5.13,12.7085 Z M21.945,18 C21.6663319,18 21.4557507,17.9620004 21.31325,17.886 C21.1707493,17.8099996 21.0520005,17.6516679 20.957,17.411 L20.748,16.8695 C20.5009988,17.078501 20.2635011,17.2621659 20.0355,17.4205 C19.8074989,17.5788341 19.5715846,17.7134161 19.32775,17.82425 C19.0839154,17.9350839 18.8242514,18.0174164 18.54875,18.07125 C18.2732486,18.1250836 17.9676683,18.152 17.632,18.152 C17.1823311,18.152 16.7738352,18.0934173 16.4065,17.97625 C16.0391648,17.8590827 15.7272513,17.6865011 15.47075,17.4585 C15.2142487,17.2304989 15.016334,16.947085 14.877,16.60825 C14.737666,16.269415 14.668,15.8783355 14.668,15.435 C14.668,15.0866649 14.7566658,14.7288352 14.934,14.3615 C15.1113342,13.9941648 15.4184978,13.6600848 15.8555,13.35925 C16.2925022,13.0584152 16.8814963,12.8066677 17.6225,12.604 C18.3635037,12.4013323 19.297661,12.2873335 20.425,12.262 L20.425,11.844 C20.425,11.2676638 20.3062512,10.8512513 20.06875,10.59475 C19.8312488,10.3382487 19.4940022,10.21 19.057,10.21 C18.7086649,10.21 18.4236678,10.2479996 18.202,10.324 C17.9803322,10.4000004 17.7824175,10.4854995 17.60825,10.5805 C17.4340825,10.6755005 17.2646675,10.7609996 17.1,10.837 C16.9353325,10.9130004 16.7390011,10.951 16.511,10.951 C16.3083323,10.951 16.1357507,10.9019172 15.99325,10.80375 C15.8507493,10.7055828 15.7383337,10.5836674 15.656,10.438 L15.124,9.5165 C15.7193363,8.99083071 16.3795797,8.59975128 17.10475,8.34325 C17.8299203,8.08674872 18.6073292,7.9585 19.437,7.9585 C20.0323363,7.9585 20.5690809,8.05508237 21.04725,8.24825 C21.5254191,8.44141763 21.9307483,8.71058161 22.26325,9.05575 C22.5957517,9.40091839 22.8506658,9.81099763 23.028,10.286 C23.2053342,10.7610024 23.294,11.2803305 23.294,11.844 L23.294,18 L21.945,18 Z M18.563,16.2045 C18.9430019,16.2045 19.2754986,16.1380007 19.5605,16.005 C19.8455014,15.8719993 20.1336652,15.6566682 20.425,15.359 L20.425,13.991 C19.8359971,14.0163335 19.3515019,14.0669996 18.9715,14.143 C18.5914981,14.2190004 18.2906678,14.3139994 18.069,14.428 C17.8473322,14.5420006 17.6937504,14.6718326 17.60825,14.8175 C17.5227496,14.9631674 17.48,15.1214991 17.48,15.2925 C17.48,15.6281683 17.5718324,15.8640827 17.7555,16.00025 C17.9391676,16.1364173 18.2083316,16.2045 18.563,16.2045 L18.563,16.2045 Z"/></svg>
        <svg data-reactid=".d.0.0.$0.2.$2.0.0" name="int" fill="currentcolor" viewBox="0 0 24, 24" height="18" width="18" class="Icon Icon-int"><path data-reactid=".d.0.0.$0.2.$2.0.0.0" d="M15.141,15.512 L14.294,20 L13.051,20 C12.8309989,20 12.6403341,19.9120009 12.479,19.736 C12.3176659,19.5599991 12.237,19.343668 12.237,19.087 C12.237,19.0503332 12.2388333,19.0155002 12.2425,18.9825 C12.2461667,18.9494998 12.2516666,18.9146668 12.259,18.878 L12.908,15.512 L10.653,15.512 L10.015,19.01 C9.94899967,19.3620018 9.79866784,19.6149992 9.564,19.769 C9.32933216,19.9230008 9.06900143,20 8.783,20 L7.584,20 L8.42,15.512 L7.155,15.512 C6.92033216,15.512 6.74066729,15.4551672 6.616,15.3415 C6.49133271,15.2278328 6.429,15.0390013 6.429,14.775 C6.429,14.6723328 6.43999989,14.5550007 6.462,14.423 L6.605,13.554 L8.695,13.554 L9.267,10.518 L6.913,10.518 L7.122,9.385 C7.17333359,9.10633194 7.28699912,8.89916734 7.463,8.7635 C7.63900088,8.62783266 7.92499802,8.56 8.321,8.56 L9.542,8.56 L10.224,5.018 C10.282667,4.7246652 10.4183323,4.49733414 10.631,4.336 C10.8436677,4.17466586 11.0929986,4.094 11.379,4.094 L12.611,4.094 L11.775,8.56 L14.019,8.56 L14.866,4.094 L16.076,4.094 C16.3326679,4.094 16.5416659,4.1673326 16.703,4.314 C16.8643341,4.4606674 16.945,4.64766553 16.945,4.875 C16.945,4.9483337 16.9413334,5.00333315 16.934,5.04 L16.252,8.56 L18.485,8.56 L18.276,9.693 C18.2246664,9.97166806 18.1091676,10.1788327 17.9295,10.3145 C17.7498324,10.4501673 17.4656686,10.518 17.077,10.518 L15.977,10.518 L15.416,13.554 L16.978,13.554 C17.2126678,13.554 17.3904994,13.6108328 17.5115,13.7245 C17.6325006,13.8381672 17.693,14.0306653 17.693,14.302 C17.693,14.4046672 17.6820001,14.5219993 17.66,14.654 L17.528,15.512 L15.141,15.512 Z M10.928,13.554 L13.183,13.554 L13.744,10.518 L11.5,10.518 L10.928,13.554 Z"/></svg>
        <svg data-reactid=".d.0.0.$0.2.$5.0.0" name="calendar" fill="currentcolor" viewBox="0 0 24 24" height="18" width="18" class="Icon Icon-calendar"><path data-reactid=".d.0.0.$0.2.$5.0.0.0" d="M21,2 L21,0 L18,0 L18,2 L6,2 L6,0 L3,0 L3,2 L2.99109042,2 C1.34177063,2 0,3.34314575 0,5 L0,6.99502651 L0,20.009947 C0,22.2157067 1.78640758,24 3.99005301,24 L20.009947,24 C22.2157067,24 24,22.2135924 24,20.009947 L24,6.99502651 L24,5 C24,3.34651712 22.6608432,2 21.0089096,2 L21,2 L21,2 Z M22,8 L22,20.009947 C22,21.1099173 21.1102431,22 20.009947,22 L3.99005301,22 C2.89008272,22 2,21.1102431 2,20.009947 L2,8 L22,8 L22,8 Z M6,12 L10,12 L10,16 L6,16 L6,12 Z"/></svg>
    </div>
    <div id="loader-icon">
        <img src="LoaderIcon.gif" />
    </div>
    <div data-reactid=".2.$=1$modal.0" class="Modal Modal1" style="display:none;" >
        <a data-reactid=".2.$=1$modal.0.0.0.1" id="closeSaveDiv"  class="closeTable"></a>
        <div data-reactid=".2.$=1$modal.0.0" class="Modal-content NewForm"><div data-reactid=".2.$=1$modal.0.0.0" class="Modal-header Form-header flex align-center"><h2 data-reactid=".2.$=1$modal.0.0.0.0" class="flex-full">Save Question</h2></div><div data-reactid=".2.$=1$modal.0.0.1" class="Modal-body"><div data-reactid=".2.$=1$modal.0.0.1.0.0" class="Form-inputs"><div data-reactid=".2.$=1$modal.0.0.1.0.0.1" class="Form-field"><label data-reactid=".2.$=1$modal.0.0.1.0.0.1.0" class="Form-label"><span data-reactid=".2.$=1$modal.0.0.1.0.0.1.0.0">Name</span><span data-reactid=".2.$=1$modal.0.0.1.0.0.1.0.1"> </span></label><input data-reactid=".2.$=1$modal.0.0.1.0.0.1.1"  placeholder="Name your Query" name="tagName" id="tagName" class="Form-input full"></div><div data-reactid=".2.$=1$modal.0.0.1.0.0.2" class="Form-field"><label data-reactid=".2.$=1$modal.0.0.1.0.0.2.0" class="Form-label"><span data-reactid=".2.$=1$modal.0.0.1.0.0.2.0.0">Description (optional)</span><span data-reactid=".2.$=1$modal.0.0.1.0.0.2.0.1"> </span></label><textarea  data-reactid=".2.$=1$modal.0.0.1.0.0.2.1" placeholder="Describe" name="tagDescription" id="tagDescription"class="Form-input full"></textarea></div></div><div data-reactid=".2.$=1$modal.0.0.1.0.1" class="Form-actions"><input type="hidden" value="" name="queryColTagForm" id="queryColTagForm"></input><button data-reactid=".2.$=1$modal.0.0.1.0.1.0" class="Button Button--primary" id="saveTag">Save</button></div></div></div></div>

    <div data-reactid=".2.$=1$modal.0" class="Modal" style="z-index:9; display:none;" id="formAfterClick">
        <a id="closeTable" href="#" class="closeTable"></a>
        <div data-reactid=".2.$=1$modal.0.0" class="Modal-content NewForm">
            <div data-reactid=".7.2.0.0" class="Grid ObjectDetail-headingGroup">
                <div data-reactid=".7.2.0.0.0" class="Grid-cell ObjectDetail-infoMain px4 py3 ml2 arrow-right">
                    <div data-reactid=".7.2.0.0.0.0" class="text-brand text-bold">
                        <span data-reactid=".7.2.0.0.0.0.0" id="tableName_Form"></span>
                        <h1 data-reactid=".7.2.0.0.0.0.1" id="clickedId_Form"></h1>
                    </div>
                </div>
            </div>
            <div data-reactid=".7.2.0.1.0"  style="display:none;" class="Grid-cell ObjectDetail-infoMain p4">

                <div data-reactid=".7.2.0.1.0.$19" class="Grid mb2 gridList_f" >
                    <div data-reactid=".7.2.0.1.0.$19.0" class="Grid-cell">
                        <div class="f_colName" data-reactid=".7.2.0.1.0.$19.0.$cl19_field"></div>
                    </div>
                    <div data-reactid=".7.2.0.1.0.$19.1" class="Grid-cell text-bold text-dark" style="word-wrap:break-word;">
                        <div data-reactid=".7.2.0.1.0.$19.1.$cl19_value"><span class="f_colVal" data-reactid=".7.2.0.1.0.$19.1.$cl19_value.0.0"></span></div>
                    </div>
                </div>
            </div>
            <div data-reactid=".7.2.0.1.0" id="f_GridContainer" class="Grid-cell ObjectDetail-infoMain p4">


            </div>

        </div>
    </div>
</Html>