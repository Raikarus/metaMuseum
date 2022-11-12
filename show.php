<?php
if ($_SESSION['id'] and $_SESSION['role']==2)
{
while($row = mysqli_fetch_assoc($res))
		{
		echo "<hr />";
		echo "<div class = 'user'>";
		echo "<div><span>Логин:</span><span>Пароль:</span><span>Почта:</span><span>Уровень доступа:</span></div>";
		echo "<div><span>{$row['login']}</span><span>{$row['pass']}</span><span>{$row['email']}</span><span>{$row['role']}</span></div>";
		echo "</div><hr /><br />";
		}
}
?>
