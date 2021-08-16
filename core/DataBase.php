<?php

namespace Core;

use PDO;
use PDOException;

class DataBase
{
    public function getDataBase()
    {
        try {
            $pdo = new PDO("mysql:host=mysql;dbname=care;charset=utf8", 'root', 'root');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES '$charset' COLLATE 'utf8_unicode_ci'");
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            return $pdo;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

}