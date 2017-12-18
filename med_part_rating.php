<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Врачи-партнеры - База "Медсервис"</title>
<script type="text/javascript" src="med_func.js"></script>
<script type="text/javascript" src="combo.js"></script>
<script type="text/javascript" src="calendar_ru.js"></script>
<script type="text/javascript" src="medecins.js"></script>
<script type="text/javascript" src="med_part.js"></script>
<script type="text/javascript" src="clinics.js"></script>
<script type="text/javascript" src="stations.js"></script>
<script type="text/javascript" src="patients.js"></script>
<script type="text/javascript" src="window_search.js"></script>
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="alert.js"></script>
<script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="combo.css" />
<script language="javascript" type="text/javascript">
	var request=null;
	var new_pat_id=0;
	var new_serv_id=0;
	var price=0;
	var payed=0;
	try 
		{
			request = new XMLHttpRequest();
		}	
		catch (trymicrosoft) 
		{
			try 
			{
				request = new ActiveXObject("Msxml2.XMLHTTP");
			}	
			catch (othermicrosoft) 
			{
				try 
				{
					request = new ActiveXObject("Microsoft.XMLHTTP");
				}	
				catch (failed) 
				{
					request=null;
				}
			}
		}
		if(request==null)
			alert("Error!");
</script>
</head>
<body>
<div class="main_fields">
	<h3 class="form_header">Рейтинг врачей-партнеров</h3>
	<div class="number">Найдено записей: <span id="number_of_entries"></span></div>
	<div class="number">Сумма наживок: <span id="summa_nazhivok"></span></div>
</div>
<div style="margin-left:100px">
<div>
		<div class="char_name">
		Показать записей:
		</div>
	</div>
	<input type="text" id="limit" value="50" SelectBoxOptions="все;50;100;1000;2000;5000"/>
</div>
	<?php

include("menu.php");
require_once('settings.php');
error_reporting(0);
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection! ').mysql_error();
mysql_select_db('base_med');
$query = "SELECT DISTINCT med_part.id,med_part.surname,med_part.name,med_part.patronym,med_part.contacts,
(SELECT COUNT(patients.id) from patients WHERE patients.med_part=med_part.id) as num_pat,
med_part.remark FROM (((med_part LEFT JOIN med_part_jobs ON med_part.id=med_part_jobs.id_med_part) 
LEFT JOIN dolzhnost ON med_part_jobs.id_dolzhnost=dolzhnost.id) 
LEFT JOIN clinics ON med_part_jobs.id_clinic=clinics.id)
LEFT JOIN nazhivki ON med_part.id=nazhivki.id_med_part ORDER BY num_pat DESC LIMIT 50";


$result=mysql_query($query);

