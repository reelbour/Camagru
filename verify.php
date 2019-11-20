<?php
session_start();
include_once 'fonction/verify.php';
?>
<!DOCTYPE html>
<HTML>
  <header>
    <link rel="stylesheet" type="text/css" href="style/index.css">
    <meta charset="UTF-8">
    <title>CAMAGRU - VERIFIER VOTRE COMPTE</title>
  </header>
  <body>
    <?php include('fragment/header.php') ?>

    <div id="login">
    <div class="title">VERIFIER VOTRE COMPTE</div>
    <?php if (verify($_GET["token"]) == 0) { ?>
      <strong>Votre comte à bien été verifié, vous pouvez mtn vous connecter !</strong>
    <?php } else { ?>
      <strong>Compte non trouvé, avez vous fait une erreur de frappe ?</strong>
    <?php } ?>
    </div>
    <?php include('fragment/footer.php') ?>
  </body>
</HTML>
