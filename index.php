<?php
$cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
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
	        var img_name = "img/"+$('#img_name').val();
	        var ajaxurl = 'ajax.php',
          var pass = $('#pass').val();
          alert(pass);
	        data =  {'action': clickBtnValue, 'img_name': img_name}, 'pass': pass;
	        $.post(ajaxurl, data, function (response) {
				  $('#output').html(response);
	        });
    	});
	});

	</script>
</head>
<body>
<a href="index.php">Дом</a>
<a href="tags.php">Тэги</a>
<form method="post" enctype="multipart/form-data">
	<input id = "pass" type="password" placeholder="пароль" name="pass">
	<input id="img" name="imgfile" type="file">
	<input class="button" name="Download" value="Download" type="submit">
</form>
<br>
<input type="text" id="img_name" placeholder="Название изображения" />
<input type="submit" class="button" name="read" value="read" />
<input type="submit" class="button" name="list" value="list" />
<input type="submit" class="button" name="pics" value="pics" />
<input type="submit" class="button" name="pictags" value="pictags" />
<input type="submit" class="button" name="REMOVE" value="REMOVE" />
<br>
<form method="post">
	<input type="text" name="img_name" placeholder="Название изображения">
	<select multiple name="kwords[]">
	<?php
		$query = "SELECT kword_name FROM kwords";
		$res = pg_query($cn,$query);
		while($row=pg_fetch_object($res))
		{
			echo "<option>".$row->kword_name."</option>";
		}
	?>
	<input id = "pass" type="password" placeholder="пароль" name="pass">
	<input class="button" name="LinkKeyword" value="LinkKeyword" type="submit">
</form>
<br>
<div id = "output">
</div>
</body>
</html>
