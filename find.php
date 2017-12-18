<?php
require_once('settings.php');
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection!');
mysql_select_db('dbo');
$query = "SELECT name FROM medp";
$result=mysql_query($query);
if($result==false)
{
	mysql_close($conn);
	die('error: '.mysql_error($conn));
}
$array=array();
while($row=mysql_fetch_array($result))
{
	$arr[]=$row['name'];
}

for($j=0;$j<count($arr);$j++)
{
	$s=preg_split('/ /',$arr[$j]);
	$c=0;
	while($c<count($s)&&((mb_ereg_match('/д.?р/i',$s[$c]))||(mb_ereg_match('/ж.?к/i',$s[$c])))&&strlen($s[$c])>2) $c++;
	if($c<count($s)&&$s[$c]!="")
	{
		$str_search=mb_ereg_replace('/[аоеиэ]/i','.',$s[$c]);
		$num_matches=0;
		echo '<p>-> К '.$str_search.' подошли ';
		for($i=$j+1;$i<count($arr);$i++)
		{
			if(mb_ereg_match('/\b'.preg_quote($str_search).'\B/i',$arr[$i])>0)
			{
				echo $arr[$i].' | ';				
				$num_matches++;
				array_splice($arr,$i,1);
				$i--;
			}
		}
		echo $num_matches.' совпадений</p>';
	}
}

foreach($arr as $key=>$value)
{
	echo '<p>'.$value.'</p>';
}
mysql_close($conn);
?>