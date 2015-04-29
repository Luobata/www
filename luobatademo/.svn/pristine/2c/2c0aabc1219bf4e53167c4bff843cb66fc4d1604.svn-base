$(function() { 
   $.fn.imgbig = function(options) { 
      var defaults = { 
		 width : "200",
		 height : "200",
		 length : "50",
		 img : "luobata_img",
		 span : "luobata"
      }; 
      var options = $.extend(defaults,options); 
      var $this = $(this);        //当然响应事件对象 
      //功能代码部分 
      
      function CreatBigPic(img){
      	//浮层窗口的大小
      	var width = defaults.width.toString(),						//浮层宽
      		height = defaults.height.toString();//浮层高，按照长宽比
      	$("<span class='luobata' style='width:"+width+"px;height:"+height+"px;position:absolute;overflow: hidden;'>"
      	+ "<img class='luobata_img' src="+img.src+">"
      	+ "</span>").insertAfter($(img));

      }
      //绑定事件 
      $this.live("mousemove",function(e){
		//判断是否需要创建span窗口
		var imgL = $('.'+defaults.img),
	        spanL = $('.'+defaults.span);
		 if(!$(spanL).length){
	      	 CreatBigPic(this);
		 }
		 	var x = e.originalEvent.x - this.offsetLeft||e.pageX - this.offsetLeft,
		 		y = e.originalEvent.y - this.offsetTop||e.pageY - this.offsetTop,//获取鼠标在图片中的位置
	      		width = defaults.width.toString(),
	      		height = defaults.height.toString(),//获取浮层的长宽
	      		imgwidth = $('.'+defaults.img).get(0).offsetWidth,
	      		imgheight = $('.'+defaults.img).get(0).offsetHeight,//获取大图片的长宽（即图片的实际大小）
	      		simgwidth = this.offsetWidth,
	      		simgHeight = this.offsetHeight,//在页面上显示的图片大小
	      		rateX = (imgwidth/simgwidth),
	      		rateY = (imgheight/simgHeight),           //获取‘放大’倍率
	      		offSetLeft = parseInt((x)-(width/rateX/2)),   //计算左移位置
	      		offSetTop = parseInt((y)-(height/rateY/2));
	      		$(spanL).get(0).scrollLeft = offSetLeft * rateX;
	      		$(spanL).get(0).scrollTop = offSetTop * rateY;
		 
          
      });
      $this.live('mouseout',function(e){
      	$('.'+defaults.span).remove();
      })
   } 
}); 