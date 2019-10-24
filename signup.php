<?php
session_start();
?>
<!DOCTYPE html>
<HTML>
  <header>
    <link rel="stylesheet" type="text/css" href="style/index.css">
    <meta charset="UTF-8">
    <title>SIGNUP</title>
  </header>
  <body>
    <?php include('headersignup.php') ?>
    <div id="login">
      <div class="title">Page de création de compte</div>
      <div id="blue">
        <form method="post" style="position: relative;" action="action/action_signup.php">
          <label>Email: </label>
          <input id="mail" name="email" placeholder="email" type="mail">
          <label>pseudo: </label>
          <input id="name" name="pseudo" placeholder="pseudo" type="text">
          <label>mdp: </label>
          <input id="mdp" name="mdp" placeholder="mdp" type="password">
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
    <?php include('footer.php') ?>
  </body>
</HTML>
