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

          <?php } ?>
</div>
</div>
