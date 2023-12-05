<?php

$dsn = 'mysql:dbname=quiz; host=127.0.0.1; charset=utf8';
$usr = 'dbuser';
$passwd = 'e8GfDdmh';

$cnt = 1;

try {

  $pdo = new PDO($dsn,$usr,$passwd);

} catch (PDOException $e) {
  die("接続エラー：{$e->getMessage()}");
}

$SQL = "SELECT * FROM words WHERE id >= 7789 and id <= 7969";

$st = $pdo->query($SQL);

//件数表示
//$AllRow = $st->rowCount();

?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
  <title>Quiz</title>

</head>

<body>
  <div class="container">

<table>

<tr>
<th>カテ</th>
<th>問題</th>
<th>答え</th>
<th>ヒント</th>
</tr>

<?php while($row = $st->fetch()) { ?>

<tr>
<td><?php echo $row['category']; ?></td>
<td><?php echo $row['question']; ?></td>
<td><?php echo $row['answer']; ?></td>
<td><?php echo $row['hint']; ?></td>
</tr>

<?php } ?>

</table>

  </div>
</body>

</html>
