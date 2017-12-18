<?php
require_once('settings.php');
error_reporting(E_ALL);
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection!');

$db=mysql_select_db('base_med',$conn);
if($db==false)
{
	die('Error! '.mysql_error($conn));
}
$result=mysql_query(
	'SELECT patients.surname,patients.name,patients.patronym,services.name as serv_name,pat_serv_med.serv_date,pat_serv_med.price,pat_serv_med.diagnoz
	FROM (pat_serv_med INNER JOIN services ON pat_serv_med.id_serv=services.id) INNER JOIN patients ON pat_serv_med.id_pat=patients.id');
if($result==false)
{
	die('Error in the query! '.mysql_error($conn));
}
$n=mysql_num_rows($result);
if($n==false)
{
	echo mysql_error($conn);
}
else
{
	print '<table class="pat_serv_med">';
	print '<tr>';
		print '<td>';
			print 'Фамилия';
		print '</td>';
		print '<td>';
			print 'Имя';
		print '</td>';
		print '<td>';
			print 'Отчество';
		print '</td>';
		print '<td>';
			print 'Услуга';
		print '</td>';
		print '<td>';
			print 'Дата оказания услуги';
		print '</td>';
		print '<td>';
			print 'Стоимость';
		print '</td>';
		print '<td>';
			print 'Диагноз';
		print '</td>';
	print '</tr>';
	while($row=mysql_fetch_array($result))
	{
		print '<tr>';
			echo '<td> '.$row['surname'].'</td>';
			echo '<td> '.$row['name'].'</td>';
			echo '<td> '.$row['patronym'].'</td>';
			echo '<td> '.$row['serv_name'].'</td>';
			echo '<td> '.$row['serv_date'].'</td>';
			echo '<td> '.$row['price'].'</td>';
			echo '<td> '.$row['diagnoz'].'</td>';
			//echo '<td>'.$row[''].'</td>';
		print '</tr>';
	}
	print '</table>';
}
mysql_close($conn);
?>