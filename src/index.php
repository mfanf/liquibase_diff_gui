<html>
    <head>
    <link rel="stylesheet" href="form_style.css?version=2">
    </head>
<body>

<div class="container">
<h1>Insert connection data</h1>
<form action="run_query.php" method="post">
<div class="styled-input wide">
<label>Reference DB url:</label> <input type="text" name="ref_url"><br>
</div>
<div class="styled-input wide">
<label>Reference DB port:</label> <input type="text" name="ref_port"><br>
</div>
<div class="styled-input wide">
<label>Reference DB name:</label> <input type="text" name="ref_name"><br>
</div>
<div class="styled-input wide">
<label>Reference DB user:</label> <input type="text" name="ref_user"><br>
</div>
<div class="styled-input wide">
<label>Reference DB password:</label> <input type="text" name="ref_pass"><br>
</div>
<div class="styled-input wide">
<label>Target DB url:</label> <input type="text" name="tar_url"><br>
</div>
<div class="styled-input wide">
<label>Target DB port:</label> <input type="text" name="tar_port"><br>
</div>
<div class="styled-input wide">
<label>Target DB name:</label> <input type="text" name="tar_name"><br>
</div>
<div class="styled-input wide">
<label>Target DB user:</label> <input type="text" name="tar_user"><br>
</div>
<div class="styled-input wide">
<label>Target DB password:</label> <input type="text" name="tar_pass"><br>
</div>
<div class="submit-btn"><input type="submit"></div>
</form>
</div>

</body>
</html>