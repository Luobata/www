;(function($){
	$.fn.waterfall = function(option) {
		var defaults={
			column_width : 240,								//列宽
			column_num : 5,									//列数量
			column_className : 'waterfall_column',			//列的类名
			column_space : 10,								//列间距
			box_padding : 10,								//图片与盒子的间距
			cell_selector : '.cell',						//要排列的砖块的选择器，context为整个外部容器
			img_selector : 'img',							//要加载的图片的选择器
			auto_imgHeight : true,							//是否需要自动计算图片的高度
			fadein : true,									//是否渐显载入
			fadein_speed : 600,								//渐显速率，单位毫秒
			insert_type : 1,								//单元格插入方式，1为插入最短那列，2为按序轮流插入
			url :'getImage.php',							//ajax获取图片接口
			water_type : 1									//渲染顺序，1代表先渲染已有的再获取，0代表先获取
			//getResource:function(index){},				//获取动态资源函数,必须返回一个砖块元素集合,传入参数为加载的次数
		};
		var options = $.extend(defaults , option);
		var self = $(this);
		var $Column,
			$cell_clone;									//每个图层的克隆，用于添加新图片

		self.init = function(self) {
			//初始化瀑布流
			//var $Column,
			var	$cell = self.find(options.cell_selector),
				lowest_c = 0,									//默认最短列
				waterfall_width = (options.column_width +		//画布的宽 = （图片+边距）* 图片列数+（图片列数-1）* 列间距
								2 * options.box_padding) * options.column_num +
								(options.column_num - 1) * options.column_space;
			self.width(waterfall_width);
			if(options.water_type) {
				//判断先渲染再加载
				$Column = self.createColumn();
			}else{

			}
			//添加列
			//$cell.remove();
			self.append($Column);
			//遍历cell添加到$Column中
			$cell_clone = $cell.eq(0);
			self.appendImg($cell);
			$(window).bind('scroll',function() {
				clearTimeout(self._scrollTimer2);
				self._scrollTimer2=setTimeout(self.onScorll(),300);
					self.onScorll();
				});
		};

		self.createColumn = function() {
			//创建列
			var Column = [];
			for(var i = 0; i < options.column_num; i++){
				var $col = $('<div></div>');
				$col.addClass(options.column_className);
				$col.css({
					'width' : options.column_width+'px',
					'margin-left' : '5px',
					'margin-right' : '5px',
					'display' : 'inline-block',
					'overflow' : 'hidden',
					'vertical-align' : 'top'
				});
				Column.push($col.get(0));
			}

			return $(Column);
		};

		self.getImage = function (url,callback) {
			//从给如接口获取图片
			var img = [];
			$.ajax({
				url: url,
				type: 'POST',
				dataType: 'json',
				data: {param1: 'value1'},
				success : function(data){
					//模拟ajax数据
					for (var i = 0; i < data.length; i++) {
						img.push(data[i]);
					}
					callback(img);
				}
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});

		};

		self.calculatarColumn = function () {
			//计算加载图片的列（最短列）
			var lowest = $Column.eq(0).outerHeight(),
				key = 0;
				//console.log("0:"+lowest);
			for (var i = 1; i < $Column.size(); i++) {
				//console.log(i + ":" +$Column.eq(i).outerHeight());
				if($Column.eq(i).outerHeight() < lowest){
					lowest = $Column.eq(i).outerHeight();
					key = i;
				}
			}
			

			return key;
		};

		self.onScorll = function() {
			//浏览器滚动变化进行监听
			clearTimeout(self._scrollTimer);
			self._scrollTimer = setTimeout(function(){
				var $lowest_column = $Column.eq(self.calculatarColumn($Column));						//最短列
				var bottom = $lowest_column.offset().top+$lowest_column.outerHeight();					//最短列底部距离浏览器窗口顶部的距离
				var scrollTop = document.documentElement.scrollTop||document.body.scrollTop||0;			//滚动条距离
				var windowHeight = document.documentElement.clientHeight||document.body.clientHeight||0;//窗口高度
				if(scrollTop >= bottom-windowHeight) {
					//根据img渲染页面
					self.getImage(options.url, self.render);
				}
			},100);
		};

		self.appendImg = function($cell) {
			//插入元素(封装)
			$cell.each(function(i){
				var image = new Image();
				var src = $(this).find('img').attr('src');
				var cell = $(this);
				image.src = src;

				image.onreadystatechange = function() {
					console.log("readystage");
					if(document.readyState == 'complete'){
						console.log("document.readyState");
					}
				};
				
				if(image.complete) {
					lowest_c = self.calculatarColumn();
					$Column.eq(lowest_c).append(cell);
				} else {
					image.onload = function() {
						lowest_c = self.calculatarColumn();
						$Column.eq(lowest_c).append(cell);
					};
				}
			});
		};

		self.render = function (img) {
			//渲染界面
			//把img封装成$cell元素;
			var cells = [];
			$(img).each(function(index, el) {
				var $cell = $cell_clone.clone();
				$cell.find('p a').text(this.name).end()
						.find('img').attr('src', this.src);
				cells.push($cell);
			});
			self.appendImg($(cells));
		};

		//function
		self.init(self);

		return this.each(function(i) {
			var self = $(this);
			self.init(self);
		});

	};
})(jQuery);