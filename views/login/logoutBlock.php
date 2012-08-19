Здравствуйте, <?= $this->getVar('userName') ?>!<br/>
<form method="post">
	<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('loginPage', 'logout') ?>" />
    <input type="submit" name="submit" value="Выйти" />
</form>