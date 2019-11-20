<?php
function send_forget_mail($toAddr, $toUsername, $password) {
  $subject = "[CAMAGRU] - Reset your password";
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
  $headers .= 'From: <reelbour@student.s19.be>' . "\r\n";
  $message = '
  <html>
    <head>
      <title>' . $subject . '</title>
    </head>
    <body>
      Yo' . htmlspecialchars($toUsername) . ' </br>
      Voici votre nouveau mot de passe : ' . $password . ' </br>
    </body>
  </html>
  ';
    mail($toAddr, $subject, $message, $headers);
}

function reset_password($userMail) {
  include '../config/database.php';

  try {
      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query= $dbh->prepare("SELECT id, username FROM users WHERE mail=:mail AND verified='Y'");
      $userMail = strtolower($userMail);
      $query->execute(array(':mail' => $userMail));

      $val = $query->fetch();
      if ($val == null) {
          $query->closeCursor();
          return (-1);
      }
      $query->closeCursor();

      $pass = uniqid('');
      $passEncrypt = hash("whirlpool", $pass);

      $query= $dbh->prepare("UPDATE users SET password=:password WHERE mail=:mail");
      $query->execute(array(':password' => $passEncrypt, ':mail' => $userMail));
      $query->closeCursor();

      send_forget_mail($userMail, $val['username'], $pass);
      return (0);
    } catch (PDOException $e) {
      return ($e->getMessage());
    }
}

?>
