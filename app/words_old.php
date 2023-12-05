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

$grade = $_GET['select'];

if (mb_strlen($grade) == 5) {
$SQL = "SELECT * FROM words WHERE grade = '".$grade."' ORDER BY RAND()";
}else if(mb_strlen($grade) == 3){
$SQL = "SELECT * FROM words WHERE LEFT(grade,3) = '".$grade."' ORDER BY RAND()";
}

$st = $pdo->query($SQL);

//件数表示
$AllRow = $st->rowCount();

?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
  <title>Quiz</title>
  <link rel="stylesheet" href="css/styles.css">

</head>

<body>
  <div class="container">

     <div id="title"></div>
      <div id="header">
      <div id="question">
      </div>

      <div id="hint" style="color:#0000FF;">
      </div>
    </div>

      <input id="input" type="text" autocomplete="off"/>

      <button id="btn" type="submit">次の問題</button>
	  <a href="index.php"><button>終わる</button></a>

      <div id="res"></div>

    <div id="result">
      <p>スコア: 3/3</p>
      <a href="">もう一度？</a>
	  <a href="index.php">トップへ</a>
    </div>

  </div>

<script>

(function() {
  'use strict';

  var container = document.getElementById('container');
  var question = document.getElementById('question');
  var hint = document.getElementById('hint');
  var btn = document.getElementById('btn');
  var answer = document.getElementById('answer');
  var input = document.getElementById('input');
  var inp = document.getElementById('inp');
  var res = document.getElementById('res');
  var result = document.getElementById('result');
  var scoreLabel = document.querySelector('#result > p');
  var title = document.getElementById('title');
  var pTag = document.createElement('div');
  var Wrk;


  var quizSet = [
    <?php while($row = $st->fetch()) { ?>

    {r: <?= $cnt ?> + "/" + <?= $AllRow ?> , c:'<?= $row['category'] ?>' , k:'<?= $row['kbn'] ?>' , q:'<?= $row['question'] ?>' , a:"<?= $row['answer'] ?>" , h:'<?= $row['hint'] ?>'},

    <?php $cnt++; ?>

    <?php } ?>
  ];

  // 現在の問題
  var currentNum = 0;
  var isAnswered;
  var score = 0;

  //初期カーソルは入力箇所
  input.focus();

  function setQuiz() {

    //問題を表示する
    if(quizSet[currentNum].k === 'i'){
      //区分がi（画像）なら
      question.innerHTML = "<img src=image/" + quizSet[currentNum].a + ".jpg height='250px;'/>"
    }else{
      question.innerHTML = "[" + quizSet[currentNum].c + "]　" + quizSet[currentNum].q;
    }

    //ヒントがあれば表示
    if(quizSet[currentNum].h){
      hint.innerHTML = quizSet[currentNum].h;
    }else{
      hint.innerHTML = "";
    }

    title.innerHTML = 'Stage<?= $grade ?>' + '  ' + quizSet[currentNum].r;

    //答えを変数に入れる
    answer = quizSet[currentNum].a;

    //最終問題ならボタンをShow Scoreにする
    if (currentNum === quizSet.length - 1) {
      btn.textContent = '最終問題';
    }
  }



  function setEvents() {

    //ボタンをクリックしたら
    input.addEventListener('blur', function() {

      //答え合わせ
      checkAnswer(input);

      input.focus();

      // 最後の問題なら答え、でなければsetQuizを
      if (currentNum === quizSet.length) {
        scoreLabel.textContent = 'スコア: ' + score + ' / ' + quizSet.length;
        result.classList.add('show');
      } else {
        setQuiz();
      }
    });
  }

  function escapeHtml(str) {
    str = str.replace(/&/g, '&amp;');
    str = str.replace(/</g, '&lt;');
    str = str.replace(/>/g, '&gt;');
    str = str.replace(/"/g, '&quot;');
    str = str.replace(/'/g, '&#39;');
    return str;
  }


  function checkAnswer(node) {

    // 問題・入力・成否を表示
    if (node.value === quizSet[currentNum].a) {
      //node.classList.add('correct');
      Wrk = "<p style='color:#00F'>〇 問題:" + quizSet[currentNum].q + "　入力:" + escapeHtml(node.value) + "　答え:" + quizSet[currentNum].a + "</p>";
      score++;
    } else {
      //node.classList.add('wrong');
      Wrk = "<p style='color:#F00'>× 問題:" + quizSet[currentNum].q + "　入力:" + escapeHtml(node.value) + "　答え:" + quizSet[currentNum].a + "</p>";
    }

    // 成否を続けて表示していく
	res.insertAdjacentHTML('afterbegin',Wrk);
	//res.insertAdjacentHTML('beforebegin',Wrk);
    //res.insertAdjacentHTML('beforeend',Wrk);
    //res.insertAdjacentHTML('afterend',Wrk);

    // インプット値をクリア
    node.value = "";

    btn.classList.remove('disabled');

    //次の問題
    currentNum++;
  }

    // セットクイズ
    setQuiz();
    // セットイベント
    setEvents();

    container.scrollIntoView(true);
	

})();


</script>

</body>

</html>
