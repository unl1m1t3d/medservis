<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Клиники - База "Медсервис"</title>
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

<?php
	include("menu.php");
?>
<div oninput="search_clinic()" class="main_fields">
	<h3 class="form_header">Поиск пациентов</h3>
		<div class="char_name">Период:</div>
		<div class="input_char" id="query_period">
			<div>От: <input class="normal_input" type="text" id="period_begin" onfocus="this.select();lcs(this);" onclick="event.cancelBubble=true;lcs(this);"/></div>
			<div>До: <input class="normal_input" type="text" id="period_end" onfocus="this.select();lcs(this);"onclick="event.cancelBubble=true;lcs(this);"/></div>
		</div>
	<div class="services">Услуги:
	<div class="service"><input type="text" id="service_1" source="sbase_get_services_list.php" value=""/></div>
	<span id="button_add" class="button_as_link">Добавить еще</span>
	</div>
	
	<label style="display:block; margin-bottom:10px"><input type="checkbox" name="first_time_patient"/> Первичный пациент (пришел первый раз в указанный период времени)</label>
	<button onclick="query_period()">Поиск</button>
</div>
	
	<div class="number">Найдено записей: <span id="number_of_entries"></span></div>

	
	<div id="table_clinics" class="table_search">
	</div>
	<script type="text/javascript" language="javascript">
	$('input[source]').each(function(){
	createEditableSelect(this);
	});//функция, которая из всех input'ов с атрибутом source делает selectbox'ы
	$("#button_add").click(function(){
		addNewDiv($(this),'<div class="service"><input type="text" source="sbase_get_services_list.php"/><img src="images/delete_inactive.gif" onClick="delete_div($(this).parent())" onMouseOver="set_active_delete_image(this)" onMouseOut="set_inactive_delete_image(this)"></div>');
	/* 
		Первый аргумент addNewDiv - $(this) - кнопка "Добавить еще".
		Второй аргумент - текст (HTML String), что конкретно добавить.
	*/
	});
	var selects=document.getElementsByTagName("SELECT");
	for(var i=0;i<selects.length;i++)
	show_inputs(selects[i]);
	$("select").change(search_clinic);
	$('#fc').click(search_clinic);
	//$('.selectBox').click(search_clinic);
	</script>
<script language="JavaScript" type="text/javascript">
 	document.onclick=handle;
</script>
</body>
</html>
