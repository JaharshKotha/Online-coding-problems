
<?php
include "simple_html_dom.php";
$table = $_POST['ExportType'];

$html = str_get_html($table);
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename=sample.csv');

$fp = fopen("php://output", "w");

foreach($html->find('tr') as $element)
{
    $td = array();
    foreach( $element->find('th') as $row)  
    {
        $td [] = $row->plaintext;
    }
	if (!empty($td)) {
    fputcsv($fp, $td);
  }

    $td = array();
    foreach( $element->find('td') as $row)  
    {
        $td [] = $row->plaintext;
    }
	if (!empty($td)) {
    fputcsv($fp, $td);
  }
}


fclose($fp);
?>