<?php


function pwi()
{
	$ar = array(":a", ":b", ":c", ":d",":e",":f",":g");
    $numargs = func_num_args();
    
    $arg_list = func_get_args();
	
	$numarg=$numargs-1;
	$query_a=explode("%s",$arg_list[1]);
	$s="";
	$j=0;
	$c=count($query_a);

    for ($i = 0; $i < $numarg; $i++) {
         $s=$s.$query_a[$i] ;
	if($i < ($c-1))
	{

	$s=$s.$ar[$j];
	$j++;
	
	}
		
    }

	$conn = $arg_list[0];
	$db_det='\'mysql:host='.$conn[0].';dbname='.$conn[1].'\'';
	$uname = '\''.$conn[2].'\'';
	$pass = '\''.$conn[3].'\'';
	echo $db_det.$uname.$pass;
	$p = new PDO($db_det,$uname,$pass);
$st = $p->prepare($s);

for($i = 0;$i < ($numargs-2) ;$i++)
	{
		$st->bindParam($ar[$i],$arg_list[$i+2]);
		
	}
	
	$st->execute();
	$res = $st->fetchAll();
	 return $res;
}

?>