

var audio = document.getElementById("bg-m");
audio.oncanplay = playmusic();

var firsttaped = 0;
function playmusic(){
$('html').on('touchstart',function(){
if(firsttaped == 0){
audio.play();
firsttaped = 1;
}
});
};

   window.onload=function(){
   	audio.play();
   }
audio.play();
   $("#play-btn").bind("click",function(){
    $('#play-btn').hide();
    $('#pause-btn').show();
   	audio.play();
   })

   $("#pause-btn").bind("click",function(){
    $('#play-btn').show();
    $('#pause-btn').hide();
   	audio.pause();
  
   })


  



