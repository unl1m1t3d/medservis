<html>
<head>
<title>Врачи - База "Медсервис"</title>
<script type="text/javascript" src="combo.js"></script>
<script type="text/javascript" src="calendar_ru.js"></script>
<script type="text/javascript" src="med_func.js"></script>
<script type="text/javascript" src="medecins.js"></script>
<script type="text/javascript" src="patients.js"></script>
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>

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
			include 'medecin_edit.php';
		}
		else
		{
			echo '<body>';
			include("medecin_by_id.php");
		}
	}
	else if(!empty($_GET['act'])&&$_GET['act']=="create")
	{
		echo '<body>';
		include("medecin_create.php");
	}
	else 
	{
		echo '<body onLoad="search_medecin();">';
		include("medecin_search.php");
	}
?>

<script language="JavaScript" type="text/javascript">
 	document.onclick=handle;
</script>
</body>
</html>
