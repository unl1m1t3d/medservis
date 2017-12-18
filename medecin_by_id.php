<?php
require_once('settings.php');
if(!isset($_GET['id']))
{
	echo "Не задан id врача!";
	exit;
}
	$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
	if($conn==false)
	die('Error establishing connection!');
	mysql_select_db('base_med');
	$query = "SELECT id,name,surname,patronym,contacts,(SELECT COUNT(DISTINCT id_pat) from pat_serv_med WHERE pat_serv_med.id_med=employees.id) as num_pat,(SELECT SUM(pat_serv_med.payed) FROM pat_serv_med WHERE pat_serv_med.id_med=employees.id) as sum_of_money,(SELECT COUNT(pat_serv_med.id) from pat_serv_med WHERE pat_serv_med.id_med=employees.id) AS num_serv,remark FROM employees WHERE employees.dolzhnost=1 AND employees.id=".mysql_real_escape_string($_GET['id']);
	
	$result=mysql_query($query);
	
	if($result==false)
	{
		echo "Ошибка подключения к базе!";
		mysql_close($conn);
		exit;
	}
	$n=mysql_num_rows($result);
	if($n<=0)
	{
		echo "Врач с id ".$_GET['id']." не найден!";
	}
	if($row=mysql_fetch_array($result))
	{
		echo '<div class="main_fields">';
		echo '<h3 class="form_header">Врач №'.$_GET['id'].'</h3>';
		echo '<div>Фамилия:';
		echo $row['surname'].'</div>';
		echo '<div>Имя:';
		echo $row['name'].'</div>';
		echo '<div>Отчество:';
		echo $row['patronym'].'</div>';
		echo '<div>Контакты:';
		echo $row['contacts'].'</div>';
		echo '<div>Количество пациентов:';
		echo $row['num_pat'].'</div>';
		echo '<div>Количество услуг:';
		echo $row['num_serv'].'</div>';
		echo '<div>Сумма, принесенная клинике:';
		echo $row['sum_of_money'].'</div>';
		echo '<div>Примечание:';
		echo $row['remark'].'</div>';
	}
	//Таблица услуг этого врача:
	$query_serv='SELECT pat_serv_med.id as psm_id,services.name as serv_name,patients.id as pat_id,patients.name as pat_name,patients.surname,patients.patronym,pat_serv_med.serv_date,pat_serv_med.price,
			pat_serv_med.payed,pat_serv_med.is_debt,pat_serv_med.debt,pat_serv_med.date_debt_payed,pat_serv_med.diagnoz,pat_serv_med.remark
			FROM services,pat_serv_med,patients
			WHERE services.id=pat_serv_med.id_serv AND patients.id=pat_serv_med.id_pat AND pat_serv_med.id_med='.mysql_real_escape_string($_GET['id']);
	$result_serv=mysql_query($query_serv);
	header("Query: ".$query_serv,true);

if($result_serv==false)
{
	header("Status: ".mysql_error($conn),true,400);
	header("Query: ".$query_serv,true);	
	mysql_close($conn);
	exit;
}
	echo '<div class="table_search">';
	echo '<table id="table_serv">';
	echo '<tr>
	<th>Имя услуги</th>
	<th>Пациент</th>
	<th>Дата</th>
	<th>Стоимость</th>
	<th>Оплачено</th>
	<th>Долг</th>
	<th>Сумма долга</th>
	<th>Дата оплаты долга</th>
	<th>Диагноз</th>
	<th>Примечание к услуге</th>
	<th>Скидки</th>
	<th>Лекарства</th>
	</tr>';
	
		while($row_serv=mysql_fetch_array($result_serv))
				{
					echo "<tr>";
					echo '<td id="t_name"><a href="services.php?id='.$row_serv['psm_id'].'">'.$row_serv['serv_name'].'</a></td>';
					echo '<td><a href="patients.php?id='.$row_serv['pat_id'].'">'.$row_serv['surname'].' '.$row_serv['pat_name'].' '.$row_serv['patronym'].' '.'</a></td>';
					echo '<td id="t_serv_date">'.preg_replace("/(\d+)-(\d+)-(\d+)/","$3-$2-$1",$row_serv['serv_date']).'</td>';
					echo '<td id="t_price" >'.$row_serv['price'].'</td>';
					echo '<td id="t_payed" >'.$row_serv['payed'].'</td>';
					echo '<td id="t_is_debt">'.$row_serv['is_debt'].'</td>';
					echo '<td id="t_debt">'.$row_serv['debt'].'</td>';
					echo '<td id="t_date_debt_payed">'.preg_replace("/(\d+)-(\d+)-(\d+)/","$3-$2-$1",$row_serv['date_debt_payed']).'</td>';
					echo '<td id="t_diagnoz">'.$row_serv['diagnoz'].'</td>';
					echo '<td id="t_remark">'.$row_serv['remark'].'</td>';
					
						//ищем все скидки и выводим их
						
						$query_discount="SELECT discounts.id,discounts.name,discounts.is_percent,discounts.value,discounts_used.summa
						from discounts_used,discounts
						WHERE discounts.id=discounts_used.id_disc AND discounts_used.id_serv=".$row_serv['psm_id'];
						$result_discount=mysql_query($query_discount);
						if($result_discount==false)
						{	
							header("Status: ".mysql_error($conn),true,400);
							header("Query: ".$query_discount,true);
							mysql_close($conn);
							exit;
						}
						echo '<td id="t_discounts'.$row_serv['psm_id'].'">';
						while($row_discount=mysql_fetch_array($result_discount))
							{
								echo '<a href="discounts.php?id='.$row_discount['id'].'">'.$row_discount['name'].':</a>';
								echo 'Скидка '.$row_discount['value'];
								if($row_discount['is_percent']==0)echo " руб.";
								else echo ' %';
								echo 'Сумма скидки: '.$row_discount['summa'].' руб.';
							}
						echo "</td>";
						//ищем все лекарства и выводим их
						$query_drug="SELECT drugs.id,drugs.name,drugs_used.quantity,drugs_used.ed_izm
						from drugs_used,drugs
						WHERE drugs.id=drugs_used.id_drug AND drugs_used.id_serv=".$row_serv['psm_id'];
						$result_drug=mysql_query($query_drug);
						if($result_drug==false)
						{	
							header("Status: ".mysql_error($conn),true,400);
							header("Query: ".$query_drug,true);
							mysql_close($conn);
							exit;
						}
						echo '<td id="t_drugs'.$_GET['id'].'">';
							while($row_drug=mysql_fetch_array($result_drug))
							{
								echo '<a href="drugs.php?id='.$row_drug['id'].'">'.$row_drug['name'].':</a>';
								echo 'Израсходовано: '.$row_drug['quantity'].' '.$row_drug['ed_izm'];
							}
						echo "</td>";
					echo "</tr>";
		
				}
			echo "</table>";
			echo '</div>';
	mysql_close($conn);
?>
<div class="buttons">
<input type="button" id="edit" value="Редактировать" onClick="location.href+='&act=edit'"/>
<input type="button" id="delete" value="Удалить врача" onClick="if(confirm('Вы действительно хотите удалить врача <?php echo $row["surname"].' '.$row["name"].' '.$row["patronym"];?>?\nОтменить данное действие будет невозможно.'))if(delete_medecin(<?php echo $_GET['id'];?>)>=0)location.href='<?php echo $_SERVER["HTTP_REFERER"];?>';"/>
</div>
</div>