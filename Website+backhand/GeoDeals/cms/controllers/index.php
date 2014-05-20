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
		
		if(!User::isAuthenticated(1))
		{
			$function = "login";
			$args = null;
		}
            
        switch ($function)
        {
			case "login":
				$this->view->render("Login/index");
			break;
            case "noauth":
                $this->view->msg = "U heeft geen toegang tot de pagina die u zojuist heeft proberen te bereiken.";
                $this->view->render(__CLASS__ . '/index');
                break;
            default:
                 $this->loadView();
            break;
        }
    }

    function loadModel()
    {
        require 'models/'. __CLASS__ . '.php';  
        $this->model = new index_model();
    }
	
	function loadView()
	{
		$data = array('test' => 'haha');
	
		$this->view->data = $data;
		$this->view->render(__CLASS__ . '/index');
	}
}
