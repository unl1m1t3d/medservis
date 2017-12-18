<?php
require_once('settings.php');
error_reporting(E_ALL);
date_default_timezone_set('UTC');
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection!');
mysql_select_db("base_med");
if(!isset($_REQUEST["date"]))
{
	header("Status: ".mysql_error($conn),true,400);
	header("Error: no begin date!",true);	
	mysql_close($conn);
	exit;
}
if(!isset($_REQUEST["to_date"]))
{
	header("Status: ".mysql_error($conn),true,400);
	header("Error: no end date!",true);	
	mysql_close($conn);
	exit;
}
$query="SELECT SUM(pat_serv_med.payed) as income,serv_date FROM pat_serv_med WHERE pat_serv_med.serv_date>='".mysql_real_escape_string($_REQUEST["date"])."' AND pat_serv_med.serv_date<='".mysql_real_escape_string($_REQUEST["to_date"])."' GROUP BY serv_date";
$result=mysql_query($query);
header("Query: ".$query);
if($result==false)
{
	header("Query: ".$query,true);
	header("Status: ".mysql_error($conn),true,400);
	mysql_close($conn);
	exit;
}
$s="";
$n=0;
while($row=mysql_fetch_array($result))
{
	$date=DateTime::createFromFormat('Y-m-d|',$row['serv_date']);
	//header("Date".$n++.": ".$date->format('Y-m-d H:i:s:u'),true);
	if($date==false)
	{
	header("Date: ".$row['serv_date'],true);
	header("Status: ".mysql_error($conn),true,400);
	mysql_close($conn);
	exit;
	}
	$s.=($date->getTimestamp()*1000).'|'.$row['income'].';';
}
$s=substr_replace($s ,"",-1);
echo $s;
$query="SELECT SUM(pat_serv_med.payed) as income FROM pat_serv_med WHERE pat_serv_med.serv_date>='".mysql_real_escape_string($_REQUEST["date"])."' AND pat_serv_med.serv_date<='".mysql_real_escape_string($_REQUEST["to_date"])."'";
$result=mysql_query($query);
if($result==false)
{
	header("Query: ".$query,true);
	header("Status: ".mysql_error($conn),true,400);
	mysql_close($conn);
	exit;
}
if($row=mysql_fetch_array($result))
{
	header("Total_income:".$row['income'],true);
}
else
{
	header("Query: ".$query,true);
	header("Status: ".mysql_error($conn),true,400);
	mysql_close($conn);
	exit;
}
mysql_close($conn);
?>