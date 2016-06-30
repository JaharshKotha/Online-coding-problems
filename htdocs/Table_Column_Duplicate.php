<?php
$con2 = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz" );
$z = "select datname from pg_database where datistemplate is false";
$zr = $r = pg_query($con2, $z);
$arr_res1 = pg_fetch_all($r);
$arr_len1 = count($arr_res1);
 $createquery="create table if not exists metatable(database_name varchar(100),existing_table_name varchar(100),new_table_name varchar(100))";
 $res=pg_query($con2,$createquery);
      $createquery2="create table if not exists metatable2(table_name varchar(100),existing_col_name varchar(100),new_col_name varchar(100))";
     $res2=pg_query($con2,$createquery2);
 for($x = 0; $x < $arr_len1; $x++){
     echo $arr_res1[$x]['datname'];
     echo"host=localhost port=5421 dbname=".$arr_res1[$x]['datname']." user=postgres password=plz";
     $conne2 = pg_connect("host=localhost port=5421 dbname=".$arr_res1[$x]['datname']." user=postgres password=plz");
     $z1 = "select table_name from information_schema.tables where table_schema = 'public';";
     $z1r = pg_query($conne2, $z1);
     $arr_temp = pg_fetch_all($z1r);

     $arr_templen = count($arr_temp);
     for($y = 0; $y < $arr_templen; $y++){
         $insertquery="insert into metatable values('".$arr_res1[$x]['datname']."','".$arr_temp[$y]['table_name']."', '".$arr_temp[$y]['table_name']."')";;
         $res3=pg_query($con2,$insertquery);
         $z2 = "select column_name from information_schema.columns where table_name ='".$arr_temp[$y]['table_name']."'";
                //echo "insert into metatable values('".$arr_res1[$x]['datname']."','".$arr_temp[$y]['table_name']."', '".$arr_temp[$y]['table_name']."')";
//echo $z2;
         $z2r = pg_query($conne2, $z2);
         $arr_tempres2 = pg_fetch_all($z2r);
         $arr_templen2 = count($arr_tempres2);
         for($y1 = 0; $y1 < $arr_templen2; $y1++){
             $insertquery2="insert into metatable2 values('".$arr_temp[$y]['table_name']."','".$arr_tempres2[$y1]['column_name']."','".$arr_tempres2[$y1]['column_name']."')";
             $res4=pg_query($con2,$insertquery2);        
         }
     }
 }
 ?>