<?php
/**
* 
*/
class content extends Controller
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
        if(!empty($function))
		{
			$this->loadContent($args[0]);	
		}
		else
		{
			$this->view->render("error/index");
		}        
    }

    function loadModel()
    {
        require 'models/'. __CLASS__ . '.php';  
        $this->model = new content_model();
    }
	
	function loadContent($id)
	{
		$data = $this->model->GetContentById($id);
		
		$this->view->data = $data;
		$this->view->render(__CLASS__ . '/index');
	}
}