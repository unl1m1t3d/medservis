function handle(e)
	{
		var i,n;
		var optionDiv;
		var sboxes = $("div.selectBox");
		for(var j=0;j<sboxes.length;j++)
		{
			for(i=0;i<2;i++)
			{
				if(e.target==sboxes[j].childNodes[i])
				{
					for(l=0;l<sboxes.length;l++)
					{
						if(l!=j)
						{
							optionDiv = sboxes[l].lastChild;
							if(optionDiv.style.display=='block')
							{
								optionDiv.style.display='none';
								if(navigator.userAgent.indexOf('MSIE')>=0)document.getElementById('selectBoxIframe' + numId).style.display='none';
								sboxes[l].childNodes[1].src = arrowImageOver;	
							}
						}
					}
					j=-1;
					break;
				}
			}
			if(j<0)break;
		}
		if(j==sboxes.length)
		{
			for(l=0;l<sboxes.length;l++)
			{
				optionDiv = sboxes[l].lastChild;
				if(optionDiv.style.display=='block')
				{
						optionDiv.style.display='none';
						//if(navigator.userAgent.indexOf('MSIE')>=0)document.getElementById('selectBoxIframe' + numId).style.display='none';
						sboxes[l].childNodes[1].src = arrowImageOver;	
				}
			}
		}
		//document.dispatchEvent(e);
	} 
function showADY()
{
	var s=$("input:radio:checked").attr('id');
	if(s=="radio_date_1")
	showAge();
	else if(s=="radio_date_2")
	showDateOfBirth(); 
	else if(s=="radio_date_3")
	showYearOfBirth(); 
}
function showAge()
 {
	$('#radio_date_of_birth').hide();
	$('#radio_year_of_birth').hide();
	$('#radio_age').show();
 }
  function showDateOfBirth()
 {
	$('#radio_date_of_birth').show();
	$('#radio_year_of_birth').hide();
	$('#radio_age').hide();
 }
  function showYearOfBirth()
 {
	$('#radio_date_of_birth').hide();
	$('#radio_year_of_birth').show();
	$('#radio_age').hide();
 }
 function showRadioFields()
 {
	var w=document.getElementsByName("radio_date");
	var s,x;	
		if(w[0].checked)
			{
				x=document.getElementById('s_age');
				showAge();
				show_inputs(x);
			}
		else if(w[1].checked)
			{
				x=document.getElementById('s_date_of_birth');
				showDateOfBirth();
				show_inputs(x);
			}
		else
			{
				x=document.getElementById('s_year_of_birth');
				showYearOfBirth();
				show_inputs(x);
			}
 }


function error_alert(k)
{
	switch(k)
	{
		case -1:
			alert('Ошибка при записи врача!');
			break;
		case -2:
			alert('Не введено имя!');
			break;
		case -3:
			alert('Не введена фамилия!');
			break;
		case -5:
			alert('Ошибка при вводе фамилии!');
			break;
		case -4:
			alert('Ошибка при вводе имени!');
			break;
		default:
			break;
	}
}


	function update_page_med_part()
	{
		if(request.readyState==4)
		if(request.status==200)
		{
			document.getElementById('table_med_part').innerHTML=request.responseText;
			$("#number_of_entries").html(request.getResponseHeader("Number"));
		}
		else
		alert(request.getResponseHeader("Status")+'\n'+request.getResponseHeader("Query"));
	}
	
	function update_page_medecin()
	{
		if(request.readyState==4)
		if(request.status==200)
		{
			document.getElementById('table_medecin').innerHTML=request.responseText;
			$("#number_of_entries").html(request.getResponseHeader("Number"));
		}
		else
		alert(request.getResponseHeader("Status")+'\n'+request.getResponseHeader("Query"));
	}
	
	
	function show_inputs(elem)
	{
	var s;
	s=elem.getAttribute('id');
	s=s.replace('s_','');
	if(elem.value=='fromto')
		{	
			$("#to_"+s).show();
			if($("#ot_"+s).length==0)$('#'+s).before('<span id="ot_'+s+'">От: </span>');
			if($("#do_"+s).length==0)$("#to_"+s).before('<span id="do_'+s+'">До: </span>');
		}
		else
		{
			$("#to_"+s).hide();
			$("#ot_"+s).remove();
			$("#do_"+s).remove();
		}
	}
	
	function update_page_patients()
	{
		if(request.readyState==4)
		if(request.status==200)
		{
			document.getElementById('table_serv').innerHTML=request.responseText;
			$("#number_of_entries").html(request.getResponseHeader("Number"));
		}
		else
		alert(request.getResponseHeader("Status")+'\n'+request.getResponseHeader("Query"));
	}
	
	
	function get_pat_serv_med()
	{
			var url="get_pat_serv_med_ajax.php";
			request.open("GET", url, false);
			request.onreadystatechange=updatePage;
			request.send(null);
	}
	
	function updatePage()
	{
		if(request.readyState==4)
		if(request.status==200)
		{
			var new_text=request.responseText;
			var table_serv_el=document.getElementById("table_serv");
			table_serv_el.innerHTML=new_text;
		}
	}
