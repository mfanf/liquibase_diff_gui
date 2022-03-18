<html>
    <head>
    <link rel="stylesheet" href="form_style.css?version=2">
    </head>
<body>

<div class="container">
<h1>Insert connection data</h1>
<form action="run_query.php" method="post" autocomplete="on">
<div class="styled-input wide">
<label>Reference DBMS:</label> 
<select id="dbms" name="ref_dbms">
    <option value="mysql">MySQL</option>
    <option value="maria">MariaDB</option>
</select><br>
</div>
<div class="styled-input wide">
<label>Reference DB url:</label> <input type="text" name="ref_url" id="ref_url" /><br>
</div>
<div class="styled-input wide">
<label>Reference DB port:</label> <input type="text" name="ref_port" id="ref_port" /><br>
</div>
<div class="styled-input wide">
<label>Reference DB name:</label> <input type="text" name="ref_name" id="ref_name" /><br>
</div>
<div class="styled-input wide">
<label>Reference DB user:</label> <input type="text" name="ref_user" id="ref_user" /><br>
</div>
<div class="styled-input wide">
<label>Reference DB password:</label> <input type="password" name="ref_pass" id="ref_pass" /><br>
</div>
<!-- target -->
<div class="styled-input wide">
<label>Target DBMS:</label> 
<select id="dbms" name="tar_dbms">
    <option value="mysql">MySQL</option>
    <option value="maria">MariaDB</option>
</select><br>
</div>
<div class="styled-input wide">
<label>Target DB url:</label> <input type="text" name="tar_url" id="tar_url" /><br>
</div>
<div class="styled-input wide">
<label>Target DB port:</label> <input type="text" name="tar_port" id="tar_port" /><br>
</div>
<div class="styled-input wide">
<label>Target DB name:</label> <input type="text" name="tar_name" id="tar_name" /><br>
</div>
<div class="styled-input wide">
<label>Target DB user:</label> <input type="text" name="tar_user" id="tar_user" /><br>
</div>
<div class="styled-input wide">
<label>Target DB password:</label> <input type="password" name="tar_pass" id="tar_pass" /><br>
</div>
<div class="submit-btn"><input type="submit"></div>
</form>
</div>

</body>
</html>

<!-- <html>
    <head>
    </head>
<body>


<h1>Insert connection data</h1>
<form action="run_query.php" method="post" autocomplete="on">
Reference DB url: <input type="text" name="ref_url" id="ref_url" /><br>
Reference DB port: <input type="text" name="ref_port" id="ref_port" /><br>
Reference DB name:<input type="text" name="ref_name" id="ref_name" /><br>
Reference DB user: <input type="text" name="ref_user" id="ref_user" /><br>
Reference DB password: <input type="text" name="ref_pass" id="ref_pass" /><br>
Target DB url: <input type="text" name="tar_url" id="tar_url" /><br>
Target DB port: <input type="text" name="tar_port" id="tar_port" /><br>
Target DB name: <input type="text" name="tar_name" id="tar_name" /><br>

Target DB user: <input type="text" name="tar_user" id="tar_user" /><br>

Target DB password: <input type="text" name="tar_pass" id="tar_pass" /><br>

<input type="submit">


</body>
</html> -->