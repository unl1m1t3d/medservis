<?php
date_default_timezone_set('UTC');
$date=DateTime::createFromFormat('Y-m-d|',"2012-02-30");
$date->modify('first day of next year');
echo $date->format('Y-m-d');
?>
<script type="text/javascript" language="javascript">
var xdate=Date.parse('2012-01-01');
xdate=new Date(xdate);
xdate.setMonth(xdate.getMonth()+1);
alert(xdate.toString());
xdate.setDate(xdate.getDate()-1);
alert(xdate.toString());
</script>
$query="SELECT SUM(sum) as summa FROM incomes WHERE date_of_income>='' AND date_of_income<=';