if($result==false)
{
	header("Status: ".mysql_error($conn),true,400);
	mysql_close($conn);
	exit;
}
$summa_nazhivok = 0;
	echo '<div id="table_med_part" class="table_search"><table>';
	echo '<tr>
	<th>Фамилия</th>
	<th>Имя</th>
	<th>Отчество</th>
	<th>Места работы</th>
	<th>Контакты</th>
	<th>Наживки</th>
	<th>Кол-во пациентов</th>
	<th>Сумма, принесенная клинике</th>
	<th>Примечание</th>
	</tr>';
	$number = mysql_num_rows($result);
	while($row=mysql_fetch_array($result))
	{	
		echo '<tr>';
		echo '<td><a href="med_part.php?id='.$row['id'].'">'.$row['surname']."</a></td>";
		echo '<td><a href="med_part.php?id='.$row['id'].'">'.$row['name']."</a></td>";
		echo '<td><a href="med_part.php?id='.$row['id'].'">'.$row['patronym']."</a></td>";
		$query_job="SELECT clinics.name as clinics_name, clinics.address,dolzhnost.name as dolzhnost_name 
		FROM (med_part_jobs LEFT JOIN dolzhnost ON med_part_jobs.id_dolzhnost=dolzhnost.id) 
		LEFT JOIN clinics ON med_part_jobs.id_clinic=clinics.id WHERE med_part_jobs.id_med_part=".$row['id'];
		$result_job=mysql_query($query_job);
		if($result_job==false)
		{
			header("Status: ".mysql_error($conn),true,400);
			mysql_close($conn);
			exit;
		}
		echo '<td>';
		while($row_job=mysql_fetch_array($result_job))
		{
			echo '"'.$row_job['clinics_name'].'"';
			if($row_job['address']!="")
			echo ', '.$row_job['address'];
			if($row_job['dolzhnost_name']!="")
			echo ', '.$row_job['dolzhnost_name'];
			echo '<br/>';
		}
		echo "</td>";
		echo '<td>'.$row['contacts']."</td>";
		$query_nazhivki="SELECT summa, date 
		FROM nazhivki WHERE nazhivki.id_med_part=".$row['id'];
		
		if(isset($_REQUEST['s_data_nazhivki']))
		switch($_REQUEST['s_data_nazhivki'])
			{
				case 'less':
					$query_nazhivki.=sprintf(" AND date(nazhivki.date) < '%s'", mysql_real_escape_string($_REQUEST['data_nazhivki']));
					break;
				case 'more':
					$query_nazhivki.=sprintf(" AND date(nazhivki.date) > '%s'", mysql_real_escape_string($_REQUEST['data_nazhivki']));
					break;
				case 'fromto':
					$query_nazhivki.=sprintf(" AND date(nazhivki.date) > '%s' AND date(nazhivki.date) < '%s'", mysql_real_escape_string($_REQUEST['data_nazhivki']),mysql_real_escape_string($_REQUEST['to_data_nazhivki']));
					break;
				case 'equal':
					$query_nazhivki.=sprintf(" AND date(nazhivki.date)='%s'", mysql_real_escape_string($_REQUEST['data_nazhivki']));
					break;
				case 'notequal':
					$query_nazhivki.=sprintf(" AND not (date(nazhivki.date) = '%s')", mysql_real_escape_string($_REQUEST['data_nazhivki']));
					break;
				default:
					$query_nazhivki.=sprintf(" AND date(nazhivki.date)='%s'", mysql_real_escape_string($_REQUEST['data_nazhivki']));
					break;
			}
		
		$result_nazhivki=mysql_query($query_nazhivki);
		if($result_nazhivki==false)
		{
			header("Status: ".mysql_error($conn),true,400);
			mysql_close($conn);
			exit;
		}
		echo '<td>';
		while($row_nazhivki=mysql_fetch_array($result_nazhivki))
		{
			echo $row_nazhivki['summa'].'руб.';
			if($row_nazhivki['date']!="")
				echo ', '.preg_replace('/(\d+)-(\d+)-(\d+)/',"$3-$2-$1",$row_nazhivki['date']);
			else echo "дата неизвестна";
			$summa_nazhivok += $row_nazhivki['summa'];
			echo '<br/>';
		}
		
		echo "</td>";
		echo '<td>'.$row['num_pat']."</td>";
		echo '<td>';
		$conn_mssql=mssql_connect($_MSSQL_HOST,$_MSSQL_USERNAME,$_MSSQL_PASSWORD);
			if($conn_mssql==false)
				{
					echo('Error establishing connection!');
				}
			else
			{
				mssql_select_db('MyBase');
				$query_pat="SELECT id FROM patients WHERE patients.med_part=".$row['id'];
				$result_p=mysql_query($query_pat);
				
				if($result_p==false)
				{
					echo "Ошибка подключения к базе!";
					mysql_close($conn);
					exit;
				}
				if(mysql_num_rows($result_p)>0)
				{
					$query_sum='SELECT ISNULL(SUM(price),0) as sum_of_money
					FROM dbo.data_motconsu_billdet INNER JOIN dbo.patients ON dbo.patients.patients_id=dbo.data_motconsu_billdet.patients_id
					WHERE ';
					$st="";
					
					while($row_p=mysql_fetch_array($result_p))
					{
						$st.='dbo.patients.patients_id='.$row_p['id'].' OR ';
					}
					$st=substr_replace($st,"",-4);
					$query_sum.=$st;
					$result_sum=mssql_query($query_sum);
					if($result_sum==false)
					{	
						header("Status: ".mssql_get_last_message(),true,400);
						header("Query: ".$query_sum,true);
						mssql_close($conn_mssql);
						exit;
					}
					if($row_sum=mssql_fetch_array($result_sum))
					echo $row_sum['sum_of_money'];
				}
				mssql_close($conn_mssql);
			}
		echo "</td>";
		echo '<td>'.$row['remark']."</td>";
		echo "</tr>";
	
	}
	echo '</table>
	</div>';

mysql_close($conn);
?>
<script>
$("#summa_nazhivok").text('<?php echo $summa_nazhivok; ?>');
$("#number_of_entries").text('<?php echo $number; ?>');
createEditableSelect(document.getElementById("limit"));
$('.selectBox').click(search_med_part_rating);
</script>
</div>
</body>
</html>	
	