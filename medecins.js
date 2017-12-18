function search_medecin()
	{
		var surname = document.getElementById("surname").value;
		var name = document.getElementById("name").value;
		var patronym = document.getElementById("patronym").value;
		var number_of_patients = document.getElementById("number_of_patients").value;
		var contacts = document.getElementById("contacts").value;
		var sum_of_money = document.getElementById("sum_of_money").value;
		var number_of_services = document.getElementById("number_of_services").value;
		var remark = document.getElementById("remark").value;
		var order = document.getElementById("order").value;
		var limit = document.getElementById("limit").value;
		
		var s_surname = document.getElementById("s_surname").value;
		var s_name = document.getElementById("s_name").value;
		var s_patronym = document.getElementById("s_patronym").value;
		var s_number_of_patients = document.getElementById("s_number_of_patients").value;
		var s_contacts = document.getElementById("s_contacts").value;
		var s_sum_of_money = document.getElementById("s_sum_of_money").value;
		var s_number_of_services = document.getElementById("s_number_of_services").value;
		var s_remark = document.getElementById("s_remark").value;
		
		
		var str="";
			if(surname!="")
	         str+="s_surname="+(s_surname)+"&surname="+(surname);
			if(name!="")
			 str+="&s_name="+(s_name)+"&name="+(name);
			 if(patronym!="")	
			 str+="&s_patronym="+(s_patronym)+"&patronym="+(patronym);
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
			if(isNaN(parseInt(number_of_services))==false)
			 if(s_number_of_services!="fromto")
				str+="&s_number_of_services="+(s_number_of_services)+"&number_of_services="+(number_of_services);
				else
				{
					var x=document.getElementById("to_number_of_services");
					if(x!=null) 
					{var to_number_of_services=x.value;
					if(isNaN(parseInt(to_number_of_services))==false)
						str+="&s_number_of_services="+(s_number_of_services)+"&number_of_services="+(number_of_services)+"&to_number_of_services="+(to_number_of_services);
					}
				}
			if(contacts!="")	
			str+="&s_contacts="+(s_contacts)+"&contacts="+(contacts);
			if(remark!="")
			str+="&s_remark="+(s_remark)+"&remark="+(remark);	
			
			if(order!="none")
			str+="&order="+(order);
			limit=parseInt(limit);
			if((isNaN(limit)==false)&&(limit>0))
			str+="&limit="+(limit);
			
		request.open("POST","sbase_search_medecin.php",true);
		request.onreadystatechange = update_page_medecin;
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
	}
	
	function delete_medecin(id)
	{
		if(isNaN(id))return -1;
		request.open("POST","sbase_delete_medecin.php",false);
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
	
	function edit_medecin(id)
	{
		var surname = document.getElementById("surname").value;
		var name = document.getElementById("name").value;
		var patronym = document.getElementById("patronym").value;
		var contacts = document.getElementById("contacts").value;
		var remark = document.getElementById("remark").value;
		if(isNaN(parseInt(id)))
		return -2;
		var str="id="+id;
			if(surname!="")
	         str+="&surname="+(surname);
			if(name!="")
			 str+="&name="+(name);
			 if(patronym!="")
			 str+="&patronym="+(patronym);
			 if(contacts!="")	
			 str+="&contacts="+(contacts);
			 if(remark!="")
			 str+="&remark="+(remark);
		request.open("POST","sbase_edit_medecin.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
		if(request.readyState==4)
			if(request.status==200)
				return 0;
			else
				return -1;
	}
	function write_new_medecin_to_list()
	{
		var surname = document.getElementById("surname").value;
		var name = document.getElementById("name").value;
		var patronym = document.getElementById("patronym").value;
		var contacts = document.getElementById("contacts").value;
		var remark = document.getElementById("remark").value;
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

		request.open("POST","sbase_search_medecin.php",false);
			request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			if(patronym!="")
			request.send("s_name=equal&name="+name+"&s_surname=equal&surname="+surname+"&s_patronym=equal&patronym="+patronym);
			else request.send("s_name=equal&name="+name+"&s_surname=equal&surname="+surname);
			var str=request.getResponseHeader("Number");
			if(str!="0")
			{
				if(!window.confirm('Врач '+surname+' '+name+' '+patronym+' уже существует. Все равно записать его?'))
				{
					return -1;
				}
			}
			 str="name="+name+"&surname="+surname;
			 if(patronym!="")
			 str+="&patronym="+patronym;	 
			if(contacts!="")
			 str+="&contacts="+(contacts);
			 if(remark!="")
			 str+="&remark="+(remark);
			
		request.open("POST","sbase_write_new_medecin_to_list.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
		if(request.readyState==4)
			if(request.status==200)
			{
				return request.responseText;
			}
			else
			{
				return -2;
			}
	}
function write_new_medecin_to_list_withA(attributes,select)
	{
		var surname = attributes[0].value;
		var name = attributes[1].value;
		var patronym = attributes[2].value;
		var contacts = attributes[3].value;
		var remark = attributes[4].value;
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
			 
		request.open("POST","sbase_write_new_medecin_to_list.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
		if(request.readyState==4)
			if(request.status==200)
				{
					if(select)
					{	
						
						var s=surname;
						s+=' '+name.charAt(0)+'.';
						if(patronym!="")
						s+=' '+patronym.charAt(0)+'.';
						select.val(s);
					}
					return 0;
				}
			else
				return -1;
	}