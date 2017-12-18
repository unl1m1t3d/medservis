<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Документ без названия</title>
</head>

<body>

<div>
<a href="services.php">Услуги</a>
<a href="patients.php">Пациенты</a>
<a href="medecins.php">Врачи</a>
<a href="queries.php">Запросы</a>
</div>
<?php
error_reporting(E_ALL);
$conn=sqlsrv_connect('pc1\\sqlexpress',array("Database"=>"xbase"));
if($conn==false)
	die('Error establishing connection!');
$result=sqlsrv_query($conn,'
	SELECT TOP 100 * 
	FROM pat_serv_med');
if($result==false)
{
	sqlsrv_close($conn);
	die('Error in the query!');
}
$n=sqlsrv_num_rows($result);
if($n==0)
{
	echo "No services";
}
else
{
	echo '<table>';
	for($i=0;$i<$n;$i++)
	{
		echo '<tr>';
		foreach ($result[$i] as $key => $value)
		{
			echo '<td>';
			echo $value;
			echo '</td>';
		}
		echo '</tr>';
	}
	echo '</table>';
}
sqlsrv_close($conn);
?>
</body>
</html>
