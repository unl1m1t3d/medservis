<?php
require_once('settings.php');
error_reporting(E_ALL);
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
{
	header("Status: ".mysql_error($conn),true,400);
	mysql_close($conn);
	exit;
}
mysql_select_db("base_med");
$result=mysql_query(
	'
	SELECT name 
	FROM incomes_names ');
if($result==false)
{
	header("Status: ".mysql_error($conn),true,400);
	mysql_close($conn);
	exit;
}
$s="";
	while($row=mysql_fetch_array($result))
	{
			$s=$s.$row['name'].';';
	}
	$s=substr_replace($s ,"",-1);
	echo $s;
mysql_close($conn);
?>