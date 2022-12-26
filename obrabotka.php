Страница обработки <br>
<?php
//	$exif = exif_read_data('img/'.$_POST['picName'],'IFD0');
	echo $_POST['picName']."<br>";
	$exif = exif_read_data('img/'.$_POST['picName'],0,true);
	foreach($exif as $key => $section){
		foreach($section as $name => $val){
			if(!$_POST['full_info'])
			{
				if($key=="IFD0" && $name="Image_Description")echo "$key.$name: $val<br />\n";
			}
			else
			{
				echo "$key.$name: $val <br>\n";
			}
		}
	}
	echo "<img width = 500px src = img/".$_POST['picName'].">";
?>
<form method = "post">
	<input type="text" name="picName" placeholder="Название картинки">
	<div>Отобразить всё<input id = "check1" type="checkbox" name = "full_info"></div>
	<input id="submit" type="submit" value="Проверить">
</form>

<?php
	$dir='./img';
	$files = scandir($dir);
	foreach($files as $n => $img){
		echo $img."<br>";
	}
?>
