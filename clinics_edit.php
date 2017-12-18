<?php
require_once('settings.php');
if(!isset($_GET['id']))
{
	echo "Не задан id клиники!";
	exit;
}
	$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
	if($conn==false)
	die('Error establishing connection!');
	mysql_select_db('base_med');
	$query = "SELECT clinics.id, clinics.name, stations.name as metro_name, clinics.address, clinics.contacts, clinics.remark, latitude, longitude FROM clinics LEFT JOIN stations ON clinics.metro=stations.id WHERE clinics.id=".mysql_real_escape_string($_GET['id']);
	
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
	if(!($row=mysql_fetch_array($result)))
	{
		echo "Ошибочка вышла.";
		exit;
	}
?>
<script language="javascript" type="text/javascript">
	ymaps.ready(init);
    var clinicsMap;
	var clinics;
	var clinicPlacemark=false;
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
<div class="main_fields">
	<h3 class="form_header">Редактирование информации о клинике</h3>
	<div id="map" style="height:300px; width:400px; margin-left:500px; position:absolute;"></div>
	<div class="input_form">
	<div>Название:
		<input type="text" id="name" value="<?php echo $row['name'];?>"/>
	</div>
	<div>Метро:
		<input type="text" source="sbase_get_stations_list.php" id="metro" value="<?php echo $row['metro_name'];?>"/>
	</div>
	<div>Адрес:
		 <textarea  rows="6" cols="30"  id="address"><?php echo $row['address'];?></textarea>
	</div>
	<div>Контакты:
		 <textarea  rows="6" cols="30"  id="contacts"><?php echo $row['contacts'];?></textarea>
	</div>
	<div>Примечание:
		<textarea  rows="6" cols="30" id="remark"><?php echo $row['remark'];?></textarea>
	</div>
	</div>
<div class="buttons">
	<input type="button" id="save" value="Сохранить" onClick="create_smth()"/>
	<input type="button" id="cancel" value="Отмена" onClick="location.href='clinics.php?id='+<?php echo $_GET['id'];?>;"/>
</div>
<script type="text/javascript">
	$('input[source]').each(function(){
	createEditableSelect(this);
	});
	var coords={};
	function getCoordinates(address)
	{
		$.ajax({
			url: "http://geocode-maps.yandex.ru/1.x/",
			type: "GET",
			data:{
				geocode: address,
				format:"json"},
			success: function (data,status,jqXHR) {
				if(data.response.GeoObjectCollection.featureMember.length!=0)
					{
						var coo=data.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(" ");
						coords.longitude=coo[0];
						coords.latitude=coo[1];
					}
			},
			async: false,
			error: function(jqXHR,textStatus,errorThrown){
				alert('Ошибка запроса: '+textStatus);
			},
		});
	}
	$("#address").change(function(){
		clinicPlacemark && clinicsMap.geoObjects.remove(clinicPlacemark);
		if($("#not_found").length!=0)$("#not_found").remove();
		var address=$(this).val();
		delete coords.latitude;
		delete coords.longitude;
		if(address=="") 
		{
			$("#map").append('<div id="not_found" style="color:red;">Адрес не указан.</div>');
		}		
		else 
		{
			getCoordinates(address);
			if(!coords.longitude||!coords.latitude)
				$("#map").append('<div id="not_found" style="color:red;">Адрес не найден.</div>');
			else
			{
				clinicPlacemark = new ymaps.Placemark([coords.latitude, coords.longitude], {
                balloonContentHeader: $("#name").val(),
                balloonContent: address
				});
				clinicsMap.geoObjects.add(clinicPlacemark);
			}
		}
	});
	function create_smth()
	{
		t=check_selectboxes();
		if(t>=0)
		{
			var address=$("#address").val();
			if(address!="") getCoordinates(address);
				else if(!confirm("Адрес не указан.\nВсе равно сохранить данные?"))
					return -1;
			if(address!=""&&(!coords.longitude||!coords.latitude))
				if(!confirm("Не удалось получить координаты клиники на карте.\nВозможно, адрес введен некорректно.\nВсе равно сохранить данные?"))
					return -1;
			if(!coords.longitude||!coords.latitude)
			{
				coords.longitude="";
				coords.latitude="";
			}
			if(edit_clinic(<?php echo $_GET['id']; ?>, coords.longitude, coords.latitude)>=0)location.href='clinics.php?id='+<?php echo $_GET['id'];?>;
			else 
			{
				alert('Ошибка при редактировании клиники!');
			}
		}
	}
</script>	
<?php
	mysql_close($conn);
?>