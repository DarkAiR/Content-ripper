<?php
header('Content-Type: text/html; charset=utf-8'); 

echo 'error';
die();

/*
// Include the main Propel script
require_once 'propel/runtime/lib/Propel.php';

// Initialize Propel with the runtime configuration
Propel::init("seabattle/build/conf/seabattle-conf.php");

// Add the generated 'classes' directory to the include path
set_include_path("seabattle/build/classes" . PATH_SEPARATOR . get_include_path());

require_once 'lib/httpUtils.php';
require_once 'lib/gameException.php';
require_once 'controllers/game.php';

$auth   = HttpUtils::getPost( 'auth',   null );
$userId = HttpUtils::getPost( 'uid',    null );
$method = HttpUtils::getPost( 'method', null );
$params = unserialize( HttpUtils::getPost( 'params', null ) );

if( !checkAuth( $auth, $method, $params ) )
	die( "You aren't authorization" );

$res = array();
$data = array();

$game = Game::instance();

try
{
	switch( $method )
	{
		// No parameters
		case 'getRooms':
			$rooms = $game->getRooms( $userId );
			$selfRoomId = $game->findRoomByUserId( $userId );
			$data = array(
				'rooms' => serialize($rooms),
				'selfRoomId' => $selfRoomId,
			);
			break;

		// No parameters
		case 'createRoom':
			$game->createRoom( $userId );
			break;

		// roomId
		case 'enterRoom':
			if( !isset($params['roomId']) )
				throw new GameException( 'Parameter RoomId not found' );
			$roomId = $params['roomId'];

			$game->enterRoom( $userId, $roomId );
			break;

		// roomId
		case 'leaveRoom':
			if( !isset($params['roomId']) )
				throw new GameException( 'Parameter RoomId not found' );
			$roomId = $params['roomId'];

			$game->leaveRoom( $userId, $roomId );
			break;

		// field
		case 'saveField':
			if( !isset($params['field']) )
				throw new GameException( 'Parameter Field not found' );
			$field = $params['field'];

			$game->saveField( $userId, $field );
			break;

		default:
			$res['error'] = 'API-method "'.$method.'" not found';
			break;
	}
}
catch( GameException $e )
{
	$res['error'] = $e->getMessage();
}
$res['data'] = $data;
echo serialize($res);

*/

function checkAuth( $auth, $method, $params )
{
	$salt = 'darkair';
	$hash = md5(md5($method.serialize($params).$salt));
	return $hash == $auth;
}