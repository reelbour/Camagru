<?php
function signup($mail, $pseudo, $mdp, $host) {
  include_once '../setup/database.php';
  include_once 'mail.php';
  $mail = strtolower($mail);
  try {
          $dbh = new PDO($DB_DSN, $DB_USER, $DB_mdp);
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query= $dbh->prepare("SELECT id FROM users WHERE pseudo=:pseudo OR mail=:mail");
          $query->execute(array(':pseudo' => $pseudo, ':mail' => $mail));
          if ($val = $query->fetch()) {
            $_SESSION['error'] = "Ce pseudo est deja utilisé";
            $query->closeCursor();
            return(-1);
          }
          $query->closeCursor();
          // cryptage mdp
          $mdp = hash("whirlpool", $mdp);
          $query= $dbh->prepare("INSERT INTO users (pseudo, mail, mdp, token) VALUES (:pseudo, :mail, :mdp, :token)");
          $token = uniqid(rand(), true);
          $query->execute(array(':pseudo' => $pseudo, ':mail' => $mail, ':mdp' => $mdp, ':token' => $token));
          send_verification_email($mail, $pseudo, $token, $host);
          $_SESSION['signup_success'] = true;
          return (0);
      } catch (PDOException $e) {
          $_SESSION['error'] = "ERROR: ".$e->getMessage();
      }
}
?>
