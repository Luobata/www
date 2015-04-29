(FileUpload=function(){
	var fileShow,
		fileSelect,
		fileUpload,
		fileDelete,
		fileFilter=[],
		id=1;
		url = "doAction.php";


	//文件选中
	function SelectFile(e){
		// 获得上传文件列表
		var files = e.target.files || e.dataTransfer.files;
		//需要上传所有被选中的图片
		fileFilter=fileFilter.concat(FilterFile(files));

		// 处理文件
		for (var i = 0, f; f = files[i]; i++) {
			ParseFile(f);
		}
	}

	//文件加工
	function ParseFile(file){
		//给每个文件编号
		file.index = id;
		id++;

		//文件信息
		// Output(
		// 	"<p>File information: <strong>" + file.name +
		// 	"</strong> type: <strong>" + file.type +
		// 	"</strong> size: <strong>" + file.size +
		// 	"</strong> bytes</p>"  
			
		// );

		//展示图片
		if (file.type.indexOf("image") == 0) {
			var reader = new FileReader();
			reader.onload = function(e) {
				Output(
					"<p><strong>" + file.name + ":</strong><br />" +
					'<img width="200" src="' + e.target.result + '" /></p>' + 
					"<input type='button' class='delete' name=" + file.index +
					" value='删除'/>"
				);
				//绑定删除事件，这段改成js
				fileDelete = document.getElementsByClassName('delete');
				for(var i = 0,f; f=fileDelete[i];i++){
					f.addEventListener('click',function(){
						DeleteFile(this.name);
					})
				}

			}
			reader.readAsDataURL(file);
		}

		//展示文本
		if (file.type.indexOf("text") == 0) {
			var reader = new FileReader();
			reader.onload = function(e) {
				Output(
					"<p><strong>" + file.name + ":</strong></p><pre>" +
					e.target.result.replace(/</g, "&lt;").replace(/>/g, "&gt;") +
					"</pre>"
				);
			}
			reader.readAsText(file);
		}
	}

	//文件展示
	function Output(msg){
		fileShow.innerHTML = msg + fileShow.innerHTML;
	}

	//文件上传
	function UploadFile(){
		var self = this;	
		if (location.host.indexOf("sitepointstatic") >= 0) {
			//非站点服务器上运行
			return;	
		}
		for (var i = 0, file; file = fileFilter[i]; i++) {
			(function(file) {
				var xhr = new XMLHttpRequest();
				if (xhr.upload) {
					// 上传中
					var o = document.getElementById('progress');
					var progress = o.appendChild(document.createElement("p"));
					progress.appendChild(document.createTextNode("upload " + file.name));

					//进度条
					xhr.upload.addEventListener("progress", function(e) {
						var pc = parseInt(100 - (e.loaded / e.total * 100));
						progress.style.backgroundPosition = pc + "% 0";
					}, false);
				
					// 文件上传成功或是失败
					xhr.onreadystatechange = function(e) {
						if (xhr.readyState == 4) {
							if (xhr.status == 200) {
								DeleteFile(file.index);
								if (!fileFilter.length) {
									//全部完毕
									alert("上传完毕");
								}
							} else {
								alert("上传失败"+xhr.responseText);
							}
						}
					};
				
					// 开始上传
					xhr.open("POST", url, true);
					xhr.setRequestHeader("X_FILENAME", file.name);
					xhr.send(file);
				}	
			})(file);	
		}
	}

	//文件删除
	function DeleteFile(index){
		if(index){
				//寻找index的数组下标
				for (var i = 0,f; f = fileFilter[i]; i++) {
					if(f.index == index){
						//删除数组中元素
						fileFilter.splice(i,1);
						//删除显示对象
						var file = document.getElementsByClassName('delete');
						for(i=0,f; f=file[i]; i++){
							if(f.name == index){
								var p =f.previousElementSibling;
								//删除元素。fadeout效果需要jq，可去
								$(p).fadeOut();
								$(f).fadeOut();
							}
						}
					}
				};
		}
	}

	//上传成功提示函数
	function SuccessFile(file){
		alert(file.name+"文件上传成功");
	}

	//上传失败提示函数
	function FaileFile(file){
		alert(file.name+"文件上传失败");
	}

	//文件过滤函数
	function FilterFile(files){
		var array_files = [];
		for (var i = 0 ,f; f= files[i]; i++) {
			if(f.type.indexOf("image") == 0){
				//格式正确
				if(f.size < 1048576){
					array_files.push(f);
				}else{
					alert(f.name+"的大小过大，请上传不大于1MB的图片");
				}
			}else{
				alert(f.name+"的格式不符合要求，请上传图片格式的文件");
			}
		};

		return array_files;
	}


	//初始化
	function Init(){

		fileSelect = document.getElementById('fileSelect');     //图片文件
		fileShow = document.getElementById('fileShow');			//图片预览
		fileUpload = document.getElementById('fileUpload');		//图片上传

		//文件选中
		fileSelect.addEventListener('change', SelectFile,false);

		//是否支持ajax
		var xhr = new XMLHttpRequest();
		if (xhr.upload) {
			//支持,对上传按钮添加上传函数绑定
			fileUpload.addEventListener('click',UploadFile,false);
		}

	}

	// call initialization file
	if (window.File && window.FileList && window.FileReader) {
		Init();
	}

})();