function search_med_part()
	{
		var surname = document.getElementById("surname").value;
		var name = document.getElementById("name").value;
		var patronym = document.getElementById("patronym").value;
		var clinic = document.getElementById("clinic").value;
		var address = document.getElementById("address").value;
		var number_of_patients = document.getElementById("number_of_patients").value;
		var dolzhnost = document.getElementById("dolzhnost").value;
		var contacts = document.getElementById("contacts").value;
		var sum_of_money = document.getElementById("sum_of_money").value;
		var remark = document.getElementById("remark").value;
		var nazhivka = document.getElementById("nazhivka").value;
		var data_nazhivki = document.getElementById("data_nazhivki").value;
		var order = document.getElementById("order").value;
		var limit = document.getElementById("limit").value;
		
		var s_surname = document.getElementById("s_surname").value;
		var s_name = document.getElementById("s_name").value;
		var s_patronym = document.getElementById("s_patronym").value;
		var s_clinic = document.getElementById("s_clinic").value;
		var s_address = document.getElementById("s_address").value;
		var s_number_of_patients = document.getElementById("s_number_of_patients").value;
		var s_dolzhnost = document.getElementById("s_dolzhnost").value;
		var s_contacts = document.getElementById("s_contacts").value;
		var s_sum_of_money = document.getElementById("s_sum_of_money").value;
		var s_remark = document.getElementById("s_remark").value;
		var s_nazhivka = document.getElementById("s_nazhivka").value;
		var s_data_nazhivki = document.getElementById("s_data_nazhivki").value;
		
		var str="";
			if(surname!="")
	         str+="s_surname="+(s_surname)+"&surname="+(surname);
			if(name!="")
			 str+="&s_name="+(s_name)+"&name="+(name);
			 if(patronym!="")	
			 str+="&s_patronym="+(s_patronym)+"&patronym="+(patronym);
			 if(clinic!="")	
			 str+="&s_clinic="+(s_clinic)+"&clinic="+(clinic);
			 if(address!="")	
			 str+="&s_address="+(s_address)+"&address="+(address);
			 if(isNaN(parseInt(number_of_patients))==false)
			 if(s_number_of_patients!="fromto")
				str+="&s_number_of_patients="+(s_number_of_patients)+"&number_of_patients="+(number_of_patients);
				else
				{
					var x=document.getElementById("to_number_of_patients");
					if(x!=null) 
					{var to_number_of_patients=x.value;
					if(isNaN(parseInt(to_number_of_patients))==false)
						str+="&s_number_of_patients="+(s_number_of_patients)+"&number_of_patients="+(number_of_patients)+"&to_number_of_patients="+(to_number_of_patients);
					}
				}
			if(isNaN(parseFloat(sum_of_money))==false)
			 if(s_sum_of_money!="fromto")
				str+="&s_sum_of_money="+(s_sum_of_money)+"&sum_of_money="+(sum_of_money);
				else
				{
					var x=document.getElementById("to_sum_of_money");
					if(x!=null) 
					{var to_sum_of_money=x.value;
					if(isNaN(parseFloat(to_sum_of_money))==false)
						str+="&s_sum_of_money="+(s_sum_of_money)+"&sum_of_money="+(sum_of_money)+"&to_sum_of_money="+(to_sum_of_money);
					}
				}
			 if(dolzhnost!="")	
			 str+="&s_dolzhnost="+(s_dolzhnost)+"&dolzhnost="+(dolzhnost);
			 if(contacts!="")	
			 str+="&s_contacts="+(s_contacts)+"&contacts="+(contacts);
			 if(remark!="")
			 str+="&s_remark="+(s_remark)+"&remark="+(remark);
		
		if(isNaN(parseFloat(nazhivka))==false)
			 if(s_nazhivka!="fromto")
				str+="&s_nazhivka="+(s_nazhivka)+"&nazhivka="+(nazhivka);
				else
				{
					var x=document.getElementById("to_nazhivka");
					if(x!=null) 
					{var to_nazhivka=x.value;
					if(isNaN(parseFloat(to_nazhivka))==false)
						str+="&s_nazhivka="+(s_nazhivka)+"&nazhivka="+(nazhivka)+"&to_nazhivka="+(to_nazhivka);
					}
				}
		if(s_data_nazhivki!="fromto")
			{
				data_nazhivki=data_nazhivki.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
				var x_date = Date.parse(data_nazhivki);
				if(isNaN(x_date)==false)
				str+="&s_data_nazhivki="+(s_data_nazhivki)+"&data_nazhivki="+(data_nazhivki);
			}
			else
			{
				var to_data_nazhivki=document.getElementById("to_data_nazhivki").value;
				data_nazhivki=data_nazhivki.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
				var x_date = Date.parse(data_nazhivki);
				to_data_nazhivki=to_data_nazhivki.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
				var to_x_date = Date.parse(to_data_nazhivki);
				if((!isNaN(x_date))&&(!isNaN(to_x_date)))
				str+="&s_data_nazhivki="+(s_data_nazhivki)+"&data_nazhivki="+(data_nazhivki)+"&to_data_nazhivki="+(to_data_nazhivki);
				else if((isNaN(x_date))&&(!isNaN(to_x_date)))
				str+="&s_data_nazhivki=less&data_nazhivki="+(to_data_nazhivki);
				else if((!isNaN(x_date))&&(isNaN(to_x_date)))
				str+="&s_data_nazhivki=more&data_nazhivki="+(data_nazhivki);
			}
			
		if(order!="none")
		str+="&order="+(order);
		limit=parseInt(limit);
		if((isNaN(limit)==false)&&(limit>0))
		str+="&limit="+(limit);
		$.ajax({
		url:"sbase_search_med_part.php",
		data:str,
		type:"GET",
		success:function(data,status,jqXHR){
			$("#summa_nazhivok").parent().remove();
			$('#table_med_part').html(data);
			$("#number_of_entries").html(jqXHR.getResponseHeader("Number"));
			$("#summa_nazhivok").parent().insertAfter($('#number_of_entries').parent());
		},
		error:function(jqXHR,textStatus,errorThrown){
			alert('Ошибка поиска: '+textStatus+'Исключение: '+errorThrown);
		},
		dataType:"html"
		});
	}
	
	function write_new_med_part_to_list()
	{
		var surname = document.getElementById("surname").value;
		var name = document.getElementById("name").value;
		var patronym = document.getElementById("patronym").value;
		var contacts = document.getElementById("contacts").value;
		var remark = document.getElementById("remark").value;
		var nazhivki=$(".nazhivki");
		for(i=0;i<nazhivki.length;i++)
			nazhivki[i]=new Array($(nazhivki[i]).find('input[type="text"]:first').val(),$(nazhivki[i]).find('input[type="text"]:last').val(),$(nazhivki[i]).find('input[type="checkbox"]').prop("checked"));
		var jobs=$(".job_place");
		for(i=0;i<jobs.length;i++)
		jobs[i]=new Array($(jobs[i]).find('input:first').val(),$(jobs[i]).find('input:last').val());
		
		if(surname=="")
		{
			return -3;
		}
		
		if(name=="")
		{
			return -2;
		}
		name=name.replace(/[^A-zА-я-ёЁ]/g,"");
		surname=surname.replace(/[^A-zА-я-ёЁ]/g,"");
		patronym=patronym.replace(/[^A-zА-я-ёЁ]/g,"");
		if(surname=="")
		{
			return -5;
		}
		
		if(name=="")
		{
			return -4;
		}
	         	 
		var str="surname="+(surname);
		str+="&name="+(name);
		if(patronym!="")
		str+="&patronym="+(patronym);
		if(remark!="")
		str+="&remark="+(remark);
		if(contacts!="")
		str+="&contacts="+(contacts);
		var id_clinic,id_dolzhnost;
		var c=0;
		for(i=0;i<jobs.length;i++)
		{
			id_clinic=search_clinic_get_id(jobs[i][0]);
			if(id_clinic>0)
			{
				id_dolzhnost=search_dolzhnost_get_id(jobs[i][1]);
				if(id_dolzhnost<0)
				{
					str+='&clinic'+(c)+'='+id_clinic;
				}
				else
				{
					str+='&clinic'+(c)+'='+id_clinic+'&dolzhnost'+(c)+'='+id_dolzhnost;
				}
				c++;
			}
		}
		var nazhivka, data_nazhivki;
		c=0;
		for(i=0;i<nazhivki.length;i++)
		{
			nazhivka=parseFloat(nazhivki[i][0]);
			if(isNaN(nazhivka)==false && nazhivka>0)
			{
				str+='&nazhivka'+(c)+'='+nazhivka;
				data_nazhivki=nazhivki[i][1].replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
				var x_date = Date.parse(data_nazhivki);
				if(isNaN(x_date)==false)
					str+="&data_nazhivki"+(c)+'='+(data_nazhivki);
				if(nazhivki[i][2])
					str+="&patient_didnot_come"+(c)+'=1';
				else
					str+="&patient_didnot_come"+(c)+'=0';	
				c++;
			}
		}
		request.open("POST","sbase_write_med_part_to_list.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
		if(request.readyState==4)
			if(request.status==200)
				return request.responseText;
			else
				return -1;
	}
	
	function edit_med_part(id)
	{
		var surname = document.getElementById("surname").value;
		var name = document.getElementById("name").value;
		var patronym = document.getElementById("patronym").value;
		var contacts = document.getElementById("contacts").value;
		var remark = document.getElementById("remark").value;
		var nazhivki=$(".nazhivki");
		for(i=0;i<nazhivki.length;i++)
			nazhivki[i]=new Array($(nazhivki[i]).find('input[type="text"]:first').val(),$(nazhivki[i]).find('input[type="text"]:last').val(),$(nazhivki[i]).find('input[type="checkbox"]').prop("checked"));
		var jobs=$(".job_place");
		for(i=0;i<jobs.length;i++)
		jobs[i]=new Array($(jobs[i]).find('input:first').val(),$(jobs[i]).find('input:last').val());
		
		name=name.replace(/[^A-zА-я-ёЁ]/g,"");
		surname=surname.replace(/[^A-zА-я-ёЁ]/g,"");
		patronym=patronym.replace(/[^A-zА-я-ёЁ]/g,"");

	    if(isNaN(parseInt(id)))
		return -7;
		var str="id="+(id);
		if(surname!="")
		str+="&surname="+(surname);
		if(name!="")
		str+="&name="+(name);
		if(patronym!="")
		str+="&patronym="+(patronym);
		str+="&remark="+(remark);
		str+="&contacts="+(contacts);
		var nazhivka, data_nazhivki;
		var c=0;
		for(i=0;i<nazhivki.length;i++)
		{
			nazhivka=parseFloat(nazhivki[i][0]);
			if(isNaN(nazhivka)==false && nazhivka>0)
			{
				str+='&nazhivka'+(c)+'='+nazhivka;
				data_nazhivki=nazhivki[i][1].replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
				var x_date = Date.parse(data_nazhivki);
				if(isNaN(x_date)==false)
					str+="&data_nazhivki"+(c)+'='+(data_nazhivki);
				else
				{
					alert("Дата наживки отсутствует или введена неправильно!");
					return -2;
				}
				if(nazhivki[i][2])
					str+="&patient_didnot_come"+(c)+'=1';
				else
					str+="&patient_didnot_come"+(c)+'=0';	
				c++;
			}
		}
		var id_clinic,id_dolzhnost;
		c=0;
		for(i=0;i<jobs.length;i++)
		{
			id_clinic=search_clinic_get_id(jobs[i][0]);
			if(id_clinic>0)
			{
				id_dolzhnost=search_dolzhnost_get_id(jobs[i][1]);
				if(id_dolzhnost<0)
				{
					str+='&clinic'+(c)+'='+id_clinic;
				}
				else
				{
					str+='&clinic'+(c)+'='+id_clinic+'&dolzhnost'+(c)+'='+id_dolzhnost;
				}
				c++;
			}
		}
		var i,x,way;
		var s;
		var c=0;
		patients=$("#patients").children(".patient").each(function(){
			s="";
			s+="&patient"+(c)+"="+$(this).attr('id');
			var surname=$(this).find(".pat_surname").text();
			var name=$(this).find(".pat_name").text();
			var patronym=$(this).find(".pat_patronym").text();
			var date_of_coming=$(this).find(".pat_date_of_coming").text();
			s+="&surname"+(c)+"="+surname+"&name"+(c)+"="+name+"&patronym"+(c)+"="+patronym+"&date_of_coming"+(c)+"="+(date_of_coming.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1'));
			
			var data = $(this).find("input");
			if((isNaN(parseFloat(data[0].value))==false)&&data[0].value>0)
			{
				s+="&sum"+(c)+"="+(parseFloat(data[0].value));
				x=data[1].value;
				if(x!=null)
				{
					x=x.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
					if(isNaN(Date.parse(x))==false)
					s+="&date"+(c)+"="+x;
				}
				way=data[2].value;
				way=search_way_of_paying_get_id(way);
				if(way>0)
				s+="&way"+(c)+"="+way;
			}
			data = $(this).find("textarea");
			s+="&med_part_diagnoz"+(c)+"="+data[0].value+"&anamnesis"+(c)+"="+data[1].value;
			if(s!="")
			{
				str+=s;
				c++;
			}
		});
		request.open("POST","sbase_edit_med_part.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
		if(request.readyState==4)
			if(request.status==200)
				return 0;
			else
				return -1;
	}
	
	function delete_med_part(id)
	{
		if(isNaN(id))return -1;
		request.open("POST","sbase_delete_med_part.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send("id="+id);
		if(request.readyState==4)
			if(request.status==200)
			{
				return 0;
			}
			else
			{
				alert("Status: "+request.getResponseHeader("Status")+"\nQuery: "+request.getResponseHeader("Query"));
				return -2;
			}
	}
function write_way_of_paying_to_list(way_of_paying)
	{
		if(way_of_paying=="")
		return -1;
		request.open("POST","sbase_write_way_of_paying_to_list.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send("name="+way_of_paying);
		if(request.readyState==4)
			if(request.status==200)
			{
				var data=JSON.parse(request.responseText);
				if(s_ways_of_paying)
					s_ways_of_paying.push(data.name);
				return data.id;
			}
		return -2;
	}
function write_discount_to_list(discount)
	{
		if(discount=="")
		return -1;
		request.open("POST","sbase_write_discount_to_list.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send("name="+discount);
		if(request.readyState==4)
			if(request.status==200)
			{
				return request.responseText;
			}
		return -2;
	}
function search_med_part_get_id(s)
{
	if(s=="")
	return -1;
	request.open("POST","sbase_get_med_part_list_with_id.php",false);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.send();
	if(request.readyState==4)
	if(request.status==200)
	{
		var s_med_part=request.responseText.split(";");
		for(j=0;j<s_med_part.length;j++)
		s_med_part[j]=s_med_part[j].split("|");
		for(j=0;j<s_med_part.length;j++)
		if(s==s_med_part[j][1])return s_med_part[j][0];
		return -2;
	}
	return -3;
}
function search_discount_get_id(s)
{
	if(s=="")
	return -1;
	request.open("POST","sbase_get_discounts_with_id.php",false);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.send();
	if(request.readyState==4)
	if(request.status==200)
	{
		var s_med_part=request.responseText.split(";");
		for(j=0;j<s_med_part.length;j++)
		s_med_part[j]=s_med_part[j].split("|");
		for(j=0;j<s_med_part.length;j++)
		if(s==s_med_part[j][1])return s_med_part[j][0];
		return -2;
	}
	return -3;
}
function search_way_of_paying_get_id(s)
{
	if(s=="")
	return -1;
	request.open("POST","sbase_get_ways_of_paying_with_id.php",false);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.send();
	if(request.readyState==4)
	if(request.status==200)
	{
		var s_med_part=request.responseText.split(";");
		for(j=0;j<s_med_part.length;j++)
		s_med_part[j]=s_med_part[j].split("|");
		for(j=0;j<s_med_part.length;j++)
		if(s==s_med_part[j][1])return s_med_part[j][0];
		return -2;
	}
	return -3;
}

function search_med_part_patients_get_id(pat,med_part)
{
	if(pat=="")
	return -1;
	request.open("POST","sbase_get_med_part_patients_with_id.php",false);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.send("id="+(med_part));
	if(request.readyState==4)
	if(request.status==200)
	{
		var s_med_part_patients=request.responseText.split(";");
		for(j=0;j<s_med_part_patients.length;j++)
		s_med_part_patients[j]=s_med_part_patients[j].split("|");
		for(j=0;j<s_med_part_patients.length;j++)
		if(pat==s_med_part_patients[j][1])return s_med_part_patients[j][0];
		return -2;
	}
	return -3;
}
function write_new_med_part_to_list_withA(attributes,select)
	{
		var surname = attributes[0].value;
		var name = attributes[1].value;
		var patronym = attributes[2].value;
		var nazhivka = attributes[3].value;
		var data_nazhivki = attributes[4].value;
		var contacts = attributes[5].value;
		var remark = attributes[6].value;
		var jobs = new Array;
		if ((typeof(attributes[7]) == 'object')&&(attributes[7] instanceof Array)) 
		{
			jobs=attributes[7];
		}
		if(surname=="")
		{
			return -3;
		}
		
		if(name=="")
		{
			return -2;
		}
		name=name.replace(/[^A-zА-я-ёЁ]/g,"");
		surname=surname.replace(/[^A-zА-я-ёЁ]/g,"");
		patronym=patronym.replace(/[^A-zА-я-ёЁ]/g,"");
		if(surname=="")
		{
			return -5;
		}
		
		if(name=="")
		{
			return -4;
		}
	         	 
		var str="surname="+(surname);
		str+="&name="+(name);
		if(patronym!="")
		str+="&patronym="+(patronym);
		if(contacts!="")	
		str+="&contacts="+(contacts);
		if(remark!="")
		str+="&remark="+(remark);
		nazhivka=parseFloat(nazhivka);
		if(isNaN(nazhivka)==false)
		str+="&nazhivka="+nazhivka;
		data_nazhivki=data_nazhivki.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
		var x_date = Date.parse(data_nazhivki);
		if(isNaN(x_date)==false)
		str+="&data_nazhivki="+(data_nazhivki);
		var id_clinic,id_dolzhnost;
		var c=0;
		for(i=0;i<jobs.length;i+=2)
		{
			id_clinic=search_clinic_get_id(jobs[i].value);
			if(id_clinic>0)
			{
				id_dolzhnost=search_dolzhnost_get_id(jobs[i+1].value);
				if(id_dolzhnost<0)
				{
					str+='&clinic'+(c)+'='+id_clinic;
				}
				else
				{
					str+='&clinic'+(c)+'='+id_clinic+'&dolzhnost'+(c)+'='+id_dolzhnost;
				}
				c++;
			}
		}
		request.open("POST","sbase_write_med_part_to_list.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
		if(request.readyState==4)
			if(request.status==200)
				{
					if(select)
					{	
						var s=search_med_part_get_name(request.responseText);
						if(s=="")
						return -3;
						select.val(s);
					}
					return 0;
				}
			else
				return -1;
	}
function search_med_part_get_name(id)
{
	if(isNaN(parseInt(id)))
	return "";
	request.open("POST","sbase_get_med_part_list_with_id.php",false);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.send();
	if(request.readyState==4)
	if(request.status==200)
	{
		var s_med_part=request.responseText.split(";");
		for(j=0;j<s_med_part.length;j++)
		s_med_part[j]=s_med_part[j].split("|");
		for(j=0;j<s_med_part.length;j++)
		if(id==s_med_part[j][0])return s_med_part[j][1];
		return "";
	}
	return "";
}
function write_new_clinic_to_list_withA(attributes,select)
{
	var name = attributes.name.value;
	var address = attributes.address.value;
	var remark = attributes.remark.value;
	var contacts = attributes.contacts.value;
	var metro = attributes.metro.value;
	if(name=="")
	{
		return -5;
	}
	var str="name="+encodeURIComponent(name);
	if(address!="")
	id_metro=search_station_get_id(metro);
	if(id_metro>0)
	{
		str+="&metro="+(id_metro);
	}
	var coords={};
	if(address!="")
	{
		var req=$.ajax({
			url: "http://geocode-maps.yandex.ru/1.x/",
			type: "GET",
			data:{
				geocode: address,
				format:"json"},
			async: false,
			error: function(jqXHR,textStatus,errorThrown){
				alert('Ошибка запроса к Яндексу: '+textStatus);
			},
		});
		if(req.readyState==4)
			if(req.status==200)
			{
				var data=JSON.parse(req.responseText);
				if(data.response.GeoObjectCollection.featureMember.length!=0)
				{
					var coo=data.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(" ");
					coords.longitude=coo[0];
					coords.latitude=coo[1];
				}
			}
	}
	else if(!confirm("Адрес не указан.\nВсе равно сохранить данные?"))
		return -1;
	if(address!=""&&(!coords.longitude||!coords.latitude))
	{
		if(!confirm("Не удалось получить координаты клиники на карте.\nВозможно, адрес введен некорректно.\nВсе равно сохранить данные?"))
			return -1;
	}
	else
	{
		str+="&latitude="+(coords.latitude);
		str+="&longitude="+(coords.longitude);
	}
	str+="&address="+encodeURIComponent(address);
	str+="&contacts="+encodeURIComponent(contacts);
	if(remark!="")
	str+="&remark="+encodeURIComponent(remark);
		 
	request.open("POST","sbase_write_clinic_to_list.php",false);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.send(str);
	if(request.readyState==4)
		if(request.status==200)
			{
				if(select)
				{	
					var s=name;
					if(address.replace(/\n/g,' ')!='')
					s+=', '+address.replace(/\n/g,' ');
					$(select).val(s);
				}
				var data=JSON.parse(request.responseText);
				if(s_clinics)
					s_clinics.push(data.name);
				return 0;
			}
		else
			return -1;
}
function write_dolzhnost_to_list(dolzhnost)
	{
		if(dolzhnost=="")
		return -1;
		request.open("POST","sbase_write_dolzhnost_to_list.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send("name="+dolzhnost);
		if(request.readyState==4)
			if(request.status==200)
			{
				var data=JSON.parse(request.responseText);
				if(s_dolzhnost)
					s_dolzhnost.push(data.name);
				return data.id;
			}
		return -2;
	}
	function search_med_part_rating()
	{
		
		var limit = document.getElementById("limit").value;

		var str="";

		limit=parseInt(limit);
		if((isNaN(limit)==false)&&(limit>0))
			str+="limit="+(limit);
		else
			str+="limit=50";
		$.ajax({
		url:"sbase_search_med_part.php",
		data:str,
		type:"GET",
		success:function(data,status,jqXHR){
			$("#summa_nazhivok").parent().remove();
			$('#table_med_part').html(data);
			$("#number_of_entries").html(jqXHR.getResponseHeader("Number"));
			$("#summa_nazhivok").parent().insertAfter($('#number_of_entries').parent());
		},
		error:function(jqXHR,textStatus,errorThrown){
			alert('Ошибка поиска: '+textStatus);
		},
		dataType:"html"
		});
	}