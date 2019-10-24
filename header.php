<div class="header">
  <?php if (isset($_SESSION['id'])) { ?>
    <div class="logo">
      <img src="img/logo.png" alt="">
    </div>
  <div class="bouton_header" onclick="location.href='action/deconnexion.php'">
    Bonjour, <?php print_r(htmlspecialchars($_SESSION['pseudo']))?>
    <h5>Deconnexion</h3>
  </div>
</div>
<?php } else { ?>
  <div class="logo">
    <img src="img/logo.png" alt="">
  </div>
<div class="login">
    <form class="form_index" action="action/signin.php" method="post">
      <label>Email: </label>
      <input id="mail" type="mail" name="email" value="" placeholder="">
      <label>Mot de passe:</label>
      <input id="mdp" type="password" name="mdp" value="">
      <input type="submit" name="submit" value="Envoyer">
      <a href="action/signup.php"> <br>Créer un compte</a>
      <a href="action/forgot.php">Mot de passe oublié ?</a>
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