function countDiscountPrice()
{
	var value_of_discount=parseFloat($("#value_of_discount").val());
	var price=parseFloat($("#price").val());
	if(!isNaN(value_of_discount)&&!isNaN(price)&&(value_of_discount>0))
	{
		if($("#is_percent :selected").val()==1)
		{
			if(value_of_discount>100)
			value_of_discount=100;
			$("#div_discount_price").show();
			var discount_price=price-price*value_of_discount/100;
			$("#discount_price").html(discount_price);
		}
		else
		{
			$("#div_discount_price").show();
			var discount_price=price-value_of_discount;
			$("#discount_price").html(discount_price);
		}
	}
	else
	{
		$("#div_discount_price").hide();
	}
}
	function countDebt()
	{
		price=parseFloat($("#price").val());
		if(isNaN(price))
		price=0;
		payed=parseFloat($("#payed").val());
		if(!(isNaN(payed))&&price>=0&&payed>=0)
		{
			var value_of_discount=parseFloat($("#value_of_discount").val());
			if(!isNaN(value_of_discount)&&(value_of_discount>0))
			{
				if($("#is_percent :selected").val()==1)
				{
					if(value_of_discount>100)
						value_of_discount=100;
					price=price-price*value_of_discount/100;
				}
				else
				{
					price=price-value_of_discount;
				}
			}
				var debt=price-payed;
				if(debt>0)
				{
					$("#debt").show();
					$("#sum_of_debt").html(debt);
					show_inputs_debt();
				}
				else $("#debt").hide();
		}
		else
		{
			$("#debt").hide();
		}
	}
	function show_inputs_debt()
	{
		var id_radio=$("input:radio:checked").attr('id');
		if(id_radio=="radio_debt_3")
		{
			$("#p_date_debt").show();
		}
		else
		$("#p_date_debt").hide();
	}

