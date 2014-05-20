<?php
/**
* 
*/
class index extends Controller
{
    function __construct($args = array())
    {
        parent::__construct();
        $this->loadModel();		
        $function = "";
        if(count($args) > 0)
        {
            $function = $args[0];
            if(count($args) > 1)
            {
                $args = array_splice($args, 1);
            }
        }
            
        switch ($function)
        {
            case "noauth":
                $this->view->msg = "U heeft geen toegang tot de pagina die u zojuist heeft proberen te bereiken.";
                $this->view->render(__CLASS__ . '/index');
                break;
            default:
                 $this->view->render(__CLASS__ . '/index');
            break;
        }
    }

    function loadModel()
    {
		
        /*require 'models/'. __CLASS__ . '.php';  
        $this->model = new index_model();*/
    }
}
