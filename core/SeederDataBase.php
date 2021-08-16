<?php

namespace Core;

use PDO;
use Core\DataBase;

class SeederDataBase
{
    public static function tablesCreation()
    {
        try {
            $pdo = DataBase::getDataBase();

            $stmt = $pdo->prepare("show tables");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $stmt->closeCursor();
            if (0 === count($result)) {
                $query = "CREATE TABLE nfs (
					id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					nf VARCHAR(30) NOT NULL,
					dataemit VARCHAR(30) NOT NULL, 
					vnf FLOAT(10, 2) NOT NULL,
					cnpj VARCHAR(30) NOT NULL,
					nome VARCHAR(150) NOT NULL,
					cod_ie VARCHAR(150) NOT NULL,
					end_logradouro VARCHAR(150) NOT NULL,
					end_nr VARCHAR(150) NOT NULL,
					end_bairro VARCHAR(150) NOT NULL,
					end_cmun VARCHAR(150) NOT NULL,
					end_mun VARCHAR(150) NOT NULL,
					end_uf VARCHAR(150) NOT NULL,
					end_cep VARCHAR(150) NOT NULL,
					end_cpais VARCHAR(150) NOT NULL,
					end_tel VARCHAR(150) NOT NULL
				);
				
				CREATE TABLE user (
	                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	                name VARCHAR(30) NOT NULL,
	                email VARCHAR(50) NOT NULL,
	                password VARCHAR(100) NOT NULL,
	                UNIQUE (email)
				);
				
				CREATE TABLE role (
	                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	                priority INT NOT NULL,
	                description VARCHAR(120) NOT NULL
	            );

				CREATE TABLE user_roles (
	                user_id INT UNSIGNED NOT NULL,
	                role_id INT UNSIGNED NOT NULL,
	                FOREIGN KEY (user_id) REFERENCES user(id),
	                FOREIGN KEY (role_id) REFERENCES role(id)
	            );";

                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $stmt->closeCursor();
            }
        } catch (Exception $e) {
            throw Exception($e->getMessage(), 500);
        }
    }
}
