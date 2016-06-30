<?php



//$db_name = '<script>document.getElementById(sele).textContent;</script>';
	$db_name = $_GET["data"];
	//echo $db_name + 'Value';
	$conn = pg_connect("host=localhost port=5421 dbname=$db_name user=postgres password=plz" );
	if(!$conn){
		echo 'No connection';
		exit;
	}
	//echo $db_name;
	//db_name contains database selected in the list
	$result = pg_query($conn , "select table_name from information_schema.tables where table_schema = 'public';" );
	if(!$result){
		echo 'No result';
	}
	$arr_res = pg_fetch_all($result);


	$arr_len = count($arr_res);
	$data="";
for($x = 0 ; $x < $arr_len; $x++ )
{
	if($x != $arr_len-1)
		$data.=$arr_res[$x]['table_name'].',';
    else
    	$data.=$arr_res[$x]['table_name'];
}
echo $data;

?>
