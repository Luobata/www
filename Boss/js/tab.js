/* 维度端前端网整理 http://www.weiduduan.com */
(function(){
tab_main(".scroll",".scrollDesc",".scrollBar","current");
tab_main(".move",".moveDesc",".moveBar","current");
})();


function  tab_main(tab_id,tab_pic,tab_slide,on){
    var timer=null,
	$sliderContain = $(tab_id),
	$ul = $sliderContain.find(tab_pic+"  > ul"),
	$li = $ul.children(),
	size = $li.size(),
	height = $li.eq(0).width(),
	lastLiH = height*size,
	index=1,
	$btns = $sliderContain.find(tab_slide+" li").mouseover(function(){
		if(timer){
			clearInterval(timer);
		}
		index=$(this).index();
		slider();
		timer = setInterval(slider, 5000);
	}),
	slider = function(){
		if(index === size){
			var t = $li.eq(0).css({position:"relative",left:lastLiH}),
			callback = function(){
				t.css({left:0});
				$ul.css({left:0});
			},
			myTop = -index*height,
			eq = index = 0;
		}else{
			var myTop = -index*height,
			callback='',
			eq = index;
		}
		$btns.removeClass(on).eq(eq).addClass(on);
		$ul.stop().animate({left:myTop},500,callback);
		index++
	};
	$ul.width(lastLiH);
	timer = setInterval(slider, 5000);
}; /* 维度端前端网整理 http://www.weiduduan.com */