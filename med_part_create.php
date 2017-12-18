<form class="main_fields">
	<h3 class="form_header">Создание нового врача-партнера</h3>
	<div class="input_form">
		<div>Фамилия:
			 <input type="text"  id="surname"/>
		</div>
		<div>Имя:
		<input type="text" id="name"/>
		</div>
		<div>Отчество:
			 <input type="text"  id="patronym"/>
		</div>
		<div>Места работы:<div class="job_place"><span>Клиника:</span><input type="text" id="job_place_1" source="sbase_get_clinics_list.php"/><span>Должность:</span><input type="text" id="dolzhnost_1" source="sbase_get_dolzhnost_list.php"/></div><span id="button_add" class="button_as_link">Добавить еще</span></div>
		<div>Контакты:
		 <textarea  rows="6" cols="30"  id="contacts"></textarea>
		</div>
		<div><span style="float:left">Примечание:</span>
			<textarea  rows="6" cols="30" id="remark"></textarea>
		</div>
		<div>Наживки:
			<div class="nazhivki"><span>Сумма:</span><input type="text"><span>Дата наживки:</span><input type=text onfocus="this.select();lcs(this);" onclick="event.cancelBubble=true;lcs(this);"><input type="checkbox">Пациент не пришел</input></div>
			<span class="button_as_link" id="button_add_nazhivki">Добавить еще</span>
		<div>
	</div>
	<div class="buttons">
	<input type="button" id="create" value="Создать" onClick="create_smth();"/>
	<input type="button" id="cancel" value="Отмена" onClick="location.href='med_part.php';"/>
</div>
</form>
<script type="text/javascript" language="javascript">
	
	var el=document.getElementsByClassName('job_place');
	el=el[el.length-1];
	createEditableSelect(el.childNodes[1]);
	createEditableSelect(el.childNodes[3]);
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
		
		var new_med_part_id=write_new_med_part_to_list();
		if(new_med_part_id>=0)
			location.href='med_part.php?id='+new_med_part_id;
		else 
		{
			alert('Ошибка при сощдании врача!');
		}
	}
	$("#button_add").click(function(){
		addNewDiv($(this),'<div class="job_place"><span>Клиника:</span><input type="text" source="sbase_get_clinics_list.php"/><span>Должность:</span><input type="text" source="sbase_get_dolzhnost_list.php"/><img src="images/delete_inactive.gif" onClick="delete_div($(this).parent())" onMouseOver="set_active_delete_image(this)" onMouseOut="set_inactive_delete_image(this)"></div>');
	});
	$("#button_add_nazhivki").click(function(){
		addNewDiv($(this),['<div class="nazhivki">',
		'<span>Сумма:</span><input type="text">',
		'<span>Дата наживки:</span><input type=text onfocus="this.select();lcs(this);" onclick="event.cancelBubble=true;lcs(this);">',
		'<input type="checkbox">Пациент не пришел</input>',
		'<img src="images/delete_inactive.gif" onClick="delete_div($(this).parent())" onMouseOver="set_active_delete_image(this)" onMouseOut="set_inactive_delete_image(this)"></div>'].join(""));
	});
</script>