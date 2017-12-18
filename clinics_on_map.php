<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Клиники на карте- База "Медсервис"</title>
<script type="text/javascript" src="combo.js"></script>
<script type="text/javascript" src="calendar_ru.js"></script>
<script type="text/javascript" src="med_func.js"></script>
<script type="text/javascript" src="medecins.js"></script>
<script type="text/javascript" src="med_part.js"></script>
<script type="text/javascript" src="patients.js"></script>
<script type="text/javascript" src="window_search.js"></script>
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="alert.js"></script>
<script type="text/javascript" src="clinics.js"></script>
<script type="text/javascript" src="stations.js"></script>
<script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="combo.css" />
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
		$.ajax({
			url: "/get_clinics_JSON.php",
			type: "POST",
			success: placeClinics,
			error: function(jqXHR,textStatus,errorThrown){
				alert('Ошибка поиска: '+textStatus);
			},
			dataType: "json"
		});
		clinicsMap.controls.add('zoomControl', { top: 75, left: 5 });
		clinicsMap.behaviors.enable('scrollZoom');
    }
	function placeClinics(data,status,jqXHR){
		clinics=data;
		for(var i=0;i<clinics.length;i++)
		{
			clinicPlacemark = new ymaps.Placemark([clinics[i].latitude, clinics[i].longitude], {
                balloonContentHeader: clinics[i].name,
                balloonContent: clinics[i].address
            });
            
            clinicsMap.geoObjects.add(clinicPlacemark);
		}
	}
</script>
</head>
<body>
<?php
	include("menu.php");
?>
	<div id="map" style="width: 90%; height: 85%; margin-top:120px;margin-left:100px;"></div>

<script language="JavaScript" type="text/javascript">
 	document.onclick=handle;
</script>
</body>
</html>
