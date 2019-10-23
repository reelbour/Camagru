<div class="header">
  <?php if (isset($_SESSION['id'])) { ?>
  <div class="bouton_header" onclick="location.href='action/deconnexion.php'">
      <h3>Deconnexion</h3>
  </div>
</div>
<?php } else { ?>
  <div class="bouton_header" onclick="location.href='index.php'">
      <h3>Connexion</h3>
  </div>
<?php } ?>
