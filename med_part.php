<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Врачи-партнеры - База "Медсервис"</title>
<script type="text/javascript" src="med_func.js"></script>
<script type="text/javascript" src="combo.js"></script>
<script type="text/javascript" src="calendar_ru.js"></script>
<script type="text/javascript" src="medecins.js"></script>
<script type="text/javascript" src="med_part.js"></script>
<script type="text/javascript" src="clinics.js"></script>
<script type="text/javascript" src="stations.js"></script>
<script type="text/javascript" src="patients.js"></script>
<script type="text/javascript" src="window_search.js"></script>
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="alert.js"></script>
<script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="combo.css" />
<script language="javascript" type="text/javascript">
	var request=null;
	var new_pat_id=0;
	var new_serv_id=0;
	var price=0;
	var payed=0;
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
<?php
	include("menu.php");
	if(!empty($_GET['id']))
	{
		if(!empty($_GET['act'])&&$_GET['act']=='edit')
		{
			echo '<body>';
			include 'med_part_edit.php';
		}
		else
		{
			echo '<body>';
			include("med_part_by_id.php");
		}
	}
	else if(!empty($_GET['act'])&&$_GET['act']=="create")
	{
		echo '<body>';
		include("med_part_create.php");
	}
	else 
	{
		echo '<body onLoad="search_med_part();">';
		include("med_part_search.php");
	}
?>
<script language="JavaScript" type="text/javascript">
 	document.onclick=handle;
</script>
</body>
</html>
