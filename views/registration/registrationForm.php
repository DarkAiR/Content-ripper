<h3>Регистрация</h3>
<form method="POST">
	Логин <input name="login" type="text"><br>
	Пароль <input name="password" type="text"><br>
	<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('registration') ?>" />
	<input name="submit" type="submit" value="Зарегистрироваться">
</form>