<?php

class index_model extends Model {

    function __construct() {
         parent::__construct();
    }

    function getLargeSizeCategory()
    {
        $query = $this->database->prepare("SELECT * FROM categorie WHERE cat_size = 'large'");
        $query->execute();
        return $query->fetchAll();
    }
    
    function getMediumSizeCategory()
    {
        $query = $this->database->prepare("SELECT * FROM categorie WHERE cat_size = 'medium'");
        $query->execute();
        return $query->fetchAll();
    }
    
    function getSmallSizeCategory()
    {
        $query = $this->database->prepare("SELECT * FROM categorie WHERE cat_size = 'small'");
        $query->execute();
        return $query->fetchAll();
    }
}
