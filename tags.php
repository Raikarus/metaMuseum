<?php
if($_POST['pass']=="schef2002"){
        echo "П4р0ль пр0йд3н <br>";
        $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
        $query = "INSERT INTO kwords(tag_id,kword_name,status) VALUES(10,'".$_POST['kword_name']."',1)";
        echo "<br>--- ".$query." ---<br>";
        $res = pg_query($cn,$query);
}
else
{
	echo "П4р0ль не пр0йд3н <br>";
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
	        var img_name = "img/"+$('#img_name').val();
	        var ajaxurl = 'ajax.php',
	        data =  {'action': clickBtnValue, 'img_name': img_name};
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
<br>
<input type="text" id="img_name" placeholder="Название изображения">
<input type="submit" class="button" name="read" value="read" />
<input type="submit" class="button" name="list" value="list" />
<input type="submit" class="button" name="tags" value="tags" />
<div id = "output">
</div>

<form method="post">
	<input type="text" name="kword_name" placeholder="Название ключевого слова">
	<input type="password" placeholder="пароль" name="pass">
	<input value="Добавить ключевое слово" type="submit">
</form>

</body>
</html>