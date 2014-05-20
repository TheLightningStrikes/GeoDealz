<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class instellingen_model extends Model {

    function __construct()
    {
        parent::__construct();
    }

	function GetAllSettings()
	{
		$sQuery = "SELECT i.key, i.value, display, i.type FROM tblinstellingen i ORDER BY i.order";
		
		$query = $this->database->prepare($sQuery);
		$query->execute();
		return $query->fetchAll();
	}
	
	function UpdateQueries($query)
	{
		$query = $this->database->prepare($query);
		$query->execute();
	} 
}