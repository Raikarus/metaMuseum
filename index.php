<?php
$cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
function upload_file($file, $nameFile='default', $upload_dir= 'img', $allowed_types= array('image/png','image/x-png','image/jpeg','image/webp','image/gif')){

  $blacklist = array(".php", ".phtml", ".php3", ".php4");
  $filename = $file['name']; // В переменную $filename заносим точное имя файла.
  $ext = strtolower(substr($filename, strrpos($filename,'.'), strlen($filename)-1)); // В переменную $ext заносим расширение загруженного файла.
  if(in_array($ext,$blacklist )){
    return array('error' => 'Запрещено загружать исполняемые файлы');}

  $upload_dir = dirname(__FILE__).DIRECTORY_SEPARATOR.$upload_dir.DIRECTORY_SEPARATOR; // Место, куда будут загружаться файлы.
  $max_filesize = 8388608; // Максимальный размер загружаемого файла в байтах (в данном случае он равен 8 Мб).
  $prefix = date('Ymd-is_');
  
  if(!is_writable($upload_dir))  // Проверяем, доступна ли на запись папка, определенная нами под загрузку файлов.
    return array('error' => 'Невозможно загрузить файл в папку "'.$upload_dir.'". Установите права доступа - 777.');
//  echo $file['type']."TEST".$file['name']."<br>";
//  if(!in_array($file['type'], $allowed_types))
//    return array('error' => 'Данный тип файла не поддерживается.');

  if(filesize($file['tmp_name']) > $max_filesize)
    return array('error' => 'файл слишком большой. максимальный размер '.intval($max_filesize/(1024*1024)).'мб');

  if(!move_uploaded_file($file['tmp_name'],$upload_dir.$prefix.$nameFile.$ext)) // Загружаем файл в указанную папку.
    return array('error' => 'При загрузке возникли ошибки. Попробуйте ещё раз.');
    $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
  	$query = "INSERT INTO pics(title,fmt,fsize) VALUES('".$file['name']."','$ext',".$file['size'].")";
  	echo "<br>".$cn."--=--".$query."<br>";
  	$res = pg_query($cn,$query);
    return Array('filename' => $prefix.$nameFile.$ext);
}
if($_POST['pass']=="schef2002"){
        echo "П4р0ль пр0йд3н <br>";
        $res=upload_file($_FILES['imgfile'],$_POST['etc']);
        foreach($res as $a => $b){
                echo $a." ".$b."<br>";
        }
}
else if($_POST['pass']=="schef2003"){
        echo "П4р0ль пр0йд3н <br>";

        $shl = 'exiftool -TagsFromFile img/'.$_POST['img_name'].' img/file.xmp';
        $res = shell_exec($shl);
        echo "<pre>$res</pre>";

        $shl = 'exiftool -XMP=img/'.$_POST['img_name'];
        $res = shell_exec($shl);
        echo "<br><pre>$res</pre>";

        $shl = 'exiftool -TagsFromFile img/file.xmp img/'.$_POST['img_name'];
        $res = shell_exec($shl);
        echo "<br><pre>$res</pre>";

        $query="SELECT pic_id FROM pics WHERE title='".$_POST['img_name']."'";
        $res = pg_query($cn,$query);
        $row=pg_fetch_object($res);
        $pic_id = $row->pic_id;

        foreach($_POST['kwords'] as $selected_kword)
        {
	       	$shl = 'exiftool -XMP-dc:subject+="'.$selected_kword.'" img/'.$_POST['img_name'];
    	    $res = shell_exec($shl);
        	echo "<br><pre>$res</pre>";	
          
          $query="SELECT tag_id,tag_id_num WHERE tag_name='".$selected_kword."'";
          $res = pg_query($cn,$res);
          $row=pg_fetch_object($res);
          $tag_id = $row->tag_id;
          $tag_id_num = $row->tag_id_num;
          $query="INSERT INTO pictags(pic_id,tag_id,tag_id_num) VALUES (".$pic_id.",".$tag_id.",".$tag_id_num.")";
          $res = pg_query($cn,$query);

          echo $query."<br>";
        }

        $shl = 'exiftool -XMP-dc:ALL img/'.$_POST['img_name']." -b";
        $res = shell_exec($shl);
        echo "<br><pre>$res</pre>";

        $shl = 'rm img/file.xmp';
        $res = shell_exec($shl);
        
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
<form method="post" enctype="multipart/form-data">
	<input type="text" name="etc" placeholder="имя">
	<input type="password" placeholder="пароль" name="pass">
	<input id="img" name="imgfile" type="file">
	<input value="Загрузить" type="submit">
</form>
<br>
<input type="text" id="img_name" placeholder="Название изображения">
<input type="submit" class="button" name="read" value="read" />
<input type="submit" class="button" name="list" value="list" />
<input type="submit" class="button" name="SQL" value="SQL" />
<div id = "output">
</div>
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
	<input type="password" placeholder="пароль" name="pass">
	<input value="Добавить ключевое слово" type="submit">
</form>
</body>
</html>
