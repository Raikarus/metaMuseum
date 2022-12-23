<?php
	$exif = exif_read_data('img/20221113-3445_333.png','IFD0');
	$exif = exif_read_data('img/20221113-3445_333.png',0,true);
	foreach($exif as $key => $section){
		foreach($section as $name => $val){
			echo "$key.$name: $val<br />\n";
		}
	}
?>

Страница обработки
