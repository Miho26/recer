<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
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
    $sql = "INSERT INTO contents (category, title, text) VALUES
    (:category, :title, :text)";
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':category', $_POST['category'], PDO::PARAM_INT);
    $stmh->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
    $stmh->bindValue(':text', $_POST['text'], PDO::PARAM_STR);
    $stmh->execute();
    $pdo->commit();

    
    $return =   '追加しました。 <a href="../rec">戻る</a>';
    echo $return;

} catch (PDOException $e){
  $pdo->rollBack();
   print "エラー : " . $e->getMessage();
}


  ?>

</body>
</html>
