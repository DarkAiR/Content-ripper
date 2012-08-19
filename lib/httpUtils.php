<?php
class HttpUtils
{
	public static function getPost( $name, $def='' )
	{
		if( !isset( $_POST[$name] ) )
			return $def;
		$p = $_POST[$name];
		if( get_magic_quotes_gpc() )
			$p = stripslashes($p);
		return $p;
	}


	public static function getGet( $name, $def='' )
	{
		if( !isset( $_GET[$name] ) )
			return $def;
		$p = $_GET[$name];
		if( get_magic_quotes_gpc() )
			$p = stripslashes($p);
		return $p;
	}
}
?>