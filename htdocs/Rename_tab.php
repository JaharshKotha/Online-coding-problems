<?php
	function renam_tab(){
			$db_name = $_POST["data"];
			$tab_name = $_POST["data1"];
			$conn = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz" );
			if(!$conn){
				echo 'No connection';
				exit;
			}
			echo $db_name;
			echo $tab_name;
			//$old_tab_name = $_POST['sels'];
			$new_tab_name = $_POST["data2"];
			echo $new_tab_name;
			$updatequery = "Update metatable set new_table_name ='".trim($new_tab_name)."' where existing_table_name ='".trim($tab_name)."'";
			$res = pg_query($conn , $updatequery);

	}
	if(isset($_POST['Save_tables'])){
		renam_tab();
	}
?>