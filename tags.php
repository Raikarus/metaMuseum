<?php
    function AddKeyword()
    {
        if($_POST['passAdd']=="schef2002"){
        echo "П4р0ль пр0йд3н <br>";
        $kword_name = $_POST['kword_name'];
        $cn = pg_connect("host=localhost port=5432 dbname=museumbasa user=mm password=schef2002");
        $query = "SELECT tag_id_num FROM kwords WHERE tag_id=10 AND kword_name='$kword_name'";
        echo "ЗАПРОСИК $query<br>";
        $res = pg_query($cn,$query);
        $row = pg_fetch_object($res);
        if(!$row->tag_id_num)
        {
        	$query = "INSERT INTO kwords(tag_id,kword_name,status) VALUES(10,'$kword_name',1)";
        	$res = pg_query($cn,$query);
        	echo "ЗАПРОСИК $query<br>";

        	$query = "SELECT tag_id_num FROM kwords WHERE tag_id=10 AND kword_name='$kword_name'";
        	$res = pg_query($cn,$query);
        	echo "ЗАПРОСИК $query<br>";
        	$row = pg_fetch_object($res);
        	$tag_id_num = $row->tag_id_num;
        	$query = "INSERT INTO kwgkw(gkword_id,tag_id,tag_id_num) VALUES(0,10,$tag_id_num)";
        	echo "ЗАПРОСИК $query<br>";
        	$res = pg_query($cn,$query);
        }
        else
        {
        	echo "Тэг $kword_name уже существует <br>";
        }
        }
        else
        {
            echo "П4р0ль не пр0йд3н <br>";
        }
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
<a href="style.php">Главная</a>
<br>
<input type="text" id="img_name" placeholder="Название изображения">
<input type="submit" class="button" name="read" value="read" />
<input type="submit" class="button" name="list" value="list" />
<input type="submit" class="button" name="kwords" value="kwords" />
<input type="submit" class="button" name="kwgkw" value="kwgkw" />
<br>
<form method="post">
	<input type="text" name="kword_name" placeholder="Название ключевого слова">
	<input type="password" placeholder="пароль" name="passAdd">
	<input name="AddKeyword" value="AddKeyword" type="submit">
</form>
<br>
<div id = "output">
	<?php
	AddKeyword();
	?>
</div>
</body>
</html>