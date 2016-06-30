
<?php
include "simple_html_dom.php";
include "Logging.php";

$table = $_POST['ExportType'];

$html = str_get_html($table);
header('Content-Encoding: UTF-8');
header('Content-type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=output_data.csv');

$fp = fopen("php://output", "w");

foreach($html->find('tr') as $element)
{
    $td = array();
    foreach( $element->find('th') as $row)  
    {
        $td [] = htmlspecialchars_decode(mb_convert_encoding($row->plaintext, 'UTF-16LE', 'UTF-8'));
    }
	if (!empty($td)) {
    fputcsv($fp, $td);
  }

    $td = array();
    foreach( $element->find('td') as $row)  
    {
        //echo $row->plaintext;
        //echo htmlspecialchars_decode($row->plaintext);
        $td [] = htmlspecialchars_decode(mb_convert_encoding($row->plaintext, 'UTF-16LE', 'UTF-8'));
    }
    
	if (!empty($td)) {
            
 
    fputcsv($fp, $td);
  }
}
   $log = new Logging();
 
$log->lfile($_SERVER["DOCUMENT_ROOT"].'/PHPProject1/Logs/'. date("m.d.y").'.txt');
 
$log->lwrite('Action:::: CSVDownload ;;;; PageVisited :::: QueryPage');
 
$log->lclose();
//print mb_convert_encoding('Où étiez-vous', 'UTF-16LE', 'UTF-8');

fclose($fp);
?>