function set_active_delete_image(elem)
{
	elem.src='images/delete_active.png';
}
function set_inactive_delete_image(elem)
{
	elem.src='images/delete_inactive.gif';
}
var s_dolzhnost=new Array();
var s_clinics=new Array();
var s_ways_of_paying=new Array();
var s_stations=new Array();
//var s_med_part,s_charges,s_incomes,s_med,s_serv,s_drugs,s_discounts;
function check_selectboxes(selectboxes)
{
	var sboxes= new Array;
	if(!selectboxes)
		sboxes = $("input.selectBoxInput");
	else
		if ((typeof(selectboxes) == 'object')&&(selectboxes instanceof Array))
		sboxes=selectboxes;
	else
		sboxes.push(selectboxes);
	var s,i,j;

	for(i=0;i<sboxes.length;i++)
	{
		s=sboxes[i].getAttribute("source");
		if(sboxes[i].value!="")
		{
			/*if(s=="get_services.php")
			{
				if(s_serv.length<=0)
				{
					request.open("GET","/get_services.php",false);
					request.send();
					if(request.readyState==4)
						if(request.status==200)
						{
							s_serv=request.responseText.split(';');
						}
						else
							s_serv="";
				}
				for(j=0;j<s_serv.length;j++)
				if(sboxes[i].value==s_serv[j])break;
				if(j==s_serv.length)
				if(!confirm("Услуга "+sboxes[i].value+" отсутствует в списке услуг. Добавить?"))
				return -1;
				else 
				{
					if(write_service_to_list(sboxes[i].value)<0)
					return -4;
				}
			}
			else if(s=="get_medecins_ajax.php")
			{
				for(j=0;j<s_med.length;j++)
				if(sboxes[i].value==s_med[j])break;
				if(j==s_med.length)
				if(!confirm("Врач "+sboxes[i].value+" отсутствует в списке врачей. Добавить?"))
				return -2;
				else 
				{
					return -5;
				}
			}
			else if(s=="sbase_get_drugs.php")
			{
				for(j=0;j<s_drugs.length;j++)
				if(sboxes[i].value==s_drugs[j])break;
				if(j==s_drugs.length)
				if(!confirm("Препарат "+sboxes[i].value+" отсутствует в списке лекарств. Добавить?"))
				return -3;
				else 
				{
					if(write_drug_to_list(sboxes[i].value)<0)
					return -6;
				}
			}
			else if(s=="sbase_get_med_part_list.php")
			{
				if(s_med_part.length<=0)
				{
					request.open("GET","sbase_get_med_part_list.php",false);
					request.send();
					if(request.readyState==4)
						if(request.status==200)
						{
							s_med_part=request.responseText.split(';');
						}
						else
						s_med_part="";
				}
				for(j=0;j<s_med_part.length;j++)
				if(sboxes[i].value==s_med_part[j])break;
				if(j==s_med_part.length)
				if(!confirm("Врач "+sboxes[i].value+" отсутствует в списке врачей-партнеров. Добавить?"))
				return -7;
				else
				return -8;
			}
			else if(s=="sbase_get_charges_list.php")
			{
				if(s_charges.length<=0)
				{
					request.open("GET","sbase_get_charges_list.php",false);
					request.send();
					if(request.readyState==4)
						if(request.status==200)
						{
							s_charges=request.responseText.split(';');
						}
						else
						s_charges="";
				}
				if(s_charges.length==0)
				if(!confirm('Список расходов пуст. Добавить в него "'+sboxes[i].value+'"?'))
				return -9;
				else 
				{
					if(write_charge_to_list(sboxes[i].value)<0)
					return -10;
				}
				for(j=0;j<s_charges.length;j++)
				if(sboxes[i].value==s_charges[j])break;
				if(j==s_charges.length)
				if(!confirm("Наименование расхода "+sboxes[i].value+" отсутствует в списке расходов. Добавить?"))
				return -9;
				else 
				{
					if(write_charge_to_list(sboxes[i].value)<0)
					return -10;
				}
			}
			else if(s=="sbase_get_incomes_list.php")
			{
				if(s_incomes.length==0)
				if(!confirm('Список доходов пуст. Добавить в него "'+sboxes[i].value+'"?'))
				return -11;
				else 
				{
					if(write_income_to_list(sboxes[i].value)<0)
					return -12;
				}
				for(j=0;j<s_incomes.length;j++)
				if(sboxes[i].value==s_incomes[j])break;
				if(j==s_incomes.length)
				if(!confirm("Наименование дохода "+sboxes[i].value+" отсутствует в списке доходов. Добавить?"))
				return -11;
				else 
				{
					if(write_income_to_list(sboxes[i].value)<0)
					return -12;
				}
			}*/
			if(s=="sbase_get_dolzhnost_list.php")
			{
				if(s_dolzhnost.length<=0)
				{
					request.open("GET","sbase_get_dolzhnost_list.php",false);
					request.send();
					if(request.readyState==4)
						if(request.status==200)
						{
							s_dolzhnost=request.responseText.split(';');
						}
						else
						s_dolzhnost="";
				}
				if(s_dolzhnost.length==0)
				if(!confirm('Список должностей пуст. Добавить в него "'+sboxes[i].value+'"?'))
				return -13;
				else 
				{
					if(write_dolzhnost_to_list(sboxes[i].value)<0)
					return -14;
				}
				for(j=0;j<s_dolzhnost.length;j++)
				if(sboxes[i].value==s_dolzhnost[j])break;
				if(j==s_dolzhnost.length)
				if(!confirm("Наименование должности "+sboxes[i].value+" отсутствует в списке должностей. Добавить?"))
				return -13;
				else 
				{
					if(write_dolzhnost_to_list(sboxes[i].value)<0)
					return -14;
				}
			}
			else if(s=="sbase_get_clinics_list.php")
			{
				if(s_clinics.length<=0)
				{
					request.open("GET","sbase_get_clinics_list.php",false);
					request.send();
					if(request.readyState==4)
						if(request.status==200)
						{
							s_clinics=request.responseText.split(';');
						}
						else
						s_clinics="";
				}
				if(s_clinics.length==0)
				if(!confirm('Список клиник пуст. Добавить в него "'+sboxes[i].value+'"?'))
				return -15;
				else 
				{
					return -16;
				}
				for(j=0;j<s_clinics.length;j++)
				if(sboxes[i].value==s_clinics[j])break;
				if(j==s_clinics.length)
				if(!confirm("Клиника "+sboxes[i].value+" отсутствует в списке клиник. Добавить?"))
				return -15;
				else 
				{
					return -16;
				}
			}
			else if(s=="sbase_get_ways_of_paying.php")
			{
				if(s_ways_of_paying.length<=0)
				{
					request.open("GET","sbase_get_ways_of_paying.php",false);
					request.send();
					if(request.readyState==4)
						if(request.status==200)
						{
							s_ways_of_paying=request.responseText.split(';');
						}
						else
						s_ways_of_paying="";
				}
				if(s_ways_of_paying.length==0)
				if(!confirm('Список способов оплаты пуст. Добавить в него "'+sboxes[i].value+'"?'))
				return -17;
				else 
				{
					if(write_way_of_paying_to_list(sboxes[i].value)<0)
					return -18;
				}
				for(j=0;j<s_ways_of_paying.length;j++)
				if(sboxes[i].value==s_ways_of_paying[j])break;
				if(j==s_ways_of_paying.length)
				if(!confirm("Способ оплаты "+sboxes[i].value+" отсутствует в списке способов оплаты. Добавить?"))
				return -17;
				else 
				{
					if(write_way_of_paying_to_list(sboxes[i].value)<0)
					return -18;
				}
			}
			/*else if(s=="sbase_get_discounts_list.php")
			{
				if(s_discounts.length==0)
				if(!confirm('Список скидок пуст. Добавить в него "'+sboxes[i].value+'"?'))
				return -19;
				else 
				{
					if(write_discount_to_list(sboxes[i].value)<0)
					return -20;
				}
				for(j=0;j<s_discounts.length;j++)
				if(sboxes[i].value==s_discounts[j])break;
				if(j==s_discounts.length)
				if(!confirm("Название скидки "+sboxes[i].value+" отсутствует в списке скидок. Добавить?"))
				return -19;
				else 
				{
					if(write_discount_to_list(sboxes[i].value)<0)
					return -20;
				}
			}*/
			else if(s=="sbase_get_stations_list.php")
			{
				if(s_stations.length<=0)
				{
					request.open("GET","sbase_get_stations_list.php",false);
					request.send();
					if(request.readyState==4)
						if(request.status==200)
						{
							s_stations=request.responseText.split(';');
						}
						else
						s_stations="";
				}
				if(s_stations.length==0)
				if(!confirm('Список станций метро пуст. Добавить в него "'+sboxes[i].value+'"?'))
				return -19;
				else 
				{
					if(write_station_to_list(sboxes[i].value)<0)
					return -20;
				}
				for(j=0;j<s_stations.length;j++)
				if(sboxes[i].value==s_stations[j])break;
				if(j==s_stations.length)
				if(!confirm("Название станции метро "+sboxes[i].value+" отсутствует в списке станций. Добавить?"))
				return -19;
				else 
				{
					if(write_station_to_list(sboxes[i].value)<0)
					return -20;
				}
			}
		}
	}
	return 0;
}
function show_med_part_block()
{
	if($("#ads").val()==2)
	$("#med_part_block").show();
	else
	$("#med_part_block").hide();
}
function create_med_part_alert(select=null,func=null)
{
	var f=write_new_med_part_to_list_withA;
	var select=$("#med_part");
	str="<div>Фамилия:<input type='text'  id='surname'/></div>Имя:<input type='text' id='name'/><div>Отчество:<input type='text'  id='patronym'/></div><div>Наживка:<input type='text'  id='nazhivka'/></div><div>Дата наживки:<input type='text'  id='data_nazhivki' onfocus='this.select();lcs(this);' onclick='event.cancelBubble=true;lcs(this);'/></div><div>Места работы:<div class='job_place'><span>Клиника:</span><input type='text' id='job_place_1' source='sbase_get_clinics_list.php'/><span>Должность:</span><input type='text' id='dolzhnost_1' source='sbase_get_dolzhnost_list.php'/></div><span class='button_as_link' onClick='addNewDiv_job_place($(this))'>Добавить еще</span></div><div>Контакты:<input type='text'  id='contacts'/></div><div>Примечание:<textarea  rows='6' cols='30' id='remark'></textarea></div>";
	new Alert(str,f,select,func).show();
}
function create_clinic_alert(select=null,func=null,name="")
{
	var f=write_new_clinic_to_list_withA;
	new Alert('<div>Название:<input type="text"  id="name" value="'+name+'"/></div><div>Метро: <input type="text" id="metro" source="sbase_get_stations_list.php"/></div><div>Контакты:<textarea rows="6" cols="30" id="contacts"></textarea><div>Адрес:<textarea rows="6" cols="30" id="address"></textarea></div><div>Примечание:<textarea rows="6" cols="30" id="remark"></textarea></div>',f,select,func).show();
}
function create_medecin_alert(select=null,func=null)
{
	var f=write_new_medecin_to_list_withA;
	new Alert('<div>Фамилия:<input type="text"  id="surname"/></div>Имя:<input type="text" id="name"/><div>Отчество:<input type="text"  id="patronym"/></div><div>Контакты:<input type="text"  id="contacts"/></div><div>Примечание:<textarea  rows="6" cols="30" id="remark"></textarea></div>',f,select,func).show();
}
function create_search_window_patients(func_callback=null)
{
	if($('div.windowSearch').length==0)
	{
		var func_search=search_pat_medialog;
		new WindowSearch('<div>Фамилия:<input type="text"  id="surname"/></div><div>Имя:<input type="text" id="name"/></div><div>Отчество:<input type="text"  id="patronym"/></div><div>Врач-партнер:<input type="text" id="med_part"/></div><div><div class="char_name">Показать записей:</div><input type="text" id="limit" value="50" SelectBoxOptions="все;50;100;1000;2000;5000"/></div>',func_search,func_callback).show();
	}
}
function addNewDiv_job_place(elem)
{
	html='<div class="job_place"><span>Клиника:</span><input type="text" source="sbase_get_clinics_list.php"/><span>Должность:</span><input type="text" source="sbase_get_dolzhnost_list.php"/><img src="images/delete_inactive.gif" onClick="delete_div($(this).parent())" onMouseOver="set_active_delete_image(this)" onMouseOut="set_inactive_delete_image(this)"></div>';
	addNewDiv(elem,html);
}
function addNewDiv(elem,html) 
{
	var s=elem.parent().children(":first").attr("class"); 
	//продвигаемся по дереву DOM до корневого элемента, и узнаем класс первого ребенка этого корневого элемента
	//т.е. div'а, который нам нужно добавить 
	//(функция универсальная, работает и для добавления услуг, и для добавления должностей и для чего угодно, для div'ов любых типов)
	elem.before(html); 
	/* Добавляем новый div перед этой кнопкой */
	if(check_length(s)==2) /* Если элементов этого класса всего 2 (т.е. до добавления был 1), значит, нужно добавить к первому кнопку удаления (справа) */
		$('.'+s).filter(":first").append('<img src="images/delete_inactive.gif" onClick="delete_div($(this).parent())" onMouseOver="set_active_delete_image(this)" onMouseOut="set_inactive_delete_image(this)">');
	$('.'+s).filter(":last").find('input[source]').each(function(){
	createEditableSelect(this);
	});//Сделать из только что добавленного элемента SelectBox.
}
function addNewDivAnyX(elem,html)
{
	var s=elem.parent().children(":first").attr("class");
	s='patient';
	elem.before(html);
	$("#caption_num_pat").text(check_length(s));
	$('.'+s).filter(":last").find('input[source]').each(function(){
		createEditableSelect(this);
	});
}
function delete_div(elem)
{
	if(check_length(elem.attr("class"))>0)
	{
		var s=elem.attr("class");
		elem.remove();
		if(check_length(s)==1)
		$('.'+s+'>*').filter(":last").remove();
	}
}
function delete_div_AnyX(elem)
{
	var s=elem.attr("class");
	$("#caption_num_pat").text(check_length(s)-1);
	elem.remove();
}
function check_length(some_class) //функция сделана для того, чтобы узнавать количество div'ов типа услуга (т.е. того, что нам необходимо добавить)
{
	return $('.'+some_class).length;
}

