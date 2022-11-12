<?php
if ($_SESSION['id'] and $_SESSION['role']==2)
{
?>
<form method="post">
<b>Логин:</b>
<input type="text" name="login" placeholder="Логин" size="30">
<b>Пароль:</b>
<input type="password" name="pass" placeholder="Пароль" size="30">
<b>Почта:</b>
<input  type="text" name="email" placeholder="Почта" size="30">
<b>Роль:</b>
<input  type="text" name="role" placeholder="Роль" value = "1" size="30">
<input id="submit" type="submit" value="Записать">
</form>
<?php
}else
{
 echo "<h1>Недостаточно прав!</h1>";
}
?>
