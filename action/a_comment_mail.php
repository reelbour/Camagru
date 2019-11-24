<?php

//session_start();

function  mail_comment()
{
  // on a besoin de savoir qui , non on dit juste frere ta eu un com sur ta photo ouselam
      include('../config/database.php');
    //  echo "<br>apres include<br>";

      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query= $dbh->prepare("SELECT mail FROM users WHERE id = :id");
      $uid = $_SESSION['id'];

    //  echo "<br><br>";
  //    echo $uid;
      $query->execute([':id' => $uid]);

      $res = $query->fetchAll(PDO::FETCH_ASSOC);

      //print_r($res);

      $adressemailuser = $res['0']['mail'];

      $subject = "[CAMAGRU] - VOUS AVEZ UN NOUVEAU COMMENTAIRE";
      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
      $headers .= 'From: <reelbour@student.s19.be>' . "\r\n";
      $message = '
      <html>
        <head>
          <title>' . $subject . '</title>
        </head>
        <body>
          Yo' . htmlspecialchars($adressemailuser) . ' </br>
          Tu a un nouveau commentaire sur l une de tes publication ? laquelle inchallah j implemente ca.
        </body>
      </html>
      ';
        mail($adressemailuser, $subject, $message, $headers);
}
?>
