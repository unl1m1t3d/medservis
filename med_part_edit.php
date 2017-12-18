<?php
require_once('settings.php');
if(!isset($_GET['id']))
{
	echo "Не задан id врача-партнера!";
	exit;
}
	$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
	if($conn==false)
	die('Error establishing connection!');
	mysql_select_db('base_med');
	$query = "SELECT med_part.id,med_part.surname,med_part.name,med_part.patronym,med_part.contacts,med_part.number_of_patients,med_part.nazhivka,med_part.data_nazhivki,
	(SELECT COUNT(patients.id) from patients WHERE patients.med_part=med_part.id) as num_pat,
	(SELECT SUM(IFNULL(pat_serv_med.payed,0)) FROM pat_serv_med,patients WHERE patients.med_part=med_part.id AND pat_serv_med.id_pat=patients.id) 
	as sum_of_money,med_part.remark FROM med_part WHERE med_part.id=".mysql_real_escape_string($_GET['id']);
	
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
	if(!($row=mysql_fetch_array($result)))
	{
		exit;
	}
	$query_job="SELECT clinics.name as clinics_name, address, dolzhnost.name as dolzhnost_name 
	FROM (med_part_jobs LEFT JOIN dolzhnost ON med_part_jobs.id_dolzhnost=dolzhnost.id) 
	LEFT JOIN clinics ON med_part_jobs.id_clinic=clinics.id WHERE med_part_jobs.id_med_part=".$row['id'];
	$result_job=mysql_query($query_job);
	if($result_job==false)
	{
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
?>
	
<div class="main_fields">
	<h3 class="form_header">Редактирование информации о враче-партнере</h3>
	<div class="input_form">
	<div>Фамилия:
		 <input type="text"  id="surname" value="<?php echo $row['surname'];?>"/>
	</div>
	<div>Имя:
	<input type="text" id="name" value="<?php echo $row['name'];?>"/>
	</div>
	<div>Отчество:
		 <input type="text"  id="patronym" value="<?php echo $row['patronym'];?>"/></div>
	<div id="clinics">Места работы:
<?php
	$n=mysql_num_rows($result_job);//если нет предыдущих результатов
	if($n==0)
	{
		echo '<div class="job_place"><span>Клиника:</span><input type="text" id="job_place_1" source="sbase_get_clinics_list.php"/>';
		echo '<span>Должность:</span><input type="text" id="dolzhnost_1" source="sbase_get_dolzhnost_list.php"/>';
		echo '</div>';
	}
	else
	while($row_job=mysql_fetch_array($result_job))
	{
		$s=$row_job['clinics_name'];
		if(preg_replace('/\n/',' ',$row_job['address'])!="")
		$s.=', '.preg_replace('/\n/',' ',$row_job['address']);
		echo '<div class="job_place"><span>Клиника:</span><input type="text" id="job_place_1" source="sbase_get_clinics_list.php"  value="'.$s.'"/>';
		echo '<span>Должность:</span><input type="text" id="dolzhnost_1" source="sbase_get_dolzhnost_list.php" value="'.$row_job['dolzhnost_name'].'"/>';
		if($n>1)
		echo '<img src="images/delete_inactive.gif" onClick="delete_div($(this).parent())" onMouseOver="set_active_delete_image(this)" onMouseOut="set_inactive_delete_image(this)">';
		echo '</div>';
	}
?>
	<span class="button_as_link" id="button_add">Добавить еще</span>
</div>
<?php
	$query_nazhivki = "SELECT summa, date, patient_didnot_come FROM nazhivki WHERE id_med_part=".mysql_real_escape_string($_GET['id']);
	
	$result_nazhivki=mysql_query($query_nazhivki);
	
	if($result_nazhivki==false)
	{
		echo "Ошибка при чтении пациентов этого врача!";
		mysql_close($conn);
		exit;
	}
	$n=mysql_num_rows($result_nazhivki);
	echo '<h3>Наживки:</h3>';
	echo '<div id="nazhivki">';
	if($n==0)
	{
		//echo '';
	}
	else
	while($row_nazhivki=mysql_fetch_array($result_nazhivki))
	{
		echo '<div class="nazhivki">';
		echo '<span>Сумма врачу за пациента:</span><input type=text value="'.$row_nazhivki['summa'].'">';
		echo '<span>Дата наживки:</span><input type=text onfocus="this.select();lcs(this);" onclick="event.cancelBubble=true;lcs(this);" value="'.preg_replace("/(\d+)-(\d+)-(\d+)/","$3-$2-$1",$row_nazhivki['date']).'">';
		echo '<input type="checkbox" ';
		if($row_nazhivki['patient_didnot_come']==1)
			echo ' checked';
		echo '>Пациент не пришел</input>';
		if($n>1)
		echo '<img src="images/delete_inactive.gif" onClick="delete_div($(this).parent())" onMouseOver="set_active_delete_image(this)" onMouseOut="set_inactive_delete_image(this)">';
		echo '</div>';
	}
	echo '<span class="button_as_link" id="button_add_nazhivki">Добавить еще наживку</span></div>';
?>
	<div>Контакты:
		 <textarea  rows="6" cols="30"  id="contacts"><?php echo $row['contacts'];?></textarea>
	</div>
	<div>Примечание:
		<textarea  rows="6" cols="30" id="remark"><?php echo $row['remark'];?></textarea>
	</div>
<?php
	/* echo "<h3>Оплаты</h3>";
	
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
	echo '<div id="payments">';
	$n=mysql_num_rows($result_paid);
	if($n==0)
	{
		echo '<div class="payment">';
		echo '<span>Сумма:</span><input type=text>';
		echo '<span>Дата оплаты:</span><input type=text onfocus="this.select();lcs(this);" onclick="event.cancelBubble=true;lcs(this);">';
		echo '<span>Способ оплаты:</span><input type=text source="sbase_get_ways_of_paying.php">';
		echo '</div>';
	}
	else
	while($row_paid=mysql_fetch_array($result_paid))
	{
		echo '<div class="payment">';
		echo '<span>Сумма:</span><input type=text value="'.$row_paid['sum'].'">';
		echo '<span>Дата оплаты:</span><input type=text onfocus="this.select();lcs(this);" onclick="event.cancelBubble=true;lcs(this);" value="'.preg_replace("/(\d+)-(\d+)-(\d+)/","$3-$2-$1",$row_paid['date_of_charge']).'">';
		echo '<span>Способ оплаты:</span><input type=text source="sbase_get_ways_of_paying.php" value="'.$row_paid['way'].'">';
		if($n>1)
		echo '<img src="images/delete_inactive.gif" onClick="delete_div($(this).parent())" onMouseOver="set_active_delete_image(this)" onMouseOut="set_inactive_delete_image(this)">';
		echo '</div>';
	}
	echo '<span class="button_as_link" id="button_add_payment">Добавить еще</span></div>'; */
	
	$query_pat = "SELECT patients.id,patients.name,patients.surname,patients.patronym,patients.anamnesis,patients.med_part_diagnoz,
	IFNULL(charges.sum,0) as sum,charges.date_of_charge, ways_of_paying.name as way, patients.date_of_coming
	FROM (patients LEFT JOIN charges ON (charges.id_employee=patients.med_part AND charges.id_charge=1 AND charges.extra_id=patients.id))
	LEFT JOIN ways_of_paying ON ways_of_paying.id=charges.id_way
	WHERE med_part=".mysql_real_escape_string($_GET['id']);
	
	$result_pat=mysql_query($query_pat);
	
	if($result_pat==false)
	{
		echo "Ошибка при чтении пациентов этого врача!";
		mysql_close($conn);
		exit;
	}
	$n=mysql_num_rows($result_pat);
	echo '<h3>Пациенты: <span id="caption_num_pat">'.$n.'</span></h3>';
	echo '<div id="patients">';
	if($n==0)
	{
		//echo '';
	}
	else
	while($row_pat=mysql_fetch_array($result_pat))
	{
		echo '<div class="patient" id="'.$row_pat['id'].'">';
		echo '<span class="pat">Пациент: <span class="pat_surname">'.$row_pat['surname'].'</span> <span class="pat_name">'.$row_pat['name'].'</span> <span class="pat_patronym">'.$row_pat['patronym'].'</span></span>';
		echo '<div class="date_of_coming">Дата прихода: <span class="pat_date_of_coming">'.preg_replace("/(\d+)-(\d+)-(\d+)/","$3-$2-$1",$row_pat["date_of_coming"]).'</span></div>';
		echo '<div class="paying"><span>Сумма врачу за пациента:</span><input type=text value="'.$row_pat['sum'].'">';
		echo '<span>Дата оплаты:</span><input type=text onfocus="this.select();lcs(this);" onclick="event.cancelBubble=true;lcs(this);" value="'.preg_replace("/(\d+)-(\d+)-(\d+)/","$3-$2-$1",$row_pat['date_of_charge']).'">';
		echo '<span>Способ оплаты:</span><input type=text source="sbase_get_ways_of_paying.php" value="'.$row_pat['way'].'"></div>';
		echo '<div class="med_info"><span>Диагноз врача-партнера:</span><textarea id="med_part_diagnoz">'.$row_pat['med_part_diagnoz'].'</textarea>';
		echo '<span>Диагноз "Медсервис":</span><textarea id="anamnesis">'.$row_pat['anamnesis'].'</textarea></div>';
		echo '<img src="images/delete_inactive.gif" onClick="delete_div_AnyX($(this).parent())" onMouseOver="set_active_delete_image(this)" onMouseOut="set_inactive_delete_image(this)">';
		echo '</div>';
	}
	echo '<span class="button_as_link" id="button_add_pat">Добавить еще пациента...</span></div>';
?>
	</div>
		<div class="buttons">
		<input type="button" id="save" value="Сохранить" onClick="create_smth()"/>
		<input type="button" id="cancel" value="Отмена" onClick="location.href='med_part.php?id='+<?php echo $_GET['id'];?>;"/>
		</div>
</div>
<script type="text/javascript">
	$('input[source]').each(function(){
	createEditableSelect(this);
	});
/* 	var offset	= new Array;
	$(".paying > .selectBox").each(function(i){
		offset.push($(this).offset());
	});
	$(".paying > .selectBox").css("position","absolute").offset(function(i,coords){
		return offset[i];
	}); */
	$("#button_add").click(function(){
		addNewDiv($(this),'<div class="job_place"><span>Клиника:</span><input type="text" source="sbase_get_clinics_list.php"/><span>Должность:</span><input type="text" source="sbase_get_dolzhnost_list.php"/><img src="images/delete_inactive.gif" onClick="delete_div($(this).parent())" onMouseOver="set_active_delete_image(this)" onMouseOut="set_inactive_delete_image(this)"></div>');
	});
	$("#button_add_nazhivki").click(function(){
		addNewDiv($(this),['<div class="nazhivki">',
		'<span>Сумма врачу за пациента:</span><input type="text">',
		'<span>Дата наживки:</span><input type=text onfocus="this.select();lcs(this);" onclick="event.cancelBubble=true;lcs(this);">',
		'<input type="checkbox">Пациент не пришел</input>',
		'<img src="images/delete_inactive.gif" onClick="delete_div($(this).parent())" onMouseOver="set_active_delete_image(this)" onMouseOut="set_inactive_delete_image(this)"></div>'].join(""));
	});
	$("#button_add_pat").click(function(){
		elem=$(this);
		create_search_window_patients(function(attributes){
			addNewDivAnyX(elem,
			['<div class="patient" id="'+attributes.id+'">',
			'<span class="pat">Пациент: <span class="pat_surname">'+attributes.surname+'</span> <span class="pat_name">'+attributes.name+'</span> <span class="pat_patronym">'+attributes.patronym+'</span></span>',
			'<div class="date_of_coming">Дата прихода: <span class="pat_date_of_coming">'+attributes.date_of_coming+'</span></div>',
			'<div class="paying"><span>Сумма врачу за пациента:</span><input type=text>',
			'<span>Дата оплаты:</span><input type=text onfocus="this.select();lcs(this);" onclick="event.cancelBubble=true;lcs(this);">',
			'<span>Способ оплаты:</span><input type=text source="sbase_get_ways_of_paying.php"></div>',
			'<div class="med_info"><span>Диагноз врача-партнера:</span><textarea id="med_part_diagnoz"></textarea>',
			'<span>Диагноз "Медсервис":</span><textarea id="anamnesis"></textarea></div>',
			'<img src="images/delete_inactive.gif" onClick="delete_div_AnyX($(this).parent())" onMouseOver="set_active_delete_image(this)" onMouseOut="set_inactive_delete_image(this)"></div>'].join(""));
		});
	});
	function create_smth()
	{
		var selectboxes=$.makeArray($('input.selectBoxInput'));
		for(i=0;i<selectboxes.length;i++)
		{
			t=check_selectboxes(selectboxes[i]);
			if(t==-16)
			{
				create_clinic_alert($(selectboxes[i]),create_smth,$(selectboxes[i]).val());
				return 0;
			}
			if(t<0)
			return 0;
		}
		
		if(edit_med_part(<?php echo $_GET['id']; ?>)>=0) location.href='med_part.php?id='+<?php echo $_GET['id'];?>;
		else 
		{
			alert('Ошибка при редактировании врача!');
		}
	}
</script>	
<?php
	mysql_close($conn);
?>