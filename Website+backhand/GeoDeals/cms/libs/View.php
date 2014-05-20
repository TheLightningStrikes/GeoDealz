<?php

/**
* You can pass any vars to the view object 
* And call them in the file that you call in the render method
*/
class View
{
	private $_showTop = true;
	public function SetShowTop($showTop){ $this->_showTop = $showTop; }

	function __construct(){
		$locations = (explode(ROOT, $_SERVER['REQUEST_URI']));
	}

	public function render($name)
	{
		require 'views/header.php';
		require 'views/top.php';
		require 'views/' . $name . '.php';
		require 'views/footer.php';
	}
}