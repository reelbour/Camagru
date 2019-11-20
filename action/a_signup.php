<?php
session_start();
include_once '../fonction/f_signup.php';
// recup valeur
$mail = $_POST['mail'];
$pseudo = $_POST['username'];
$mdp = $_POST['password'];
$_SESSION['error'] = null;
if ($mail == "" || $mail == null || $pseudo == "" || $pseudo == null || $mdp == "" || $mdp == null) {
  $_SESSION['error'] = "Vous devez remplir tout les champs";
  header("Location: ../form/signup.php");
  return;
}
if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
  $_SESSION['error'] = "Vous devez entrer une adresse mail valide";
  header("Location: ../form/signup.php");
  return;
}
if (strlen($pseudo) > 50 || strlen($pseudo) < 3) {
  $_SESSION['error'] = "pseudo doit etre compris entre 3 & 50 caracteres";
  header("Location: ../form/signup.php");
  return;
}
if (strlen($mdp) < 3) {
  $_SESSION['error'] = "mdp doit etre compris entre 3 & 255 caracteres";
  header("Location: ../form/signup.php");
  return;
}
$url = $_SERVER['HTTP_HOST'] . str_replace("/action/a_signup.php", "", $_SERVER['REQUEST_URI']);
signup($mail, $pseudo, $mdp, $url);
header("Location: ../form/signup.php")

?>
