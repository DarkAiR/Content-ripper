<?php
class RouteUtils
{
	// Сопоставление действиям основных шаблонов
	private static $_rules = array
	(
		'loginPage' => array(
			'index'  => 'loginPage.php',
		),
		'registration' => array(
			'index' => 'registrationPage.php',
		),
		'mainPage' => array(
			'index' => 'mainPage.php',
		),
	);

	public static function getRoute( $route=null )
	{
		if( $route == null )
			$route = HttpUtils::getPost( 'route', null );

		$res = array(
			'page' => 'loginPage',
			'action' => 'index'
		);
		if( $route != null )
		{
			list( $page, $action ) = explode("/", $route, 2);
			$res['page'] = $page;
			$res['action'] = $action;
		}

		return $res;
	}


	public static function makeRoute( $page, $action=null )
	{
		if( $action==null )
			$action = 'index';
		return $page.'/'.$action;
	}


	public static function getPageByRoute( $page, $action )
	{
		$template = self::$_rules['loginPage']['index'];
		if( isset(self::$_rules[$page]) )
		{
			if( isset(self::$_rules[$page][$action]) )
				$template = self::$_rules[$page][$action];
			elseif( isset(self::$_rules[$page]['index']) )
				$template = self::$_rules[$page]['index'];
		}
		return $template;
	}


	public static function redirect( $page, $action, $params=array() )
	{
		$route = self::makeRoute( $page, $action );

		if( !is_array($params) )
			$params = array();
		$params['route'] = $route;

		echo '<form name="redirect_form" method="post" action="index.php">';
		foreach( $params as $key=>$val )
			echo '<input type="hidden" name="'.$key.'" value="'.$val.'">';
		echo '</form>';
		echo '<script type="text/javascript">redirect_form.submit();</script>';
	}
}
?>