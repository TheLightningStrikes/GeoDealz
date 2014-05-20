<?php
/**
* 
*/
class Database extends PDO
{
    function __construct()
    {
        try{
            parent::__construct("mysql:host=localhost;dbname=geodealscms", "root", "");
        }
        catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
    }
}