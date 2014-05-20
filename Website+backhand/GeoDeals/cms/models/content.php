<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class content_model extends Model {

    function __construct()
    {
        parent::__construct();
    }

	function GetContentList()
	{
		$sQuery = "SELECT  c.id as id, title, content, visible FROM tblcontent c";
				
					
		$query = $this->database->prepare($sQuery);
		$query->execute();
		return $query->fetchAll();
	}
	
	function GetContent($id)
	{		
		$sQuery = "SELECT id, title, content, visible FROM tblcontent c
					WHERE c.id = :id";
					
		$query = $this->database->prepare($sQuery);
		$query->execute(array(':id' => $id));
		return $query->fetchAll();
	}
	
	function save($title, $content, $visible)
	{
		$sQuery = "INSERT INTO tblcontent (title, content, visible) VALUES (:title, :content, :visible)";
		
		
		
		$query = $this->database->prepare($sQuery);
		$query->execute(array(':title' => $title,
							  ':content' => $content,
							  ':visible' => $visible));
							  
	}
	
	function update($id, $title, $content, $visible )
	{
		$sQuery = "UPDATE tblcontent SET title = :title, content = :content, visible = :visible WHERE id = :id";
	
		$query = $this->database->prepare($sQuery);
		$query->execute(array(':id' => $id,
							  ':title' => $title,
							  ':content' => $content,
							  ':visible' => $visible)); 
	}

	function delete($id)
	{
		$sQuery = "DELETE FROM tblcontent WHERE id = :id";
		
		$query = $this->database->prepare($sQuery);
		$query->execute(array(':id' => $id));
		return $query->fetchAll();
	}
}