/*jslint browser: true*/
/*global $, clearInterval, setInterval, parseInt, ion*/

var fruits = ['apple', 'banana', 'cherries', 'grapes', 'mango', 'orange', 'peach', 'pear', 'watermelon'];
var playing = false;
var trials;
var score;
var interval;

function fall(element, speed) {
    "use strict";
    if (parseInt(element.css('top'), 10) > $("#whiteSpace").height() - 20) {
        element.remove();
        clearInterval(interval);
        trials = trials - 1;
        $("#trials table tr td:eq(" + trials + ") img").css('visibility', 'hidden');
        if (trials === 0) {
            $("#finalScore").text(score);
            $("#gameOver").css('display', 'block');
            playing = false;
            $("#startReset").text("Start Game");
        } else {
            randomFruit();
        }
    } else {
        var top = parseInt(element.css('top'), 10);
        element.css('top', top + speed);
    }
}

function randomFruit() {
    "use strict";
    var fruit = fruits[Math.floor(fruits.length * Math.random())], element;
    $("#whiteSpace").append($("<img />"));
    element = $("#whiteSpace img:last");
    element.css('visibility', 'hidden');
    element.attr({src: 'images/' + fruit + '.png'});
    element.css('position', 'absolute');
    element.load(function () {
        var left = Math.floor(($("#whiteSpace").width() - element.width()) * Math.random()),
            top = -1 * element.height();
        element.css("left", left);
        element.css("top", top);
        element.css('visibility', 'visible');
        interval = setInterval(function () {
            fall(element, 5 + Math.ceil(20 * Math.random()));
        }, 50);
        element.mouseover(function () {
            slice(element);
        });
    });
    
}

function slice(element) {
    "use strict";
    ion.sound.play("slicefruit");
    element.hide("explode");
    clearInterval(interval);
    element.remove();
    randomFruit();
    score += 1;
    $("#score").text(score);
}

function startClicked() {
    "use strict";
    var i;
    if (playing) {
        window.location.reload();
    } else {
        $("#gameOver").css('display', 'none');
        $("#score").text(0);
        playing = true;
        trials = 3;
        score = 0;
        $("#trials").css("display", "block");
        for (i = 0; i < 3; i = i + 1) {
            $("#trials table tr td:eq(" + i + ") img").css('visibility', 'visible');
        }
        $("#startReset").text("Reset Game");
        randomFruit();
    }
}

$(function () {
    "use strict";
    var i;
    for (i = 0; i < 3; i = i + 1) {
        $("#trials table tr:eq(0) td:eq(" + i + ")").html(
            $("<img />").attr({src: 'images/heart.png',
                              width: '24px',
                              height: '24px'})
        );
    }
    ion.sound({
        sounds: [
            {
                name: "slicefruit"
            }
        ],
        path: "audio/",
        preload: true
    });
    $("#startReset").click(startClicked);
    
});