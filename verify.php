<?php
session_start();
include_once 'fonction/verify.php';
?>
<!DOCTYPE html>
<HTML>
  <header>
    <link rel="stylesheet" type="text/css" href="css/master.css">
    <meta charset="UTF-8">
    <title>CAMAGRU - VERIFIER VOTRE COMPTE</title>
  </header>
  <body>
    <!-- <?php include('fragment/header_only.php') ?> -->
    <div class="header">
    <div class="logo">
    <a href="index.php">  <img src="img/logo.png" alt="" width="50px" heigth="50px"> </a>
    <a href="index.php"> Accueil</a>
    <a href="montage.php">Montage</a>
    <a href="admin.php">Administration du compte</a>
    </div>
    </div>


    <div id="login">
    <div class="title">VERIFIER VOTRE COMPTE</div>
    <?php if (verify($_GET["token"]) == 0) { ?>
      <strong class="title">Votre comte à bien été verifié, vous pouvez mtn vous connecter !</strong>

    <?php } else { ?>
      <strong>Compte non trouvé, avez vous fait une erreur de frappe ?</strong>
    <?php } ?>
    </div>

    <br><br><br>
    <?php include('fragment/footer.php') ?>
  </body>
</HTML>
