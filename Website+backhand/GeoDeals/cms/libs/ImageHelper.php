<?php 

Class ImageHelper
{
	static function upload()
	{
		$database = new Database();
	
		if(is_uploaded_file($_FILES['userfile']['tmp_name'])) {
			// check the file is less than the maximum file size
			if($_FILES['userfile']['size'] < $maxsize)
			{
				// prepare the image for insertion
				$imgData =addslashes (file_get_contents($_FILES['userfile']['tmp_name']));
				// $imgData = addslashes($_FILES['userfile']);
		 
				// get the image info..
				$size = getimagesize($_FILES['userfile']['tmp_name']);
		 
				// put the image in the db...
				// database connection
				mysql_connect("localhost", "$username", "$password") OR DIE (mysql_error());
		 
				// select the db
				mysql_select_db ("$dbname") OR DIE ("Unable to select db".mysql_error());
		 
				// our sql query
				$sql = "INSERT INTO tblimage
						( id , type ,data, size, name)
						VALUES
						('', :type, :data, :size, :name, :content_id)";
		 
				$query = $database->prepare($sql);
				$query->execute(array(':type'		=> $size['mime'],
								      ':data' 		=> $imgData,
									  ':size' 		=> $size[3],
									  ':name' 		=> $_FILES['userfile']['name'],				
									  ':content_id' => $_POST['content_id']));
									  
				return true;
			
			}
		}
		else {
			 return false;
		}
	}
}