<?php
function upload_file($file, $nameFile='default', $upload_dir= 'img', $allowed_types= array('image/png','image/x-png','image/jpeg','image/webp','image/gif')){

  $blacklist = array(".php", ".phtml", ".php3", ".php4");
  $ext = strtolower(substr($filename, strrpos($filename,'.'), strlen($filename)-1)); // В переменную $ext заносим расширение загруженного файла.
  if(in_array($ext,$blacklist )){
    return array('error' => 'Запрещено загружать исполняемые файлы');}

  $upload_dir = dirname(__FILE__).DIRECTORY_SEPARATOR.$upload_dir.DIRECTORY_SEPARATOR; // Место, куда будут загружаться файлы.
  $max_filesize = 8388608; // Максимальный размер загружаемого файла в байтах (в данном случае он равен 8 Мб).
  $prefix = date('Ymd-is_');
  $filename = $file['name']; // В переменную $filename заносим точное имя файла.
  
  if(!is_writable($upload_dir))  // Проверяем, доступна ли на запись папка, определенная нами под загрузку файлов.
    return array('error' => 'Невозможно загрузить файл в папку "'.$upload_dir.'". Установите права доступа - 777.');
//  echo $file['type']."TEST".$file['name']."<br>";
//  if(!in_array($file['type'], $allowed_types))
//    return array('error' => 'Данный тип файла не поддерживается.');

  if(filesize($file['tmp_name']) > $max_filesize)
    return array('error' => 'файл слишком большой. максимальный размер '.intval($max_filesize/(1024*1024)).'мб');

  if(!move_uploaded_file($file['tmp_name'],$upload_dir.$prefix.$nameFile.$ext)) // Загружаем файл в указанную папку.
    return array('error' => 'При загрузке возникли ошибки. Попробуйте ещё раз.');
    $query = "INSERT INTO images(name) VALUES(".$prefix.$nameFile.$ext.")";
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
<div id = "output">
</div>
<?php



?>
</body>
</html>
