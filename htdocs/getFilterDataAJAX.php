<?php

if (isset($_POST['getFilterT'])) {

    $someRandomT = $_POST['getFilterT'];
    $someRandomD = $_POST['getFilterD'];

    try {
        if (!isset($_SESSION) || !isset($_SESSION['admin_uname'])) {
            session_start();
            ob_start();
        }
        $u = trim($_SESSION['admin_uname']);
        $con1 = new PDO('pgsql:dbname=postgres;host=localhost;port=5421', 'postgres', 'plz');
        $tQuer = 'select colname,fd,td from filters where admin_uname =:aname and tablename= :tname and dbname= :dname';
        $statement = $con1->prepare($tQuer);
        $statement->bindValue(':aname', $u, PDO::PARAM_STR);
        $statement->bindValue(':tname', $someRandomT, PDO::PARAM_STR);
        $statement->bindValue(':dname', $someRandomD, PDO::PARAM_STR);

        $statement->execute();

        $fetched = $statement->fetchAll();
        $_POST['content'] = " Where ";
        for ($i = 0; $i < sizeof($fetched); $i++) {
            if ($i < sizeof($fetched) - 1) {
                $_POST['content'] = $_POST['content'] . '"' . $someRandomT . '".' . '"' . trim($fetched[$i][0]) . '"' . ' >= \'' . trim($fetched[$i][1]) . '\' AND ' . '"' . $someRandomT . '".' . '"' . trim($fetched[$i][0]) . '"' . ' <= \'' . trim($fetched[$i][2]) . '\' AND ';
            } else {
                $_POST['content'] = $_POST['content'] . '"' . $someRandomT . '".' . '"' . trim($fetched[$i][0]) . '"' . ' >= \'' . trim($fetched[$i][1]) . '\' AND ' . '"' . $someRandomT . '".' . '"' . trim($fetched[$i][0]) . '"' . ' <= \'' . trim($fetched[$i][2]) . '\' ';
            }
        }
        echo $_POST['content'];
    } catch (Exception $e) {
        echo '<div>Invalid Query</div> ' . $e;
    }
}
?>