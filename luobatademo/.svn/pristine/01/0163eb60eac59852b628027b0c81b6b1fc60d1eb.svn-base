$(function(){
	$.fn.imgslide = function(options) {
		var defaults = {
			width : '400',
			height : '300',
			scrollDesc : 'scrollDesc',
			scrollBar : 'scrollBar',
			current : 'current',
			time : '5000'
			
		};
		var options = $.extend(defaults,options);
		var $this = $(this);
		
		//功能代码
		function imgslider() {
			var timer = null,												//设置定时器
				$sliderContiner = $this,						            //轮播框
				$ul = $sliderContiner.find('.' + options.scrollDesc + ' >ul'),	//ul元素
				$li = $ul.children(),										//li元素
				size = $li.size(),											//图片数量
				width = options.width * 1,									//每个图片的width
				lastW = size * width,										//图片总长度
				index = 1,													//初始图片编号
				$scrollBar = $sliderContiner.find('.' + options.scrollBar);
				$btns = $sliderContiner.find('.' + options.scrollBar + ' li').mouseover(function(e){
					if(timer){
						clearInterval(timer);
					}
					index=$(this).index();
					slider();
					timer = setInterval(slider, options.time * 1);			// *1将string转number
				}),
				slider = function(){
					if(index === size){
						var t = $li.eq(0).css({position:"relative",left:lastW}),
						callback = function(){
							t.css({left:0});
							$ul.css({left:0});
						},
						myTop = -index*width,
						eq = index = 0;
					}else{
						var myTop = -index*width,
						callback='',
						eq = index;
					}
					$btns.removeClass(options.current).eq(eq).addClass(options.current);
					$ul.stop().animate({left:myTop},500,callback);
					index++;
				};
				//添加css属性
				$sliderContiner.css({
					'width' : options.width,
					'height' : options.height
				});
				$ul.css({
					'width' : options.width,
					'height' : options.height
				});
				
				$sliderContiner.find('img').css({
					'width' : options.width,
					'height' : options.height
				});
				
				$ul.width(lastW);
				timer = setInterval(slider, options.time *1 );
		
		}
		imgslider();
	}
});
