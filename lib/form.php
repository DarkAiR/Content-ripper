<?php
class Form
{
	/**
	 * Создание кнопки "отправить" по AJAX-запросу
	 * @param $text Имя текста на кнопке
	 * @param $blockId ID контентного блока для вывода
	 * @param $onDataPrepare функция обработки данных до отправки
	 *        object onDataPrepare( form );
	 *        Возвращает false, если отправка запрещена
	 *        Возвращает подготовленные данные, если отправка разрешена
	 * @param $onSuccess функция на приход нормальных данных
	 *        void onSuccess( data );
	 * @param $onError функция на ошибку
	 *        void onError( errordata );
	 */
	public static function createAjaxSubmit( $text, $blockId='', $onDataPrepare=null, $onSuccess=null, $onError=null )
	{
		$submitId = "submit".rand();
?>
		<input id="<?= $submitId ?>" type="submit" name="submit" value="<?= $text ?>" />
		<script type="text/javascript">
			$(document).ready( function()
			{
				var submitBtn = $('#<?= $submitId ?>');
				var form = submitBtn.closest('form');

				submitBtn.click( function()
				{
					<?php
					echo ( $onDataPrepare !== null )
						? "var data = ".$onDataPrepare."( form );\r\n".
						  "if( typeof(data) == 'boolean' && data == false )\r\n".
						  "    return false;\r\n"
						: "var data = form.serialize();\r\n";
					?>

					$.ajax(
					{
						url:      'index.php',
						type:     'post',
						data:     data+'&isAjax=1',
						dataType: 'json',
						success : function(data)
						{
						},
						complete: function(data)
						{
							resp = $.parseJSON( data.responseText );
							if( resp.error != undefined )
							{
								<?php
								echo ( $onError !== null )
									? $onError."( resp.error );\r\n"
									: "$('#error').empty().append( resp.error );\r\n";
								?>
							}
							else
							{
								<?php
								if( $onSuccess !== null )
									echo $onSuccess."( resp.data );\r\n";
								if( $blockId !== '' )
									echo "$('#".$blockId."').empty().append( resp.data );\r\n";
								?>
							}
						},
						error: function(data)
						{
							<?php
							echo ( $onError !== null )
								? $onError."( data );\r\n"
								: "$('#error').html( data );\r\n";
							?>
						}
					});

					return false;
				});
			});
		</script>
	<?php
	}
}
