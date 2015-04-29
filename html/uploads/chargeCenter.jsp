<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@taglib prefix="s" uri="/struts-tags" %>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>54考神</title><meta http-equiv="X-UA-Compatible" content="IE=edge"/><meta http-equiv="description" content="91考拉" />
	<link rel="stylesheet" href="<%=path%>/style/blue2.css"/>
    <link rel="stylesheet" href="<%=path%>/style/one.css"/>
    <link rel="stylesheet" href="<%=path%>/style/grid.css"/>
    <link rel="stylesheet" href="<%=path%>/style/nav.css"/>
    <link rel="stylesheet" href="<%=path%>/style/main.css"/>
    <link rel="stylesheet" href="<%=path%>/style/stan.css"/>
    <link rel="stylesheet" href="<%=path%>/style/heropage.css"/>
    <link rel="stylesheet" href="<%=path%>/style/liankao.css"/>
    <link rel="stylesheet" href="<%=path%>/style/black.css"/>
<script type="text/javascript" src="<%=path%>/js/jquery.js"></script>
<script type="text/javascript">
 $(function(){
	 $('#chongzhi').click(function(e){
		 e.preventDefault();
		 $.post('<%=path%>/student/chargeForTest.action', {code: $('#code').val()}, function(data){
			 alert(data);
			 if(data == 'success') {
				 alert('充值成功');	
				 $('#code').val('');
			 } else {
				 alert('充值失败');
			 }
			 
		 }, 'json');
	 });
	 
 })
</script>
<style type="text/css">
#chongzhi a{color: #fa9e64;} 
</style>
</head>
<body>
<jsp:include page="fullheadernewblack.jsp">
	<jsp:param value="3" name="cur"/>
</jsp:include>
<div class="content-back">

<div class="black-in-mid" style="height:220px; margin-top: 30px;"> 
	
	<div style="width: 990px; margin: 0 auto;">
		<h1>充值中心</h1>
		<p>考生充值界面，进行充值才能完成学科诊断哦。</p>
	</div>
</div>


<div id="content" class="fn-clear" style="margin-bottom: 20px; margin-top: -87px;">
	<div id="container" style="margin: 0 auto; padding: 0; margin-top: 0px; position: relative; top: 0; left: 0;">
        <div class="nice02 fn-left" style="width: 990px; box-shadow: 0 0 0 #fff; ">

		<img alt="" class="fn-left" src="<%=path%>/img/chongzhi.png" width="300px" style="margin-top: 80px;margin-left: 40px; margin-bottom: 80px;" />
		<div class="fn-right" style="margin-right: 100px; margin-top: 140px;">	
			<form action="">
				<span style="font-size: 16px;">充值卡号：</span><input id="code" style="font-size: 16px; height: 18px; width: 300px;border: solid;border-width: 2px;border-color: #F79061;" type="text" name="code" /><br>
				<input id="chongzhi" style="margin-left: 400px; margin-top: 70px;" type="submit" class="ui-button ui-button-lorange" value="点我充值" />
			</form>
		</div>
		
		</div>
		</div>
	</div>
	</div>
	<jsp:include page="stanfooter.jsp" />
</body>
</html>