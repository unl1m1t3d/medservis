<?php
require_once('settings.php');
error_reporting(E_ALL);
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection!');
mysql_select_db('base_med');
$where=" WHERE ";
$data="UPDATE employees SET ";
if(!isset($_REQUEST["id"]))
{
	header("Error: no id given!",true);	
	mysql_close($conn);
	exit;
}
else
{
	$where.=sprintf("id=%d",mysql_real_escape_string($_REQUEST["id"]));
}
if(isset($_REQUEST["surname"]))
{
	$data.=sprintf("surname='%s',",mysql_real_escape_string($_REQUEST["surname"]));
}
if(isset($_REQUEST["name"]))
{
	$data.=sprintf("name='%s',",mysql_real_escape_string($_REQUEST["name"]));
}
if(isset($_REQUEST["patronym"]))
{
	$data.=sprintf("patronym='%s',",mysql_real_escape_string($_REQUEST["patronym"]));
}
if(isset($_REQUEST["contacts"]))
{
	$data.=sprintf("contacts='%s',",mysql_real_escape_string($_REQUEST["contacts"]));
}
if(isset($_REQUEST["remark"]))
{
	$data.=sprintf("remark='%s',",mysql_real_escape_string($_REQUEST["remark"]));
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