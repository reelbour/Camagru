<?php
session_start();
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CAMAGRU YOUR FAVORITE SOCIAL NETWORK</title>
    <link rel="stylesheet" href="/css/master.css">
  </head>
  <body>
    <?php include("header.php");?>
    <div class="login">
      <h2>Espace de Connexion</h2>

      <?php if (isset($_SESSION['id'])) { ?>
        Bonjour, <?php print_r(htmlspecialchars($_SESSION['pseudo'])) ?>
      <?php } else { ?>
        <form class="form_index" action="action/login.php" method="post">
          <label>Email: </label>
          <input id="mail" type="mail" name="email" value="email" placeholder="email">
          <label>Mot de passe: </label>
          <input id="mdp" type="password" name="mdp" value="mot de passe">
          <input type="submit" name="submit" value=" Envoyer">
          <a href="signup.php">Crée un compte</a>
          <a href="signin.php">Mot de passe oublié ?</a>
            <span>
              <?php if ($_SESSION['erreur']) {
                echo $_SESSION['erreur'];
              }
              $_SESSION['erreur'] = NULL;
              ?>
            </span>
        </form>
              <?php } ?>
    </div>
  </div>
    <?php include("footer.php");?>
  </body>
</html>
