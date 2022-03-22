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

// $changeSet_file_name = 'changeSet_to_apply.json';
$changeSet_file_name = 'changeSet_to_apply.mysql.sql';

$fp = fopen($changeSet_file_name, 'w');
// fwrite($fp, json_encode($json->changes[0]));

fwrite($fp, "-- liquibase formatted sql\n\n");

for($i=0; $i<count($json->changes); $i++){
    fwrite($fp, ("-- changeset www-data:" . $json->changes_id[$i] . "\n"));
    fwrite($fp, ($json->changes[$i] . "\n\n"));
}

fclose($fp);

$conn_data = $json->conn_data[0];

if($conn_data->tar_dbms == "mysql"){
    $tar_driver = "jdbc:mysql";
}elseif($conn_data->tar_dbms == "maria"){
    $tar_driver = "jdbc:mariadb";
}

// TODO: find a way to return an error if the update fails!!! <<<<

$query = 'liquibase --url="' . $tar_driver . '://' . $conn_data->tar_url . ':' . $conn_data->tar_port . '/' . $conn_data->tar_name . '"' .
' --username=' . $conn_data->tar_user .
' --password=' . $conn_data->tar_pass .
' --changeLogFile=' . $changeSet_file_name . 
' update';

// $last_line = system($query, $retval);
$output = shell_exec($query . " 2>&1");
$outerror = strpos($stdout, "Unexpected error");
if(!($outerror)){
    $retval = "OK";
}else{
    $retval = "KO";
}

echo '[{"responce": "' . str_replace(['"'],'\"',$query) . '",' .
        '"retval": "' . $retval . '"' .
    '}]';

// str_replace(['"'],'\"',$output)
?>