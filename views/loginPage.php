<div class='container'>
	<?php echo PlainPhpView::loadBlock( 'common/errorBlock.php', array( 'errors' => $this->getVar( 'errors' ), )); ?>

	<?= $this->getVar( 'loginBlock' ) ?>
</div>