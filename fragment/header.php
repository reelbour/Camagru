<div class="header">

  <div class="logo">
  <a href="index.php">  <img src="img/logo.png" alt="" width="50px" heigth="50px"> </a>
  <a href="index.php"> Accueil</a>
  <a href="montage.php">Montage</a>
  <a href="admin.php">Administration du compte</a>
  </div>


  <?php if (isset($_SESSION['id'])) { ?>
  <div class="container">
    Bonjour, <?php print_r(htmlspecialchars($_SESSION['username']))?>
    <a href="action/a_logout.php"><h8>Deconnexion</h8></a>
  </div>

<?php } else { ?>
  <div class="logo">

  </div>
<div class="login">
    <form class="form_index" action="action/a_login.php" method="post">
      <label>Email: </label>
      <input id="mail" type="mail" name="email" value="" placeholder="">
      <label>Mot de passe:</label>
      <input id="password" type="current-password" name="password" value="">
      <input type="submit" name="submit" value="Envoyer">
      <a href="form/signup.php"> <br>Créer un compte</a>
      <a href="form/forgot.php">Mot de passe oublié ?</a>
        <span>
          <?php if (isset($_SESSION['erreur'])) {
            echo $_SESSION['erreur'];
          }
          $_SESSION['erreur'] = NULL;
          ?>
        </span>
    </form>
          <?php } ?>
</div>
</div>
