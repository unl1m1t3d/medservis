<div oninput="search_med_part()" class="main_fields">
	<h3 class="form_header">Поиск врачей-партнеров</h3>
		<div class="normal_search">
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
		<div class="input_char"><div class="char_name">Наживка:</div>
			<select id="s_nazhivka" onChange="show_inputs(this)">
				<option value="less">Меньше</option>
				<option value="more">Больше</option>
				<option value="fromto">От..до..</option>
				<option value="equal">Равно</option>
				<option value="notequal">Не равно</option>
			</select>
			<input class="normal_input" type="text"  id="nazhivka"/>
			<input class="normal_input" type="text"  id="to_nazhivka"/>
		</div>
		<div class="input_char"><div class="char_name">Дата наживки:</div>
		<select id="s_data_nazhivki" onChange="show_inputs(this);">
			<option value="less">Раньше</option>
			<option value="more">Позже</option>
			<option value="fromto">От..до..</option>
			<option value="equal">Равно</option>
			<option value="notequal">Не равно</option>
		</select>
		<input class="normal_input" type="text"  id="data_nazhivki" value="" onfocus="this.select();lcs(this);"
		onclick="event.cancelBubble=true;lcs(this);"/>
		<input class="normal_input" type="text"  id="to_data_nazhivki" value="" onfocus="this.select();lcs(this);"
		onclick="event.cancelBubble=true;lcs(this);"/></div>
		<div class="input_char"><div class="char_name">Клиника(-и):</div>
			<select id="s_clinic">
				<option value="begin">Начинается на</option>
				<option value="end">Заканчивается на</option>
				<option value="cont">Содержит</option>
				<option value="notcont">Не содержит</option>
				<option value="equal">Равно</option>
				<option value="notequal">Не равно</option>
			</select>
			<input class="normal_input" type="text"  id="clinic" source="sbase_get_clinics_list.php"/>
		</div>
		</div>
		<div class="extra_search">
		<div class="input_char"><div class="char_name">Должность:</div>
			<select id="s_dolzhnost">
				<option value="begin">Начинается на</option>
				<option value="end">Заканчивается на</option>
				<option value="cont">Содержит</option>
				<option value="notcont">Не содержит</option>
				<option value="equal">Равно</option>
				<option value="notequal">Не равно</option>
			</select>
			<input class="normal_input" type="text"  id="dolzhnost"/>
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
			<input class="normal_input" type="text"  id="address"/>
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
		<div class="input_char"><div class="char_name">Количество пациентов:</div>
			<select id="s_number_of_patients" onChange="show_inputs(this)">
				<option value="less">Меньше</option>
				<option value="more">Больше</option>
				<option value="fromto">От..до..</option>
				<option value="equal">Равно</option>
				<option value="notequal">Не равно</option>
			</select>
			<input class="normal_input" type="text"  id="number_of_patients"/>
			<input class="normal_input" type="text"  id="to_number_of_patients"/>
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
			<input class="normal_input" type="text"  id="to_sum_of_money"/>
		</div>	
		</div>
		<span id="ext_search" class="button_as_link">Расширенный поиск...</span>
		<div class="buttons">
			<input type="button" id="create" value="Создать нового врача-партнера" onClick="location.href='med_part.php?act=create';"/>
		</div>
	</div>
	
	<div class="order_and_limit" oninput="search_med_part()">
	<div>
	<div class="char_name">Сортировка по:</div>
		<select id="order">
			<option value="none">(нет)</option>
			<option value="surname">Фамилии</option>
			<option value="name">Имени</option>
			<option value="patronym">Отчеству</option>
			<option value="nazhivka">Наживке</option>
			<option value="data_nazhivki">Дате наживки</option>
			<option value="contacts">Контактам</option>
			<option value="num_pat">Количеству пациентов</option>
			<option value="sum_of_money">Сумме, принесенной клинике</option>
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
	<div id="table_med_part" class="table_search">
	</div>
	<script type="text/javascript" language="javascript">
	$('div.extra_search').hide();
	var state=0;
	$("#ext_search").click(function (){
		if(state%2==0)
		{
			$(this).text("Обычный поиск");
		}
		else
		$(this).text("Расширенный поиск...");
		state++;
		$("div.extra_search").toggle();
	});
	var selects=document.getElementsByTagName("SELECT");
	for(var i=0;i<selects.length;i++)
	show_inputs(selects[i]);
	$("select").change(search_med_part);
	$('#fc').click(search_med_part);
	createEditableSelect(document.getElementById("limit"));
	createEditableSelect(document.getElementById("clinic"));
	$('.selectBox').click(search_med_part);
	</script>