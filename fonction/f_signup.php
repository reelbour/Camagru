<?php
function signup($mail, $pseudo, $mdp, $host) {
  include_once '../config/database.php';
  include_once '../config/mail.php';
  $mail = strtolower($mail);
  try {
          $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query= $dbh->prepare("SELECT id FROM users WHERE username=:username OR mail=:mail");
          $query->execute(array(':username' => $pseudo, ':mail' => $mail));
          if ($val = $query->fetch()) {
            $_SESSION['error'] = "Ce pseudo est deja utilisé";
            $query->closeCursor();
            return(-1);
          }
          $query->closeCursor();
          // cryptage mdp
          $mdp = hash("whirlpool", $mdp);
          $query= $dbh->prepare("INSERT INTO users (username, mail, password, token) VALUES (:username, :mail, :password, :token)");
          $token = uniqid(rand(), true);
          $query->execute(array(':username' => $pseudo, ':mail' => $mail, ':password' => $mdp, ':token' => $token));
          send_verification_email($mail, $pseudo, $token, $host);
          $_SESSION['signup_success'] = true;
          return (0);
      } catch (PDOException $e) {
          $_SESSION['error'] = "ERROR: ".$e->getMessage();
      }
}
?>
