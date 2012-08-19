<?php
require_once 'basePage.php';

class MainPage extends BasePage
{
	public function actionIndex()
	{
		$screen = new PlainPhpView();
		$content = $screen->fetch( 'main/mainForm.php' );

		$this->_mainPage->assign( 'content', $content );
	}


	public function actionRip()
	{
		$url = HttpUtils::getPost( 'url' );
		$htmlBeforeText = HttpUtils::getPost( 'htmlBeforeText' );
		$htmlAfterText = HttpUtils::getPost( 'htmlAfterText' );
		$textRegular = HttpUtils::getPost( 'textRegular' );
		$imageRegular = HttpUtils::getPost( 'imageRegular' );
		$exportFileName = HttpUtils::getPost( 'exportFileName' );

		$app = App::instance();
		if( empty($url) )
			$app->addError( 'Введите URL' );
		elseif( !UrlValidator::isUrl($url) )
			$app->addError( UrlValidator::$message );

		if( empty($htmlBeforeText) )
			$app->addError( 'Введите htmlBeforeText' );
		if( empty($htmlAfterText) )
			$app->addError( 'Введите htmlAfterText' );
		if( empty($textRegular) )
			$app->addError( 'Введите textRegular' );
		if( empty($imageRegular) )
			$app->addError( 'Введите imageRegular' );
		if( empty($exportFileName) )
			$app->addError( 'Введите exportFileName' );

		$screen = new PlainPhpView();
		if( $app->isErrorsExists() )
		{
			$screen->assign( 'url', $url );
			$screen->assign( 'htmlBeforeText', $htmlBeforeText );
			$screen->assign( 'htmlAfterText', $htmlAfterText );
			$screen->assign( 'textRegular', $textRegular );
			$screen->assign( 'imageRegular', $imageRegular );
			$screen->assign( 'exportFileName', $exportFileName );
			$content = $screen->fetch( 'main/mainForm.php' );
			$this->_mainPage->assign( 'content', $content );
		}
		else
		{
			$content = "Какой-то результат";
			$this->_mainPage->assign( 'content', $content );
		}
	}
}
