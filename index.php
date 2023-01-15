<?php
	function select()
	{
		echo "SELECT";
	}
	function insert()
	{
		echo "INSERT";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>
		SCHEF
	</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	
	<script>

	$(document).ready(function(){
    	$('.button').click(function(){
	        var clickBtnValue = $(this).val();
	        var ajaxurl = 'ajax.php',
	        data =  {'action': clickBtnValue};
	        $.post(ajaxurl, data, function (response) {
	            // Response div goes here.
	            alert("action performed successfully");
	        });
    	});
	});

	</script>
</head>
<body>

<input type="submit" class="button" name="insert" value="insert" />
<input type="submit" class="button" name="select" value="select" />

<?php



?>
</body>
</html>