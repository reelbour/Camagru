<?php
session_start();
?>
<!DOCTYPE html>
<HTML>
  <header>
    <link rel="stylesheet" type="text/css" href="../css/master.css">


    <meta charset="UTF-8">
    <title>Creer votre compte !</title>
  </header>
  <body>
    <?php include("../fragment/header_only.php") ?>
    <div id="login">
      <div class="title">Page de création de compte</div>
      <div id="blue">
        <form method="post" style="position: relative;" action="../action/a_signup.php"class="formulaire_signup">
          <label>Email: </label>
          <input id="mail" name="mail" placeholder="mail" type="mail">
          <label>pseudo: </label>
          <input id="username" name="username" placeholder="username" type="text">
          <label>mot de passe: </label>
          <input id="password" name="password" placeholder="password" type="password">
          <input name="submit" type="submit" value="Envoyer ">
          <span>
            <?php
            echo $_SESSION['error'];
            $_SESSION['error'] = null;
            if (isset($_SESSION['signup_success'])) {
              echo "Inscription effectué avec succes, veuillez mtn confirmer votre
              adresse email (verifier les spam)";
              $_SESSION['signup_success'] = null;
            }
            ?>
          </span>
        </form>
      </div>
    </div>
    <?php include('../fragment/footer.php') ?>
  </body>
</HTML>
