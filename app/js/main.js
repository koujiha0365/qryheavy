(function() {
  'use strict';

  var question = document.getElementById('question');
  var hint = document.getElementById('hint');
  var btn = document.getElementById('btn');
  var answer = document.getElementById('answer');
  var input = document.getElementById('input');
  var inp = document.getElementById('inp');
  var res = document.getElementById('res');
  var result = document.getElementById('result');
  var scoreLabel = document.querySelector('#result > p');
  var pTag = document.createElement('div');
  var Wrk;

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
      question.innerHTML = "問題：" + quizSet[currentNum].q;
    }

    //ヒントがあれば表示
    if(quizSet[currentNum].h){
      hint.innerHTML = "(" + quizSet[currentNum].h + ")";
    }else{
      hint.innerHTML = "";
    }

    //答えを変数に入れる
    answer = quizSet[currentNum].a;

    //最終問題ならボタンをShow Scoreにする
    if (currentNum === quizSet.length - 1) {
      btn.textContent = '最終問題';
    }
  }



  function setEvents() {

    //ボタンをクリックしたら
    btn.addEventListener('click', function() {

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


  function checkAnswer(node) {

    // 問題・入力・成否を表示
    if (node.value === quizSet[currentNum].a) {
      node.classList.add('correct');
      Wrk = "<p>問題：" + quizSet[currentNum].q + "　入力したもの：" + node.value + "　答え：" + quizSet[currentNum].a + "　成否：〇</p>";
      score++;
    } else {
      node.classList.add('wrong');
      Wrk = "<p>問題：" + quizSet[currentNum].q + "　入力したもの：" + node.value + "　答え：" + quizSet[currentNum].a + "　成否：×</p>";
    }

    // 成否を続けて表示していく
    res.insertAdjacentHTML('afterend',Wrk);

    // インプット値をクリア
    node.value = ""

    btn.classList.remove('disabled');

    //次の問題
    currentNum++;
  }

    // セットクイズ
    setQuiz();
    // セットイベント
    setEvents();

})();
