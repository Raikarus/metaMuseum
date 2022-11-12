<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<link rel="stylesheet" type="text/css" href="style.css">
<title>Все авторы</title>
</head>
<body>
<?php
require 'connect.php'; // Подключает файл с логином/паролем и именем БД
mysql_set_charset('utf8'); // Устанавливает кодировку клиента
$sql_select = "SELECT * FROM gachi_users"; // Выбираем таблицу из которой читать данные
$result = mysql_query($sql_select); // Запрос к БД
$row = mysql_fetch_array($result); // Разбираем полученый массив
do
{
  printf("<p>Номер книги: ".$row['id']."</p><p>Автор: ".$row['author']."</p><p>Название: ".$row['title']
  ."</p>----------------------------------------<b>");
}
while($row = mysql_fetch_array($result));
?>
<form method='post' action='read.php'><b>
<input id="Nknig" type='text' name='nk' placeholder="Номер книги"><b><b>
<input id='submitread'  type='submit' value='Читать...'><b><b>
</form>
<form method="post" action="index.html">
<input id="submitback" type="submit" value="На главную">
</form>
</body>
</html>