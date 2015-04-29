<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" x-undefined>
<html>
<head>
<title>shenbin</title>
</head>

<body>
<?php

  $s1=$_POST["message"];
  $s2=$_POST["name"];
  if(empty($s1) or empty($s2))
  {
     echo "请填写姓名或留言内容";
     echo "<br>";
     echo "<br>";
  }
  else
  {
	$str=$_POST["name"].":   ".$_POST["message"];
        $str=$str."\r\n";
chmod("snote.txt",0755);
        $fp=fopen("boss.txt","a");
        fwrite($fp,$str);
        fclose($fp); 
  }
?>


<?php
$data=file("boss.txt");
$n=count($data); 
for($I=$n-1;$I>=0;$I--)
{ 
echo $data[$I];
echo "<br>";
echo "<br>";
}
?>

</body>

</html>
