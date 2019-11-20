<?php

function send_verification_email($toAddr, $toUsername, $token, $ip) {
  $subject = "[CAMAGRU] - Email verification";
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
  $headers .= 'From: <reelbour@student.s19.be>' . "\r\n";
  $message = '
  <html>
    <head>
      <title>' . $subject . '</title>
    </head>
    <body>
      Hello ' . htmlspecialchars($toUsername) . ' </br>
      Pour finaliser votre inscription </br>
      <a href="http://' . $ip . '/verify.php?token=' . $token . '">Confirmer votre adresse email</a>
    </body>
  </html>
  ';
  mail($toAddr, $subject, $message, $headers);
}

?>
