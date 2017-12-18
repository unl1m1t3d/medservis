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
$query="SELECT id FROM patients WHERE med_part=".mysql_real_escape_string($_REQUEST["id"]);
$result=mysql_query($query);
if($result==false)
{
	header("Query: ".$query,true);
	header("Status: ".mysql_error($conn),true,400);
	mysql_close($conn);
	exit;
}
while($row=mysql_fetch_array($result))
{
	$query_upd="UPDATE patients SET med_part=NULL,ads=-1 WHERE id=".$row["id"];
	$result_upd=mysql_query($query_upd);
	if($result_upd==false)
	{
		header("Query: ".$query_upd,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
}
$query_del="DELETE FROM charges WHERE id_charge=1 AND id_employee=".mysql_real_escape_string($_REQUEST["id"]);
	$result_del=mysql_query($query_del);
	if($result_del==false)
	{
		header("Query: ".$query_del,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
$query_del="DELETE FROM med_part_jobs WHERE id_med_part=".mysql_real_escape_string($_REQUEST["id"]);
	$result_del=mysql_query($query_del);
	if($result_del==false)
	{
		header("Query: ".$query_del,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
$query_del="DELETE FROM nazhivki WHERE id_med_part=".mysql_real_escape_string($_REQUEST["id"]);
	$result_del=mysql_query($query_del);
	if($result_del==false)
	{
		header("Query: ".$query_del,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
$query_del="DELETE FROM med_part WHERE id=".mysql_real_escape_string($_REQUEST["id"]);
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