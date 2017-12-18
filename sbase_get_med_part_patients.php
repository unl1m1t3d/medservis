<?php
require_once('settings.php');
if(!isset($_REQUEST['id']))
{
	exit;
}
	$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
	if($conn==false)
	die('Error establishing connection!');
	mysql_select_db('base_med');
	$query="SELECT patients.id,patients.name,patients.surname,patients.patronym
	FROM patients WHERE patients.med_part=".mysql_real_escape_string($_REQUEST['id']);

	$result=mysql_query($query);
	
	if($result==false)
	{
		mysql_close($conn);
		exit;
	}
	
	$n=mysql_num_rows($result);
	if($n<=0)
	{
		mysql_close($conn);
		exit;
	}
		$s="";
	while($row=mysql_fetch_array($result))
	{
			$s.=$row['surname'];
			if($row['name']!="")
			$s.=' '.substr_replace($row['name'],'.',2);
			if($row['patronym']!="")
			$s.=' '.substr_replace($row['patronym'],'.',2);
			$s.=";";
	}
	$s=substr_replace($s ,"",-1);
	echo $s;
?>