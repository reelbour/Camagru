<?php
session_start();

include '../fonction/a_forgot.php';

// retreive values
$mail = $_POST['mail'];
if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
  $_SESSION['error'] = "Vous devez entrer une adresse mail valide";
  header("Location: ../form/forgot.php");
  return;
}

$_SESSION['error'] = null;

if (($res = reset_password($mail)) !== 0) {
  if ($res == -1) {
    $_SESSION['error'] = "user not found";
  } else {
    $_SESSION['error'] = "internal error";
  }
} else {
  $_SESSION['forgot_success'] = true;
}

 // $mail = $_POST['mail'];
 // $_SESSION['error'] = null;
 // $res = reset_password($mail);
 //    if ($res == -1)
 //      $_SESSION['error'] = "User non trouvé";
 //    else if ($res == NULL)
 //      $_SESSION['error'] = "Erreur de traitement, veuillez recommencer, merci";
 //    else
 //      $_SESSION['forgot_success'] = true;
header("Location: ../form/forgot.php");

?>
