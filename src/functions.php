<?php

function do_diffCahngelog($post_data, $chlog_file){

    if($post_data){
        $ref_dbms = $post_data["ref_dbms"];
        $ref_url = $post_data["ref_url"];
        $ref_port = $post_data["ref_port"];
        $ref_name = $post_data["ref_name"];
        $ref_user = $post_data["ref_user"];
        $ref_pass = $post_data["ref_pass"];

        $tar_dbms = $post_data["tar_dbms"];
        $tar_url = $post_data["tar_url"];
        $tar_port = $post_data["tar_port"];
        $tar_name = $post_data["tar_name"];
        $tar_user = $post_data["tar_user"];
        $tar_pass = $post_data["tar_pass"];
    }else{
        $ref_dbms = "mysql";
        $ref_url = "192.168.1.108";
        $ref_port = "3306";
        $ref_name = "liquibase_test";
        $ref_user = "admin";
        $ref_pass = "password";

        $tar_dbms = "mysql";
        $tar_url = "192.168.1.108";
        $tar_port = "3306";
        $tar_name = "liquibase_test_2";
        $tar_user = "admin";
        $tar_pass = "password";
    }

    $conn_data = [
        "ref_dbms" => $ref_dbms,
        "ref_url" => $ref_url,
        "ref_port" => $ref_port,
        "ref_name" => $ref_name,
        "ref_user" => $ref_user,
        "ref_pass" => $ref_pass,
        "tar_dbms" => $tar_dbms,
        "tar_url" => $tar_url,
        "tar_port" => $tar_port,
        "tar_name" => $tar_name,
        "tar_user" => $tar_user,
        "tar_pass" => $tar_pass,
    ];

    $present = file_exists($chlog_file);
    //echo "TEST: " . $present ."<br>"; //./changelogs/db_diff_changelog.json") . "<br>";
    if ($present==1) {
        //echo "File found! " . $chlog_file . "\n";
        system("rm " . $chlog_file);
    } else {
        //echo "File NOT found!\n";
    }
    // php -r 'echo file_exists("/var/www/html/changelogs/db_diff_changelog.json") . "\n";'

    if($ref_dbms == "mysql"){
        $ref_driver = "jdbc:mysql";
    }elseif($ref_dbms == "maria"){
        $ref_driver = "jdbc:mariadb";
    }

    if($tar_dbms == "mysql"){
        $tar_driver = "jdbc:mysql";
    }elseif($tar_dbms == "maria"){
        $tar_driver = "jdbc:mariadb";
    }

    $query = 'liquibase --url="'. $tar_driver .'://' . $tar_url . ':' . $tar_port . '/' . $tar_name . '"' .
    ' --username=' . $tar_user .
    ' --password=' . $tar_pass .
    ' --referenceUrl="'. $ref_driver .'://' . $ref_url . ':' . $ref_port . '/' . $ref_name . '"' .
    ' --referenceUsername=' . $ref_user .
    ' --referencePassword=' . $ref_pass .
    ' --changelog-file=' . $chlog_file . 
    ' diff-changelog';

    $output = shell_exec($query . " 2>&1");

    return [$conn_data, $query, $output];
}


function read_sql_changelog($sqlfilepath){
    
    $changes = [];
    $changes_id = [];
    $sqlfile = fopen($sqlfilepath, "r") or die("Unable to open file!");
    // Output one line until end-of-file
    while(!feof($sqlfile)) {
        $line =  fgets($sqlfile);
        $line = rtrim($line, "\r\n");
        $line_arr = preg_split('//', $line, -1, PREG_SPLIT_NO_EMPTY);
        if(!empty($line_arr[0])){
            if($line_arr[0] != '-'){
                array_push($changes,$line);
            }
            else{
                // -- changeset www-data:1647861507129-1
                $tmp = preg_split('/[\s,:]+/', $line, -1, PREG_SPLIT_NO_EMPTY);
                if($tmp[1] == "changeset"){
                    array_push($changes_id, $tmp[3]);
                }
                
            }
        }
    }
    fclose($sqlfile);
    return [$changes, $changes_id];
}

?>