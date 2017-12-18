<form class="main_fields">
	<h3 class="form_header">Создание нового врача</h3>
	<div id="fields_input">
	<h3>Врач</h3>
	<div>
	<div>Фамилия:
		 <input type="text"  id="surname" onKeyUp="search_pat();"/>
	</div>
	Имя:
	<input type="text" id="name"/>
	<div>Отчество:
		 <input type="text"  id="patronym"/>
	</div>
	<div>Контакты:
		 <input type="text"  id="contacts"/>
	</div>
	<div>Примечание:
		<textarea  rows="6" cols="30" id="remark"></textarea>
	</div>
	</div>
	</div>
	<div class="buttons"> 
	<input type="button" id="create" value="Создать" onClick="var new_med_id=write_new_medecin_to_list();if(new_med_id>=0)location.href='medecins.php?id='+new_med_id;else error_alert(new_med_id);"/>
	<input type="button" id="cancel" value="Отмена" onClick="location.href='medecins.php';"/>
	</div>
</form>
