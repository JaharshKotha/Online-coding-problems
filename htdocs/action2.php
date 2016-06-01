   



        <?php
        session_start();
        ob_start();

        //$s = $_GET['queryString'];
        // echo $s;
        $selectTags = trim($_GET['selectTags']);
        $u = trim($_SESSION['admin_uname']);
                    $tableNames = explode(',', trim($_GET['tableName']));
                     $thCount = sizeof(explode(',', trim($_GET['selectTags'])));

        if (trim($selectTags) === "*") {
            $con1 = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");

            $z1 = "select * from table_view_control where admin_name=$u;";
            $r = pg_query($con1, $z1);
            $tc = array();
           // echo $_GET['tableName'];
           //  echo $tableNames ;

           
            while ($zo = pg_fetch_array($r)) {
                if (trim($zo[1]) === trim($tableNames[0])) {
                    $selectTags = $zo[2];
                    $thCount = sizeof(explode(',', trim($selectTags)));
                } else if (sizeof($tableNames) > 1 && trim($zo[1]) === trim($tableNames[1])) {
                    $selectTags.=" , ".$zo[2];
                }
            }
        }

        $con = pg_connect("host=localhost port=5421 dbname=" . $_GET['databaseName'] . " user=postgres password=plz");
        $con1 = pg_connect("host=localhost port=5421 dbname=" . $_GET['databaseName'] . " user=postgres password=plz");
        $x = "SELECT " . $selectTags . " FROM information_schema.columns WHERE table_name = '" . $tableNames[0] . "';";

        $sendResult = "";
        $sendResult.= ' <table id="displayTable" data-reactid=".d.0.1.0.0.0:$3.0.0.1.0.0.0" class="Table l96_CLxo_PqCKgtKdL8oT oswsGtBEhm6HA5DPrrAWV fullscreen-normal-text fullscreen-night-text">';
        $sendResult.= '<thead><tr>';
        $count = 0;
        $data1 = explode(',', trim($selectTags));
        $selectTags = "";
        for ($i = 0; $i < $thCount; $i++) {
            $sendResult.= '<th data-attr=\'"' . trim($tableNames[0]) . '"."' . trim($data1[$i]) . '"\'>' . trim($data1[$i]) . '</th>';
            $selectTags.="\"" . trim($tableNames[0]) . "\".\"" . trim($data1[$i]) . "\"";
            if ($i != $thCount - 1) {
                $selectTags.= " , ";
            }
            $count = $count + 1;
        }
        if (sizeof($data1) > $thCount) {
            for ($i = $thCount; $i < sizeof($data1); $i++) {

                $sendResult.= '<th data-attr=\'"' . trim($tableNames[1]) . '"."' . trim($data1[$i]) . '"\'>' . trim($data1[$i]) . '</th>';
                $count = $count + 1;
                $selectTags.=", \"" . trim($tableNames[1]) . "\".\"" . trim($data1[$i]) . "\"";
            }
        }
        $sendResult.= '</tr></thead><tbody><tr>';
        $mainQ = $_GET['queryString'];
        if (trim($_GET['selectTags']) === "*") {
            $secondPart = substr(strstr($mainQ, '*'), 1, strlen(strstr($mainQ, '*')));
//echo $secondPart;
            $firstPart = strstr($mainQ, '*', true); // As of PHP 5.3.0
            $mainQ = $firstPart . " " . $selectTags . " " . $secondPart;
         // echo $mainQ;
        }
        $r = pg_query($con1, $mainQ);

        /* $count = "SELECT count(*) posts;";
          $c = pg_query($con1,$count);
          $count =pg_result($c,0); */
        while ($row = pg_fetch_array($r)) {
            $i = 0;
            for ($i = 0; $i < $count; $i++) {
                $sendResult.= '<td>' . $row[$i] . '</td>';
            }
            $sendResult.= '</tr>';
        }

        $sendResult.= "</tbody></table><input type=\"hidden\" value=\"".htmlspecialchars($mainQ)."\" name=\"queryForTagForm\" id=\"queryForTagForm\"></input>";

        echo $sendResult;
        ?>