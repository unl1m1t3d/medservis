<html>
<head>
<title>База данных-студенты</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<script src="jquery-1.7.1.min.js"></script>
<script>
$(document).ready(function(){

$('#search').keyup(function(){
var query = $(this).val();
$.ajax({
  url: 'getdata.php?query='+query,
  success: function(data) {
    $('#result').html(data);
  },
  error: function(jqXHR, textStatus, errorThrown){
   alert(textStatus);
  }
});
});


});

$('#result .class_states').live("click",function(){
$('#search').val($(this).html());
$('#result').html('');
});

</script>

<input type="text" id="search" value="">
<div id="result"></div>
</body>
</html>