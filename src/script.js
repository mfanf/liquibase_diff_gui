function check_checker() {
    var inputElements = document.getElementsByClassName('changeCheckbox');
    console.log(inputElements);
    for(var i=0; inputElements[i]; ++i){
       if(inputElements[i].checked){
          const element = document.getElementById(inputElements[i].value);
          console.log(element);
          element.innerHTML = "- " + inputElements[i].value;
       }else{
          const element = document.getElementById(inputElements[i].value);
          console.log(element);
          element.innerHTML = "";
       }
    }
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
    document.getElementById("json_changes").appendChild(document.createElement('pre')).innerHTML = JSON.stringify(up_json, null, 2);
    document.getElementById("updated_changelog").style.display = "block";
 }

 var getPhpResponse = function( data ) {
   console.log(data);
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
      }
    });
    console.log('sent!');
 }

