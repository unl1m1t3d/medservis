<?php
require_once('settings.php');
error_reporting(E_ALL);
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection!');
mysql_select_db('base_med');
$where=" WHERE ";
$data="UPDATE pat_serv_med SET ";
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
if(isset($_REQUEST["id_serv"]))
{
	$data.=sprintf("id_serv=%s,",mysql_real_escape_string($_REQUEST["id_serv"]));
}
if(isset($_REQUEST["id_med"]))
{
	$data.=sprintf("id_med=%s,",mysql_real_escape_string($_REQUEST["id_med"]));
}
if(isset($_REQUEST["id_discount"]))
{
	$data.=sprintf("id_discount=%s,",mysql_real_escape_string($_REQUEST["id_discount"]));
}
if(isset($_REQUEST["value_of_discount"]))
{
	$data.=sprintf("value_of_discount=%s,",mysql_real_escape_string($_REQUEST["value_of_discount"]));
}
if(isset($_REQUEST["is_percent"]))
{
	$data.=sprintf("is_percent=%s,",mysql_real_escape_string($_REQUEST["is_percent"]));
}
if(isset($_REQUEST["serv_date"]))
{
	$data.=sprintf("serv_date='%s',",mysql_real_escape_string($_REQUEST["serv_date"]));
}
if(isset($_REQUEST["payed"]))
{
	$data.=sprintf("payed=%s,",mysql_real_escape_string($_REQUEST["payed"]));
}
if(isset($_REQUEST["price"]))
{
	$data.=sprintf("price=%s,",mysql_real_escape_string($_REQUEST["price"]));
}
if(isset($_REQUEST["diagnoz"]))
{
	$data.=sprintf("diagnoz='%s',",mysql_real_escape_string($_REQUEST["diagnoz"]));
}
if(isset($_REQUEST["remark"]))
{
	$data.=sprintf("remark='%s',",mysql_real_escape_string($_REQUEST["remark"]));
}
if(isset($_REQUEST["is_debt"]))
{
	$data.=sprintf("is_debt=%s,",mysql_real_escape_string($_REQUEST["is_debt"]));
}
if(isset($_REQUEST["date_debt_payed"]))
{
	$data.=sprintf("date_debt_payed='%s',",mysql_real_escape_string($_REQUEST["date_debt_payed"]));
}
if(isset($_REQUEST["debt"]))
{
	$data.=sprintf("debt=%s,",mysql_real_escape_string($_REQUEST["debt"]));
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
$id_serv=mysql_real_escape_string($_REQUEST['id']);
$query="DELETE FROM drugs_used WHERE id_serv=".$id_serv;
	$result=mysql_query($query);
	if($result==false)
		{
			header("Query: ".$query,true);
			header("Status: ".mysql_error($conn),true,400);
			mysql_close($conn);
			exit;
		}
if(isset($_REQUEST["drugs"]))
{
	$drugs=preg_split("/\|/",$_REQUEST["drugs"]);
	for($i=0;$i<count($drugs);$i++)
	{
		$drugs[$i]=preg_split('/;/',$drugs[$i]);
	}
	$fields="INSERT INTO drugs_used(id_serv,id_drug,quantity,ed_izm) VALUES ";
	for($i=0;$i<count($drugs);$i++)
	{
		$data=sprintf("(%s,%s,%s,'%s')",$id_serv,$drugs[$i][0],$drugs[$i][1],$drugs[$i][2]);
		$query=$fields.$data;
		$result=mysql_query($query);
		if($result==false)
		{
			header("Query: ".$query,true);
			header("Status: ".mysql_error($conn),true,400);
			mysql_close($conn);
			exit;
		}
	}
}
mysql_close($conn);
?>