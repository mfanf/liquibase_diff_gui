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

if($_POST){
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

$chlog_file = "/var/www/html/changelogs/db_diff_changelog.json";

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

?>
<!DOCTYPE html>
<html>
<head>
<style>
.change {
  background-color: lightgray;
  color: black;
  border: 0px solid black;
  margin: 5px;
  padding: 1px;
}
.query {
  background-color: red;
  color: black;
  border: 2px solid black;
  margin: 5px;
  padding: 1px;
}
</style>
</head>
<body>

<h1>Results</h1>

<h2>Query</h2>
<div class="query">
<?php echo($query); ?> <br>
</div>

<h2>List of differences found:</h2>

<?php

$jsonData =  file_get_contents($chlog_file);
$jsonData = stripslashes(html_entity_decode($jsonData));
$json=json_decode($jsonData,false);
$numCS = count($json->databaseChangeLog);

?>

<form>

<?php

for($i=0; $i<$numCS; $i++){
   $numCh = count($json->databaseChangeLog[$i]->changeSet->changes);
   //print($numCh);
   for($j=0; $j<$numCh; $j++){
      echo "<div class=\"change\">";
      echo "<input type=\"checkbox\" id=\"" . $json->databaseChangeLog[$i]->changeSet->id . "\">";
      echo "<pre>";
      //print_r($json->databaseChangeLog[$i]->changeSet->changes[$j]);
      echo json_encode($json->databaseChangeLog[$i]->changeSet->changes[$j], JSON_PRETTY_PRINT);
      echo "</pre>";
      echo "</div>";
   }
}

?>

<input type="submit">
</form>

</body>
</html>