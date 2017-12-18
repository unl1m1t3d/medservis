	function write_new_income()
	{
		var str="";
		var type_of_income = document.getElementById("type_of_income").value;
		var date_of_income = document.getElementById("date_of_income").value;
		var sum = document.getElementById("sum").value;
		var private_or_public = document.getElementById("private_or_public").value;
		var remark = document.getElementById("remark").value;
		var str="";
		if(type_of_income!="")
	         str+="&type_of_income="+(type_of_income);

		request.open("POST","sbase_search_id_of_income.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send("name="+type_of_income);
				var id_income=request.responseText;
				if(id_income.indexOf('-2')!=-1)
				{
					alert ("No income with this name!");
					return -2;
				}
			str='id_income='+(id_income);
			if(isNaN(parseFloat(sum))==false)
			str+="&sum="+(sum);
			
			if(private_or_public!=-1)
			str+="&private_or_public="+(private_or_public);
			
			if(remark!="")
	         str+="&remark="+(remark);
			 
			date_of_income=date_of_income.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
			var x_date = Date.parse(date_of_income);
			if(isNaN(x_date)==false)
			str+="&date_of_income="+(date_of_income);
		
			request.open("POST","sbase_write_new_income.php",false);
			request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			request.send(str);
			if(request.readyState==4)
			if(request.status==200)
			{
				return request.responseText;
			}
		return -1;
	}
	
	function edit_income(id)
	{
		var str="";
		if(isNaN(id))
		{
			return -1;
		}
		var type_of_income = document.getElementById("type_of_income").value;
		var date_of_income = document.getElementById("date_of_income").value;
		var sum = document.getElementById("sum").value;
		var remark = document.getElementById("remark").value;
		var private_or_public=$('[name="radio_private_or_public"]:checked').val();
		
		if(type_of_income!="")
	         str+="&type_of_income="+(type_of_income);
		request.open("POST","sbase_search_id_of_income.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send("name="+type_of_income);
				var id_income=request.responseText;
				if(id_income.indexOf('-2')!=-1)
				{
					alert ("No income with this name!");
					return -2;
				}
			str='id='+(id)+'&id_income='+(id_income);
			if(isNaN(parseFloat(sum))==false)
			str+="&sum="+(sum);
			
			if(private_or_public!=-1)
			str+="&private_or_public="+(private_or_public);
			
	        str+="&remark="+(remark);
			 
			date_of_income=date_of_income.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
			var x_date = Date.parse(date_of_income);
			if(isNaN(x_date)==false)
			str+="&date_of_income="+(date_of_income);
		
		request.open("POST","sbase_edit_income.php",false);	
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
		if(request.readyState==4)
		if(request.status==200)
		{
			return 0;
		}
		return -3;
	}
	
	function write_income_to_list(income)
	{
		if(income=="")
		return -1;
		request.open("POST","sbase_write_income_to_list.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send("name="+income);
		if(request.readyState==4)
			if(request.status==200)
			{
				return request.responseText;
			}
		return -2;
	}
	
	function delete_income(id)
	{
		if(isNaN(id))return -1;
		request.open("POST","sbase_delete_income.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send("id="+id);
		if(request.readyState==4)
			if(request.status==200)
			{
				return 0;
			}
		return -2;
	}
	function search_income()
	{
		var type_of_income = document.getElementById("type_of_income").value;
		var s_type_of_income = document.getElementById("s_type_of_income").value;
		var date_of_income = document.getElementById("date_of_income").value;
		var s_date_of_income = document.getElementById("s_date_of_income").value;
		var sum = document.getElementById("sum").value;
		var s_sum = document.getElementById("s_sum").value;
		var remark = document.getElementById("remark").value;
		var s_remark = document.getElementById("s_remark").value;
		var private_or_public = document.getElementById("private_or_public").value;
		var str="";
			if(type_of_income!="")
	         str+="s_type_of_income="+(s_type_of_income)+"&type_of_income="+(type_of_income);
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
			
			if(s_date_of_income!="fromto")
			{
				date_of_income=date_of_income.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
				var x_date = Date.parse(date_of_income);
				if(isNaN(x_date)==false)
				str+="&s_date_of_income="+(s_date_of_income)+"&date_of_income="+(date_of_income);
			}
			else
			{
				var to_date_of_income=document.getElementById("to_date_of_income").value;
				date_of_income=date_of_income.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
				var x_date = Date.parse(date_of_income);
				to_date_of_income=to_date_of_income.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
				var to_x_date = Date.parse(to_date_of_income);
				if((!isNaN(x_date))&&(!isNaN(to_x_date)))
				str+="&s_date_of_income="+(s_date_of_income)+"&date_of_income="+(date_of_income)+"&to_date_of_income="+(to_date_of_income);
				else if((isNaN(x_date))&&(!isNaN(to_x_date)))
				str+="&s_date_of_income=less&date_of_income="+(to_date_of_income);
				else if((!isNaN(x_date))&&(isNaN(to_x_date)))
				str+="&s_date_of_income=more&date_of_income="+(date_of_income);
			}
		
		request.open("POST","sbase_search_income.php",false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
		if(request.readyState==4)
		if(request.status==200)
		{	
			$("#div_extra_incomes").html(request.responseText);
		}
	}