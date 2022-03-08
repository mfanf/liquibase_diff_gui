<?php

function do_diffCahngelog($post_data, $chlog_file){

    if($post_data){
        $ref_url = $post_data["ref_url"];
        $ref_port = $post_data["ref_port"];
        $ref_name = $post_data["ref_name"];
        $ref_user = $post_data["ref_user"];
        $ref_pass = $post_data["ref_pass"];

        $tar_url = $post_data["tar_url"];
        $tar_port = $post_data["tar_port"];
        $tar_name = $post_data["tar_name"];
        $tar_user = $post_data["tar_user"];
        $tar_pass = $post_data["tar_pass"];
    }else{
        $ref_url = "192.168.1.108";
        $ref_port = "3306";
        $ref_name = "liquibase_test";
        $ref_user = "admin";
        $ref_pass = "password";

        $tar_url = "192.168.1.108";
        $tar_port = "3306";
        $tar_name = "liquibase_test_2";
        $tar_user = "admin";
        $tar_pass = "password";
    }

    $conn_data = [
        "ref_url" => $ref_url,
        "ref_port" => $ref_port,
        "ref_name" => $ref_name,
        "ref_user" => $ref_user,
        "ref_pass" => $ref_pass,
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

    $query = 'liquibase --url="jdbc:mysql://' . $tar_url . ':' . $tar_port . '/' . $tar_name . '"' .
    ' --username=' . $tar_user .
    ' --password=' . $tar_pass .
    ' --referenceUrl="jdbc:mysql://' . $ref_url . ':' . $ref_port . '/' . $ref_name . '"' .
    ' --referenceUsername=' . $ref_user .
    ' --referencePassword=' . $ref_pass .
    ' --changelog-file=' . $chlog_file . 
    ' diff-changelog';

    $last_line = system($query, $retval);

    return [$conn_data, $query, $last_line, $retval];
}

?>