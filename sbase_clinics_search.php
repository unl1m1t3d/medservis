<?php
require_once('settings.php');
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection!');
mysql_select_db('base_med');
$query = "SELECT clinics.id, clinics.name, stations.name as metro_name, clinics.address, clinics.contacts, clinics.remark FROM clinics LEFT JOIN stations ON clinics.metro=stations.id";
$st="";
if(isset($_REQUEST['s_name']))
switch($_REQUEST['s_name'])
	{
		case 'begin':
			$st.=sprintf(" clinics.name like '%s%%'", mysql_real_escape_string($_REQUEST['name']));
			$st.=' AND';
			break;
		case 'end':
			$st.=sprintf(" clinics.name like '%%%s'", mysql_real_escape_string($_REQUEST['name']));
			$st.=' AND';
			break;
		case 'cont':
			$st.=sprintf(" clinics.name like '%%%s%%'", mysql_real_escape_string($_REQUEST['name']));
			$st.=' AND';
			break;
		case 'notcont':
			$st.=sprintf(" clinics.name not like '%%%s%%'", mysql_real_escape_string($_REQUEST['name']));
			$st.=' AND';
			break;
		case 'equal':
			$st.=sprintf(" clinics.name='%s'", mysql_real_escape_string($_REQUEST['name']));
			$st.=' AND';
			break;
		case 'notequal':
			$st.=sprintf(" not (name = '%s')", mysql_real_escape_string($_REQUEST['name']));
			$st.=' AND';
			break;
		default:
			$st.=sprintf(" clinics.name like '%s%%'", mysql_real_escape_string($_REQUEST['name']));
			$st.=' AND';
			break;
	}
if(isset($_REQUEST['s_contacts']))
switch($_REQUEST['s_contacts'])
	{
		case 'begin':
			$st.=sprintf(" clinics.contacts like '%s%%'", mysql_real_escape_string($_REQUEST['contacts']));
			$st.=' AND';
			break;
		case 'end':
			$st.=sprintf(" clinics.contacts like '%%%s'", mysql_real_escape_string($_REQUEST['contacts']));
			$st.=' AND';
			break;
		case 'cont':
			$st.=sprintf(" clinics.contacts like '%%%s%%'", mysql_real_escape_string($_REQUEST['contacts']));
			$st.=' AND';
			break;
		case 'notcont':
			$st.=sprintf(" clinics.contacts not like '%%%s%%'", mysql_real_escape_string($_REQUEST['contacts']));
			$st.=' AND';
			break;
		case 'equal':
			$st.=sprintf(" clinics.contacts='%s'", mysql_real_escape_string($_REQUEST['contacts']));
			$st.=' AND';
			break;
		case 'notequal':
			$st.=sprintf(" not (contacts = '%s')", mysql_real_escape_string($_REQUEST['contacts']));
			$st.=' AND';
			break;
		default:
			$st.=sprintf(" clinics.contacts like '%s%%'", mysql_real_escape_string($_REQUEST['contacts']));
			$st.=' AND';
			break;
	}
if(isset($_REQUEST['s_address']))
switch($_REQUEST['s_address'])
	{
		case 'begin':
			$st.=sprintf(" clinics.address like '%s%%'", mysql_real_escape_string($_REQUEST['address']));
			$st.=' AND';
			break;
		case 'end':
			$st.=sprintf(" clinics.address like '%%%s'", mysql_real_escape_string($_REQUEST['address']));
			$st.=' AND';
			break;
		case 'cont':
			$st.=sprintf(" clinics.address like '%%%s%%'", mysql_real_escape_string($_REQUEST['address']));
			$st.=' AND';
			break;
		case 'notcont':
			$st.=sprintf(" clinics.address not like '%%%s%%'", mysql_real_escape_string($_REQUEST['address']));
			$st.=' AND';
			break;
		case 'equal':
			$st.=sprintf(" clinics.address='%s'", mysql_real_escape_string($_REQUEST['address']));
			$st.=' AND';
			break;
		case 'notequal':
			$st.=sprintf(" not (address = '%s')", mysql_real_escape_string($_REQUEST['address']));
			$st.=' AND';
			break;
		default:
			$st.=sprintf(" clinics.address like '%s%%'", mysql_real_escape_string($_REQUEST['address']));
			$st.=' AND';
			break;
	}
