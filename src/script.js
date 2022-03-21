function check_checker() {
    var inputElements = document.getElementsByClassName('changeCheckbox');
    console.log(inputElements);
    for(var i=0; inputElements[i]; ++i){
       if(inputElements[i].checked){
          const element = document.getElementById(inputElements[i].value);
          console.log(element);
          element.style.backgroundColor="lightgreen";
          //element.innerHTML = "- " + inputElements[i].value;
       }else{
          const element = document.getElementById(inputElements[i].value);
          console.log(element);
          element.style.backgroundColor="lightgray";
       }
    }
 }

 function update_changelog_sql(sql, ids){
   console.log("Read my_var");
   console.log(sql);

   var checkedValue = []; 
   var inputElements = document.getElementsByClassName('changeCheckbox');
   console.log(inputElements)
   for(var i=0; inputElements[i]; ++i){
      if(inputElements[i].checked){
         checkedValue.push(i); //(inputElements[i].value);
      }
   }

   console.log(checkedValue);

   up_sql = [];
   up_ids = [];
   for(var i=0; i < checkedValue.length; i++){
      up_sql.push(sql[checkedValue[i]]);
      up_ids.push(ids[checkedValue[i]])
   }
   console.log(up_sql);
   console.log(up_ids);
   
   document.getElementById("selector_div").style.display = "none";

   listContainer = document.getElementById("json_changes");
   listContainer.innerHTML = "";
   listElement = document.createElement('ul');
   listContainer.appendChild(listElement);
    for (i = 0; i < up_sql.length; ++i) {
        listItem = document.createElement('li');
        listItemDiv = document.createElement('div');
        listItemDiv.innerHTML = up_ids[i] + "<br>" + up_sql[i];
        listItem.appendChild(listItemDiv);
        listElement.appendChild(listItem);
    }

   document.getElementById("updated_changelog").style.display = "block";
}

 function update_changelog(json){
    console.log(json);

    var checkedValue = []; 
    var inputElements = document.getElementsByClassName('changeCheckbox');
    for(var i=0; inputElements[i]; ++i){
       if(inputElements[i].checked){
          checkedValue.push(inputElements[i].value);
       }
    }
    up_json = {};
    up_json.databaseChangeLog = [];
    for(var i=0; i < json.databaseChangeLog.length; i++){
       id = json.databaseChangeLog[i].changeSet.id;
       if(checkedValue.includes(id)){
          console.log(id);
          up_json.databaseChangeLog.push(json.databaseChangeLog[i]);
       }
    }
    console.log(up_json);
    document.getElementById("selector_div").style.display = "none";
    document.getElementById("json_changes").appendChild(document.createElement('pre')).innerHTML = JSON.stringify(up_json, null, 2);
    document.getElementById("updated_changelog").style.display = "block";
 }

 var getPhpResponse = function( data ) {
   console.log(data);
}

function send_changelog_sql( conn_data ){
   console.log(conn_data);
   console.log('sending?');
   console.log(JSON.stringify({conn_data: [conn_data], changes: [up_sql]}));
   jQuery.ajax("apply_changes.php", {
      type: "POST",
      url: 'apply_changes.php',
      dataType: 'json',
      data: JSON.stringify({conn_data: [conn_data], changes: up_sql, changes_id: up_ids}),
      async: true,
      success: function (obj, textstatus, jqXHR) {
         console.log(obj);
         console.log(textstatus);
         console.log(jqXHR);
         //getPhpResponse( obj );
         if(textstatus==="success"){
           console.log('sent!');
           
           document.getElementById("updated_changelog").style.display = "none";
           document.getElementById("final_result").innerHTML += "<h3>Success!</h3><p>All changes have been applied to target DB.</p>";
           document.getElementById("final_result").innerHTML += "<div id='back'><a href='index.php'>Back</a></div>";
           document.getElementById("final_result").style.display = "block";
         }else{
           console.log('some problem :(');
           document.getElementById("updated_changelog").style.display = "none";
           document.getElementById("final_result").innerHTML += "<h3>Some problem detected</h3><p>Check if changes was applied.</p>";
           document.getElementById("final_result").appendChild(document.createElement('pre')).innerHTML += JSON.stringify(obj, null, 2);
           document.getElementById("final_result").innerHTML += "<div id='back'><a href='index.php'>Back</a></div>";
           document.getElementById("final_result").style.display = "block";
         }
     }
   });
   
}

 function send_changelog( conn_data ){
    console.log(conn_data);
    console.log('sending?')
    jQuery.ajax("apply_changes.php", {
       type: "POST",
       url: 'apply_changes.php',
       dataType: 'json',
       data: JSON.stringify({conn_data: [conn_data], changes: [up_json]}),
       async: true,
       success: function (obj, textstatus, jqXHR) {
          console.log(obj);
          console.log(textstatus);
          console.log(jqXHR);
          //getPhpResponse( obj );
          if(textstatus==="success"){
            console.log('sent!');
            
            document.getElementById("updated_changelog").style.display = "none";
            document.getElementById("final_result").innerHTML += "<h3>Success!</h3><p>All changes have been applied to target DB.</p>";
            document.getElementById("final_result").innerHTML += "<div id='back'><a href='index.php'>Back</a></div>";
            document.getElementById("final_result").style.display = "block";
          }else{
            console.log('some problem :(');
            document.getElementById("updated_changelog").style.display = "none";
            document.getElementById("final_result").innerHTML += "<h3>Some problem detected</h3><p>Check if changes was applied.</p>";
            document.getElementById("final_result").appendChild(document.createElement('pre')).innerHTML += JSON.stringify(obj, null, 2);
            document.getElementById("final_result").innerHTML += "<div id='back'><a href='index.php'>Back</a></div>";
            document.getElementById("final_result").style.display = "block";
          }
      }
    });
    
 }

function review_changelog(){
   document.getElementById("selector_div").style.display = "block";
   document.getElementById("updated_changelog").style.display = "none";
}