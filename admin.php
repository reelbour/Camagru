<?php
session_start();
if (isset($_SESSION['username']))
{

?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Page d'adminstration du compte</title>
    <!-- <link rel="stylesheet" href="css/master.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<!-- Compiled and minified JavaScript -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script> -->

  </head>
  <body class="container">
    <?php include("fragment/header.php");?>
    <span>
      <?php
      if (isset($_SESSION['error']))
        echo $_SESSION['error'];
      $_SESSION['error'] = null;
      if (isset($_SESSION['succes']))
      echo $_SESSION['succes'];
      $_SESSION['succes'] = null;
      ?>
    </span>


    <h2>Page d'adminstration du compte</h2>

    <div class="admin_contenair">
      <div class="admin_password">
        <h3>Changer Votre Mot de passe</h3>
        <form action="action/a_modifpassword.php" method="post">
          <label>Ancien mot de passe</label>
          <input type="password" name="old_password" value="">
          <label>Nouveu mot de passe</label>
          <input type="password" name="new_pass1" value="">
          <label>Confirmer Votre nouveu mot de passe</label>
          <input type="password" name="new_pass2" value="">
          <input type="submit" name="Envoyer" value="Envoyer">
        </form>
      </div>




      <div class="admin_user">
        <h3>Changer Votre Nom d'utilisateur</h3>
        <form action="action/a_modif_username.php" method="post">
          <label>Nouveu pseudo</label>
          <input type="text" name="new_username" value="">
          <input type="submit" name="Envoyer" value="Envoyer">
        </form>

      </div>







      <div class="admin_mail">
        <h3>Changer Votre Mail</h3>
        <form action="action/a_modif_mail.php" method="post">
          <label>Nouveu mail</label>
          <input type="text" name="new_mail" value="">
          <input type="submit" name="Envoyer" value="Envoyer">
        </form>
      </div>

    </div>


    <div>
      <h3>Voulez vous recevoir les mails de validations ?</h3>



      <form action="action/a_notif_state.php" method="post">
      <input type="hidden" name="choix" id="Oui" value="Oui">
      <button type="submit" value="non">OUI</button>
      </form>
      <form action="action/a_notif_state.php" method="post">
      <input type="hidden" name="choix" id="Non" value="Non">
      <button type="submit" value="oui">NON</button>
      </form>

    </div>
    <?php include("fragment/footer.php");?>
  </body>
</html>
<?php }
  else {
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h3>Vous devez vous connectez pour acceder a cette page, cliquer <a href="index.php">ICI</a> pour revenir a l'acceuil </h3>
  </body>
</html>
<?php } ?>
