Страница обработки <br>
<?php
	$exif = exif_read_data('img/'.$_POST['picName'],'IFD0');
	echo $_POST['picName'];
	$exif = exif_read_data('img/'.$_POST['picName'],0,true);
	foreach($exif as $key => $section){
		foreach($section as $name => $val){
			echo "$key.$name: $val<br />\n";
		}
	}
?>

<form method="post">
	<input type="text" name="picName" placeholder="Название картинки" size="30">
	<input id="submit" type="submit" value="Проверить">
</form>


