<?php
require_once('settings.php');
error_reporting(E_ALL);
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection!');
mysql_select_db('base_med');
if(!isset($_REQUEST["id"]))
{
	header("Error: no id given!",true);	
	mysql_close($conn);
	exit;
}
$query_del="DELETE FROM med_part_jobs WHERE id_clinic=".mysql_real_escape_string($_REQUEST["id"]);
	$result_del=mysql_query($query_del);
	if($result_del==false)
	{
		header("Query: ".$query_del,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
$query_del="DELETE FROM clinics WHERE id=".mysql_real_escape_string($_REQUEST["id"]);
	$result_del=mysql_query($query_del);
	if($result_del==false)
	{
		header("Query: ".$query_del,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
mysql_close($conn);
?>