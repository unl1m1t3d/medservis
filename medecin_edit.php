<?php
require_once('settings.php');
if(!isset($_GET['id']))
{
	echo "Не задан id врача!";
	exit;
}
	$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
	if($conn==false)
	die('Error establishing connection!');
	mysql_select_db('base_med');
	$query = "SELECT id,name,surname,patronym,contacts,remark FROM medecins WHERE id=".mysql_real_escape_string($_GET['id']);
	
	$result=mysql_query($query);
	
	if($result==false)
	{
		echo "Ошибка подключения к базе!";
		mysql_close($conn);
		exit;
	}
	$n=mysql_num_rows($result);
	if($n<=0)
	{
		echo "Врач с id ".$_GET['id']." не найден!";
		mysql_close($conn);
		exit;
	}
	if(!($row=mysql_fetch_array($result)))
	{
		exit;
	}
?>
	
<div class="main_fields">
	<h3 class="form_header">Редактирование информации о враче</h3>
	<div>
	<div>Фамилия:
		 <input type="text"  id="surname" value="<?php echo $row['surname'];?>"/>
	</div>
	Имя:
	<input type="text" id="name" value="<?php echo $row['name'];?>"/>
	<div>Отчество:
		 <input type="text"  id="patronym" value="<?php echo $row['patronym'];?>"/></div>
	</div>
	<div>Контакты:
		 <input type="text"  id="contacts" value="<?php echo $row['contacts'];?>"/>
	</div>
	<div>Примечание:
		<textarea  rows="6" cols="30" id="remark"><?php echo $row['remark'];?></textarea>
	</div>
	<div class="buttons">
		<input type="button" id="save" value="Сохранить" onClick="if(edit_medecin(<?php echo $_GET['id']; ?>)>=0)location.href='medecins.php?id='+<?php echo $_GET['id'];?>;"/>
		<input type="button" id="cancel" value="Отмена" onClick="location.href='medecins.php?id='+<?php echo $_GET['id'];?>;"/>
	</div>
</div>	
<?php
	mysql_close($conn);
?>