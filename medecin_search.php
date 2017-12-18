<div oninput="search_medecin()"  class="main_fields">
	<h3 class="form_header">Врач</h3>
		<div class="input_char"><div class="char_name">Фамилия:</div>
			<select id="s_surname">
				<option value="begin">Начинается на</option>
				<option value="end">Заканчивается на</option>
				<option value="cont">Содержит</option>
				<option value="notcont">Не содержит</option>
				<option value="equal">Равно</option>
				<option value="notequal">Не равно</option>
			</select>
			<input class="normal_input" type="text"  id="surname" />
		</div>
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
		<div class="input_char"><div class="char_name">Отчество:</div>
			<select id="s_patronym">
				<option value="begin">Начинается на</option>
				<option value="end">Заканчивается на</option>
				<option value="cont">Содержит</option>
				<option value="notcont">Не содержит</option>
				<option value="equal">Равно</option>
				<option value="notequal">Не равно</option>
			 </select>
			 <input class="normal_input" type="text"  id="patronym"/>
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
			<input class="normal_input" type="text"  id="contacts"/>
		</div>
		<div class="input_char"><div class="char_name">Количество пациентов:</div>
			<select id="s_number_of_patients" onChange="show_inputs(this)">
				<option value="less">Меньше</option>
				<option value="more">Больше</option>
				<option value="fromto">От..до..</option>
				<option value="equal">Равно</option>
				<option value="notequal">Не равно</option>
			</select>
			<input class="normal_input" type="text"  id="number_of_patients"/>
			<input class="hidden_input" type="text"  id="to_number_of_patients"/>
		</div>
		<div class="input_char"><div class="char_name">Количество услуг:</div>
			<select id="s_number_of_services" onChange="show_inputs(this)">
				<option value="less">Меньше</option>
				<option value="more">Больше</option>
				<option value="fromto">От..до..</option>
				<option value="equal">Равно</option>
				<option value="notequal">Не равно</option>
			</select>
			<input class="normal_input" type="text"  id="number_of_services"/>
			<input class="hidden_input" type="text"  id="to_number_of_services"/>
		</div>
		<div class="input_char"><div class="char_name">Общая сумма денег, принесенная клинике:</div>
			<select id="s_sum_of_money" onChange="show_inputs(this)">
				<option value="less">Меньше</option>
				<option value="more">Больше</option>
				<option value="fromto">От..до..</option>
				<option value="equal">Равно</option>
				<option value="notequal">Не равно</option>
			</select>
			<input class="normal_input" type="text"  id="sum_of_money"/>
			<input class="hidden_input" type="text"  id="to_sum_of_money"/>
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
		<div>
		<input type="button" id="create" value="Создать нового врача" onClick="location.href='medecins.php?act=create';"/>
		</div>
	</div>
	<div class="order_and_limit" oninput="search_medecin()">
	<div>
	<div class="char_name">
		Сортировка по:
	</div>
		<select id="order">
			<option value="none">(нет)</option>
			<option value="surname">Фамилии</option>
			<option value="name">Имени</option>
			<option value="patronym">Отчеству</option>
			<option value="contacts">Контактам</option>
			<option value="num_serv">Количеству услуг</option>
			<option value="num_pat">Количеству пациентов</option>
			<option value="sum_of_money">Сумме, принесенной клинике</option>
			<option value="remark">Примечанию</option>
		</select>
	</div>
		<div class="char_name">
		Показать записей:
		</div>
		<input type="text" id="limit" SelectBoxOptions="все;50;100;1000;2000;5000"/>
	</div>
	
	<div class="number">Найдено записей: <span id="number_of_entries"></span></div>
	</div>
	<div id="table_medecin"  class="table_search">
	</div>
	<script type="text/javascript" language="javascript">
	var selects=document.getElementsByTagName("SELECT");
	for(var i=0;i<selects.length;i++)
	show_inputs(selects[i]);
	$("select").change(search_medecin);
	$('#fc').click(search_medecin);
	createEditableSelect(document.getElementById("limit"));
	$('.selectBox').click(search_medecin);
	</script>