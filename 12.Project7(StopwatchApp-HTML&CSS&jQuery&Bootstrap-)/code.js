
var Clock = (function() {
    function update() {
        this.element.find(".cs").text((this.cs < 10) ? '0'+this.cs : this.cs);
        this.element.find(".s").text((this.s < 10) ? '0'+this.s : this.s);
        this.element.find(".m").text((this.m < 10) ? '0'+this.m : this.m);
    };
    function publicClock(selector) {
        this.element = $(selector);
        this.m = 0;
        this.s = 0;
        this.cs = 0;

        this.inc = function() {
            ++this.cs;
            if (this.cs >= 100) { this.cs = 0; ++this.s; }
            if (this.s >= 60) { this.s = 0; ++this.m; }
            update.call(this);
        };
        this.reset = function() {
            this.cs = 0; this.s = 0; this.m = 0;
            update.call(this);
        };
        this.getText = function() {
            var txt = this.element.find(".m").text() + ":";
            txt += this.element.find(".s").text() + ":";
            txt += this.element.find(".cs").text();
            return txt;
        }
    }

    return publicClock;
}) ();

var interval;
var running = false;
var started = false;
var count = 0;
var lapTimer = new Clock("#lapTimer");
var mainTimer = new Clock("#mainTimer");

function startClicked() {
    started = true;
    if (running) {
        clearInterval(interval);
        $("#startBtn").text("Resume");
        $("#lapBtn").text("Reset");
        running = !running;
    } else {
        interval = setInterval(timer, 10);
        $("#startBtn").text("Stop");
        $("#lapBtn").text("Lap");
        running = !running;
    }
}

function lapClicked() {
    if (!started) return;
    if (running) {
        var lst = $("#lapList");
        var item = $("<div class='list-item'></div>");
        item.append($("<span><span>").text("Lap"+(++count)));
        item.append($("<span><span>").text(lapTimer.getText()));
        lst.append(item);
        lapTimer.reset();
    } else {
        window.location.reload();
    }
}

function timer() {
    lapTimer.inc();
    mainTimer.inc();
}

$(function() {
    $("#startBtn").click(startClicked);
    $("#lapBtn").click(lapClicked);
});
