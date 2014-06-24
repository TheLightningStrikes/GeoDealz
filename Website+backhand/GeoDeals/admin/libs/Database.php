<?php
/**
* 
*/
class Database extends PDO
{
    function __construct()
    {
        try{
            parent::__construct("mysql:host=145.24.222.188;port=8010;dbname=geodealsadmin", "geodatabase", "weetikniet");
        }
        catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
    }
}