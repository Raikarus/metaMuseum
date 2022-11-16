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
$link = mysqli_connect("127.0.0.1", "client", "sosi123", "museumbasa");
session_start();
$form = $_GET['form'];
$msg = "0";
switch ($form) {
	case 'reg':
		if ($_SESSION['role']!=2)
		{
 			header('location:/');
		}
		else
		{
			if($_POST['login'])
			{
				if($_POST['pass'])
				{
					if($_POST['email'])
					{
						if($_POST['role']=="0" or $_POST['role']=="1" or $_POST['role']=="2")
						{
							$sql = "INSERT INTO museum_users(login,pass,email,role) VALUES ('{$_POST['login']}','{$_POST['pass']}','{$_POST['email']}',{$_POST['role']})";
		    				mysqli_query($link, $sql);
	    				}
					}
				}
			}
		}
		break;
	case 'show':
		if ($_SESSION['role']!=2)
		{
 			header('location:/');
		}
		else
		{
			$sql = "SELECT * FROM `museum_users`";
			$res = mysqli_query($link, $sql);
		}
		break;
	case 'auth':
		if ($_SESSION['id'])
		{
 			header('location:/');
		}
		else
		{
		if($_POST['login'] and $_POST['pass']){
				$sql = "SELECT id, login, pass, email,role FROM museum_users WHERE login='{$_POST['login']}' and pass='{$_POST['pass']}'";
				$res = mysqli_query($link, $sql);
				$row = mysqli_fetch_assoc($res);
				if($row['id']){
					$_SESSION['id'] = $row['id'];
					$_SESSION['login'] = $row['login'];
					$_SESSION['email'] = $row['email'];
					$_SESSION['role'] = $row['role'];
					$msg = "1";
				}
				else{
					$msg = "0";
				}
			}
		}
		break;
		case 'upload':
			if($_SESSION['role']!=2)
			{
				header('location:/');
			}
			else
			{
				$etc = $_POST['etc']; // Конечно нужно фильтровать пришедшие данные

				if(isset($_FILES['imgfile']) && !empty($_FILES['imgfile']['name'])){$result = upload_file($_FILES['imgfile'],$etc);header('location:/?form=showpic');}
			}
		break;
		case 'exit': session_destroy(); header('location:/'); break;
	default:
		# code...
		break;
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<link rel="stylesheet" href="css/style.css"  type="text/css">
<script type="text/javascript" src = "js/jq.js"></script>
<script type="text/javascript" src = "js/script.js"></script>
<title>Главная_для_пидоров</title>
</head>
<body>
<div id = "bigPic">
<div>
	<img src = "img/">
</div>
</div>
<header>
	<div id = "left"><a href = "?form=home">DATABASE TEST</a></div>
	<div id = "right">
<?php if($_SESSION['id']){
		echo $_SESSION['login']; ?>
		<a href="?form=exit">Выйти</a>
<?php	}
	else
	{
?>
		<a href="?form=auth">Войти</a>
<?php 	}	?>
	</div>
</header>
<div id = "main">
	<?php if ($_SESSION['id']) {
		if($_SESSION['role']==2){?>
	<a href="?form=show">Показать всех</a>
	<br />
	<a href="?form=reg">Добавить</a>
	<br />
	<a href="?form=upload">Добавить изображение</a>
	<br />
	<?php	}
		if($_SESSION['role']==2 or $_SESSION['role']==1 or $_SESSION['role']==0)
		{
	?>
			<a href = "?form=showpic">Показать изображения</a>
			<br />
<?php		}
	}
			switch($form){
				case 'show': include('show.php'); break;
				case 'reg': include('rec.php'); break;
				case 'auth': include('auth.php');break;
				case 'showpic': include('showpic.php');break;
				case 'upload': include('upload.php');break;
				default:include('home.php');break;
			}
?>
</div>
<footer>
	</footer>
</body>
</html>
