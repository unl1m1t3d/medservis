	function write_new_charge()
	{
		var str="";
		var type_of_charge = document.getElementById("type_of_charge").value;
		var date_of_charge = document.getElementById("date_of_charge").value;
		var sum = document.getElementById("sum").value;
		var private_or_public = document.getElementById("private_or_public").value;
		var remark = document.getElementById("remark").value;
		var str="";
		if(type_of_charge!="")
	         str+="&type_of_charge="+(type_of_charge);

		request.open("POST","sbase_search_id_of_charge.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send("name="+type_of_charge);
				var id_charge=request.responseText;
				if(id_charge.indexOf('-2')!=-1)
				{
					alert ("No charge with this name!");
					return -2;
				}
			str='id_charge='+(id_charge);
			if(isNaN(parseFloat(sum))==false)
			str+="&sum="+(sum);
			
			if(private_or_public!=-1)
			str+="&private_or_public="+(private_or_public);
			
			if(remark!="")
	         str+="&remark="+(remark);
			 
			date_of_charge=date_of_charge.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
			var x_date = Date.parse(date_of_charge);
			if(isNaN(x_date)==false)
			str+="&date_of_charge="+(date_of_charge);
		
			request.open("POST","sbase_write_new_charge.php",false);
			request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			request.send(str);
			if(request.readyState==4)
			if(request.status==200)
			{
				return request.responseText;
			}
		return -1;
	}
	
	function edit_charge(id)
	{
		var str="";
		if(isNaN(id))
		{
			return -1;
		}
		var type_of_charge = document.getElementById("type_of_charge").value;
		var date_of_charge = document.getElementById("date_of_charge").value;
		var sum = document.getElementById("sum").value;
		var remark = document.getElementById("remark").value;
		var private_or_public=$('[name="radio_private_or_public"]:checked').val();
		
		if(type_of_charge!="")
		{
			request.open("POST","sbase_search_id_of_charge.php",false);
			request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			request.send("name="+type_of_charge);
			var id_charge=request.responseText;
				if(id_charge.indexOf('-2')!=-1)
				{
					alert ("No charge with this name!");
					return -2;
				}
			str='id='+(id)+'&id_charge='+(id_charge);
		}
		else
		return -2;
		if(type_of_charge=="Оплата врачу-партнеру")
		{
			str+="&private_or_public=0";
			var med_part=$("#med_part").val();
			var id_med_part=search_med_part_get_id(med_part);
			if(id_med_part>=-1)
			str+="&med_part="+(id_med_part);
			else
			return -4;
			var patient=$("#pat").val();
			var id_patient=search_med_part_patients_get_id(patient,id_med_part);
			if(id_patient>=-1)
			str+="&patient="+(id_patient);
			else
			return -5;
		}
		else
		if(private_or_public!=-1)
		str+="&private_or_public="+(private_or_public);
		
		if(isNaN(parseFloat(sum))==false)
		str+="&sum="+(sum);
		
		str+="&remark="+(remark);
		 
		date_of_charge=date_of_charge.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
		var x_date = Date.parse(date_of_charge);
		if(isNaN(x_date)==false)
		str+="&date_of_charge="+(date_of_charge);
	
		request.open("POST","sbase_edit_charge.php",false);	
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
		if(request.readyState==4)
		if(request.status==200)
		{
			return 0;
		}
		return -3;
	}
	
	function write_charge_to_list(charge)
	{
		if(charge=="")
		return -1;
		request.open("POST","sbase_write_charge_to_list.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send("name="+charge);
		if(request.readyState==4)
			if(request.status==200)
			{
				return request.responseText;
			}
		return -2;
	}
	
	function delete_charge(id)
	{
		if(isNaN(id))return -1;
		request.open("POST","sbase_delete_charge.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send("id="+id);
		if(request.readyState==4)
			if(request.status==200)
			{
				return 0;
			}
		return -2;
	}
	function search_charge()
	{
		var type_of_charge = document.getElementById("type_of_charge").value;
		var s_type_of_charge = document.getElementById("s_type_of_charge").value;
		var date_of_charge = document.getElementById("date_of_charge").value;
		var s_date_of_charge = document.getElementById("s_date_of_charge").value;
		var sum = document.getElementById("sum").value;
		var s_sum = document.getElementById("s_sum").value;
		var remark = document.getElementById("remark").value;
		var s_remark = document.getElementById("s_remark").value;
		var private_or_public = document.getElementById("private_or_public").value;
		var str="";
			if(type_of_charge!="")
	         str+="s_type_of_charge="+(s_type_of_charge)+"&type_of_charge="+(type_of_charge);
			if(s_sum!="fromto")
			{
				if(isNaN(parseFloat(sum))==false)
				str+="&s_sum="+(s_sum)+"&sum="+(sum);
			}
			else
			{
				var to_sum=document.getElementById("to_sum").value;
				to_sum=parseFloat(to_sum);
				sum=parseFloat(sum);
				if((!isNaN(sum))&&(!isNaN(to_sum)))
				str+="&s_sum="+(s_sum)+"&sum="+(sum)+"&to_sum="+(to_sum);
				else if((isNaN(sum))&&(!isNaN(to_sum)))
				str+="&s_sum=less&sum="+(to_sum);
				else if((!isNaN(sum))&&(isNaN(to_sum)))
				str+="&s_sum=more&sum="+(sum);
			}

			if(remark!="")
	         str+="&s_remark="+(s_remark)+"&remark="+(remark);		
			if(private_or_public!=-1)
			str+="&private_or_public="+(private_or_public);
			
			if(s_date_of_charge!="fromto")
			{
				date_of_charge=date_of_charge.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
				var x_date = Date.parse(date_of_charge);
				if(isNaN(x_date)==false)
				str+="&s_date_of_charge="+(s_date_of_charge)+"&date_of_charge="+(date_of_charge);
			}
			else
			{
				var to_date_of_charge=document.getElementById("to_date_of_charge").value;
				date_of_charge=date_of_charge.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
				var x_date = Date.parse(date_of_charge);
				to_date_of_charge=to_date_of_charge.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
				var to_x_date = Date.parse(to_date_of_charge);
				if((!isNaN(x_date))&&(!isNaN(to_x_date)))
				str+="&s_date_of_charge="+(s_date_of_charge)+"&date_of_charge="+(date_of_charge)+"&to_date_of_charge="+(to_date_of_charge);
				else if((isNaN(x_date))&&(!isNaN(to_x_date)))
				str+="&s_date_of_charge=less&date_of_charge="+(to_date_of_charge);
				else if((!isNaN(x_date))&&(isNaN(to_x_date)))
				str+="&s_date_of_charge=more&date_of_charge="+(date_of_charge);
			}
		
		request.open("POST","sbase_search_charge.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
		if(request.readyState==4)
		if(request.status==200)
		{	
			$("#div_extra_charges").html(request.responseText);
		}
	}