if(isset($_REQUEST['s_remark']))
switch($_REQUEST['s_remark'])
	{
		case 'begin':
			$st.=sprintf(" clinics.remark like '%s%%'", mysql_real_escape_string($_REQUEST['remark']));
			$st.=' AND';
			break;
		case 'end':
			$st.=sprintf(" clinics.remark like '%%%s'", mysql_real_escape_string($_REQUEST['remark']));
			$st.=' AND';
			break;
		case 'cont':
			$st.=sprintf(" clinics.remark like '%%%s%%'", mysql_real_escape_string($_REQUEST['remark']));
			$st.=' AND';
			break;
		case 'notcont':
			$st.=sprintf(" clinics.remark not like '%%%s%%'", mysql_real_escape_string($_REQUEST['remark']));
			$st.=' AND';
			break;
		case 'equal':
			$st.=sprintf(" clinics.remark='%s'", mysql_real_escape_string($_REQUEST['remark']));
			$st.=' AND';
			break;
		case 'notequal':
			$st.=sprintf(" not (remark = '%s')", mysql_real_escape_string($_REQUEST['remark']));
			$st.=' AND';
			break;
		default:
			$st.=sprintf(" clinics.remark like '%s%%'", mysql_real_escape_string($_REQUEST['remark']));
			$st.=' AND';
			break;
	}
if(isset($_REQUEST['s_metro']))
switch($_REQUEST['s_metro'])
	{
		case 'begin':
			$st.=sprintf(" stations.name like '%s%%'", mysql_real_escape_string($_REQUEST['metro']));
			$st.=' AND';
			break;
		case 'end':
			$st.=sprintf(" stations.name like '%%%s'", mysql_real_escape_string($_REQUEST['metro']));
			$st.=' AND';
			break;
		case 'cont':
			$st.=sprintf(" stations.name like '%%%s%%'", mysql_real_escape_string($_REQUEST['metro']));
			$st.=' AND';
			break;
		case 'notcont':
			$st.=sprintf(" stations.name not like '%%%s%%'", mysql_real_escape_string($_REQUEST['metro']));
			$st.=' AND';
			break;
		case 'equal':
			$st.=sprintf(" stations.name='%s'", mysql_real_escape_string($_REQUEST['metro']));
			$st.=' AND';
			break;
		case 'notequal':
			$st.=sprintf(" not (stations.name = '%s')", mysql_real_escape_string($_REQUEST['metro']));
			$st.=' AND';
			break;
		default:
			$st.=sprintf(" stations.name like '%s%%'", mysql_real_escape_string($_REQUEST['metro']));
			$st.=' AND';
			break;
	}
if($st!="")
{	
	$st=substr_replace($st,"",-4);
	$query.=" WHERE ".$st;
}
if(isset($_REQUEST['order']))
{
	$query.=sprintf(" order by %s", mysql_real_escape_string($_REQUEST['order']));
}
if(isset($_REQUEST['limit']))
{
	$query.=sprintf(" limit %s", mysql_real_escape_string($_REQUEST['limit']));
}
$result=mysql_query($query);
header("Query: ".$query,true);

if($result==false)
{
	header("Status: ".mysql_error($conn),true,400);
	header("Query: ".$query,true);	
	mysql_close($conn);
	exit;
}

	echo '<table>';
	echo '<tr>
	<th>Название</th>
	<th>Адрес</th>
	<th>Станция метро</th>
	<th>Контакты</th>
	<th>Примечание</th>
	</tr>';
	$n=mysql_num_rows($result);
	header('Number:'.$n,true);
	while($row=mysql_fetch_array($result))
	{	
		echo '<tr id="t_clinic'.$row['id'].'">';
			echo '<td><a href="clinics.php?id='.$row['id'].'">'.$row['name']."</a></td>";
			echo '<td>'.$row['address']."</td>"; 
			echo '<td>'.$row['metro_name']."</td>"; 
			echo '<td>'.$row['contacts']."</td>"; 
			echo '<td>'.$row['remark']."</td>"; 
		echo '</tr>';
	}
	echo '</table>';

mysql_close($conn);
?>