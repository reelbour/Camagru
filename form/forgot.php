<?php
session_start();
?>
<!DOCTYPE html>
<HTML>
  <head>
    <link rel="stylesheet" type="text/css" href="../css/master.css">
    <meta charset="UTF-8">
    <title>CAMAGRU - MOT DE PASSE OUBLIE ?</title>
  </head>
  <body>
    <?php include("../fragment/header_only.php") ?>



    <div>
      <h2>MOT DE PASSE OUBLIE</h2>
      <div id="blue">
        <form method="post" style="position: relative;" action="../action/a_forgot.php">
          <label>Email: </label>
          <input id="mail" name="mail" placeholder="email" type="mail">
          <input name="submit" type="submit" value=" ENVOYER ">
        </form>
      </div>
      <?php
      echo $_SESSION['error'];
      $_SESSION['error'] = null;
      if (isset($_SESSION['forgot_success'])) {
        echo "Un email contenant votre mot de passe à été envoyé sur votre adresse mail renseigné lors de l'inscription.";
        $_SESSION['forgot_success'] = null;
      }
      ?>
    </div>
    <?php include('../fragment/footer.php') ?>
  </body>
</HTML>
