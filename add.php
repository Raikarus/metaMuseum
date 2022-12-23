<?php
function upload_file($file, $nameFile='default', $upload_dir= 'img', $allowed_types= array('image/png','image/x-png','image/jpeg','image/webp','image/gif')){

  $blacklist = array(".php", ".phtml", ".php3", ".php4");

  if(in_array($ext,$blacklist )){
    return array('error' => 'Запрещено загружать исполняемые файлы');}

  $upload_dir = dirname(__FILE__).DIRECTORY_SEPARATOR.$upload_dir.DIRECTORY_SEPARATOR; // Место, куда будут загружаться файлы.
  $max_filesize = 8388608; // Максимальный размер загружаемого файла в байтах (в данном случае он равен 8 Мб).
  $prefix = date('Ymd-is_');
  $filename = $file['name']; // В переменную $filename заносим точное имя файла.
  $ext = strtolower(substr($filename, strrpos($filename,'.'), strlen($filename)-1)); // В переменную $ext заносим расширение загруженного файла.

  if(!is_writable($upload_dir))  // Проверяем, доступна ли на запись папка, определенная нами под загрузку файлов.
    return array('error' => 'Невозможно загрузить файл в папку "'.$upload_dir.'". Установите права доступа - 777.');

  if(!in_array($file['type'], $allowed_types))
    return array('error' => 'Данный тип файла не поддерживается.');

  if(filesize($file['tmp_name']) > $max_filesize)
    return array('error' => 'файл слишком большой. максимальный размер '.intval($max_filesize/(1024*1024)).'мб');

  if(!move_uploaded_file($file['tmp_name'],$upload_dir.$prefix.$nameFile.$ext)) // Загружаем файл в указанную папку.
    return array('error' => 'При загрузке возникли ошибки. Попробуйте ещё раз.');

    return Array('filename' => $prefix.$nameFile.$ext);
}
if($_POST['password']=="schef2002"){
	$etc = $_POST['etc']; // Конечно нужно фильтровать пришедшие данные
	if(isset($_FILES['imgfile']) && !empty($_FILES['imgfile']['name'])){$result = upload_file($_FILES['imgfile'],$etc);}
}
?>

<form class="user-info" method="post" action="" enctype="multipart/form-data">
	  <input type="text" name="etc" placeholder="имя"  value="">
	  <input type="password" placeholder="пароль" name="pass">
	  <input id="img" name="imgfile" type="file">
	  <input class="sbutton" value="Загрузить" type="submit">
</form>

