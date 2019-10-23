<?php
require "database.php";
try{
    $db = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE `camagru`";
    $db->exec($sql);
    } catch (PDOException $e) {
        echo "Error database creation :".$e->getMessage()."\n";
        throw $e;
    }
?>
