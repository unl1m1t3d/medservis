	function write_drug_to_list(drug)
	{
		if(drug==null)
		return -1;
		request.open("POST","sbase_write_drug_to_list.php",false);
		request.onreadystatechange = function(){
			if(request.readyState==4)
			if(request.status==200)
			{
				return request.responseText;
			}
			else
			{
				alert("Status: "+request.getResponseHeader("Status")+"\nQuery: "+request.getResponseHeader("Query"));
				return -2;
			}
			};
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.send("name="+drug);
	}