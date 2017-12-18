<?php
require_once('settings.php');
error_reporting(E_ALL);
date_default_timezone_set('UTC');
$conn=mysql_connect($_MYSQL_HOST,$_MYSQL_USERNAME,$_MYSQL_PASSWORD);
if($conn==false)
	die('Error establishing connection!');
mysql_select_db("base_med");
if(!isset($_REQUEST["date"]))
{
	header("Error: no begin date!",true,400);	
	mysql_close($conn);
	exit;
}
if(!isset($_REQUEST["to_date"]))
{
	header("Error: no end date!",true,400);	
	mysql_close($conn);
	exit;
}
if(!($begin_date=DateTime::createFromFormat('Y-m-d|',$_REQUEST["date"])))
{
	header("Error: Wrong begin date!",true,400);	
	mysql_close($conn);
	exit;
}
if(!($end_date=DateTime::createFromFormat('Y-m-d|',$_REQUEST["to_date"])))
{
	header("Error: Wrong end date!",true,400);	
	mysql_close($conn);
	exit;
}
if(!isset($_REQUEST["interval"]))
{
	$s="";
	$query="SELECT COUNT(id) as num_pat,date_of_coming FROM patients WHERE date_of_coming>='".$begin_date->format('Y-m-d')."' AND date_of_coming<='".$end_date->format('Y-m-d')."' GROUP BY date_of_coming";
	$result=mysql_query($query);
	header("Query: ".$query);
	if($result==false)
	{
		header("Query: ".$query,true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
	}
	while($row=mysql_fetch_array($result))
	{
		$date=DateTime::createFromFormat('Y-m-d|',$row['date_of_coming']);
		if($date==false)
		{
		header("Date: ".$row['date_of_coming'],true);
		header("Status: ".mysql_error($conn),true,400);
		mysql_close($conn);
		exit;
		}
		$s.=($date->getTimestamp()*1000).'|'.$row['num_pat'].';';
	}
}
else
{
	switch($_REQUEST["interval"])
	{
		case "day":
			$interval=new DateInterval('P1D');
			$date=DateTime::createFromFormat('Y-m-d|',$_REQUEST["date"]);
			$n=0;
			$s="";
			while($date<=$end_date)
			{
				$query="SELECT COUNT(id) as num_pat FROM patients WHERE date_of_coming='".$date->format('Y-m-d')."'";
				$result=mysql_query($query);
				header("Query$n: ".$query);
				$n++;
				if($result==false)
				{
					header("Query: ".$query,true);
					header("Status: ".mysql_error($conn),true,400);
					mysql_close($conn);
					exit;
				}
				if($row=mysql_fetch_array($result))
				{
					$s.=($date->getTimestamp()*1000).'|'.$row['num_pat'].';';
				}
				$date->add($interval);
			}
			break;
		case "month":
			$date=DateTime::createFromFormat('Y-m-d|',$_REQUEST["date"]);
			$next_date=DateTime::createFromFormat('Y-m-d|',$_REQUEST["date"]);
			$next_date->modify('last day of ');
			if($next_date>$end_date)
				$next_date=$end_date;
			$n=0;
			$s="";
			if($next_date==$end_date)
			{
				$query="SELECT COUNT(id) as num_pat FROM patients WHERE date_of_coming>='".$date->format('Y-m-d')."' AND date_of_coming<='".$next_date->format('Y-m-d')."'";
				$result=mysql_query($query);
				header("Query$n: ".$query);
				$n++;
				if($result==false)
				{
					header("Query: ".$query,true);
					header("Status: ".mysql_error($conn),true,400);
					mysql_close($conn);
					exit;
				}
				if($row=mysql_fetch_array($result))
				{
					$s.=($next_date->getTimestamp()*1000).'|'.$row['num_pat'].';';
				}
			}
			else
			while($next_date<=$end_date)
			{
				$query="SELECT COUNT(id) as num_pat FROM patients WHERE date_of_coming>='".$date->format('Y-m-d')."' AND date_of_coming<='".$next_date->format('Y-m-d')."'";
				$result=mysql_query($query);
				header("Query$n: ".$query);
				$n++;
				if($result==false)
				{
					header("Query: ".$query,true);
					header("Status: ".mysql_error($conn),true,400);
					mysql_close($conn);
					exit;
				}
				if($row=mysql_fetch_array($result))
				{
					$s.=($next_date->getTimestamp()*1000).'|'.$row['num_pat'].';';
				}
				$date->modify('first day of next month');
				$next_date->modify('last day of next month');
				if($next_date>=$end_date)
				{
					$next_date=$end_date;
					$query="SELECT COUNT(id) as num_pat FROM patients WHERE date_of_coming>='".$date->format('Y-m-d')."' AND date_of_coming<='".$next_date->format('Y-m-d')."'";
					$result=mysql_query($query);
					header("Query$n: ".$query);
					$n++;
					if($result==false)
					{
						header("Query: ".$query,true);
						header("Status: ".mysql_error($conn),true,400);
						mysql_close($conn);
						exit;
					}
					if($row=mysql_fetch_array($result))
					{
						$s.=($next_date->getTimestamp()*1000).'|'.$row['num_pat'].';';
					}
					break;
				}
			}
			break;
		case "year":
			$date=DateTime::createFromFormat('Y-m-d|',$_REQUEST["date"]);
			$next_date=DateTime::createFromFormat('Y-m-d|',$_REQUEST["date"]);
			$next_date->modify('12/31 this year');
			if($next_date>$end_date)
				$next_date=$end_date;
			$n=0;
			$s="";
			if($next_date==$end_date)
			{
				$query="SELECT COUNT(id) as num_pat FROM patients WHERE date_of_coming>='".$date->format('Y-m-d')."' AND date_of_coming<='".$next_date->format('Y-m-d')."'";
				$result=mysql_query($query);
				header("Query$n: ".$query);
				$n++;
				if($result==false)
				{
					header("Query: ".$query,true);
					header("Status: ".mysql_error($conn),true,400);
					mysql_close($conn);
					exit;
				}
				if($row=mysql_fetch_array($result))
				{
					$s.=($next_date->getTimestamp()*1000).'|'.$row['num_pat'].';';
				}
			}
			else
			while($next_date<=$end_date)
			{
				$query="SELECT COUNT(id) as num_pat FROM patients WHERE date_of_coming>='".$date->format('Y-m-d')."' AND date_of_coming<='".$next_date->format('Y-m-d')."'";
				$result=mysql_query($query);
				header("Query$n: ".$query);
				$n++;
				if($result==false)
				{
					header("Query: ".$query,true);
					header("Status: ".mysql_error($conn),true,400);
					mysql_close($conn);
					exit;
				}
				if($row=mysql_fetch_array($result))
				{
					$s.=($next_date->getTimestamp()*1000).'|'.$row['num_pat'].';';
				}
				$date->modify('1/1 next year');
				$next_date->modify('12/31 next year');
				if($next_date>=$end_date)
				{
					$next_date=$end_date;
					$query="SELECT COUNT(id) as num_pat FROM patients WHERE date_of_coming>='".$date->format('Y-m-d')."' AND date_of_coming<='".$next_date->format('Y-m-d')."'";
					$result=mysql_query($query);
					header("Query$n: ".$query);
					$n++;
					if($result==false)
					{
						header("Query: ".$query,true);
						header("Status: ".mysql_error($conn),true,400);
						mysql_close($conn);
						exit;
					}
					if($row=mysql_fetch_array($result))
					{
						$s.=($next_date->getTimestamp()*1000).'|'.$row['num_pat'].';';
					}
					break;
				}
			}
			break;
		default:
		if(is_numeric($_REQUEST["interval"]))
		if(($interval=intval($_REQUEST["interval"]+0))>1)
		{
			$interval=new DateInterval('P'.$interval.'D');
			$date=DateTime::createFromFormat('Y-m-d|',$_REQUEST["date"]);
			$next_date=DateTime::createFromFormat('Y-m-d|',$_REQUEST["date"]);
			$next_date->add($interval);
			$next_date->modify('- 1 day');
			if($next_date>$end_date)
				$next_date=$end_date;
			$n=0;
			$s="";
			if($next_date==$end_date)
			{
				$query="SELECT COUNT(id) as num_pat FROM patients WHERE date_of_coming>='".$date->format('Y-m-d')."' AND date_of_coming<='".$next_date->format('Y-m-d')."'";
				$result=mysql_query($query);
				header("Query$n: ".$query);
				$n++;
				if($result==false)
				{
					header("Query: ".$query,true);
					header("Status: ".mysql_error($conn),true,400);
					mysql_close($conn);
					exit;
				}
				if($row=mysql_fetch_array($result))
				{
					$s.=($next_date->getTimestamp()*1000).'|'.$row['num_pat'].';';
				}
			}
			else
			while($next_date<=$end_date)
			{
				$query="SELECT COUNT(id) as num_pat FROM patients WHERE date_of_coming>='".$date->format('Y-m-d')."' AND date_of_coming<='".$next_date->format('Y-m-d')."'";
				$result=mysql_query($query);
				header("Query: ".$query);
				$n++;
				if($result==false)
				{
					header("Query: ".$query,true);
					header("Status: ".mysql_error($conn),true,400);
					mysql_close($conn);
					exit;
				}
				if($row=mysql_fetch_array($result))
				{
					$s.=($next_date->getTimestamp()*1000).'|'.$row['num_pat'].';';
				}
				$date->add($interval);
				$next_date->add($interval);
				if($next_date>=$end_date)
				{
					$next_date=$end_date;
					$query="SELECT COUNT(id) as num_pat FROM patients WHERE date_of_coming>='".$date->format('Y-m-d')."' AND date_of_coming<='".$next_date->format('Y-m-d')."'";
					$result=mysql_query($query);
					header("Query$n: ".$query);
					$n++;
					if($result==false)
					{
						header("Query: ".$query,true);
						header("Status: ".mysql_error($conn),true,400);
						mysql_close($conn);
						exit;
					}
					if($row=mysql_fetch_array($result))
					{
						$s.=($next_date->getTimestamp()*1000).'|'.$row['num_pat'].';';
					}
					break;
				}
			}
			break;
		}
		$interval=new DateInterval('P1D');
		$date=DateTime::createFromFormat('Y-m-d|',$_REQUEST["date"]);
		$n=0;
		$s="";
		while($date<=$end_date)
		{
			$query="SELECT COUNT(id) as num_pat FROM patients WHERE date_of_coming='".$date->format('Y-m-d')."'";
			$result=mysql_query($query);
			header("Query$n: ".$query);
			$n++;
			if($result==false)
			{
				header("Query: ".$query,true);
				header("Status: ".mysql_error($conn),true,400);
				mysql_close($conn);
				exit;
			}
			if($row=mysql_fetch_array($result))
			{
				$s.=($next_date->getTimestamp()*1000).'|'.$row['num_pat'].';';
			}
			$date->add($interval);
		}
		break;
	}
}

$s=substr_replace($s ,"",-1);
echo $s;
$query="SELECT COUNT(id) as num_pat FROM patients WHERE date_of_coming>='".$begin_date->format('Y-m-d')."' AND date_of_coming<='".$end_date->format('Y-m-d')."'";
header("Query_num: ".$query,true);
$result=mysql_query($query);
if($result==false)
{
	header("Query: ".$query,true);
	header("Status: ".mysql_error($conn),true,400);
	mysql_close($conn);
	exit;
}
if($row=mysql_fetch_array($result))
{
	header("Num_pat: ".$row['num_pat'],true);
}
else
{
	header("Query: ".$query,true);
	header("Status: ".mysql_error($conn),true,400);
	mysql_close($conn);
	exit;
}
mysql_close($conn);
?>