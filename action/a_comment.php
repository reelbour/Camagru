<?php
session_start();

include_once('a_comment_mail.php');
if (isset($_POST['comment']) && isset($_POST['submit']))
{
  if ($_POST['comment'] != '')
  {
    print_r($_POST);

    echo "<br>";
    //print_r($_GET);

    $commentaireainserer = $_POST['comment'];
    $galleryid = $_POST['galleryid'];

    echo $galleryid;

    echo $commentaireainserer;

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
    mail_comment();
    echo "<br>apres";
    header('Location: ../index.php');

  }
  else{

    echo "on accepte pas les com vide ";
  }
}
else {
  echo "les valeurs n existe pas ?";
  //faire des session error ici
}

?>
