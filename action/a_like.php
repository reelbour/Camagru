<?php
session_start();



///function pour ajouter un like

function add_like($img, $uid) {
  include('../config/database.php');
  try {
      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query= $dbh->prepare("INSERT INTO `like` (userid, galleryid) VALUES (:userid, :img)");

      // $uid = $_SESSION['id'];

      $query->execute(array(':userid' => $uid, ':img' => $img));
      return (0);
    } catch (PDOException $e) {
      return ($e->getMessage());
    }
}

$uid = $_SESSION['id'];

$img = $_GET['imgPath'];

try {
include('../config/database.php');
  $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query= $dbh->prepare("SELECT * FROM `like` WHERE userid = :u AND galleryid = :i");

  $query->execute([':u' => $uid, ':i' => $img]);

  $ress = $query->fetchAll();

  $query= $dbh->prepare("SELECT COUNT(*) FROM `like` WHERE userid = :u AND galleryid = :i");
  $query->execute([':u' => $uid, ':i' => $img]);

  $countmax = $query->fetchAll();

  $nombredelike = $countmax[0]['COUNT(*)'];



} catch (PDOException $e) {
  echo "jsai pas";
echo "ERROR: ".$e->getMessage();
}

print_r($ress);


echo "<br>";
print_r($countmax);

echo "<br>";echo "<br>";echo "<br>";
echo $nombredelike;
$c = 0;
$dejalike = 0;

while($c < $nombredelike)
{
  if ($ress[$c]['userid'])
  {
    $dejalike = 1;
  }
  $c++;
}

echo $dejalike;
if ($dejalike == 0)
{
if (add_like($img, $uid) == 0){

  //var_dump((int)$img);
  //var_dump((int)$uid);
  $_SESSION['succes'] = 'c bon ta like l image';
 header("Location: ../montage.php");
}
else {
  $_SESSION['error'] = 'y a eu une erreur lors du like mg';
  header("Location: ../montage.php");

}
}
else {
  $_SESSION['error'] = "vous ne pouvez likez qu une seule fois !";
  header("Location: ../montage.php");
}




//
// function nombre_like($galleryid)
// {
//   include_once 'config/database.php';
//  try {
//
//                   $dbhz = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
//                   $dbhz->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//                   $queryz= $dbhz->prepare("SELECT COUNT(*) FROM `like` (userid, img) VALUES (:userid, :img)");
//
//                   $uid = $_SESSION['id'];
//
//                   $queryz->execute(array(':userid' => $uid, ':img' => $galleryid));
//                   $resultz = $queryz->fetchAll(PDO::FETCH_ASSOC);
//                   echo $resultz;
//                 }
//              catch (PDOException $e) {
//               return($e->getMessage());
//               }
//
//               //echo $resultz;
//                //var_dump($resultz);
// }
//
//  nombre_like($galleryid);

?>
