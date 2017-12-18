function write_new_pat()
	{
		var surname = document.getElementById("surname").value;
		var name = document.getElementById("name").value;
		var patronym = document.getElementById("patronym").value;
		var date_of_birth = document.getElementById("date_of_birth").value;
		var sex = document.getElementById("sex").value;
		var ads = document.getElementById("ads").value;
		var date_of_coming = document.getElementById("date_of_coming").value;
		var phone = document.getElementById("phone").value;
		var email = document.getElementById("email").value;
		var anamnesis = document.getElementById("anamnesis").value;
		var remark = document.getElementById("remark").value;
		name.replace(/[^A-zА-я-ёЁ]/g,"");
		surname.replace(/[^A-zА-я-ёЁ]/g,"");
		patronym.replace(/[^A-zА-я-ёЁ]/g,"");
		if(name=="")
		{
			alert("Не введено имя!");
			return -2;
		}
		if(surname=="")
		{
			alert("Не введена фамилия!");
			return -3;
		}
			request.open("POST","search_pat.php",false);
			//request.onreadystatechange = ;
			request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			if(patronym!="")
			request.send("s_name=equal&name="+name+"&s_surname=equal&surname="+surname+"&s_patronym=equal&patronym="+patronym);
			else request.send("s_name=equal&name="+name+"&s_surname=equal&surname="+surname);
			var str=request.getResponseHeader("Number");
			if(str!="0")
			{
				if(!window.confirm('Пациент '+surname+' '+name+' '+patronym+' уже существует. Все равно записать его?'))
				{
					document.forms[0].reset();
					search_pat();
					return -1;
				}
			}
			 str="name="+name+"&surname="+surname;
			 if(patronym!="")	 
			 str+="&patronym="+patronym;	 
			 str+="&sex="+sex;
			 str+="&ads="+ads;
			 
			if(ads=='2')
			{
				var med_part=document.getElementById("med_part");
				if(med_part!=null)med_part=med_part.value;
				else med_part="";
				var id_med_part=search_med_part_get_id(med_part);
				if(id_med_part>=-1)
				str+="&med_part="+(id_med_part);
				var summa_med_part=$("#summa").val();
				summa_med_part=parseFloat(summa_med_part);
				if(!(isNaN(summa_med_part)))
				str+="&summa_med_part="+(summa_med_part);
				var date_of_charge=$("#date_of_charge").val().replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
				if(!isNaN(Date.parse(date_of_charge)))
				str+="&date_of_charge="+(date_of_charge);
				var way=$("#way").val();
				way=search_way_of_paying_get_id(way);
				if(way>0)
				str+="&way="+way;
			}
			 
			 if(phone!="")	 
			 str+="&phone="+(phone);
			 if(remark!="")
			 str+="&remark="+(remark);
			 if(email!="")	 
			 str+="&email="+(email);
			if(anamnesis!="")	 
			 str+="&anamnesis="+(anamnesis);
			if(date_of_coming!="")
			{date_of_coming=date_of_coming.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
			var x_date = Date.parse(date_of_coming);
			if(isNaN(x_date)==false)
			 str+="&date_of_coming="+(date_of_coming);
			}
		if($("#has_discount_card").prop('checked')) str+="&has_discount_card=1";
		var w=document.getElementsByName("radio_date");
		if(w[0].checked)
		{
			var age = document.getElementById("age").value;
			var curDate=new Date;
			var year=curDate.getFullYear();
			age=parseInt(age);
			if(isNaN(age)==false)
			{
				var date_of_birth=(year-age)+"-01-01";
				str+="&date_of_birth="+(date_of_birth);
			}
		}
		else if(w[1].checked)
		{
			var date_of_birth = document.getElementById("date_of_birth").value;
			date_of_birth=date_of_birth.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
			x_date = Date.parse(date_of_birth);
			if(isNaN(x_date)==false)
			str+="&date_of_birth="+(date_of_birth);
		}
		else
		{
			var year_of_birth = document.getElementById("year_of_birth").value;
			if(year_of_birth!=null)
			if(isNaN(parseInt(year_of_birth))==false)
			var date_of_birth=year_of_birth+"-01-01";
			str+="&date_of_birth="+(date_of_birth);
		}
		request.open("POST","write_pat.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
		if(request.readyState==4)
			if(request.status==200)
			{
				return request.responseText;
			}
			else
			{
				alert("Ошибка при записи пациента! Status: "+request.getResponseHeader("Status")+"\nQuery: "+request.getResponseHeader("Query"));
			}	
		return -1;
	}
	
	function edit_pat(id)
	{
		
		var surname = document.getElementById("surname").value;
		var name = document.getElementById("name").value;
		var patronym = document.getElementById("patronym").value;
		var date_of_birth = document.getElementById("date_of_birth").value;
		var sex = document.getElementById("sex").value;
		var ads = document.getElementById("ads").value;
		var date_of_coming = document.getElementById("date_of_coming").value;
		var phone = document.getElementById("phone").value;
		var email = document.getElementById("email").value;
		var anamnesis = document.getElementById("anamnesis").value;
		var remark = document.getElementById("remark").value;
		name.replace(/[^A-zА-я-ёЁ]/g,"");
		surname.replace(/[^A-zА-я-ёЁ]/g,"");
		patronym.replace(/[^A-zА-я-ёЁ]/g,"");
		if(isNaN(id))
		{
			alert("Ошибка при чтении id!");
			return -1;
		}
		if(name=="")
		{
			alert("Не введено имя!");
			return -2;
		}

		if(surname=="")
		{
			alert("Не введена фамилия!");
			return -3;
		}
		
			 str="id="+id+"&name="+name+"&surname="+surname;
			 if(patronym!="")	 
			 str+="&patronym="+patronym;	 
			 str+="&sex="+sex;
			 str+="&ads="+ads;
			 str+="&phone="+(phone);
			 str+="&remark="+(remark);
			 str+="&email="+(email);
			 str+="&anamnesis="+(anamnesis);
			if(date_of_coming=="")
			str+="&date_of_coming="+(date_of_coming);
			else if(date_of_coming!="")
			{date_of_coming=date_of_coming.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
			var x_date = Date.parse(date_of_coming);
			if(isNaN(x_date)==false)
			 str+="&date_of_coming="+(date_of_coming);
			}
			if($("#has_discount_card").prop('checked')) str+="&has_discount_card=1";
			else str+="&has_discount_card=0";
			var date_of_birth = document.getElementById("date_of_birth").value;
			date_of_birth=date_of_birth.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
			x_date = Date.parse(date_of_birth);
			if(isNaN(x_date)==false)
			str+="&date_of_birth="+(date_of_birth);
			if(ads=='2')
			{
				var med_part=document.getElementById("med_part");
				if(med_part!=null)med_part=med_part.value;
				else med_part="";
				var id_med_part=search_med_part_get_id(med_part);
				if(id_med_part>=-1)
				str+="&med_part="+(id_med_part);
				var summa_med_part=$("#summa").val();
				summa_med_part=parseFloat(summa_med_part);
				if(!(isNaN(summa_med_part)))
				str+="&summa_med_part="+(summa_med_part);
				var date_of_charge=$("#date_of_charge").val().replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
				if(!isNaN(Date.parse(date_of_charge)))
				str+="&date_of_charge="+(date_of_charge);
				var way=$("#way").val();
				way=search_way_of_paying_get_id(way);
				if(way>0)
				str+="&way="+way;
			}
		request.open("POST","edit_pat.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.onreadystatechange=function(){
			if(request.readyState==4)
			if(request.status==200)
			{
			}
			else
			{
				alert("Status: "+request.getResponseHeader("Status")+"\nQuery: "+request.getResponseHeader("Query"));
			}
			}
		request.send(str);
		return 0;
	}
	function delete_patient(id)
	{
		if(isNaN(id))return -1;
		request.open("POST","sbase_delete_patient.php",false);
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
	
	function search_pat()
	{
		var surname = document.getElementById("surname").value;
		var name = document.getElementById("name").value;
		var patronym = document.getElementById("patronym").value;
		var sex = document.getElementById("sex").value;
		var ads = document.getElementById("ads").value;
		var date_of_coming = document.getElementById("date_of_coming").value;
		var phone = document.getElementById("phone").value;
		var email = document.getElementById("email").value;
		var anamnesis = document.getElementById("anamnesis").value;
		var remark = document.getElementById("remark").value;
		var order = document.getElementById("order").value;
		var limit = document.getElementById("limit").value;
		
		var s_surname = document.getElementById("s_surname").value;
		var s_name = document.getElementById("s_name").value;
		var s_patronym = document.getElementById("s_patronym").value;
		var s_date_of_coming = document.getElementById("s_date_of_coming").value;
		var s_phone = document.getElementById("s_phone").value;
		var s_email = document.getElementById("s_email").value;
		var s_anamnesis = document.getElementById("s_anamnesis").value;
		var s_remark = document.getElementById("s_remark").value;
		var str="";
			if(surname!="")
	         str+="s_surname="+(s_surname)+"&surname="+(surname);
			if(name!="")	 
			 str+="&s_name="+(s_name)+"&name="+(name);
			 if(patronym!="")	 
			 str+="&s_patronym="+(s_patronym)+"&patronym="+(patronym);	 
			 //str+="&s_sex="+(s_sex)+"&sex="+(sex);
			 if(ads!=-2)
			 str+="&ads="+(ads);
			 if(phone!="")	 
			 str+="&s_phone="+(s_phone)+"&phone="+(phone);
			 if(remark!="")
			 str+="&s_remark="+(s_remark)+"&remark="+(remark);
			 if(email!="")	 
			 str+="&s_email="+(s_email)+"&email="+(email);
			if(anamnesis!="")	 
			 str+="&s_anamnesis="+(s_anamnesis)+"&anamnesis="+(anamnesis);
			if(date_of_coming!="")
			{date_of_coming=date_of_coming.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
			var x_date = Date.parse(date_of_coming);
			if(isNaN(x_date)==false)
			 str+="&s_date_of_coming="+(s_date_of_coming)+"&date_of_coming="+(date_of_coming);
			}

			if(order!="none")
			str+="&order="+(order);
			limit=parseInt(limit);
			if((isNaN(limit)==false)&&(limit>0))
			str+="&limit="+(limit);
			
	/* 	var s_date_of_birth,date_of_birth,to_date_of_birth;
		var w=document.getElementsByName("radio_date");
		if(w[0].checked)
		{
			var s_age = document.getElementById("s_age").value;
			var age = document.getElementById("age").value;
			if(!isNaN(parseInt(age)))
				if(s_age!="fromto")
				str+="&s_age="+(s_age)+"&age="+(age);
				else
				{
					var x=document.getElementById("to_age");
					if(x!=null) var to_age=x.value;
					if(!isNaN(parseInt(to_age)))
						to_date_of_birth=new Date();
				}
		}
		else if(w[1].checked)
		{ */
			var s_date_of_birth = document.getElementById("s_date_of_birth").value;
			var date_of_birth = document.getElementById("date_of_birth").value;
			date_of_birth=date_of_birth.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
			x_date = Date.parse(date_of_birth);
			if(isNaN(x_date)==false)
			if(s_date_of_birth!="fromto")
				str+="&s_date_of_birth="+(s_date_of_birth)+"&date_of_birth="+(date_of_birth);
				else
				{
					var x=document.getElementById("to_date_of_birth");
					if(x!=null) var to_date_of_birth=x.value;
					if(!isNaN(parseInt(to_date_of_birth)))
						str+="&s_date_of_birth="+(s_date_of_birth)+"&date_of_birth="+(date_of_birth)+"&to_date_of_birth="+(to_date_of_birth);
				}
		/* }
		 else
		{
			var s_year_of_birth = document.getElementById("s_year_of_birth").value;
			var year_of_birth = document.getElementById("year_of_birth").value;
			if(year_of_birth!="")
			str+="&s_year_of_birth="+(s_year_of_birth)+"&year_of_birth="+(year_of_birth);
		}  */
		request.open("POST","search_pat.php",false);
		request.onreadystatechange = update_page_patients;
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
	}
	
	function search_pat_medialog(attributes)
	{
		var send_data={};
		if(attributes.surname!="")
	    	send_data.surname=attributes.surname;
		if(attributes.name!="")	 
		send_data.name=attributes.name;
		if(attributes.patronym!="")	 
		send_data.patronym=attributes.patronym;
		if(attributes.med_part!="")	 
		send_data.med_part=attributes.med_part;
		if(attributes.limit)
		{
			var limit=parseInt(attributes.limit);
			if((isNaN(limit)==false)&&(limit>0))
			send_data.limit=limit;
		}
		$.ajax({
		url:"sbase_search_pat_medialog.php",
		data:send_data,
		type:"POST",
		success:function(data){
			if(attributes.resultTarget)
			attributes.resultTarget.html(data);
		},
		error:function(jqXHR,textStatus,errorThrown){
			alert('Ошибка поиска: '+textStatus);
		},
		dataType:"html"
		});
		//request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	}
	