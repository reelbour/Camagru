<?php
require "database.php";
try{
    $db = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE `camagru`";
    $db->exec($sql);
    } catch (PDOException $e) {
        echo "Erreur de création de la base de donnée :".$e->getMessage()."\n";
        throw $e;
    }
try {
  $db = new PDP($DB_DNS, $DB_USER, $DB_PASSWORD);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "CREATE TABLxE `users`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `pseudo` VARCHAR(50) NOT NULL,
          `mdp` VARCHAR(255) NOT NULL,
          `mail` VARCHAR(100) NOT NULL,
          `check` INT NOT NULL DEFAULT '0',
          `token` VARCHAR NOT NULL
        )";
        $db->exec($sql);
      }
      catch (PDOException $e)
      {
          echo "Erreur de créatio de la table user :".$e->getMessage()."\n";
      }
?>
