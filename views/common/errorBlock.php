<?php
	$err = $this->getVar( 'errors' );
	if( is_array($err) && count($err)>0 )
	{
	?>
		<div id='error' class="error">
			<?php
			foreach( $err as $e )
			{
			?>
				<div class="clear"><?= $e ?></div>
			<?php
			}
			?>
		</div>
	<?php
	}
?>