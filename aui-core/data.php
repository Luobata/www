<?php
$page = $_GET["page"];
$num = $_GET["num"];

switch( $page )
{
	case 1 :
		echo "{ \"code\" : \"1\", \"list\" : { \"src\" : [ \"images/1.jpg\", \"images/2.jpg\", \"images/3.jpg\", \"images/4.jpg\", \"images/5.jpg\", \"images/6.jpg\", \"images/7.jpg\", \"images/8.jpg\", \"images/9.jpg\" ], \"title\":[  \"这个是标题10\", \"这个是标题11\", \"这个是标题12\", \"这个是标题13\", \"这个是标题14\", \"这个是标题15\", \"这个是标题16\", \"这个是标题17\", \"这个是标题18\" ] } }";
	break;	
	
	case 2 :
		echo "{ \"code\" : \"1\", \"list\" : { \"src\" : [ \"images/1.jpg\", \"images/2.jpg\", \"images/3.jpg\", \"images/4.jpg\", \"images/5.jpg\", \"images/6.jpg\", \"images/7.jpg\", \"images/8.jpg\", \"images/9.jpg\" ], \"title\":[  \"这个是标题19\", \"这个是标题20\", \"这个是标题21\", \"这个是标题22\", \"这个是标题23\", \"这个是标题24\", \"这个是标题25\", \"这个是标题26\", \"这个是标题27\" ] } }";
	break;	
	
	case 3 :
		echo "{ \"code\" : \"1\", \"list\" : { \"src\" : [ \"images/1.jpg\", \"images/2.jpg\", \"images/3.jpg\", \"images/4.jpg\", \"images/5.jpg\", \"images/6.jpg\", \"images/7.jpg\", \"images/8.jpg\", \"images/9.jpg\" ], \"title\":[  \"这个是标题28\", \"这个是标题29\", \"这个是标题30\", \"这个是标题31\", \"这个是标题32\", \"这个是标题33\", \"这个是标题34\", \"这个是标题35\", \"这个是标题36\" ] } }";
	break;
	
	default : 
		echo "{\"code\":\"0\"}";
}

?>