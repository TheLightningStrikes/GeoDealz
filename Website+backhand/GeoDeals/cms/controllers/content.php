<?php

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
		
		if(!User::isAuthenticated(1))
		{
			$function = "login";
			$args = null;
		}
            
        switch ($function)
        {
			case "new":
				$this->newContent();
			break;
			case "save":
				$this->saveContent();
			breal;
			case "edit":
				$this->editContent($args);
			break;
			case "update":
				$this->updateContent();
			break;
			case "delete":
				$this->deleteContent($args);
			break;
			case "login":
				$this->view->render("Login/index");
			break;
            default:
                 $this->loadContentLists();
            break;
        }
    }
	
	function loadModel()
    {
        require 'models/'. __CLASS__ . '.php';  
        $this->model = new content_model();
    }
	
	function loadContentLists()
	{
		$data = $this->model->getContentList();
		
		$this->view->data = $data;
		$this->view->render(__CLASS__ . '/index');
	}
	
	function newContent()
	{
		$this->view->render(__CLASS__ .'/new');
	}
	
	function saveContent()
	{
		$title = $_POST['title'];
		$content = $_POST['content'];
		$visible = ((isset($_POST['visible']))?$_POST['visible']:"0");
	
		
		$this->model->save($title, $content, $visible);
		
		Header("Location:" . URL . "content");
	}
	
	function editContent($args)
	{
		if(isset($args) && !empty($args))
		{
			$id = $args[0];
			
			$this->view->content = $this->model->GetContent($id);
			$this->view->render(__CLASS__ . '/edit');
		}
		else
		{
			Header("Location:" . URL . "content");
		}
	}
	
	function updateContent()
	{
		$id = $_POST['content_id'];
		$title = $_POST['title'];
		$content = $_POST['content'];
		$visible = $_POST['visible'];
		
		$query = $this->model->update($id, $title, $content, $visible);		
		Header("Location:" . URL . "content");
	}
	
	function deleteContent($args)
	{
		if(isset($args) && !empty($args))
		{
			$id = $args[0];
			$this->model->delete($id);
			Header("Location:" . URL . "content");
		}
		else
		{
			Header("Location:" . URL . "content");
		}
	}
}