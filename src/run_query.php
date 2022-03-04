<?php

// Reference DB url: <input type="text" name="ref_url"><br>
// Reference DB port: <input type="text" name="ref_port"><br>
// Reference DB name: <input type="text" name="ref_name"><br>
// Reference DB user: <input type="text" name="ref_user"><br>
// Reference DB password: <input type="text" name="ref_pass"><br>
// Target DB url: <input type="text" name="tar_url"><br>
// Target DB port: <input type="text" name="tar_port"><br>
// Target DB name: <input type="text" name="tar_name"><br>
// Target DB user: <input type="text" name="tar_user"><br>
// Target DB password: <input type="text" name="tar_pass"><br>

$ref_url = $_POST["ref_url"];
$ref_port = $_POST["ref_port"];
$ref_name = $_POST["ref_name"];
$ref_user = $_POST["ref_user"];
$ref_pass = $_POST["ref_pass"];

$tar_url = $_POST["tar_url"];
$tar_port = $_POST["tar_port"];
$tar_name = $_POST["tar_name"];
$tar_user = $_POST["tar_user"];
$tar_pass = $_POST["tar_pass"];

$chlog_file = '/var/www/html/changelogs/db_diff_changelog.json';
if (file_exists($clog_file)) {
    unlink($clog_file);
 }

$query = 'liquibase --url="jdbc:mysql://' . $tar_url . ':' . $tar_port . '/' . $tar_name . '"' .
' --username=' . $tar_user .
' --password=' . $tar_pass .
' --referenceUrl="jdbc:mysql://' . $ref_url . ':' . $ref_port . '/' . $ref_name . '"' .
' --referenceUsername=' . $ref_user .
' --referencePassword=' . $ref_pass .
' --changelog-file=' . $chlog_file . 
' diff-changelog';

$last_line = system($query, $retval);

?>
<html>
<body>

<p> DEBUG: </p>
query = <?php echo($query); ?> <br>
retval = <?php echo($retval); ?> <br>
last_line = <?php echo($last_line); ?> <br>

<p> Liquibase diff-changelog executed! </p>
<p>List of changes found:</p>
<?php

$jsonData =  file_get_contents($chlog_file);
$jsonData = stripslashes(html_entity_decode($jsonData));
$json=json_decode($jsonData,true);

foreach($json as $cl){
   foreach($cl as $cset){
      foreach($cset as $cset_i){
         foreach($cset_i['changes'] as $op_key => $op_arr){
            echo "<ul>";
            foreach($op_arr as $op_j_key => $op_j_arr){
               //print($op_j_key . "\n");
               echo "<li>[" . $op_j_key . "]";
               foreach($op_j_arr as $spec_key => $spec_val){
                  echo " - " . $spec_key . ":" . $spec_val;   
               }
               echo "</li>";
            }
            echo "</ul>";
         }
      }
   }
}

?>

</body>
</html>