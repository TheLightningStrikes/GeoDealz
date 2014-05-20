<?php 

Class ImageHelper
{
	static function uploadToDatabase()
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
	
	static function uploadToFolder($file)
	{
		$valid_file=true;
		$message= "Never Used";
		//if they DID upload a file...
		if($file['name'])
		{
			//if no errors...
			if(!$file['error'])
			{
				//now is the time to modify the future file name and validate the file
				$new_file_name = strtolower($file['tmp_name']); //rename file
				if($file['size'] > (1024000)) //can't be larger than 1 MB
				{
					$valid_file = false;
					$message = 'Oops!  Your file\'s size is to large.';
				}
				else
				{
					$message = "file not too large. but stukc here";
				}
				
				//if the file has passed the test
				if($valid_file)
				{
					//move it to where we want it to be
					move_uploaded_file($file['tmp_name'], IMAGE_UPLOAD . "/" . $file['name']);
					$message = 'uploads/'.$file['name'];
				}
			}
			//if there is an error...
			else
			{
				//set that to be the returned message
				$message = 'Ooops!  Your upload triggered the following error:  '.$file['error'];
			}
			
		}
		return $message;
	}
}