<?php
require_once('settings.php');
error_reporting(E_ALL);
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection!');
mysql_select_db('base_med');
$where=" WHERE ";
$data="UPDATE patients SET ";
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
if(isset($_REQUEST["date_of_birth"]))
{
	$data.=sprintf("date_of_birth='%s',",mysql_real_escape_string($_REQUEST["date_of_birth"]));
}
if(isset($_REQUEST["sex"]))
{
	$data.=sprintf("sex=%s,",mysql_real_escape_string($_REQUEST["sex"]));
}
if(isset($_REQUEST["phone"]))
{
	$data.=sprintf("phone='%s',",mysql_real_escape_string($_REQUEST["phone"]));
}
if(isset($_REQUEST["email"]))
{
	$data.=sprintf("email='%s',",mysql_real_escape_string($_REQUEST["email"]));
}
if(isset($_REQUEST["ads"]))
{
	$data.=sprintf("ads=%s,",mysql_real_escape_string($_REQUEST["ads"]));
	if($_REQUEST["ads"]==2)
	if(isset($_REQUEST["med_part"]))
	{
		$query_del="DELETE FROM charges WHERE id_charge=1 AND id_employee=".mysql_real_escape_string($_REQUEST["med_part"]).' AND extra_id='.mysql_real_escape_string($_REQUEST["id"]);
		$result_del=mysql_query($query_del);
		if($result_del==false)
		{
			header("Query: ".$query_del,true);
			header("Status: ".mysql_error($conn),true,400);
			mysql_close($conn);
			exit;
		}
		$query_insert="INSERT INTO charges (id_charge,private_or_public,id_employee,extra_id";
		$insert_values="VALUES (1,0,".mysql_real_escape_string($_REQUEST["med_part"]).','.mysql_real_escape_string($_REQUEST["id"]);
		if(isset($_REQUEST["summa_med_part"]))
		{
			$sum=mysql_real_escape_string($_REQUEST["summa_med_part"]);
			if($sum>=0)
			{
				$query_insert.=",sum";
				$insert_values.=sprintf(",%s",$sum);
			}
			if(isset($_REQUEST["date_of_charge"]))
			{
				$date_of_charge=mysql_real_escape_string($_REQUEST["date_of_charge"]);
				$query_insert.=",date_of_charge";
				$insert_values.=sprintf(",'%s'",$date_of_charge);
			}
			if(isset($_REQUEST["way"]))
			{
				$way=mysql_real_escape_string($_REQUEST["way"]);
				$query_insert.=",id_way";
				$insert_values.=sprintf(",%s",$way);
			}
			$query_insert.=') '.$insert_values.=')';
			$result_insert=mysql_query($query_insert);
			if($result_insert==false)
			{
				header("Query: ".$query_insert,true);
				header("Status: ".mysql_error($conn),true,400);
				mysql_close($conn);
				exit;
			}
		}
		$data.=sprintf("med_part=%d,",mysql_real_escape_string($_REQUEST["med_part"]));
	}
}
if(isset($_REQUEST["date_of_coming"]))
{
	$data.=sprintf("date_of_coming='%s',",mysql_real_escape_string($_REQUEST["date_of_coming"]));
}
if(isset($_REQUEST["has_discount_card"]))
{
	$data.=sprintf("has_discount_card='%s',",mysql_real_escape_string($_REQUEST["has_discount_card"]));
}
if(isset($_REQUEST["remark"]))
{
	$data.=sprintf("remark='%s',",mysql_real_escape_string($_REQUEST["remark"]));
}
if(isset($_REQUEST["anamnesis"]))
{
	$data.=sprintf("anamnesis='%s',",mysql_real_escape_string($_REQUEST["anamnesis"]));
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