<?php
session_start();
include_once("../config/database.php");

//ok donc pour supprimer le fichier j ai besoin de recup le nom de l image son id
// me connecter a la base de donnee
// le supprimer
// renvoyer sur montage.php

try {
  $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query= $dbh->prepare("DELETE FROM gallery WHERE userid = :userid AND img = :imgPath");

  $userId = $_SESSION["id"];
  $imgPath = $_GET['imgPath'];
  echo $imgPath;

  $query->execute(['userid' => $userId, 'imgPath' => $imgPath]);

  echo "<br /> executed";
  header("Location: ../montage.php");

} catch (PDOException $e) {
  return($e->getMessage());
}


?>
