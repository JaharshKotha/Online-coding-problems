<?php
	function renam_col(){
			$db_name = $_POST["data"];
			$tab_name = $_POST["data1"];
						$rename_col_new = $_POST["data2"];
						$exist_col = $_POST["data3"];
			$conn = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz" );
			if(!$conn){
				echo 'No connection';
				exit;
			}
			$updatequery2 = "Update metatable2 set new_col_name='".trim($rename_col_new)."' where existing_col_name ='".trim($exist_col)."'";
			echo $updatequery2;
			$res2 = pg_query($conn,$updatequery2);
	}
	if(isset($_POST['Save_attributes'])){
		renam_col();
	}
?>