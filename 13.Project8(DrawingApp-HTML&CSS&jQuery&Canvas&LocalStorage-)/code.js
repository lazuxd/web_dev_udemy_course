var DrawingArea = (function() {
//private:
    //data
    var canvas, context;
    var width, height;
    var brushColor, brushSize;
    var oldX, oldY;
    var isPainting, eraseMode;
    //methods
    function start(e) {
        oldX = e.pageX - canvas.offsetLeft;
        oldY = e.pageY - canvas.offsetTop;
        isPainting = true;
        context.beginPath();
        context.lineWidth = brushSize;
        context.strokeStyle = (eraseMode ? "#ffffff" : brushColor);
        context.lineCap = "round";
        context.lineJoin = "round";
        context.moveTo(oldX, oldY);
        context.lineTo(oldX, oldY);
        context.stroke();
    }
    function stop(e) {
        isPainting = false;
    }
    function drawTo(e) {
        if (!isPainting) return;
        var newX = e.pageX - canvas.offsetLeft;
        var newY = e.pageY - canvas.offsetTop;
        context.beginPath();
        context.moveTo(oldX, oldY);
        context.lineTo(newX, newY);
        context.stroke();
        oldX = newX; oldY = newY;
    }
//public:
    function publicDrawingArea(canvasID) {
        var tmp = $(canvasID);
        canvas = tmp[0];
        context = canvas.getContext("2d");
        width = tmp.width();
        height = tmp.height();
        brushColor = "#000000";
        brushSize = 3;
        isPainting = false;
        eraseMode = false;

        //Add event handlers
        tmp.mousedown(start);
        tmp.mousemove(drawTo);
        tmp.mouseup(stop);
        tmp.mouseout(stop);

        this.load = function() {
            if (typeof(localStorage) === "undefined" || typeof(localStorage.drawingDataURL) === "undefined") return;
            var img = new Image();
            img.onload = function() {
                context.drawImage(img, 0, 0);
            };
            img.src = localStorage.getItem("drawingDataURL");
        };
        this.save = function() {
            if (typeof(localStorage) !== "undefined") {
                localStorage.setItem("drawingDataURL", canvas.toDataURL());
            }
        };
        this.reset = function() {
            context.clearRect(0, 0, width, height);
            brushColor = "#000000";
            brushSize = 3;
            isPainting = false;
            eraseMode = false;
        };
        this.eraseToggle = function() {
            eraseMode = !eraseMode;
        }
        this.erase = function(e) {
            if (typeof(e) !== "boolean")
                return eraseMode;
            else
                eraseMode = e;
        };
        this.size = function(s) {
            if (typeof(s) !== "number")
                return brushSize;
            else
                brushSize = s;
        };
        this.color = function(c) {
            if (typeof(c) !== "string")
                return brushColor;
            else
                brushColor = c;
        };

        this.load();
    }

    return publicDrawingArea;
})();

var Preview = (function() {
    var element;
    function publicPreview(elementID) {
        element = $(elementID);
        this.size = function(t) {
            if (typeof(t) !== "number") {
                return element.width();
            } else {
                element.css({
                    'width': t+'px',
                    'height': t+'px'
                });
            }
        };
        this.color = function(t) {
            if (typeof(t) !== "string") {
                return element.css('background');
            } else {
                element.css('background', t);
            }
        };
        this.reset = function() {
            this.color('#000000');
            this.size(3);
        };
    }
    return publicPreview;
})();

$(function() {
    $('#color').val('#000000');
    var drawingArea = new DrawingArea("#drawing");
    var preview = new Preview('#preview');
    $("#slider").slider({
        min: 3,
        max: 30,
        value: 3,
        slide: function(event, ui) {
            drawingArea.size(ui.value);
            preview.size(ui.value);
        }
    });
    $("#color").on("input", function() {
        drawingArea.color($(this).val());
        preview.color($(this).val());
    });
    $("#erase").click(function() {
        drawingArea.eraseToggle();
        $(this).toggleClass("button");
        $(this).toggleClass("red");
    });
    $("#save").click(function() {
        drawingArea.save();
    });
    $("#reset").click(function() {
        drawingArea.reset();
        preview.reset();
        $('#slider').slider("value", 3);
        $('#color').val('#000000');
        drawingArea.erase(false);
        $('#erase').removeClass('red');
        $('#erase').addClass('button');
    });
});
