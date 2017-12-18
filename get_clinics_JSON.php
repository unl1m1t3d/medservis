<?php
require_once('settings.php');
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection!');
mysql_select_db('base_med');
$query = "SELECT clinics.id, clinics.name, stations.name as station, clinics.address, clinics.contacts, clinics.remark, clinics.latitude, clinics.longitude FROM clinics LEFT JOIN stations ON clinics.metro=stations.id";
$keys=array("id","name","station","address","contacts","remark","longitude","latitude");
$result=mysql_query($query);
if($result==false)
{
	header("Status: ".mysql_error($conn),true,400);
	header("Query: ".$query,true);	
	mysql_close($conn);
	exit;
}
$clinics=array();
while($row=mysql_fetch_array($result))
{
	$clinic=array();
	foreach($keys as $key)
		$clinic[$key]=$row[$key];
	$clinics[]=$clinic;
}

echo json_encode($clinics);
?>