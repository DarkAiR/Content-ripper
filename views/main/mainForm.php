<form method="post">
	<div class="clear">
		<div class="span-4">Url:</div>
		<input class="span-6" type="text" name="url" value="<?= $this->getVar('url') ?>" />
	</div>
	<div class="clear">
		<div class="span-4">HTML before text:</div>
		<input class="span-6" type="text" name="htmlBeforeText" value="<?= $this->getVar('htmlBeforeText') ?>" />
	</div>
	<div class="clear">
		<div class="span-4">HTML after text:</div>
		<input class="span-6" type="text" name="htmlAfterText" value="<?= $this->getVar('htmlAfterText') ?>" />
	</div>
	<div class="clear">
		<div class="span-4">Text regular expression:</div>
		<input class="span-6" type="text" name="textRegular" value="<?= $this->getVar('textRegular') ?>" />
	</div>
	<div class="clear">
		<div class="span-4">Image regular expression:</div>
		<input class="span-6" type="text" name="imageRegular" value="<?= $this->getVar('imageRegular') ?>" />
	</div>
	<div class="clear">
		<div class="span-4">Export file name:</div>
		<input class="span-6" type="text" name="exportFileName" value="<?= $this->getVar('exportFileName') ?>" />
	</div>

	<div class="clear">
		<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('mainPage', 'rip') ?>" />
		<input type="submit" value="Запустить" />
	</div>
</form>