<?php

session_start();

if (isset($_POST['choix']))
{
$choix = $_POST['choix'];

if ($choix == 'Oui')
{
  try {
    include_once ('../config/database.php');

    $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query= $dbh->prepare("UPDATE `users` SET notif = :choix WHERE id = :userid");
    var_dump($query);

    $uid = $_SESSION['id'];

    $choix = 'Y';

    echo $choix;
    echo $uid;

    var_dump($query->execute([':userid' => $uid,'choix' => $choix]));


    echo 'c bon deja';

    $_SESSION['succes'] = "votre choix a bien été pris en compte";
    header("Location: ../admin.php");
  } catch (PDOException $e) {


  }


}
else {
  try {
    include_once ('../config/database.php');

    $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query= $dbh->prepare("UPDATE `users` SET notif = :choix WHERE id = :userid");
    $uid = $_SESSION['id'];
    $choix = 'N';
      var_dump($query);

        echo $choix;
        echo $uid;
    $query->execute(array(':userid' => $uid, ':choix' => $choix));
    echo "m";
    $_SESSION['succes'] = "votre choix a bien été pris en compte";
    header("Location: ../admin.php");
  } catch (PDOException $e) {

  }
}

}
else {
  $_SESSION['error'] = 'erreur lors du traitement de votre demande veuillez resssayer';
  header('Location: ../index.php');
}
?>
