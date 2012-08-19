<?php
require_once 'basePage.php';

class LoginPage extends BasePage
{
	public function actionIndex()
	{
		$user = App::instance()->getUser();
		if( empty($user) )
		{
			$loginBlock = new PlainPhpView();
			$this->_mainPage->assign( 'loginBlock', $loginBlock->fetch( 'login/loginBlock.php' ) );
		}
		else
		{
			// Пароль правильный, переходим на следующий шаг
			RouteUtils::redirect( 'mainPage', 'index' );
		}
	}


	public function actionLogin()
	{
		$isLoginParams = isset($_POST['login']) && isset($_POST['password']);
		if( $isLoginParams )
		{
			$login    = $_POST['login'];
			$password = md5( $_POST['password'] );

			$q = new UserQuery();
			$user = $q->filterByLogin($login)->findOne();
			if( empty($user) )
			{
				App::instance()->addError( 'Пользователь не найден в базе!' );
			}
			elseif( $password != $user->getPassword() )
			{
				App::instance()->addError( 'Неправильный пароль' );
			}
			else
			{
				setcookie( 'id', $user->getId(), time()+60*60*24*30 );
				RouteUtils::redirect( 'loginPage', 'index' );
			}
		}

		if( !$isLoginParams || App::instance()->isErrorsExists() )
		{
			$loginBlock = new PlainPhpView();
			$this->_mainPage->assign( 'loginBlock', $loginBlock->fetch( 'login/loginBlock.php' ) );
		}
	}


	public function actionLogout()
	{
		setcookie( 'id' );
		RouteUtils::redirect( 'loginPage', 'index' );
	}
}
?>