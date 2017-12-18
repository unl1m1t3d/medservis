<?php
require_once('settings.php');
error_reporting(E_ALL);
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection!');
mysql_select_db("base_med");
$result=mysql_query(
	'
	SELECT id, surname, name, patronym 
	FROM employees WHERE employees.dolzhnost=1');
if($result==false)
{
	die('Error in the query!');
}
$n=mysql_num_rows($result);
if($n==false)
{
	echo mysql_error($conn);
}
else
{	$s="";
	while($row=mysql_fetch_array($result))
	{
			$s.=$row['id']."|";
			$s.=$row['surname'];
			if($row['name']!="")
			$s.=' '.substr_replace($row['name'],'.',2);
			if($row['patronym']!="")
			$s.=' '.substr_replace($row['patronym'],'.',2);
			$s.=";";
	}
	$s=substr_replace($s ,"",-1);
	echo $s;
}
mysql_close($conn);
?>