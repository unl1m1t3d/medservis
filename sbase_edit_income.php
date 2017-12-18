<?php
require_once('settings.php');
error_reporting(E_ALL);
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection!');
mysql_select_db('base_med');
$where=" WHERE ";
$data="UPDATE incomes SET ";
if(!isset($_REQUEST["id"]))
{
	header("Error: no id given!",true);	
	mysql_close($conn);
	exit;
}
else
{
	$where.=sprintf("id=%d",$_REQUEST["id"]);
}
if(isset($_REQUEST["id_income"]))
{
	$data.=sprintf("id_income=%s,",mysql_real_escape_string($_REQUEST["id_income"]));
}
if(isset($_REQUEST["date_of_income"]))
{
	$data.=sprintf("date_of_income='%s',",mysql_real_escape_string($_REQUEST["date_of_income"]));
}
if(isset($_REQUEST["sum"]))
{
	$data.=sprintf("sum=%s,",mysql_real_escape_string($_REQUEST["sum"]));
}
if(isset($_REQUEST["remark"]))
{
	$data.=sprintf("remark='%s',",mysql_real_escape_string($_REQUEST["remark"]));
}
if(isset($_REQUEST["private_or_public"]))
{
	$data.=sprintf("private_or_public=%s,",mysql_real_escape_string($_REQUEST["private_or_public"]));
}

$data=substr_replace($data,"",-1);
$query=$data.$where;
	
	$result=mysql_query($query);

if($result==false)
{
	header("Query: ".$query,true);
	header("Status: ".mysql_error($conn),true,400);
	mysql_close($conn);
	exit;
}
mysql_close($conn);
?>