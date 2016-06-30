
<?php
	$db_name = $_GET["data"];
	//echo $db_name + 'Value';
	$conn = pg_connect("host=localhost port=5421 dbname=$db_name user=postgres password=plz" );
	if(!$conn){
		echo 'No connection';
		exit;
	}
$tab_name = $_GET["data1"];
$result2 = pg_query($conn , "select column_name from information_schema.columns where table_name = '$tab_name';" );
$arr_res2 = pg_fetch_all($result2);
$arr_len2 = count($arr_res2);
	$data="";
for($x = 0 ; $x < $arr_len2; $x++ )
{
	if($x != $arr_len2-1)
		$data.=$arr_res2[$x]['column_name'].',';
    else
    	$data.=$arr_res2[$x]['column_name'];
}
echo $data;
?>
 
