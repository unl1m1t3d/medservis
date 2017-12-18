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
		
		var s_surname = document.getElementById("s_surname").value;
		var s_name = document.getElementById("s_name").value;
		var s_patronym = document.getElementById("s_patronym").value;
		var s_sex = document.getElementById("s_sex").value;
		//var s_ads = document.getElementById("s_ads").value;
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
			 //str+="$s_ads=equal"+"&ads="+(ads);
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
		var w=document.getElementsByName("radio_date");
		if(w[0].checked)
		{
			var s_age = document.getElementById("s_age").value;
			var age = document.getElementById("age").value;
			if(age!="")
				if(s_age!="fromto")
				str+="&s_age="+(s_age)+"&age="+(age);
				else
				{
					var x=document.getElementById("to_age");
					if(x!=null) var to_age=x.value;
					if(to_age!="")
						str+="&s_age="+(s_age)+"&age="+(age)+"&to_age="+(to_age);
				}
		}
		else if(w[1].checked)
		{
			var s_date_of_birth = document.getElementById("s_date_of_birth").value;
			var date_of_birth = document.getElementById("date_of_birth").value;
			date_of_birth=date_of_birth.replace(/(\d+).(\d+).(\d+)/, '$3-$2-$1');
			x_date = Date.parse(date_of_birth);
			if(isNaN(x_date)==false)
			str+="&s_date_of_birth="+(s_date_of_birth)+"&date_of_birth="+(date_of_birth);
		}
		else
		{
			var s_year_of_birth = document.getElementById("s_year_of_birth").value;
			var year_of_birth = document.getElementById("year_of_birth").value;
			if(year_of_birth!="")
			str+="&s_year_of_birth="+(s_year_of_birth)+"&year_of_birth="+(year_of_birth);
		}
		request.open("POST","search_pat.php",false);
		request.onreadystatechange = update_page_patients;
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send(str);
	}
	
	function show_inputs(elem)
	{
	var s;
	if(elem.value=='fromto')
		{	
			s=elem.getAttribute('id');
			s=s.replace("s_","");
			ppp=document.createElement('input');
			ppp.setAttribute('type','text');
			ppp.setAttribute('id','to_'+s);
			elem.parentNode.appendChild(ppp);
			
			ppp=document.createElement('span');
			ppp.setAttribute('id','ot_'+s);
			elem.parentNode.insertBefore(ppp,document.getElementById(s));
			ppp.appendChild(document.createTextNode("От: "));
			
			ppp=document.createElement('span');
			ppp.setAttribute('id','do_'+s);
			elem.parentNode.insertBefore(ppp,document.getElementById("to_"+s));
			ppp.appendChild(document.createTextNode("До: "));
		}
		else
		{
			s=elem.getAttribute('id');
			s=s.replace('s_','');
			var el;
			if(el=document.getElementById("to_"+s))el.parentNode.removeChild(el);
			if(el=document.getElementById("ot_"+s))el.parentNode.removeChild(el);
			if(el=document.getElementById("do_"+s))el.parentNode.removeChild(el);
		}
	}
	
	function update_page_patients()
	{
		if(request.readyState==4)
		if(request.status==200)
		{
			document.getElementById('table_serv').innerHTML=request.responseText;
		}
		else
		alert(request.getResponseHeader("Status")+'\n'+request.getResponseHeader("Query"));
	}