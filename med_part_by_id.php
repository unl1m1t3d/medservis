<?php
require_once('settings.php');
date_default_timezone_set('UTC');
if(!isset($_GET['id']))
{
	echo "Не задан id врача-партнера!";
	exit;
}
	$summa_nazhivok = 0;
	$money_for_patients = 0;
	
	$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
	if($conn==false)
	die('Error establishing connection!');
	mysql_select_db('base_med');
	$query = "SELECT med_part.id,med_part.surname,med_part.name,med_part.patronym,med_part.contacts,
	(SELECT COUNT(patients.id) from patients WHERE patients.med_part=med_part.id) as num_pat,
	med_part.remark FROM med_part WHERE med_part.id=".mysql_real_escape_string($_GET['id']);
	
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
		echo "Врач-партнер с id ".$_GET['id']." не найден!";
		mysql_close($conn);
		exit;
	}
	if($row=mysql_fetch_array($result))
	{
		echo '<div class="main_fields">';
		echo '<h3 class="form_header">Врач-партнер №'.$_GET['id']."</h3>";
		echo '<div>Фамилия: ';
		echo $row['surname'].'</div>';
		echo '<div>Имя: ';
		echo $row['name'].'</div>';
		echo '<div>Отчество: ';
		echo $row['patronym'].'</div>';
		
		$query_job="SELECT clinics.id, clinics.name as clinics_name, address, dolzhnost.name as dolzhnost_name 
		FROM (med_part_jobs LEFT JOIN dolzhnost ON med_part_jobs.id_dolzhnost=dolzhnost.id) 
		LEFT JOIN clinics ON med_part_jobs.id_clinic=clinics.id WHERE med_part_jobs.id_med_part=".$row['id'];
		$result_job=mysql_query($query_job);
		if($result_job==false)
		{
			header("Status: ".mysql_error($conn),true,400);
			mysql_close($conn);
			exit;
		}
		
		echo '<div>Местa работы:<ul>';
		while($row_job=mysql_fetch_array($result_job))
		{
			echo '<li><a href="clinics.php?id='.$row_job['id'].'">"'.$row_job['clinics_name'].'"';
			if($row_job['address']!="")
			echo ', '.$row_job['address'];
			if($row_job['dolzhnost_name']!="")
			echo ', '.$row_job['dolzhnost_name'];
			echo '</a></li>';
		}
		echo '</ul></div>';
		$query_nazhivki="SELECT nazhivki.date, nazhivki.summa, patient_didnot_come
		FROM nazhivki WHERE nazhivki.id_med_part=".$row['id'];
		$result_nazhivki=mysql_query($query_nazhivki);
		if($result_nazhivki!=false)
		{
			$n=mysql_num_rows($result_nazhivki);
			echo '<div>Наживки:';
			if($n==0) echo " нет";
			else echo '<ul>';
			while($row_nazhivki=mysql_fetch_array($result_nazhivki))
			{
				$summa_nazhivok+=$row_nazhivki['summa'];
				echo '<li>'.$row_nazhivki['summa'].' руб., '.preg_replace("/(\d+)-(\d+)-(\d+)/","$3-$2-$1",$row_nazhivki['date']);
				if($row_nazhivki['patient_didnot_come'] == 1)
					echo ", пациент не пришел";
				echo '</li>';
				
			}
			if($n!=0) echo '</ul>';
			echo '</div>';
		}
		echo '<div>Общая сумма наживок: '.$summa_nazhivok.'</div>';
		echo '<div>Контакты: ';
		echo $row['contacts'].'</div>';
		echo '<div>Сумма, принесенная клинике: ';
		$conn_mssql=mssql_connect($_MSSQL_HOST,$_MSSQL_USERNAME,$_MSSQL_PASSWORD);
			if($conn_mssql==false)
				{
					echo('Error establishing connection!');
				}
			else
			{
				mssql_select_db('MyBase');
				$query_pat="SELECT id FROM patients WHERE patients.med_part=".mysql_real_escape_string($_GET['id']);
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
		echo '</div>';
		echo '<div>Количество пациентов: ';
		echo $row['num_pat'].'</div>';
		echo '<div>Примечание: ';
		echo $row['remark'].'</div>';
	}?>
<div class="buttons">
<input type="button" id="edit" value="Редактировать" onClick="location.href+='&act=edit'"/>
<input type="button" id="delete" value="Удалить врача-партнера" onClick="if(confirm('Вы действительно хотите удалить врача-партнера <?php echo $row["surname"].' '.$row["name"].' '.$row["patronym"];?>?\nОтменить данное действие будет невозможно.'))if(delete_med_part(<?php echo $_GET['id'];?>)>=0)location.href='<?php echo $_SERVER["HTTP_REFERER"];?>';"/>
</div>
<?php
/* 	
	echo '<div class="table_search">';
	echo '<table>';
	echo '<tr>
	<th>Сумма врачу за пациента</th>
	<th>Дата выдачи суммы</th>
	<th>Способ оплаты</th>
	</tr>';
	
	$query_paid="SELECT charges.sum,charges.date_of_charge,ways_of_paying.name as way
	FROM charges LEFT JOIN ways_of_paying ON ways_of_paying.id=charges.id_way
	WHERE charges.id_employee=".mysql_real_escape_string($_GET['id'])." AND charges.id_charge=1";
	$result_paid=mysql_query($query_paid);
	
	if($result_paid==false)
	{
		echo "Ошибка подключения к базе!";
		mysql_close($conn);
		exit;
	}
	if(mysql_num_rows($result_paid)<=0)
	{
		echo '<tr><td colspan="3">Пока врачу никто ничего не платил...</td></tr>';
	}
	else
	while($row_paid=mysql_fetch_array($result_paid))
	{	
		echo '<tr>';
		echo '<td>'.$row_paid['sum']."</td>";
		echo '<td>'.preg_replace("/(\d+)-(\d+)-(\d+)/","$3-$2-$1",$row_paid['date_of_charge'])."</td>";
		echo '<td>'.$row_paid['way']."</td>";
		echo "</tr>";
	}
	echo '</table>';
	echo '</div>';
	 */
	
//Таблица пациентов этого врача:
	echo "<h3>Пациенты</h3>";
	echo '<div class="table_search">';
	echo '<table>';
	echo '<tr>
	<th>Фамилия</th>
	<th>Имя</th>
	<th>Отчество</th>
	<th>Дата прихода</th>
	<th>Диагноз врача-партнера</th>
	<th>Диагноз клиники</th>
	<th>Услуги</th>
	<th>Сумма врачу за пациента</th>
	<th>Дата выдачи суммы</th>
	<th>Способ оплаты</th>
	</tr>';
	
	$query_pat="SELECT patients.id,patients.name,patients.surname,patients.patronym,
	patients.date_of_birth,patients.date_of_coming,patients.anamnesis,patients.med_part_diagnoz,
	charges.sum,charges.date_of_charge,ways_of_paying.name as way
	FROM ((patients INNER JOIN ads ON patients.ads=ads.id)
	LEFT JOIN charges ON (charges.id_employee=".mysql_real_escape_string($_GET['id'])." AND charges.id_charge=1 AND charges.extra_id=patients.id))
	LEFT JOIN ways_of_paying ON ways_of_paying.id=charges.id_way
	WHERE patients.med_part=".mysql_real_escape_string($_GET['id']);
	$result_pat=mysql_query($query_pat);
	
	if($result_pat==false)
	{
		echo "Ошибка подключения к базе!";
		mysql_close($conn);
		exit;
	}
	
	while($row_pat=mysql_fetch_array($result_pat))
	{	
		echo '<tr>';
		echo '<td>'.$row_pat['surname']."</td>";
		echo '<td>'.$row_pat['name']."</td>";
		echo '<td>'.$row_pat['patronym']."</td>";
		echo '<td>'.preg_replace("/(\d+)-(\d+)-(\d+)/","$3-$2-$1",$row_pat['date_of_coming'])."</td>";
		echo '<td>'.$row_pat['med_part_diagnoz']."</td>";
		echo '<td>'.$row_pat['anamnesis']."</td>";
		$money_for_patients += $row_pat['sum'];
		// echo '<td>'.preg_replace("/(\d+)-(\d+)-(\d+)/","$3-$2-$1",$row_pat['date_of_birth'])."</td>";
		//echo '<td id="t_date_of_birth">'.preg_replace("/(\d+)-(\d+)-(\d+)/","$3-$2-$1",$row_pat['date_of_coming'])."</td>";
		   
		   //находим все услуги этого пациента
		   echo '<td class="services">';
			
			$conn_mssql=mssql_connect($_MSSQL_HOST,$_MSSQL_USERNAME,$_MSSQL_PASSWORD);
			if($conn_mssql==false)
				{
					echo('Error establishing connection!');
				}
			else
			{
				mssql_select_db('MyBase');
				$query_serv="SELECT imya_uslugi,data,price
				FROM dbo.data_motconsu_billdet
				WHERE patients_id=".$row_pat['id'];
				$result_serv=mssql_query($query_serv);
				if($result_serv==false)
				{	
					header("Status: ".mssql_get_last_message(),true,400);
					header("Query: ".$query_serv,true);
					mssql_close($conn_mssql);
					exit;
				}
				$result_serv_names=mysql_query('SELECT id,name FROM services');
				if($result_serv_names==false)
				{	
					header("Status: ".mysql_error($conn),true,400);
					//header("Query: ".$query_serv,true);
					mysql_close($conn);
					exit;
				}
				$serv_names=array();
				while($row_serv_names=mysql_fetch_array($result_serv_names))
				{
					$serv_names[$row_serv_names['id']]=$row_serv_names['name'];
				}
				//выводим услуги
				if(mssql_num_rows($result_serv)==0)
				echo " - ";
				else
				{
					$str="<ul>";
					while($row_serv=mssql_fetch_array($result_serv))
					{
							$str.='<li>'.(array_key_exists(iconv('CP1251','UTF-8',$row_serv['imya_uslugi']),$serv_names)?$serv_names[iconv('CP1251','UTF-8',$row_serv['imya_uslugi'])]:'(услуга не указана)').', ';
							if($row_serv['data']!='')
							{	
								$date=new DateTime(iconv('CP1251','UTF-8',$row_serv['data']));
								$date = $date->format('d-m-Y');
							}
							else
								$date = "(дата не указана)";
							if($row_serv['price']!='')
							{	
								$price=iconv('CP1251','UTF-8',$row_serv['price']).' руб.';
							}
							else
								$price = "(цена не указана)";
							
							$str.=$date.', '.$price.'</li>';
					}
					//$str=substr_replace($str,"",-6);
					echo $str.'</ul>';
				}
				mssql_close($conn_mssql);
			}
		echo "</td>";
		echo '<td>'.$row_pat['sum']."</td>";
		echo '<td>'.preg_replace("/(\d+)-(\d+)-(\d+)/","$3-$2-$1",$row_pat['date_of_charge'])."</td>";
		echo '<td>'.$row_pat['way']."</td>";
		echo "</tr>";
	}
	echo '</table>';
	echo '</div>';
	echo '<div>Общая сумма, выданная врачу за пациентов: '.$money_for_patients.'</div>';
	mysql_close($conn);
?>
</div>
