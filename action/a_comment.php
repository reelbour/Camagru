<?php
session_start();

include_once('a_comment_mail.php');
if (isset($_POST['comment']) && isset($_POST['submit']))
{
  if ($_POST['comment'] != '')
  {
  //  print_r($_POST);

    echo "<br>";
    //print_r($_GET);

    $commentaireainserer = $_POST['comment'];
    $galleryid = $_POST['galleryid'];

  try {

      include_once ('../config/database.php');

          $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query= $dbh->prepare("INSERT INTO `commentaire` (userid, galleryid, comment) VALUES (:userid, :img, :comment)");
          $uid = $_SESSION['id'];

          $query->execute(array(':userid' => $uid, ':img' => $galleryid, ':comment' => $commentaireainserer));

          //envoi de mail si la case est coché
          //determiner une methode pour savoir si la case est coché, par défaut oui
          //donc on va deja faire une fonction denvoie de mail dans mail et l appeler ici

    } catch (PDOException $e) {
      echo "ca bug";
    }
  //je dois mettre un if ici pour determiner si le gars veux des notifs

    try {
      include_once ('../config/database.php');

          $dbhx = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
          $dbhx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          //tester si ca fonction
          $queryx= $dbhx->prepare("SELECT * FROM `users` users WHERE id =:userid");
          $uid = $_SESSION['id'];

          $queryx->execute(array(':userid' => $uid));
          $resultxx = $queryx->fetchAll();
          //print_r($resultxx);
          $choixnotif = $resultxx[0]['notif'];

    } catch (PDOException $e) {

    }


    if($choixnotif == 'Y')
      mail_comment();

//fin mail comment
  //  echo "<br>apres";
    header('Location: ../index.php');

  }
  else{

  //  echo "on accepte pas les com vide ";
    $_SESSION['error'] ='on accepte pas les com vide';
    header('Location: ../index.php');
  }
}
else {
//  echo "les valeurs n existe pas ?";
  $_SESSION['error'] ='on accepte pas les com vide';
  header('Location: ../index.php');
  //faire des session error ici
}

?>
