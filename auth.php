<?php
 if(!$_SESSION['id'])
{
?>
<form method="post">
<b>Логин:</b>
<input type="text" name="login" placeholder="логин" size="30">
<b>Пароль:</b>
<input name="pass" placeholder="пароль" type="password" size="30">
<input id="submit" type="submit" value="Войти">
</form>
<?php
}
?>
