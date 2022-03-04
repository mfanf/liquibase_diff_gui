<?php

$json_file = 'db_diff_changelog_1_2.json';
$jsonData =  file_get_contents($json_file);
$jsonData = stripslashes(html_entity_decode($jsonData));

echo $jsonData;

$json=json_decode($jsonData,true);

foreach($json as $cl){
   foreach($cl as $cset){
      foreach($cset as $cset_i){
         foreach($cset_i['changes'] as $op_key => $op_arr){
            foreach($op_arr as $op_j_key => $op_j_arr){
               //print($op_j_key . "\n");
               echo "[" . $op_j_key . "]";
               foreach($op_j_arr as $spec_key => $spec_val){
                  if(is_array($spec_val)){
                     print_r($spec_val);
                  }else{
                     echo " - " . $spec_key . ":" . $spec_val; 
                  }  
               }
               echo "<br>";
            }
         }
      }
   }
}

?>

