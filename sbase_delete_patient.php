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
$query="SELECT pat_serv_med.id FROM pat_serv_med,patients WHERE pat_serv_med.id_pat=".mysql_real_escape_string($_REQUEST["id"]);
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
	$query_del="DELETE FROM drugs_used WHERE id_serv=".$row["id"];
	$result_del=mysql_query($query_del);
	if($result_del==false)
	{
		header("Query: ".$query_del,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}

	$query_del="DELETE FROM pat_serv_med WHERE id=".$row["id"];
	$result_del=mysql_query($query_del);
	if($result_del==false)
	{
		header("Query: ".$query_del,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
}

$query_del="DELETE FROM patients WHERE id=".mysql_real_escape_string($_REQUEST["id"]);
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