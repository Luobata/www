$(function(){
	$.fn.select = function(options){
		var defaults = {
			'width' : '180'
		};
		var options = $.extend(defaults , options);
		
		return this.each(function(){
			
			var self = $(this);

			self.init=function(){
				//初始化，创建dom集合
				var $select_box = $("<div tabindex = 1></div>"),
					$select_showbox = $('<div></div>'),
					$select_option = $('<ul></ul>'),
					$li = $(this).find('option'),
					$box;

				//绑定class
				$select_box.addClass('select_box');
				$select_showbox.addClass('select_showbox');
				$select_option.addClass('select_option');

				//添加
				$select_box.append($select_showbox);
				$select_box.append($select_option);

				for(var i=0 ; i<$li.length ; i++){
					var $li_option = $('<li value = '+$li.eq(i).val()+'>'+$li.eq(i).text()+'</li>');
					if($li.eq(i).attr('selected') === 'selected'){
						//默认选中项
						$li_option.addClass('selected');
						$select_showbox.text($li.eq(i).text()).val($li.eq(i).val());
					}
					$select_option.append($li_option);
				}
				var $select_li = $select_option.find('li');
				//增加点击事件

				$select_box.click(function(event) {
					$box = $(this).children('ul');
					var a =$box.css('display');
					if( $box.css('display') === 'block' ){
						$box.slideUp();
					}else{
						$box.slideDown();
						//防止事件冒泡
						event=event||window.event; 
						event.stopPropagation(); 
					}
				});
				$select_box.blur(function(event) {
					$(this).children('ul').slideUp();
				});
				$("body").not('.select_box').bind('click',function(e){
					$select_box.children('ul').slideUp();
				});
				
				$select_li.hover(function(e) {
					$(this).addClass('hover');
				}, function() {
					$(this).removeClass('hover');
				});
				$select_li.bind('click', function(event) {
					var a=$(this).parents('.select_option');
					$select_li.removeClass('selected');
					$(this).addClass('selected');
					$(this).parents('.select_option').prev()
						 	.text($(this).text())
							.val($(this).val());

				});
				self.after($select_box);
			}

			self.init();
		});
		
	}
})
