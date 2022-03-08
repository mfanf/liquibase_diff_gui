<?php
// Handling data in JSON format on the server-side using PHP
//
header("Content-Type: application/json");
// build a PHP variable from JSON sent using POST method
$json_string = stripslashes(html_entity_decode(file_get_contents("php://input")));
$json = json_decode($json_string,false);
// build a PHP variable from JSON sent using GET method
// $json = json_decode(stripslashes($_GET["data"]));
// encode the PHP variable to JSON and send it back on client-side
// echo json_encode($json);

$changeSet_file_name = 'changeSet_to_apply.json';

$fp = fopen($changeSet_file_name, 'w');
fwrite($fp, json_encode($json->changes[0]));
fclose($fp);

$conn_data = $json->conn_data[0];

$query = 'liquibase --url="jdbc:mysql://' . $conn_data->tar_url . ':' . $conn_data->tar_port . '/' . $conn_data->tar_name . '"' .
' --username=' . $conn_data->tar_user .
' --password=' . $conn_data->tar_pass .
' --changeLogFile=' . $changeSet_file_name . 
' update';

//$last_line = system($query, $retval);

//echo $json_string;
// " . str_replace(['"',':'],'',$query) . "
echo '[{"responce": "' . str_replace(['"'],'\"',$query) . '"}]';


?>