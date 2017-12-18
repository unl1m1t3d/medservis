<?php
require_once('settings.php');
error_reporting(E_ALL);
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection!');
mysql_select_db("base_med");
$result=mysql_query(
	'
	SELECT id, surname, name, patronym FROM med_part');
if($result==false)
{
	die('Error in the query!');
}
$n=mysql_num_rows($result);
if($n==false)
{
	echo mysql_error($conn);
}
else
{	
	$s="";
	while($row=mysql_fetch_array($result))
	{
			$s.=$row['id'].'|';
			$s.=$row['surname'];
			if($row['name']!="")
			$s.=' '.substr_replace($row['name'],'.',2);
			if($row['patronym']!="")
			$s.=' '.substr_replace($row['patronym'],'.',2);

			$query_jobs='SELECT clinics.name 
			FROM ((med_part INNER JOIN med_part_jobs ON med_part.id=med_part_jobs.id_med_part) INNER JOIN clinics ON med_part_jobs.id_clinic=clinics.id) WHERE med_part.id='.$row['id'];
			$result_jobs=mysql_query($query_jobs);
			if(!$result_jobs)
			{
				header("Query: ".$query_jobs,true);
				header("Status: ".mysql_error($conn),true,400);
				mysql_close($conn);
				exit;
			}
			while($row_jobs=mysql_fetch_array($result_jobs))
			{
				$s.=', '.$row_jobs['name'];
			}
			
			$s.=";";
	}
	$s=substr_replace($s ,"",-1);
	echo $s;
}
mysql_close($conn);
?>