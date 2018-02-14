var playing = false;
var score = 0;
var time = 60;
var scoreE = document.getElementById("score");
var timeBox = document.getElementById("timeBox");
var timeE = document.getElementById("time");
var correctE = document.getElementById("correct");
var wrongE = document.getElementById("wrong");
var questionE = document.getElementById("question");
var startResetE = document.getElementById("startReset");
var ansArr = document.getElementsByClassName("answer");
var gameOverE = document.getElementById("gameOver");
var finalScore = document.getElementById("finalScore");
var interval;
var correctIndex;
var i;

function nextQuestion() {
    "use strict";
    if (!playing) {
        return;
    }
    var a = Math.floor(Math.random() * 9) + 1,
        b = Math.floor(Math.random() * 9) + 1,
        repeat = true,
        i,
        j,
        nr;
    correctIndex = Math.floor(Math.random() * 4);
    questionE.innerHTML = a + "x" + b;
    ansArr[correctIndex].innerHTML = a * b;
    for (i = 0; i < ansArr.length; i += 1) {
        if (i !== correctIndex) {
            nr = Math.floor(Math.random() * 99) + 1;
            while (repeat) {
                if (nr !== a * b) {
                    repeat = false;
                    for (j = 0; j < i; j += 1) {
                        if (Number(ansArr[j].innerHTML) === nr) {
                            nr = Math.floor(Math.random() * 99) + 1;
                            repeat = true;
                            break;
                        }
                    }
                } else {
                    nr = Math.floor(Math.random() * 99) + 1;
                }
            }
            ansArr[i].innerHTML = nr;
        }
    }
}

function timer() {
    "use strict";
    if (time >= 1) {
        time -= 1;
        timeE.innerHTML = time;
    } else {
        playing = false;
        window.clearInterval(interval);
        finalScore.innerHTML = score;
        timeBox.style.display = "none";
        gameOverE.style.display = "block";
        startResetE.innerHTML = "Start Game";
    }
}

function answerClick(i) {
    "use strict";
    if (!playing) {
        return;
    }
    if (i === correctIndex) {
        playing = false;
        correctE.style.display = "block";
        score += 1;
        scoreE.innerHTML = score;
        window.setTimeout(function () {correctE.style.display = "none"; playing = true; nextQuestion(); }, 1000);
    } else {
        playing = false;
        wrongE.style.display = "block";
        window.setTimeout(function () {wrongE.style.display = "none"; playing = true; }, 1000);
    }
}

function funcMaker(i) {
    "use strict";
    return function () { answerClick(i); };
}

function startReset() {
    "use strict";
    if (playing) {
        window.location.reload();
    } else {
        time = 60;
        score = 0;
        scoreE.innerHTML = score;
        timeE.innerHTML = time;
        gameOverE.style.display = "none";
        timeBox.style.display = "block";
        startResetE.innerHTML = "Reset Game";
        playing = true;
        nextQuestion();
        interval = window.setInterval(timer, 1000);
    }
}

startResetE.onclick = startReset;
for (i = 0; i < ansArr.length; i += 1) {
    ansArr[i].addEventListener("click", funcMaker(i), false);
}