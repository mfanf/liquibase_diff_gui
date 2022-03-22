<?php

   include 'functions.php';
   //$chlog_file = "/var/www/html/changelogs/db_diff_changelog.json";
   $chlog_file = "/var/www/html/changelogs/db_diff_changelog.mysql.sql";
   $res = do_diffCahngelog($_POST, $chlog_file);
   $conn_data = $res[0];
   $query = $res[1];
   $stdout = $res[2];
   $js_conn_data = json_encode($conn_data);
?>

<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="style.css?version=3">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script src="script.js" type="text/javascript"></script>

</head>
<body>

<div id="selector_div" >


   <!-- <h2>Query</h2>
   <div class="query">
   <?php echo($query); ?> <br>
   </div> -->

   <h2>List of differences found:</h2>

   <?php
      $outerror = strpos($stdout, "Unexpected error");

      if(!($outerror)){
         $tmp = read_sql_changelog($chlog_file);
         $changes = $tmp[0];
         $changes_id = $tmp[1]; 
         $numCS = count($changes);
         echo "<form>";
         for($i=0; $i<$numCS; $i++){
            echo "<div class=\"change\" id=\"" . $changes_id[$i] . "\">";
            echo "<input type=\"checkbox\" class=\"changeCheckbox\" 
                     value=\"" . $changes_id[$i] . "\"
                     onchange=\"check_checker();\"
                     name=\"" . $changes_id[$i] . "\" >";
            echo "<label for=\"" . $changes_id[$i] . "\">ID = " . $changes_id[$i] . "</label>";
            echo "<pre>";
            echo $changes[$i];
            echo "</pre>";
            echo "</div>";
         }
         echo "</form>";
         echo "<div class=\"button_div\">";
         echo "<script>" .
                  "var js_changes = " . json_encode($changes) . "; " .
                  "var js_changes_id = " . json_encode($changes_id) . "; " .
              "</script>";
         echo "<button onclick=\"update_changelog_sql(js_changes, js_changes_id );\" class=\"button\">Apply changes</button>";
         echo "</div>";
      }else{
         echo "<div class=\"change\">";
         echo(mb_substr($stdout, $outerror, null, 'UTF-8'));
         echo "</div>";
         echo "<div id=\"back\"><a href=\"index.php\">Back</a></div>";
      }
   ?>
</div>

<div id="updated_changelog">
   <h2>Updated changeLog:</h2>
   <div id="json_changes"> </div>
   <div class="button_div">
   <button onclick='send_changelog_sql(<?php echo $js_conn_data; ?>);' class="button">Send changes</button>
   <button onclick='review_changelog();' class="button">Review changes</button>
   </div>
</div>

<div id="final_result">

</div>

</body>
</html>