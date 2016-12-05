<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>RECER</title>
	<link rel="stylesheet" href="css/main.css">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	
</head>
<body>
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
<?php
$db_user = "matsuko";
$db_pass = "matsuko";
$db_host = "127.0.0.1";
$db_name = "recer";
$db_type = "mysql";

$dsn = "$db_type:host=$db_host;dbname=$db_name;charaset=utf8";
try {
	$pdo = new PDO ($dsn, $db_user, $db_pass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$pdo->beginTransaction();

	$titlAll = array();
	$textAll = array();
	$sql0 = "select * from contents";
	$sql1 = "select * from contents where category = 1";
	$sql2 = "select * from contents where category = 2";
	$sql3 = "select * from contents where category = 3";
	
	for($i = 0; $i < 4; $i++){
		$stmt = $pdo->prepare(${'sql'. $i});
  		$stmt->execute();
  		${'contents'. $i} = $stmt->fetchAll();


	  	for ($j= 0; $j < count(${'contents'. $i}); $j++) { 
	  		$titleAll[] =  ${'contents'. $i}[$j]["title"];
	  		$textAll[] = ${'contents'. $i}[$j]["text"];
	  	}
  	}

  	if($_POST){
        $sql_edit = "UPDATE recer.contents SET title = :editTitle, text = :editText WHERE id = :editId";
        $stmh = $pdo->prepare($sql_edit);
        $stmh->bindValue(':editId', $_POST['editId'], PDO::PARAM_INT);
        $stmh->bindValue(':editTitle', $_POST['editTitle'], PDO::PARAM_STR);
        $stmh->bindValue(':editText', $_POST['editText'], PDO::PARAM_STR);
        $stmh->execute();
        header("Location: ../rec");
    }
    $pdo->commit();


} catch (PDOException $e){

 	 print "エラー : " . $e->getMessage();
}

?>	
	<div id="container">
		<ul class="nav">
			<li><a href="#" data-id="all" class="section">all</a></li>
			<li><a href="#" data-id="category1" class="section">movie</a></li>
			<li><a href="#" data-id="category2" class="section">event</a></li>
			<li><a href="#" data-id="category3" class="section">book</a></li>
		</ul>


		<div id="content">
			<div id="all" class="box activeBox">
				<a href="#" class="all">
					<?php  for ($i=0; $i <count($contents0) ; $i++) {
						if($contents0[$i]['category'] == NULL)
							continue;
					 ?>
					<a href="#" id="title all_<?php echo $contents0[$i]['id']; ?>" data-id="all_<?php echo $contents0[$i]['id']; ?>" class="title">
					<?php echo $contents0[$i]['title']; ?>
					</a>

					<form action="<?= $_SERVER["PHP_SELF"]; ?>" method="post" class="hiddenform" id="form_<?php echo $contents0[$i]['id']; ?>" >
						<input type="hidden" value="<?php echo $contents0[$i]['id']; ?>" name="editId">
						<input  type="text" value="<?php echo $contents0[$i]['title'];?>" name="editTitle">
						<textarea name="editText" cols="30" rows="5" name="editText"><?php echo $contents0[$i]['text']; ?></textarea>
						<input type="submit" value="編集">
					</form>

					<a href="#" id="editDust_<?php echo $contents0[$i]['id']; 
					?>" 
					data-id="title all_<?php echo $contents0[$i]['id']; ?>"
					data-form="form_<?php echo $contents0[$i]['id']; ?>"
					class="fa fa-times editDustHide" aria-hidden="true">
					</a>

					<a href="#" class="fa fa-pencil-square-o edit" aria-hidden="true" data-id="title all_<?php echo $contents0[$i]['id']; ?>"
					data-form="form_<?php echo $contents0[$i]['id']; ?>"
					data-editdust="editDust_<?php echo $contents0[$i]['id']; ?>"
					></a>
					<a href="#" class="fa fa-trash-o edit" aria-hidden="true"></a>
					
					<div id="title all_<?php echo $contents0[$i]['id']; ?>" class="text">
						<?php echo $contents0[$i]['text']; ?>
					</div>
						<?php } ?>
				</a>
			</div>

			<?php
			$html = '';
			for ($k=1; $k < 4; $k++) { 
				$html.= '<div id="category'. $k. '" class="box"><a href="#" class="title">';
					for ($l=0; $l <count(${'contents'. $k}); $l++) {
							if(${'contents'. $k}[$l]['category'] == NULL)
								continue;
						$html.= '<a href="#" id="title" data-id="category'.
						$k. '_'.${'contents'.$k}[$l]["id"]. 
						'" class="title">'.
						${'contents'.$k}[$l]["title"].
						'</a>
						<a href="#" class="fa fa-pencil-square-o edit" aria-hidden="true"></a>
						<a href="#" class="fa fa-trash-o edit" aria-hidden="true"></a>
					<div id="category'. $k.'_'. ${'contents'.$k}[$l]['id'].
					'" class="text">'.${'contents'.$k}[$l]['text'].'</div></a>';
				}
				$html.= '</div>';
			}
			echo $html;
			
			 ?>
		</div>
	</div>
<script src="js/main.js"></script>


</body>
</html>




<!-- <script>
(function (){
	function aaa(){
		document.getElementById('abcd').textContent = 'TEST!';
	}
	var p = document.getElementById('abcd');
	p.addEventListener('click', aaa, false);

})();

</script> -->