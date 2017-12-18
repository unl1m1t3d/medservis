function search_clinic()
	{
		var name = document.getElementById("name").value;
		var metro = document.getElementById("metro").value;
		var contacts = document.getElementById("contacts").value;
		var address = document.getElementById("address").value;
		var remark = document.getElementById("remark").value;
		
		var s_name = document.getElementById("s_name").value;
		var s_metro = document.getElementById("s_metro").value;
		var s_contacts = document.getElementById("s_contacts").value;
		var s_address = document.getElementById("s_address").value;
		var s_remark = document.getElementById("s_remark").value;
		
		var order = document.getElementById("order").value;
		var limit = document.getElementById("limit").value;
		
		var str="";
		if(name!="")
		str+="&s_name="+(s_name)+"&name="+(name);
		if(address!="")
		str+="&s_address="+(s_address)+"&address="+(address);
		if(metro!="")
		str+="&s_metro="+(s_metro)+"&metro="+(metro);
		if(contacts!="")
		str+="&s_contacts="+(s_contacts)+"&contacts="+(contacts);
		if(remark!="")
		str+="&s_remark="+(s_remark)+"&remark="+(remark);
		
		if(order!="none")
		str+="&order="+(order);
		limit=parseInt(limit);
		if((isNaN(limit)==false)&&(limit>0))
		str+="&limit="+(limit);
		
		$.ajax({
		url:"sbase_clinics_search.php",
		data:str,
		type:"POST",
		success:function(data,status,jqXHR){
			$('#table_clinics').html(data);
			$("#number_of_entries").html(jqXHR.getResponseHeader("Number"));
		},
		error:function(jqXHR,textStatus,errorThrown){
			alert('Ошибка поиска: '+textStatus);
		},
		dataType:"html"
		});
	}
	
	function write_new_clinic_to_list(longitude="", latitude="")
	{
		var name = document.getElementById("name").value;
		var metro = document.getElementById("metro").value;
		var contacts = document.getElementById("contacts").value;
		var address = document.getElementById("address").value;
		var remark = document.getElementById("remark").value;
		if(name=="")
		{
			return -4;
		}
	         	 
		var str="name="+(name);
		if(address!="")
		str+="&address="+(address);
		if(remark!="")
		str+="&remark="+(remark);
		if(contacts!="")
		str+="&contacts="+(contacts);
		id_metro=search_station_get_id(metro);
		if(id_metro>0)
		{
			str+="&metro="+(id_metro);
		}
		if(longitude!="")
		str+="&longitude="+(longitude);
		if(latitude!="")
		str+="&latitude="+(latitude);
		request.open("POST","sbase_write_clinic_to_list.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
		if(request.readyState==4)
			if(request.status==200)
			{
				var data=JSON.parse(request.responseText);
				if(s_clinics)
					s_clinics.push(data.name);
				return data.id;
			}
			else
				return -1;
	}
	
	function edit_clinic(id, longitude="", latitude="")
	{
		var name = document.getElementById("name").value;
		var metro = document.getElementById("metro").value;
		var contacts = document.getElementById("contacts").value;
		var address = document.getElementById("address").value;
		var remark = document.getElementById("remark").value;
		if(name=="")
		{
			return -2;
		}
	    
		var str="id="+(id)+"&name="+(name);
		if(address!="")
		str+="&address="+(address);
		if(remark!="")
		str+="&remark="+(remark);
		if(contacts!="")
		str+="&contacts="+(contacts);
		id_metro=search_station_get_id(metro);
		if(id_metro>0)
		{
			str+="&metro="+(id_metro);
		}
		if(longitude!="")
		str+="&longitude="+(longitude);
		if(latitude!="")
		str+="&latitude="+(latitude);
		request.open("POST","sbase_edit_clinic.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
		if(request.readyState==4)
			if(request.status==200)
				return request.responseText;
			else
				return -1;
	}
	
	function delete_clinic(id)
	{
		if(isNaN(id))return -1;
		request.open("POST","sbase_delete_clinic.php",false);
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