<?php
class BasePage
{
	protected $_mainPage;
	protected $_page;
	protected $_action;


	public function __construct( &$mainPage, $page, $action )
	{
		$this->_mainPage = $mainPage;
		$this->_page   = $page;
		$this->_action = $action;
	}


	public function show()
	{
		$methodName = 'action'.ucfirst($this->_action);
		return call_user_func( array($this, $methodName) );
	}
}
?>