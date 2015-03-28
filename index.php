<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Twitter Aggregator - For #HashTag</title>
</head>

<body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
window.onload = function(){
var counter = 2;	

var auto_refresh = setInterval(

function ()
{
	if (counter>5)
	{counter=1;}
	else {
		$('.View').html('');
		$('.View').load('aggreagtor.php').fadeIn("slow");
		counter++;
		}

}, 10000);}

</script>

<div class="View">
<?php include 'aggreagtor.php'; ?>
</div>
</body>
</html>