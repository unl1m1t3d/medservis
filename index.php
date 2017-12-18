<html>
<head>
<title>Документ без названия</title>
<script type="text/javascript" src="text-utils.js"></script>
<script type="text/javascript" src="combo.js"></script>
<script type="text/javascript" src="calendar_ru.js"></script>
<script type="text/javascript" src="med_func.js"></script>
<script type="text/javascript" src="patients.js"></script>

<link rel="stylesheet" type="text/css" href="combo.css" />
<script language="javascript" type="text/javascript">

	var request=null;
	var price=0;
	var payed=0;
	//создаем запрос
		try 
		{
			request = new XMLHttpRequest();
		}	
		catch (trymicrosoft) 
		{
			try 
			{
				request = new ActiveXObject("Msxml2.XMLHTTP");
			}	
			catch (othermicrosoft) 
			{
				try 
				{
					request = new ActiveXObject("Microsoft.XMLHTTP");
				}	
				catch (failed) 
				{
					request=null;
				}
			}
		}
		if(request==null)
			alert("Error!");


</script>
</head>

<body>

<div>
<a href="services.php">Услуги</a>
<a href="patients.php">Пациенты</a>
<a href="medecins.php">Врачи</a>
<a href="queries.php">Запросы</a>
</div>

<div id="table_serv">
</div>
<form id="form_pat">
	<div id="pat">
	<h2>Пациент</h2>
	Имя: <input type="text"  name="name"/>
	Фамилия: <input type="text"  name="surname"/>
	<p>Отчество: <input type="text"  name="patronym"/></p>
	<p>Дата рождения: <input type="text" name="date_of_birth" onfocus="this.select();lcs(this);"
	onclick="event.cancelBubble=true;lcs(this);"/></p>
	<p>Дата прихода: <input type="text"  name="date_of_coming" value="dd-mm-yy" onfocus="this.select();lcs(this);"
	onclick="event.cancelBubble=true;lcs(this);"/></p>
	<p>Пол: 
	<select name="sex">
		<option value="-1">Выберите пол...</option>
		<option value="0">Мужской</option>
		<option value="1">Женский</option>
	</select></p>
	<p>Реклама: 
	<select name="ads">
	<option value="0">Интернет</option>
	<option value="1">Знакомая</option>
	<option value="2">Врач-партнер</option>
	</select>
	<!-- <option value="3"></option> -->
	</p>
	<p>Телефон: <input type="text"  name="phone"/></p>
	<p>E-mail: <input type="text"  name="email"/></p>
	<p>Анамнез: <input type="text"  name="anamnesis"/></p>
	<p>Примечание: <input type="text"  name="remark"/></p>
	</div>
	
	<div id="serv">
	<h2>Услуга</h2>
	<p>Услуга: <input type="text"  name="service"/></p>
	<p>Дата оказания услуги: <input type="text" name="date_serv" value="dd-mm-yy" pattern="[0-9]{2}[-][0-1][0-9][-][0-9]{4}";onfocus="this.select();lcs(this);"
	onclick="event.cancelBubble=true;lcs(this);"/></p>
	<p>Врач(и): <input type="text" name="medecins" value="" selectBoxOptions=""/></p>
	<p>Стоимость: <input type="text" id="price" onBlur="countDebt();"/></p>
	<p>Оплачено: <input type="text" id="payed" onBlur="countDebt();"/></p>
	<p id="debt">
	Долг 
	 <ul>
        <li><span><input type="radio" name="x" value="0" id="radio_1" checked="true"/></span><label for="radio_1">Не оплачен</label></li>
		<li><span><input type="radio" name="x" value="1" id="radio_2" /></span><label for="radio_2">Оплачен</label></li>
	</ul>
	Дата оплаты долга: <input type="text" name="date_debt_payed"/></p>
	<p>Скидка: <input type="text" name="discount"/></p>
	<p>Диагноз: <input type="text" name="diagnoz"/></p>
	</div>
	<p><input type="button" name="send" value="OK" onclick="write_pat();"/></p>
</form>

<script language="JavaScript" type="text/javascript">
	get_pat_serv_med();
	
	 var url_req="get_medecins_ajax.php";
			request.open("GET", url_req, false);
			request.onreadystatechange=function(){
				if(request.readyState==4){
				document.forms[0].medecins.setAttribute('selectBoxOptions',request.responseText);}
				} 
		request.send(null);
	document.onclick=handle;
	createEditableSelect(document.forms[0].medecins);
	function handle(e)
	{
		var selectbox = document.getElementById("selectBox0");
		var n=selectbox.childElementCount;
		var i;
		for(i=0;i<n;i++)
		{
		if(e.target==selectbox.childNodes[i])
			{
				i=-1;
				break;
			}
		}
		if(i>0)
		{
			var optionDiv = document.getElementById('selectBoxOptions0');
			if(optionDiv.style.display=='block')
			{
				optionDiv.style.display='none';
				if(navigator.userAgent.indexOf('MSIE')>=0)document.getElementById('selectBoxIframe' + numId).style.display='none';
				document.getElementById("arrowSelectBox0").src = arrowImageOver;	
			}
		}
		window.routeEvent(e);
	}
</script>
</body>
</html>
