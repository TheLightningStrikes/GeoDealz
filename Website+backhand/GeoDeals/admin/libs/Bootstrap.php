<?php

class Bootstrap
{
    function __construct()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : 'index';
        $url = explode('/', $url);

		
        $args = array();
		
		if(count($url) >= 2 && $url[0] == "api")
		{		
			$file_name = $url[1];
			$file_location = "controllers/api/"  . $file_name . ".php" ;	
			$args = array_splice($url, 2);
		}
		else
		{
			$file_name = $url[0];
			$file_location = "controllers/"  . $file_name . ".php" ;	
			if(count($url) > 1)
			{	
				$args = array_splice($url, 1);
			}
		}
		
        if(file_exists($file_location))
        {      
            require $file_location;
            $controller = new $file_name($args);
        }
        else
        {
            require "controllers/error.php";
            $error = new Error();
        }		
    }
}