function search_dolzhnost_get_id(s)
{
	if(s=="")
	return -1;
	request.open("POST","sbase_get_dolzhnost_list_with_id.php",false);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.send();
	if(request.readyState==4)
	if(request.status==200)
	{
		var s_dolzhnost=request.responseText.split(";");
		for(j=0;j<s_dolzhnost.length;j++)
		s_dolzhnost[j]=s_dolzhnost[j].split("|");
		for(j=0;j<s_dolzhnost.length;j++)
		if(s==s_dolzhnost[j][1])return s_dolzhnost[j][0];
		return -2;
	}
	return -3;
}
function search_clinic_get_id(s)
{
	if(s=="")
	return -1;
	request.open("POST","sbase_get_clinics_list_with_id.php",false);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.send();
	if(request.readyState==4)
	if(request.status==200)
	{
		var s_clinic=request.responseText.split(";");
		for(j=0;j<s_clinic.length;j++)
		s_clinic[j]=s_clinic[j].split("|");
		for(j=0;j<s_clinic.length;j++)
		if(s==s_clinic[j][1])return s_clinic[j][0];
		return -2;
	}
	return -3;
}
	
function insert_into_select(s,select)
{
	if(s&&select)
	{
		select.value=s;
	}
}
function show_select_date()
{
	elem=$('#s_date');
	if(elem.length!=1)return 0;
	switch (elem.val())
	{
		case "date":
			$('#stats_inputs > *').hide();
			$('#date').show();		
			break;
		case "month":
			$('#stats_inputs > *').hide();
			$('#div_month').show();
			$('#div_year').show();				
			break;
		case "year":
			$('#stats_inputs > *').hide();
			$('#div_year').show();		
			break;
		case "fromto":
			$('#stats_inputs > *').hide();
			$('.period').show();		
			break;
		default:
			break;
	}
}
function show_div_interval()
{
	elem=$("#interval");
	if(elem.length!=1)return 0;
	if(elem.val()=='int_days')
	$("#div_interval_days").show();
	else
	$("#div_interval_days").hide();
}
function setCookie (name, value, expires, path, domain, secure) {
      document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}
function getCookie ( cookie_name )
{
  var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );
 
  if ( results )
    return ( unescape ( results[2] ) );
  else
    return null;
}