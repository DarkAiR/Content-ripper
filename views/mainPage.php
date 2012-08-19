<div class='container'>
	<?php echo PlainPhpView::loadBlock( 'common/errorBlock.php', array( 'errors' => $this->getVar( 'errors' ), )); ?>

	<?php
	$user = App::instance()->getUser();
	echo PlainPhpView::loadBlock( 'login/logoutBlock.php', array(
		'userName' => $user->getLogin(),
	));
	?>

	<div>
		<?php
		$content = $this->getVar( 'content' );
		if( $content !== false )
			echo $content;
		?>
	</div>
</div>