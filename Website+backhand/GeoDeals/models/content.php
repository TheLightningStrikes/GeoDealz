 <?php
 
 class Content_model extends Model{
	function __construct() {
         parent::__construct();
    }
	
	function GetContentById($id)
	{		
		$sQuery = "	SELECT title, content FROM tblcontent c
					WHERE c.id = $id";
					
		$query = $this->database->prepare($sQuery);
		$query->execute(array(':id' => $id));
		return $query->fetchAll();
	}
 }