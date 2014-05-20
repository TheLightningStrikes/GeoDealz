<?php

/**
* You can pass any vars to the view object 
* And call them in the file that you call in the render method
*/
class View
{
	function __construct(){
		$locations = (explode(ROOT, $_SERVER['REQUEST_URI']));
	}
        
	public function render($name)
	{
		require 'views/header.php';
		require 'views/' . $name . '.php';
		require 'views/footer.php';
		
	}
}