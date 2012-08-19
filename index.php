<?php
header('Content-Type: text/html; charset=utf-8'); 

session_start();

// Include the main Propel script
require_once 'propel/runtime/lib/Propel.php';

// Initialize Propel with the runtime configuration
Propel::init("content-ripper/build/conf/content-ripper-conf.php");

// Add the generated 'classes' directory to the include path
set_include_path("content-ripper/build/classes" . PATH_SEPARATOR . get_include_path());

require_once 'lib/plainPhpView.php';
require_once 'lib/form.php';
require_once 'lib/routeUtils.php';
require_once 'lib/httpUtils.php';

require_once 'lib/linkHelper.php';
require_once 'lib/validators/urlValidator.php';

require_once 'lib/gameException.php';

require_once 'config/mainConfig-home.php';
require_once 'app.php';

// Если передаем в ajax-запросе, то ставим обработчики ошибок и возвращаем валидный JSON
$isAjax = HttpUtils::getPost('isAjax', false);
if( $isAjax == true )
{
	// Включаем буферизацию вывода
	ob_start();

	function handleException( $exception )
	{
		restore_exception_handler();
		$res = array(
			'error' => $exception->getMessage(),
		);
		// Очищаем буфер обмена
		ob_end_clean();
		echo json_encode($res);
		exit();	// Выходим, иначе будет не валидный JSON в ответе
	}
	function handleError( $code, $message, $file, $line )
	{
		restore_error_handler();
		ob_clean();
		trigger_error( $message );
		$res = array(
			'error' => ob_get_clean(),
		);
		echo json_encode($res);
		exit();	// Выходим, иначе будет не валидный JSON в ответе
	}
	set_exception_handler( 'handleException' );
	set_error_handler( 'handleError', error_reporting() );
}

$app = App::instance();
$app->addScript( "jquery-1.7.2.min.js" );
$app->run();