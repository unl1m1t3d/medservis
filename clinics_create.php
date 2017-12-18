<form class="main_fields">
	<h3 class="form_header">Создание новой клиники</h3>
	<div id="map" style="height:300px; width:400px; margin-left:500px; position:absolute;"></div>
	<div class="input_form">
		<div>Название:
		<input type="text" id="name"/>
		</div>
		<div>Станция метро:
			<input type="text" id="metro" source="sbase_get_stations_list.php"/>
		</div>
		<div><span style="float:left">Адрес:</span>
			<textarea  rows="6" cols="30"  id="address"></textarea>
		</div>
		<div><span style="float:left">Контакты:</span>
			<textarea  rows="6" cols="30"  id="contacts"></textarea>
		</div>
		<div><span style="float:left">Примечание:</span>
			<textarea  rows="6" cols="30" id="remark"></textarea>
		</div>
	</div>
	<div class="buttons">
	<input type="button" id="create" value="Создать" onClick="create_smth();"/>
	<input type="button" id="cancel" value="Отмена" onClick="location.href='clinics.php';"/>
</div>
</form>
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
    }
</script>
<script type="text/javascript" language="javascript">
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
				alert('Ошибка поиска: '+textStatus);
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
			$("#map").append('<div id="not_found" style="color:red;"><b>Адрес не указан.</b></div>');
		}		
		else 
		{
			getCoordinates(address.replace(/\s/," "));
			if(!coords.longitude||!coords.latitude)
				$("#map").append('<div id="not_found" style="color:red;"><b>Адрес не найден.</b></div>');
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
			var new_clinic_id=write_new_clinic_to_list(coords.longitude,coords.latitude);
			if(new_clinic_id>=0)
				location.href='clinics.php?id='+new_clinic_id;
			else 
			{
				alert('Ошибка при создании новой клиники!');
			}
		}
	}
</script>