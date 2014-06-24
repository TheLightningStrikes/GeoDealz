<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class nfcmap_model extends Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function UpdateMarker($data)
	{
		$user_id = Session::get("User")->GetId();
		
		$x = $data['x'];
		$y = $data['y'];
		$query = $this->database->prepare("INSERT INTO tblmarkers (x, y, user_id) VALUES (:x, :y, :user_id);");
        $query->execute(array(':x' => $x,
							  ':y' => $y,
							  ':user_id' => $user_id));
	}
	
	function DeleteMarkersUser()
	{	
		$user_id = Session::get("User")->GetId();
	
		$query = $this->database->prepare("DELETE FROM tblmarkers
										  WHERE user_id = :user_id;");
        $query->execute(array(':user_id' => $user_id));
	}
	
	function GetMarkers()
	{
		$user_id = Session::get("User")->GetId();
	
		$query = $this->database->prepare("SELECT x, y FROM tblmarkers
										  WHERE user_id = :user_id;");
        $query->execute(array(':user_id' => $user_id));
		
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function GetAllMarkers()
	{
		$query = $this->database->prepare("SELECT x, y, naam FROM tblmarkers m 
											INNER JOIN tbluser u on u.id = m.user_id
											INNER JOIN tblprofiel p on p.user_id = u.id;");
        $query->execute();
		
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
}