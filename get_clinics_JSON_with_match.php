<?php
require_once('settings.php');
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection!');
mysql_select_db('base_med');
$query = "SELECT clinics.id, clinics.name, stations.name as station, clinics.address, clinics.contacts, clinics.remark, clinics.latitude, clinics.longitude FROM clinics LEFT JOIN stations ON clinics.metro=stations.id";
$keys=array("id","name","station","address","contacts","remark");
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
	$matches=array();
	preg_match_all('/\b((м(етро)?|г(ород|ор)?)\b[\. ]*[\s\w\-]*)?(ул(ица)?|б(-р|ул|ульвар)?|ш(оссе)?|п(р|роезд|-д|ер|ереулок|роспект)?)[,\.\s\w-]*д(ом)?[\s\.]*\d{1,3}[,\.\s]*([АБВГЕабвге][^А-я])?[,\.\s]*((\/|с(тр|троение)?|к(в|ар|арт|артира|орп|орпус|ор)?)[\.\s]*\d+)?/ui',$clinic['address'],$matches);
	//preg_match_all('/((м(етро|\.|\s)|г(ород|ор|\.|\s))[,\.\s\w\-]*)?(ул(ица)?|б(-р|ул|ульвар)?|ш(оссе)?|п(р|роезд|-д|ер|ереулок|роспект)?)[,\.\s\w-]*д(ом)?[\s\.]*\d{1,3}[,\.\s]*([АБВГЕабвге][^А-я])?[,\.\s]*((\/|с(тр|троение)?|к(в|ар|арт|артира|орп|орпус|ор)?)[\.\s]*\d+)?/ui',$clinic['address'],$matches);
	$clinic['match']=$matches[0];
	$clinics[]=$clinic;
}

echo json_encode($clinics);
?>