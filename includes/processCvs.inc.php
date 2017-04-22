<?php
/**
 * Description of processCsv.inc.php
 *
 * @author rciampa
 */

$handel = fopen("calspeed.csv", "r", true);
$row = 0;
$num = 0;
$field_labels;
$data_by_iocation_id;
$data_raw_csv;

while($data = fgetcsv($handel, ',')){
    $num = count($data);
    if($row == 0){
            $field_labels = $data;
    }else{
        $data_raw_csv[$row -1] = $data;
    }
    $row++;
}
fclose($handel);

echo count($data_raw_csv) . "<br/>";

echo "<br/><br/>fields below / Count: "; echo count($field_labels) . "<br/><br/>";
var_dump($field_labels);

echo "<br/><br/>Data below <br/><br/>";
foreach ($data_raw_csv as $key => $value) {
    echo $key . "<br/><br/>";
    echo print_r($value) . "<br/><br/>";
}
?>
