function query_period()
{
	var date_begin = document.getElementById("date_begin").value;
	var date_end = document.getElementById("date_end").value;
	
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
	url:"sbase_query.php",
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