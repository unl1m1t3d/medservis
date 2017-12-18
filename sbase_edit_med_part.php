<?php
require_once('settings.php');
error_reporting(E_ALL);
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection!');
mysql_select_db('base_med');
$where=" WHERE ";
$data="UPDATE med_part SET ";
if(!isset($_REQUEST["id"]))
{
	header("Error: no id given!",true);
	header("Status: no id",true,400);
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

$i=0;
$id_med_part=mysql_real_escape_string($_REQUEST["id"]);
$query="DELETE FROM med_part_jobs WHERE id_med_part=".$id_med_part;
$result=mysql_query($query);
if($result==false)
{
	header("Query: ".$query,true);
	header("Status: ".mysql_error($conn),true,400);
	mysql_close($conn);
	exit;
}
while(isset($_REQUEST["clinic".$i]))
{
	$id_clinic=$_REQUEST['clinic'.$i];	
	if(isset($_REQUEST['dolzhnost'.$i]))
		$id_dolzhnost=$_REQUEST['dolzhnost'.$i];
	else $id_dolzhnost=-1;
	$query=sprintf('INSERT INTO med_part_jobs(id_med_part,id_clinic,id_dolzhnost) VALUES (%d,%d,%d)',$id_med_part,$id_clinic,$id_dolzhnost);
	$result=mysql_query($query);
	if($result==false)
	{
		header("Query: ".$query,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
	$i++;
}

$i=0;
$query="DELETE FROM nazhivki WHERE id_med_part=".$id_med_part;
$result=mysql_query($query);
if($result==false)
{
	header("Query: ".$query,true);
	header("Status: ".mysql_error($conn),true,400);
	mysql_close($conn);
	exit;
}
while(isset($_REQUEST["nazhivka".$i]))
{
	$nazhivka=$_REQUEST['nazhivka'.$i];	
	if(isset($_REQUEST['data_nazhivki'.$i]))
		$data_nazhivki=$_REQUEST['data_nazhivki'.$i];
	else $data_nazhivki="NULL";
	if(isset($_REQUEST['patient_didnot_come'.$i]))
		$patient_didnot_come=$_REQUEST['patient_didnot_come'.$i];
	else
		$patient_didnot_come = 0;
	$query=sprintf("INSERT INTO nazhivki(id_med_part, summa, date, patient_didnot_come) VALUES (%d,%d,'%s',%d)",$id_med_part,$nazhivka,$data_nazhivki,$patient_didnot_come);
	$result=mysql_query($query);
	if($result==false)
	{
		header("Query: ".$query,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
	$i++;
}

$n=0;
$data="";

	$query_delete="DELETE from charges where id_charge=1 AND id_employee=".mysql_real_escape_string($_REQUEST['id']);
	$result=mysql_query($query_delete);
	if($result==false)
	{
		header("Query: ".$query_delete,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
	$query_delete='DELETE from patients where ads=2 and med_part='.mysql_real_escape_string($_REQUEST['id']);
	$result=mysql_query($query_delete);
	if($result==false)
	{
		header("Query: ".$query_delete,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
while(isset($_REQUEST["patient".$n]))
{
	$query_delete='DELETE from patients where id='.mysql_real_escape_string($_REQUEST["patient".$n]);
	$result=mysql_query($query_delete);
	if($result==false)
	{
		header("Query: ".$query_delete,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
	$data="";
	$query_insert="INSERT INTO patients (id,ads,med_part";
	$data=" VALUES (".mysql_real_escape_string($_REQUEST["patient".$n]).',2,'.mysql_real_escape_string($_REQUEST['id']);
	if(isset($_REQUEST["surname".$n]))
	{
		$data.=sprintf(",'%s'",mysql_real_escape_string($_REQUEST["surname".$n]));
		$query_insert.=",surname";
	}
	if(isset($_REQUEST["name".$n]))
	{
		$data.=sprintf(",'%s'",mysql_real_escape_string($_REQUEST["name".$n]));
		$query_insert.=",name";
	}
	if(isset($_REQUEST["patronym".$n]))
	{
		$data.=sprintf(",'%s'",mysql_real_escape_string($_REQUEST["patronym".$n]));
		$query_insert.=",patronym";
	}
	if(isset($_REQUEST["date_of_coming".$n]))
	{
		$data.=sprintf(",'%s'",mysql_real_escape_string($_REQUEST["date_of_coming".$n]));
		$query_insert.=",date_of_coming";
	}
	if(isset($_REQUEST["anamnesis".$n]))
	{
		$data.=sprintf(",'%s'",mysql_real_escape_string($_REQUEST["anamnesis".$n]));
		$query_insert.=",anamnesis";
	}
	if(isset($_REQUEST["med_part_diagnoz".$n]))
	{
		$data.=sprintf(",'%s'",mysql_real_escape_string($_REQUEST["med_part_diagnoz".$n]));
		$query_insert.=",med_part_diagnoz";
	}
	$data.=")";
	$query_insert.=")";
	$result=mysql_query($query_insert.$data);
	header("Query".$n.": ".$query_insert.$data,true);
	if($result==false)
	{
		header("Query: ".$query_insert.$data,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
	$data="";
	$query_insert="INSERT INTO charges (id_employee,id_charge";
	$data=" VALUES (".mysql_real_escape_string($_REQUEST['id']).',1';
	if(isset($_REQUEST["sum".$n]))
	{
		$data.=sprintf(",%s",mysql_real_escape_string($_REQUEST["sum".$n]));
		$query_insert.=",sum";

		if(isset($_REQUEST["date".$n]))
		{
			$data.=sprintf(",'%s'",mysql_real_escape_string($_REQUEST["date".$n]));
			$query_insert.=",date_of_charge";
		}
		if(isset($_REQUEST["way".$n]))
		{
			$data.=sprintf(",%s",mysql_real_escape_string($_REQUEST["way".$n]));
			$query_insert.=",id_way";
		}
		$data.=sprintf(",%s",mysql_real_escape_string($_REQUEST["patient".$n]));
		$query_insert.=",extra_id";
	}
	$data.=")";
	$query_insert.=")";
	$result=mysql_query($query_insert.$data);
	if($result==false)
	{
		header("Query: ".$query_insert.$data,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
	
	$n++;
}

mysql_close($conn);
?>