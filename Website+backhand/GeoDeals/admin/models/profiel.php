<?php

class profiel_model extends Model {
		
	function __construct()
	{
		parent::__construct();
	}
	
	function GetProfiel()
	{
		$user_id = Session::get("User")->GetId();
        
        $query = $this->database->prepare("SELECT * FROM tblprofiel WHERE user_id = :user_id");
        $query->execute(array(':user_id' => $user_id));
               
        $count =  $query->rowCount();
        if($count > 0)
        {
            return $query->fetchAll();
        }
		return null;
	}
	
	function Save($data)
	{
		$user_id = Session::get("User")->GetId();
		
		$logo = $data['image'];
		$naam = $data['naam'];
		$beschrijving = $data['beschrijving'];
		$opmerkingen = $data['opmerkingen'];
		
        $query = $this->database->prepare("INSERT INTO tblprofiel (logo, naam, beschrijving, opmerkingen, user_id) VALUES (:logo, :naam, :beschrijving, :opmerkingen, :user_id);");
        $query->execute(array(':logo' => $logo,
							  ':naam' => $naam,
							  ':beschrijving' => $beschrijving,
							  ':opmerkingen' => $opmerkingen,
							  ':user_id' => $user_id));
	}
	function Update($data)
	{
		$user_id = Session::get("User")->GetId();
		
		$logo = $data['image'];
		$naam = $data['naam'];
		$beschrijving = $data['beschrijving'];
		$opmerkingen = $data['opmerkingen'];
		
        $query = $this->database->prepare("	UPDATE tblprofiel SET logo = :logo,
																naam = :naam,
																beschrijving = :beschrijving,
																opmerkingen = :opmerkingen
											WHERE user_id = :user_id");
        $query->execute(array(':logo' => $logo,
							  ':naam' => $naam,
							  ':beschrijving' => $beschrijving,
							  ':opmerkingen' => $opmerkingen,
							  ':user_id' => $user_id));
	}
}