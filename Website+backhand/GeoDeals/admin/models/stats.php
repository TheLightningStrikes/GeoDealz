<?php

class stats_model extends Model {
		
	function __construct()
	{
		parent::__construct();
	}
	
	function GetRatings()
	{
		$user_id = Session::get("User")->GetId();
         
		$query = $this->database->prepare("SELECT avg(rating) as avg, d.naam, d.deal FROM geodealsadmin.tbldealrating r
											INNER JOIN tbldeal d ON d.id = r.deal_id
											WHERE d.user_id = :user_id
											GROUP BY (deal_id)");
											
		$query->execute(array(':user_id' => $user_id));
											
		return $query->fetchAll(PDO::FETCH_ASSOC);
											
	}
	
	function GetTotalRating()
	{
		$user_id = Session::get("User")->GetId();
         
		$query = $this->database->prepare("SELECT (sum(rating) / count(*)) as global_avg FROM geodealsadmin.tbldealrating r
											INNER JOIN tbldeal d ON d.id = r.deal_id
											WHERE d.user_id = :user_id");
											
		$query->execute(array(':user_id' => $user_id));
											
		return $query->fetchAll(PDO::FETCH_ASSOC);
	
	
	}
}