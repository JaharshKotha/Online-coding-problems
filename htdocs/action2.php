<?php

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});
error_reporting(E_ERROR);

function handleError($errno, $errstr, $error_file, $error_line) {

    echo "<b>Error:</b> You must at least select a data source from the top left".$errstr;

    die();
}

require_once('nossl/nossl_start.php');
set_error_handler("handleError");
try {
    if (!isset($_SESSION) || !isset($_SESSION['admin_uname'])) {
        session_start();
        ob_start();
    }
  if (time() - $_SESSION['timestamp'] > 500) { //subtract new timestamp from the old one
    unset($_SESSION['username'], $_SESSION['password'], $_SESSION['timestamp']);
    $_SESSION['logged_in'] = false;
    echo "<script>
alert('Session Timeout (5 min)');
window.location.href='logout.php';
</script>";

    exit;
} else {
    $_SESSION['timestamp'] = time(); //set new timestamp
}
    $u = trim($_SESSION['admin_uname']);
//queryString+"##splitter##"+tableName+"##splitter##"+selectTags+"##splitter##"+databaseName)
//explode(',', $selectTags)
//allData
    //$s = $_POST['queryString'];
    $colMappingDummy = array();
    $con1 = new PDO('pgsql:dbname=postgres;host=localhost;port=5421', 'postgres', 'plz');
    $tQuer = 'select DISTINCT  existing_col_name,new_col_name from metatable2 where existing_col_name <> new_col_name';
    $statement = $con1->prepare($tQuer);
//  echo $u;
    $statement->execute();
    while ($zo = $statement->fetch()) {

        $colMappingDummy[$zo['existing_col_name']] = $zo['new_col_name'];
    }


    $allData = nossl_decrypt($_POST['allData']);
    $pageNo = $_POST['pageNo'];
    $offset = $_POST['offset'];
    $allDataSplit = explode('##splitter##', $allData);
    $selectTags = $allDataSplit[2];
    $selectTagsBefore = $allDataSplit[2];
    $dbName = $allDataSplit[3];
    $tableNames = explode(',', $allDataSplit[1]);
    $mainQ = $allDataSplit[0];
    $countQuer = $allDataSplit[4];
    // echo 'pgsql:dbname='.$dbName.';host=localhost;port=5421';

    $con1c = new PDO('pgsql:dbname=' . $dbName . ';host=localhost;port=5421', 'postgres', 'plz');

    $statementc = $con1c->prepare($countQuer);
    $statementc->execute();
    $countDataI = $statementc->fetch();

    $thCount = sizeof(explode(',', $selectTags));

    if (trim($selectTagsBefore) === "*") {
        // $con1 = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
        $con1 = new PDO('pgsql:dbname=postgres;host=localhost;port=5421', 'postgres', 'plz');
        $tQuer = 'select * from table_view_control where admin_name =:aname ';
        $statement = $con1->prepare($tQuer);
        $statement->bindValue(':aname', $u, PDO::PARAM_STR);

        //  echo $u;
        $statement->execute();
        $tc = array();
        while ($zo = $statement->fetch()) {
            if (trim($zo[1]) === trim($tableNames[0])) {
                $selectTags = $zo[2];
                $thCount = sizeof(explode(',', trim($selectTags)));
            } else if (sizeof($tableNames) > 1 && trim($zo[1]) === trim($tableNames[1])) {
                $selectTags.=" , " . $zo[2];
            }
        }
      //  echo $selectTags;
    }

    //$con = pg_connect("host=localhost port=5421 dbname=" . $_POST['databaseName'] . " user=postgres password=plz");
    $con1 = new PDO('pgsql:dbname=' . $dbName . ';host=localhost;port=5421', 'postgres', 'plz');
    // $con1 = pg_connect("host=localhost port=5421 dbname=" . $_POST['databaseName'] . " user=postgres password=plz");
    if ($offset > $countDataI[0])
        $offset = $countDataI[0];
    $sendResult = "";
    if ($pageNo === "1") {
        $sendResult.= '<div class="py1 pl1 text-bold"> Limit is set to ' . $_POST['limit'] . ' & Total Records are : <span id="curCount">' . $offset . '</span>/<span id="totalCount">' . $countDataI[0] . '</span></div>';
        $sendResult.= ' <table id="displayTable" data-reactid=".d.0.1.0.0.0:$3.0.0.1.0.0.0" class="tablesorter" >';
        $sendResult.= '<thead><tr>';
    }
    $count = 0;
    $data1 = explode(',', trim($selectTags));
    $selectTags = "";
    $footTags = "<tfoot><tr>";
    //<div class="table-handle"></div><div class="sorter">Sex (2)</div>
    for ($i = 0; $i < $thCount; $i++) {
       // echo $data1[$i];
        $headerTitle = explode('.', trim($data1[$i]));
        $headerTitleM = "";
        if (sizeof($headerTitle) > 1) {
            $headerTitleM = $headerTitle[1];
            $headerTitleM = str_replace("\"", "", $headerTitleM);
            $headerTitleM = str_replace("'", "", $headerTitleM);
            if (isset($colMappingDummy[$headerTitleM])) {
                $headerTitleM = $colMappingDummy[$headerTitleM];
            }
        } else {
            $headerTitleM = $headerTitle[0];
             if (isset($colMappingDummy[$headerTitleM])) {
                $headerTitleM = $colMappingDummy[$headerTitleM];
            }
        }


        if ($pageNo === "1") {
            $sendResult.= '<th class="drag-enable tablesorter-header" data-attr=\'"' . trim($tableNames[0]) . '"."' . trim($data1[$i]) . '"\'>' . trim($headerTitleM) . '</th>';
            $footTags.='<th>' . trim($headerTitleM) . '</th>';
        }
        $selectTags.="\"" . trim($tableNames[0]) . "\".\"" . trim($data1[$i]) . "\"";
        if ($i != $thCount - 1) {
            $selectTags.= " , ";
        }
        $count = $count + 1;
    }
    if (sizeof($data1) > $thCount) {
        for ($i = $thCount; $i < sizeof($data1); $i++) {
            $headerTitle = explode('.', trim($data1[$i]));
            $headerTitleM = "";
            if (sizeof($headerTitle) > 1) {
                $headerTitleM = $headerTitle[1];

                $headerTitleM = str_replace("\"", "", $headerTitleM);
                $headerTitleM = str_replace("'", "", $headerTitleM);
                if (isset($colMappingDummy[$headerTitleM])) {
                    $headerTitleM = $colMappingDummy[$headerTitleM];
                }
            } else {
                $headerTitleM = $headerTitle[0];
                 if (isset($colMappingDummy[$headerTitleM])) {
                $headerTitleM = $colMappingDummy[$headerTitleM];
            }
            }


            if ($pageNo === "1") {
                $sendResult.= '<th class="drag-enable" data-attr=\'"' . trim($tableNames[1]) . '"."' . trim($data1[$i]) . '"\'>' . trim($headerTitleM) . '</th>';
                $footTags.='<th>' . trim($headerTitleM) . '</th>';
            }
            $count = $count + 1;
            $selectTags.=", \"" . trim($tableNames[1]) . "\".\"" . trim($data1[$i]) . "\"";
        }
    }
    if ($pageNo === "1") {
        $sendResult.= '</tr></thead>';
        $sendResult.= $footTags . '</tr></tfoot><tbody>';
    }
   
//echo $selectTagsBefore;
    if (trim($selectTagsBefore) === "*") {
//echo 'here';
        $secondPart = substr(strstr($mainQ, '*'), 1, strlen(strstr($mainQ, '*')));
        $firstPart = strstr($mainQ, '*', true); // As of PHP 5.3.0
        $mainQ = $firstPart . " " . $selectTags . " " . $secondPart;
    }
    // $r = pg_query($con1, $mainQ);
    $statement = $con1->prepare($mainQ);
    //$statement->bindParam(':aname', $u);
    //  echo $u;
    $statement->execute();
    /* $count = "SELECT count(*) posts;";
      $c = pg_query($con1,$count);
      $count =pg_result($c,0); */
    while ($row = $statement->fetch()) {
        $sendResult.='<tr data-PageNo="' . $pageNo . '">';
        $i = 0;
        for ($i = 0; $i < $count; $i++) {
            if ($i == 0) {
                $sendResult.='<td class="formLink" onclick="formOpen()" ><div>' . $row[$i] . '</div></td>';
            } else {
                $sendResult.= '<td><div>' . $row[$i] . '</div></td>';
            }
        }
        $sendResult.= '</tr>';
    }

    $pieces = explode(" LIMIT ", $mainQ);
    $mainQ = $pieces[0] . " LIMIT 10;";
    //       echo $mainQ;
    $conn = null;
    $con1 = null;
    $con1c = null;
    $log = new Logging();

    $log->lfile($_SERVER["DOCUMENT_ROOT"] . '/PHPProject1/Logs/' . date("m.d.y") . '.txt');

    $log->lwrite('Action:::: Query ;;;; Query :::: (' . $mainQ . ' ) ;;;; PageVisited :::: QueryPage');

    $log->lclose();
    if ($pageNo === "1") {
        $sendResult.= "</tbody></table><input type=\"hidden\" value=\"" . htmlspecialchars($mainQ) . "\" name=\"queryForTagForm\" id=\"queryForTagForm\"></input>";
    }
    echo $sendResult;
} catch (Exception $e) {
    echo '<div>Invalid Query</div> ';
}
?>