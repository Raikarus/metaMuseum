<?php
	$cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
	$res = pg_query($cn,"SELECT * FROM gallery");
	//gallery(id,name,party,meta [0/1])
	$form = $_GET['form'];
	if(!empty($_POST['name']) && !empty($_POST['party']) && !empty($_POST['meta'])){
		if($_POST['party'] == "noParty"){
			$query="INSERT INTO gallery(name,party,meta) VALUES('".$_POST['name']."','".$_POST['party']."','".$_POST['meta']."')";
			$res = pg_query($cn,$query);
			header("location:/?form=show");	
		}
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
<title>Главная</title>
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


	</div>
</header>
<main class = "main">
<a href="/?form=show">Показать</a><br>
<a href="/?form=auth">Тэги</a><br>
<a href="/?form=obr">Обработка картинок</a><br>
<a href="/?form=add">Добавить картинку</a><br>
<?php
switch($form){
case 'show': include('show.php');break;
case 'auth': include('auth.php');break;
case 'obr': include('obrabotka.php');break;
case 'add': include('add.php');break;
default:include('home.php');break;
}
?>
</main>
<footer>
</footer>
</body>
</html>
