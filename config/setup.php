<?php
require 'database.php';
session_start();

//on va tenter de connecter a mysql
try
{
 $bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', $DB_USER, $DB_PASSWORD);
 $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
 echo "ERREUR DE CREATION DE TABLE : ".$e->getMessage()."\nOn aborte le projet\n";
 exit(-1);
}
// CREATE TABLE USERS
try {
        $dbb = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE TABLE `users` (
          `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `username` VARCHAR(50) NOT NULL,
          `mail` VARCHAR(100) NOT NULL,
          `password` VARCHAR(255) NOT NULL,
          `token` VARCHAR(50) NOT NULL,
          `verified` VARCHAR(1) NOT NULL DEFAULT 'N'
        )";
        $dbb->exec($sql);
        echo "La table des users à été creer avec succès\n";
    } catch (PDOException $e) {
        echo "ERREUR DE CREATION DE TABLE : ".$e->getMessage()."\nOn aborte le projet\n";
    }

?>
