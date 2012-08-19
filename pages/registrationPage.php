<?php
require_once 'basePage.php';

class RegistrationPage extends BasePage
{
	public function actionIndex()
	{
		$isLoginParams = isset($_POST['submit']) && isset($_POST['login']) && isset($_POST['password']);
		if( $isLoginParams )
		{
			$login = $_POST['login'];
			$password = $_POST['password'];

			// проверям логин
			if(!preg_match("/^[a-zA-Z0-9]+$/",$login))
				App::instance()->addError( "Логин может состоять только из букв английского алфавита и цифр" );

			if(strlen($login) < 3 or strlen($login) > 30)
				App::instance()->addError( "Логин должен быть не меньше 3-х символов и не больше 30" );

			if(strlen(trim($password)) == 0 )
				App::instance()->addError( "Пароль не должен быть пустым" );

			$q = new UserQuery();
			$user = $q->filterByLogin($login)->findOne();
			if( isset($user) )
				App::instance()->addError( "Пользователь с таким логином уже существует в базе данных" );

			// Если нет ошибок, то добавляем в БД нового пользователя
			if( !App::instance()->isErrorsExists() )
			{
				$user = new User();
				$user->setLogin( $login );
				$user->setPassword( md5($password) );
				$user->save();

				$regBlock = new PlainPhpView();
				$this->_mainPage->assign( 'registrationBlock', $regBlock->fetch( 'registration/registrationSuccess.php' ) );
			}
		}

		if( !$isLoginParams || App::instance()->isErrorsExists() )
		{
			$regBlock = new PlainPhpView();
			$this->_mainPage->assign( 'registrationBlock', $regBlock->fetch( 'registration/registrationForm.php' ) );
		}
	}
}
?>
