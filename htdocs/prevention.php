<?php


function pwi()
{
	$ar = array(":a", ":b", ":c", ":d",":e",":f",":g");
    $numargs = func_num_args();
    
    $arg_list = func_get_args();
	

	$query_a=explode("%s",$arg_list[0]);
	$s="";
	$j=0;
	$c=count($query_a);

    for ($i = 0; $i < $numargs; $i++) {
         $s=$s.$query_a[$i] ;
	if($i < ($c-1))
	{

	$s=$s.$ar[$j];
	$j++;
	
	}
		
    }
	
	$p = new PDO('mysql:host=localhost;dbname=CSE545', "root", "");
$st = $p->prepare($s);

for($i = 0;$i < ($numargs-1) ;$i++)
	{
		$st->bindParam($ar[$i],$arg_list[$i+1]);
		
	}
	
	$st->execute();
	$res = $st->fetchAll();
	 return $res;
}

?>