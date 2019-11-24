<?php
session_start();
include_once("../config/database.php");

//ok donc pour supprimer le fichier j ai besoin de recup le nom de l image son id
// me connecter a la base de donnee
// le supprimer
// renvoyer sur montage.php



// AVANT DE SUPPRIMER LA PHOTO FAUT SUPPRIMER LES FOREIGN KEY DONC ALL LIKE AND ALL iis_get_server_by_comment

//suppression commentaire


// a faire mais normaement c simple bon fai en 2 sec a tester

try {
  $dbb = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $dbb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query = $dbb->prepare("DELETE FROM `commentaire` WHERE galleryid = :imgPath ");
  $imgPathxc = $_GET['imgId'];
  $query->execute(['imgPath' => $imgPathxc]);


} catch (PDOException $e) {
  return($e->getMessage());
}



//supression like
try {

  $dbb = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $dbb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query = $dbb->prepare("DELETE FROM `like` WHERE userid = :userid AND galleryid = :imgPath ");


  $imgPathx = $_GET['imgId'];

  $useridddd = $_SESSION["id"];

  echo $useridddd;
  echo "<br/>";
  echo $imgPathx;
echo "<br/>";
  print_r($query);


echo "<br/>";
echo "<br/>";
echo "juste avant l execute";
echo "<br/>";
echo "<br/>";

  $query->execute(['userid' => $useridddd, 'imgPath' => $imgPathx]);
echo "<br/>";
echo "<br/>";

  echo "on a execute";

} catch (PDOException $e) {
  return($e->getMessage());
}

try {
  $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query= $dbh->prepare("DELETE FROM gallery WHERE userid = :userid AND img = :imgPath");

  $userId = $_SESSION["id"];
  $imgPath = $_GET['imgPath'];
//  echo $imgPath;

  $query->execute(['userid' => $userId, 'imgPath' => $imgPath]);

  unlink("../gallery/" . $imgPath);

  header("Location: ../montage.php");

} catch (PDOException $e) {

  return($e->getMessage());
}


?>
