<!DOCTYPE html>
<?php 
	if(!empty($_POST)){
		//var_dump($_POST);
        //exit();
        //$con=mysqli_connect("localhost","root","","lenovoxz");
		if(empty($_POST['name'])){
			echo "<script>alert('姓名不能为空')</script>";
		}elseif(empty($_POST['identify'])){
			echo "<script>alert('身份证号不能为空')</script>";
		}else{
			$con=mysqli_connect(SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS,"app_lenovoschool");
	        if($con){
	            $query_sql="select * from user where name='".$_POST['name']."' and identify='".$_POST['identify']."'";
				//echo $query_sql;
	            $query_res=mysqli_query($con,$query_sql);
	            if($query_res){
	                $fieldcount=mysqli_num_rows($query_res);
	                if($fieldcount){
	                    //echo "1";
						echo "<script>window.location.href='http://2.lenovoschool.sinaapp.com/qbcode.html';</script>";
						//header("Location:http://weixin.qq.com/g/AcgYXrEtEYNNPnuf");
						//header("Location:http://baidu.com");
	                }else{
	                    //echo "2";
						echo "<script>alert('亲，你确定拿到联想offer了么？')</script>";
	                }
	            }
	        }
			mysqli_close($con);
		}
	}
    
?>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no,minimal-ui" name="viewport">
    
    <link type="text/css" rel="stylesheet" href="scripts/valid.css" />
</head>

<body>
	
    <form class="vf" action="valid.php" id="valid" method="post">
        <input  style="margin-top:15%" placeholder="请输入姓名" name="name" value="<?php if(!empty($_POST['name']))echo $_POST['name'];?>"/>
        <input  placeholder="请输入身份证号码" name="identify" value="<?php if(!empty($_POST['identify']))echo $_POST['identify'];?>"/>
        <img src="images/submit.png" style="width:75%;margin-top:16px;" onclick="valid.submit();">


    </form>
</body>
<script type="text/javascript">
    (function() {
    function i() {
        WeixinJSBridge.on("menu:share:appmessage", s), WeixinJSBridge.on("menu:share:timeline", o)
    }
    function s() {
        WeixinJSBridge.invoke("sendAppMessage", {
            //appid: "wxaf1d4daa8e0ec0b5",
            img_url: t,
            img_width: "150",
            img_height: "150",
            link: e,
            desc: n,
            title: r
        }, function(e) {})
    }
    function o() {
        WeixinJSBridge.invoke("shareTimeline", {
            img_url: t,
            img_width: "150",
            img_height: "150",
            link: e,
            desc: n,
            title: n
        }, function(e) {})
    }
    var e = "http://2.lenovoschool.sinaapp.com/",
        t = "http://2.lenovoschool.sinaapp.com/images/xz.png",
        n = "致2015届想加入联想的应届生们",
        r = "今年圣诞不一样？联想许你一场美丽的约会~";
    typeof WeixinJSBridge == "object" && typeof WeixinJSBridge.invoke == "function" ? i() : document.addEventListener ? document.addEventListener("WeixinJSBridgeReady", i, !1) : document.attachEvent && (document.attachEvent("WeixinJSBridgeReady", i), document.attachEvent("onWeixinJSBridgeReady", i))
})()
</script>