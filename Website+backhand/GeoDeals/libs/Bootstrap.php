<?php

class Bootstrap
{
    function __construct()
    {
		$url = isset($_GET['url']) ? $_GET['url'] : 'index';
		
        $url = explode('/', $url);

        $args = array();

        $file_name = $url[0];
        if(count($url) > 1)
        {	
            $args = array_splice($url, 1);
        }
		
        $file_location = "controllers/" . $file_name . ".php" ;	
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