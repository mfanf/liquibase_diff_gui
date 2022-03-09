<?php

   include 'functions.php';
   $chlog_file = "/var/www/html/changelogs/db_diff_changelog.json";
   $res = do_diffCahngelog($_POST, $chlog_file);
   $conn_data = $res[0];
   $query = $res[1];
   $js_conn_data = json_encode($conn_data);
?>

<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="style.css?version=1">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script src="script.js" type="text/javascript"></script>

</head>
<body>

<div id="selector_div" >

   <h2>Query</h2>
   <div class="query">
   <?php echo($query); ?> <br>
   </div>

   <h2>List of differences found:</h2>
   <form>
   <?php
      $jsonData =  file_get_contents($chlog_file);
      //print($jsonData);
      $jsonData = stripslashes(html_entity_decode($jsonData));
      $json=json_decode($jsonData,false);
      $numCS = count($json->databaseChangeLog);
      $ch_idx = [];
      for($i=0; $i<$numCS; $i++){
         $numCh = count($json->databaseChangeLog[$i]->changeSet->changes);
         //print($numCh);
         if($numCh > 1){
            // DO SOMETHING!
         }
         array_push($ch_idx, $json->databaseChangeLog[$i]->changeSet->id);
         echo "<div class=\"change\" id=\"" . $json->databaseChangeLog[$i]->changeSet->id . "\">";
         echo "<input type=\"checkbox\" class=\"changeCheckbox\" 
                  value=\"" . $json->databaseChangeLog[$i]->changeSet->id . "\"
                  onchange=\"check_checker();\"
                  name=\"" . $json->databaseChangeLog[$i]->changeSet->id . "\" >";
         echo "<label for=\"" . $json->databaseChangeLog[$i]->changeSet->id . "\">ID = " . 
                  $json->databaseChangeLog[$i]->changeSet->id . "</label>";
         echo "<pre>";
         //print_r($json->databaseChangeLog[$i]->changeSet->changes[$j]);
         echo json_encode($json->databaseChangeLog[$i]->changeSet->changes, JSON_PRETTY_PRINT);
         echo "</pre>";
         echo "</div>";
         
      }
   ?>
   </form>

   <script>
      var my_var = <?php echo(json_encode($json)); ?>;
      console.log(my_var)
   </script>

   <div class="button_div">
   <button onclick="update_changelog(my_var, );" class="button">Apply changes</button>
   </div>
</div>

<div id="updated_changelog">
   <h2>Updated changeLog:</h2>
   <div id="json_changes"> </div>
   <div class="button_div">
   <button onclick='send_changelog(<?php echo $js_conn_data; ?>);' class="button">Send changes</button>
   </div>
</div>

<div id="final_result">

</div>

</body>
</html>