// canvasWidth = document.getElementById("js-container").style.width*0.3,
// canvasHeight = document.getElementById("js-container").style.height*0.3,
var scrollY = function (y) {
    if (window.jQuery) {
        FB.Canvas.getPageInfo (function (pageInfo) {
            $({ y: pageInfo.scrollTop })
                .animate({
                        y: y
                    },
                    {
                        duration: 1000,
                        step: function (offset) {
                            FB.Canvas.scrollTo(0, offset);
                    }
                });
        });
    } else {
        FB.Canvas.scrollTo(0, y);
    }
};

var collectedNumbers = 0
function scratchPad(canvasid, canvasWidth, canvasHeight, pixelThreshold) {
  
  var isDrawing, lastPoint;
  var container    = document.getElementById('js-container'),
      canvas       = document.getElementById(canvasid),
      ctx          = canvas.getContext('2d'),
      brush        = new Image();
      image        = new Image(),
  // base64 Workaround because Same-Origin-Policy\
  image.src = "scratch-texture-large.jpg";

 
  
  
  image.onload = function() {
    ctx.drawImage(image, 0, 0, image.naturalWidth, image.naturalHeight, 0, 0, image.naturalWidth, image.naturalHeight);
    // Show the form when Image is loaded.
    //document.querySelectorAll('.form')[0].style.visibility = 'visible';
  };

  // imgLoadedWidth = image.naturalWidth;
  // imgLoadedHeight = image.naturalHeight;

  // $(".canvas").attr("width", image.naturalWidth);
  // $(".canvas").attr("height", image.naturalHeight);

  brush.src = "circle.png"
  
  canvas.addEventListener('mousedown', handleMouseDown, false);
  canvas.addEventListener('touchstart', handleMouseDown, false);
  canvas.addEventListener('mousemove', handleMouseMove, false);
  canvas.addEventListener('touchmove', handleMouseMove, false);
  canvas.addEventListener('mouseup', handleMouseUp, false);
  canvas.addEventListener('touchend', handleMouseUp, false);
  
  function distanceBetween(point1, point2) {
    return Math.sqrt(Math.pow(point2.x - point1.x, 2) + Math.pow(point2.y - point1.y, 2));
  }
  
  function angleBetween(point1, point2) {
    return Math.atan2( point2.x - point1.x, point2.y - point1.y );
  }
  
  // Only test every `stride` pixel. `stride`x faster,
  // but might lead to inaccuracy
  function getFilledInPixels(stride) {
    if (!stride || stride < 1) { stride = 1; }
    
    var pixels   = ctx.getImageData(0, 0, canvasWidth, canvasHeight),
        pdata    = pixels.data,
        l        = pdata.length,
        total    = (l / stride),
        count    = 0;
    // Iterate over all pixels
    for(var i = count = 0; i < l; i += stride) {
      if (parseInt(pdata[i]) === 0) {
        count++;
      }
    }
    
    return Math.round((count / total) * 100);
  }
  
  function getMouse(e, canvas) {
    var offsetX = 0, offsetY = 0, mx, my;

    if (canvas.offsetParent !== undefined) {
      do {
        offsetX += canvas.offsetLeft;
        offsetY += canvas.offsetTop;      } 
        while ((canvas = canvas.offsetParent));
    }
    
    mx = (e.pageX || e.touches[0].clientX) - offsetX;
    my = (e.pageY || e.touches[0].clientY) - offsetY;
    
    return {x: mx, y: my};
  }
  
  function handlePercentage(filledInPixels) {
    filledInPixels = filledInPixels || 0;
    if (filledInPixels > pixelThreshold) {
      canvas.parentNode.removeChild(canvas);
      getSecretNumber(canvas.id);
    }
  }
  
  function handleMouseDown(e) {
    isDrawing = true;
    lastPoint = getMouse(e, canvas);
  }

  function handleMouseMove(e) {
    if (!isDrawing) { return; }
    
    e.preventDefault();

    var currentPoint = getMouse(e, canvas),
        dist = distanceBetween(lastPoint, currentPoint),
        angle = angleBetween(lastPoint, currentPoint),
        x, y;
    
    for (var i = 0; i < dist; i++) {
      x = lastPoint.x + (Math.sin(angle) * i) - 25;
      y = lastPoint.y + (Math.cos(angle) * i) - 25;
      ctx.globalCompositeOperation = 'destination-out';
      ctx.drawImage(brush, x, y);
    }
    
    lastPoint = currentPoint;
    handlePercentage(getFilledInPixels(32));
  }

  function handleMouseUp(e) {
    isDrawing = false;
  }
  
};

function getSecretNumber(id) {
  var position = id.charAt(id.length-1);
  var idTag = "#scr__mystery-number" + position;
  updateNumbers(idTag, position);
}

function updateNumbers(tag, position) {
  collectedNumbers+=1;

  switch (position) {
    case "1":
      $(tag).html("3").fadeIn(1000);
      break;
    case "2" :
    case "3" :
    case "5" :
      $(tag).html("1").fadeIn(1000);
      break;
    case "4":
      $(tag).html("0").fadeOut().fadeIn(1000);
      break;
    case "6":
      $(tag).fadeOut().html("6").fadeIn(1000);
      break;
  }

  if (collectedNumbers>5) {
    $(".scr__scratch-overlay").fadeOut("slow");
    scrollY(0);
    setTimeout(function(){
      self.location.href = "./thank-you.php#"
      
    }, 3000)
  };
}

tmpImage = new Image();
tmpImage.src = "scratch-texture-large.jpg";

window.onresize = function() {
  sizeScratchpad()
  }

window.onload = function() {
  sizeScratchpad();
  scratchPad("js-canvas1", canvasWidth, canvasHeight, 50);
  scratchPad("js-canvas2", canvasWidth, canvasHeight, 50);
  scratchPad("js-canvas3", canvasWidth, canvasHeight, 60);
  scratchPad("js-canvas4", canvasWidth, canvasHeight, 60);
  scratchPad("js-canvas5", canvasWidth, canvasHeight, 50);
  scratchPad("js-canvas6", canvasWidth, canvasHeight, 60);
}

function sizeScratchpad () {
  
  //Resizes the six scratchpad surfaces based on their 
  //proporitions to the actual image background. 
  //(The image is normally 800 px)
  counter = 0;
  while (counter < 6) {
    canvasWidth  = parseInt($("#scr__scratch-underlay").width())
    canvasHeight = parseInt($("#scr__scratch-underlay").height());
     if (counter === 0) {
      canvasWidth *= 245/800;
      canvasHeight *= 245/800;
    }
    
    if (counter === 1) {
      canvasWidth *= 280/800;
      canvasHeight *= 250/800;
    }
    if (counter === 2) {
      canvasWidth *= 210/800; 
      canvasHeight *= 155/800;
    }

    if (counter === 3) {
      canvasWidth *= 220/800
      canvasHeight *= 210/800
        }

    if (counter === 4) {
      canvasWidth *= 220/800;
      canvasHeight *= 210/800;
    }

    if (counter === 5) {
      canvasWidth *= 180/800;
      canvasHeight *= 190/800 ;
    }
    ctx = $(".scr__canvas")[counter].getContext('2d');
    ctx.canvas.width = canvasWidth;
    ctx.canvas.height = canvasHeight;
    
   
    ctx.drawImage(tmpImage, 0, 0, 50, 50, 0, 0, canvasWidth, canvasHeight);

    counter++;
  }
   
}

