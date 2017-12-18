<div oninput="search_clinic()" class="main_fields">
	<h3 class="form_header">Поиск клиник</h3>
	<div class="normal_search">
		<div class="input_char"><div class="char_name">Имя:</div>
			<select id="s_name">
				<option value="begin">Начинается на</option>
				<option value="end">Заканчивается на</option>
				<option value="cont">Содержит</option>
				<option value="notcont">Не содержит</option>
				<option value="equal">Равно</option>
				<option value="notequal">Не равно</option>
			 </select>
		<input class="normal_input" type="text" id="name"/>
		</div>
		<div class="input_char"><div class="char_name">Метро:</div>
			<select id="s_metro">
				<option value="cont">Содержит</option>
				<option value="notcont">Не содержит</option>
			</select>
			<input type="text"  id="metro" source="sbase_get_stations_list.php"/>
		</div>
		<div class="input_char"><div class="char_name">Адрес клиники:</div>
			<select id="s_address">
				<option value="begin">Начинается на</option>
				<option value="end">Заканчивается на</option>
				<option value="cont">Содержит</option>
				<option value="notcont">Не содержит</option>
				<option value="equal">Равно</option>
				<option value="notequal">Не равно</option>
			</select>
			<textarea rows="6" cols="30" id="address"></textarea>
		</div>
		
		<div class="input_char"><div class="char_name">Контакты:</div>
			<select id="s_contacts">
				<option value="begin">Начинается на</option>
				<option value="end">Заканчивается на</option>
				<option value="cont">Содержит</option>
				<option value="notcont">Не содержит</option>
				<option value="equal">Равно</option>
				<option value="notequal">Не равно</option>
			</select>
			<textarea rows="6" cols="30"  id="contacts"></textarea>
		</div>
		
		<div class="input_char"><div class="char_name">Примечание:</div>
			<select id="s_remark">
				<option value="begin">Начинается на</option>
				<option value="end">Заканчивается на</option>
				<option value="cont">Содержит</option>
				<option value="notcont">Не содержит</option>
				<option value="equal">Равно</option>
				<option value="notequal">Не равно</option>
			</select>
			<textarea rows="6" cols="30" id="remark"></textarea>
		</div>
	</div>
	<div class="buttons">
		<input type="button" id="create" value="Создать новую клинику" onClick="location.href='clinics.php?act=create';"/>
	</div>
</div>
	
	<div class="order_and_limit" oninput="search_clinic()">
	<div>
	<div class="char_name">
		Сортировка по:
	</div>
		<select id="order">
			<option value="none">(нет)</option>
			<option value="name">Названию</option>
			<option value="metro">Станции метро</option>
			<option value="address">Адресу</option>
			<option value="contacts">Контактам</option>
			<option value="remark">Примечанию</option>
		</select>
	</div>
		<div>
			<div class="char_name">
			Показать записей:
			</div>
			<input type="text" id="limit" value="50" SelectBoxOptions="все;50;100;1000;2000;5000"/>
		</div>
	</div>
	<div class="number">Найдено записей: <span id="number_of_entries"></span></div>

	
	<div id="table_clinics" class="table_search">
	</div>
	<script type="text/javascript" language="javascript">
	$('input[source]').each(function(){
	createEditableSelect(this);
	});
	var selects=document.getElementsByTagName("SELECT");
	for(var i=0;i<selects.length;i++)
	show_inputs(selects[i]);
	$("select").change(search_clinic);
	$('#fc').click(search_clinic);
	createEditableSelect(document.getElementById("limit"));
	$('.selectBox').click(search_clinic);
	</script>