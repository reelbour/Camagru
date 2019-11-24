<?php
require 'database.php';
session_start();

//on va tenter de connecter a mysql
// CREATE DATABASE

try
{
 $bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', $DB_USER, $DB_PASSWORD);
 $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 $sql = "CREATE DATABASE IF NOT EXISTS`".$DB_NAME."`";
 $bdd->exec($sql);
 echo "La base de donne a bien ete cree\n";
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
          `verified` VARCHAR(1) NOT NULL DEFAULT 'N',
          `notif` VARCHAR(1) NOT NULL DEFAULT 'Y'
        )";
        $dbb->exec($sql);
        echo "La table des users à été creer avec succès\n";
    } catch (PDOException $e) {
        echo "ERREUR DE CREATION DE TABLE : ".$e->getMessage()."\naborting process\n";
    }
try {

            $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE TABLE `gallery` (
              `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
              `userid` INT(11) NOT NULL,
              `img` VARCHAR(100) NOT NULL,
              FOREIGN KEY (userid) REFERENCES users(id)
            )";
            $dbh->exec($sql);
            echo "table gallery a bien ete cree\n";
        } catch (PDOException $e) {
            echo "ERREUR DE CREATION DE TABLE: ".$e->getMessage()."\nAborting process\n";
        }

try {
                // Connect to DATABASE previously created
                $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "CREATE TABLE `like` (
                  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                  `userid` INT(11) NOT NULL,
                  `galleryid` INT(11) NOT NULL,
                  FOREIGN KEY (userid) REFERENCES users(id),
                  FOREIGN KEY (galleryid) REFERENCES gallery(id)
                )";
                $dbh->exec($sql);
                echo "Table like a bien ete cree\n";
            } catch (PDOException $e) {
                echo "erreur de creqtion de table: ".$e->getMessage()."\non avorte\n";
    }

    try {
            // Connect to DATABASE previously created
            $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE TABLE `commentaire` (
              `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
              `userid` INT(11) NOT NULL,
              `galleryid` INT(11) NOT NULL,
              `comment` VARCHAR(255) NOT NULL,
              FOREIGN KEY (userid) REFERENCES users(id),
              FOREIGN KEY (galleryid) REFERENCES gallery(id)
            )";
            $dbh->exec($sql);
            echo "Table commentaire a bien ete cree\n";
        } catch (PDOException $e) {
            echo "erreur de creation de table commentaiere: ".$e->getMessage()."\non avorte\n";
        }


?>
