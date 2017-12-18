<?php
require_once('settings.php');
date_default_timezone_set('UTC');
if(!isset($_GET['id']))
{
	echo "Не задан id клиники!";
	exit;
}
	$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
	if($conn==false)
	die('Error establishing connection!');
	mysql_select_db('base_med');
	$query = "SELECT clinics.id, clinics.name, stations.name as metro_name, clinics.address, clinics.contacts, clinics.remark, longitude, latitude
	FROM clinics LEFT JOIN stations ON clinics.metro=stations.id WHERE clinics.id=".mysql_real_escape_string($_GET['id']);
	
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
		echo "Клиника с id ".$_GET['id']." не найдена!";
		mysql_close($conn);
		exit;
	}
	if($row=mysql_fetch_array($result))
	{
		echo '<div class="main_fields clinic" >';
		echo '<h3 class="form_header">'.$_GET['id'].'. Клиника "'.$row['name'].'"</h3>';
		echo '<div id="map" style="height:300px; width:400px; margin-right: 20px; float:left;"></div>';
		echo '<div>Метро: ';
		echo $row['metro_name'].'</div>';
		echo '<div>Адрес: ';
		echo $row['address'].'</div>';
		echo '<div>Контакты: ';
		echo $row['contacts'].'</div>';
		echo '<div>Примечание: ';
		echo $row['remark'].'</div>';
	}
		$query_med_part="SELECT med_part.id, med_part.name as med_part_name, med_part.surname as med_part_surname, med_part.patronym as med_part_patronym,dolzhnost.name as dolzhnost_name,
		(SELECT COUNT(patients.id) from patients WHERE patients.med_part=med_part.id) as num_pat, (SELECT MAX(patients.date_of_coming) from patients WHERE patients.med_part=med_part.id) as last_pat_date,
		(SELECT COUNT(*) FROM nazhivki WHERE nazhivki.id_med_part=med_part.id) as num_nazhivki
		FROM (med_part_jobs LEFT JOIN dolzhnost ON med_part_jobs.id_dolzhnost=dolzhnost.id) 
		LEFT JOIN med_part ON med_part_jobs.id_med_part=med_part.id WHERE med_part_jobs.id_clinic=".$row['id'].
		' ORDER BY num_pat DESC, num_nazhivki DESC';
		$result_med_part=mysql_query($query_med_part);
		if($result_med_part==false)
		{
			header("Status: ".mysql_error($conn),true,400);
			mysql_close($conn);
			exit;
		}
		$n=mysql_num_rows($result_med_part);
		echo '<div><h3>Врачи: '.$n.'</h3><ul>';
		while($row_med_part=mysql_fetch_array($result_med_part))
		{
			echo '<li class="';
			if($row_med_part['num_pat']<=0 and $row_med_part['num_nazhivki']<=0)
				echo 'norm';
			else if(($row_med_part['num_nazhivki']>=1) AND ($row_med_part['num_pat']<=0))
				echo 'bad';
			else echo 'good';
			echo '"><a href="med_part.php?id='.$row_med_part['id'].'">'.$row_med_part['med_part_surname'].' '.$row_med_part['med_part_name'];
			if($row_med_part['med_part_patronym']!="")
				echo ' '.$row_med_part['med_part_patronym'];
		
			if($row_med_part['dolzhnost_name']!="")
				echo ', '.$row_med_part['dolzhnost_name'];
			
			echo " (наживок: ".$row_med_part['num_nazhivki'].", пациентов: ".$row_med_part['num_pat'];
			if($row_med_part['num_pat']>0)
			echo ", последний: ".$row_med_part['last_pat_date'];
			echo ")</a></li>";
		}
	echo '</ul></div>';
	echo '</div>';
	echo '<div style="float:left;clear:both">
		<ul>
		<li class="good"> - пациенты есть</li>
		<li class="norm"> - наживок нет, пациентов нет</li>
		<li class="bad"> - наживки есть, пациентов нет</li>
		</ul>
	</div>';
	echo '</div>';
	mysql_close($conn);
?>
<script language="javascript" type="text/javascript">
	ymaps.ready(init);
    var clinicsMap;
	var clinics;
	var clinicPlacemark;
    function init(){     
        clinicsMap = new ymaps.Map ("map", {
            center: [55.755768,37.627284],
            zoom: 10,
        });
		clinicsMap.controls.add('zoomControl', { top: 75, left: 5 });
		clinicsMap.behaviors.enable('scrollZoom');
		if('<?php echo preg_replace("/\s/","",$row["address"]);?>'=="")
			$("#map").append('<div id="not_found" style="color:red;"><b>Адрес не указан.</b></div>');
		else if("<?php echo $row['latitude'];?>"==""||"<?php echo $row['longitude'];?>"=="")
			$("#map").append('<div id="not_found" style="color:red;"><b>Адрес не найден.</b></div>');
		else
		{
			clinicPlacemark = new ymaps.Placemark([<?php echo $row['latitude'];?>, <?php echo $row['longitude'];?>], {
					balloonContentHeader: '<?php echo $row["name"];?>',
					balloonContent: '<?php echo preg_replace("/\s/"," ",$row["address"]);?>'
				});
			clinicsMap.geoObjects.add(clinicPlacemark);
		}
    }
</script>
<div class="buttons">
<input type="button" id="edit" value="Редактировать" onClick="location.href+='&act=edit'"/>
<input type="button" id="delete" value="Удалить клинику" onClick="if(confirm('Вы действительно хотите удалить клинику <?php echo $row["name"];?>?\nОтменить данное действие будет невозможно.'))if(delete_clinic(<?php echo $_GET['id'];?>)>=0)location.href='<?php echo $_SERVER["HTTP_REFERER"];?>';"/>
</div>
</div>
