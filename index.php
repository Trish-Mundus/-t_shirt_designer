<!DOCTYPE html>
<html xml:lang="ru-ru" lang="ru-ru" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>Конструктов маек</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/overcast/jquery-ui.css" />
<script src="/html2canvas.js" /></script>
<script src="//www.jqueryscript.net/demo/Add-Image-Or-Text-Watermarks-To-Images-with-jQuery-watermark/dist/jquery.watermark.min.js"></script>

<script type="text/javascript">
function previewFile() {
  var file    = document.querySelector('input[type=file]').files[0];
  var reader  = new FileReader();

  reader.onloadend = function () {
    $('#show').html('<img id="new" src="'+reader.result+'" style="opacity:0;">');
	var h = document.getElementById('new').height;	
	var top = (550-h)/2;
    var w = document.getElementById('new').width;
	//$("#show img").resizable({aspectRatio: w/h}).css('top',top);
	setTimeout(function(){$("#show img").css('opacity','1');
	$('#save').before('<div class="line"></div>');
	//$('.round').trigger('.ui-widget-content .ui-icon');
	$(".line").slider({
        value: 500,
        max: 1000,
        min: 300,
        slide: function(event, ui) {
            $("#new").width(ui.value);
            $("#new").height(ui.value);
   }
});
	},500);
	
  }

  if (file) {
    reader.readAsDataURL(file);
  } else {
   $('#show').html('');
  }
}
$(document).ready(function(){
//$( ".maj,.mimg" ).disableSelection();
$('.mimg').mousedown(function(b) {
    var startX = b.pageX;
    var startY = b.pageY;
    var startCtX = parseInt($("#new").parent().css("left"));
    var startCtY = parseInt($("#new").parent().css("top"));
    
    $(".mimg").mousemove(function(m) {
        $("#new").parent().css("left", (m.pageX - startX + startCtX) + "px");
        $("#new").parent().css("top", (m.pageY - startY + startCtY) + "px");
    }).mouseup(function() {
        $(".mimg").unbind("mousemove");
    });
  });


/*$("#new").draggable({
// handle: '.mimg',
 //containment: ".maj",
 //disabled: true,
 drag: function(event,ui){

 //$('.mimg,.maj').css('top','0!important').css('left','0!important');
          $("#new").offset({ left:ui.offset.left, top:ui.offset.top }); 
			  
               //var h = document.getElementById('new').height;	
               //var w = document.getElementById('new').width;	
               //var top = (550-h)/2;
			   //$(".mimg").css('top',top);
			   //$("#show img").resizable({aspectRatio: w/h}).css('top',top);
//			   $(".line").slider({
//        value: 500,
//        max: 1000,
//        min: 300,
//        slide: function(event, ui) {
//            $("#new").width(ui.value);
//            $("#new").height(ui.value);
//   }
//});
           }
});*/
//$( "img,div" ).disableSelection();
});

$(function() { 
    $("#save").click(function() { 
        html2canvas($(".mimg"), {
				onrendered: function(canvas) {
					var ctx = canvas.getContext("2d"); 
					ctx.filter = "brightness(1.1)";
					$.ajax({
  method: 'POST',
  url: 'get.php',
  data: {
    photo: canvas.toDataURL("image/png")
  },
 success: function(data) {
  $('#img-out').html('<img src="images/image.png" class="watermark">');
  $('img.watermark').watermark({
  path: 'images/flag.png',
  outputWidth: 'auto',
  outputHeight: 'auto',
  outputType: 'png',
  margin: 10,
  opacity: 0.3,
  gravity: 'sw'
});
  }
});
setTimeout(function(){
//console.log($('#img-out img').attr('src'));
$('#img-out').find('img').after('<a href="'+$('#img-out img').attr('src')+'" download="image.png">Скачать</a>');
setTimeout(function(){$('#img-out a').css('opacity','1');
},100);},3000);	
				},
			});
    });	
});  
</script>
<!-- .mimg,.maj{top:0!important;left:0!important;} -->
<style>
.line{width:200px;height:5px;background:blue;position:absolute;left:338px;top:25px;}.round{background:#555;width:7px;height:15px;border-radius:2px;cursor:all-scroll;position:relative;top:-5px;}#save{cursor:pointer;width: 150px;text-align: center;position: absolute;top: 57px;left: 599px;color: #fff;background: #00b10f;text-transform: uppercase;border: 0;padding: 7px;}#img-out a{position: relative;top:10px;text-transform:uppercase;padding:7px 40px;text-decoration: none;color: #fff;background: #1e81ff;opacity:0;transition: opacity 1s ease-in-out;}#show img{width:100%;height:auto!important;}.ui-wrapper{min-width:450px!important;height:auto!important;}
.mimg{width:530px;height:550px;overflow:hidden;position:relative;background:#fff;filter: brightness(1.1);}
#show{cursor: all-scroll;position:absolute;top:0;width:100%;height:100%;}.maj{position:absolute;}#img-out{width: 150px;text-align:center;position: absolute;top: 93px;left: 600px;}#img-out img {width:150px;}
.ui-slider-horizontal .ui-slider-handle{top: -.5em;}
.ui-widget-content .ui-icon {background:url('https://d30y9cdsu7xlg0.cloudfront.net/png/361666-200.png')no-repeat;display:none!important;
width:25px;height:25px;position: fixed;left: 550px;top:100px;    cursor: all-scroll;    background-size: 100%;}
</style>
</head>
<body>
<div class="wrap">
<input type="file" style="margin: 10px 0 17px 0;" onchange="previewFile()"><br>
<div class="mimg ui-widget-content" id="myCanvas">
<div id="show"></div>

<img class="maj" src="images/majka.png">

</div>
</div>
</div>

<input type="button" id="save" value="Сохранить"/>

<div id="img-out"></div>

</body>
</html>
<?php


?>
