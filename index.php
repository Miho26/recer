<?php 
require_once 'db/dbconect.php';
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>RECER</title>
	<link rel="stylesheet" href="css/main.css">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	
</head>
<body>
<form action="">
</form>
	<form method="post" action="new.php" id="input">
		<select name="category" id="">
			<option value="1">映画</option>
			<option value="2">イベント</option>
			<option value="3">本</option>
		</select>
		<input type="text" class="insert" name="title">	
		<textarea cols="40" rows="4" class="insert" name="text"></textarea>
		<input type="submit" value="追加">
	</form>
	<div id="container">
		<ul class="nav">
			<li><a href="#" data-id="all" class="section">all</a></li>
			<li><a href="#" data-id="category1" class="section">movie</a></li>
			<li><a href="#" data-id="category2" class="section">event</a></li>
			<li><a href="#" data-id="category3" class="section">book</a></li>
		</ul>

<?php 
	$select = new Edit;
	$select->select();
 ?>
		
	</div>

<script src="js/main.js"></script>



</body>
</html>
