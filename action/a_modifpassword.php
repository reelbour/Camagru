<?php
  session_start();

  //include ('../config/database.php');
  // on recup le mail du gars ( set avec session mail dans fonction login) OK
  //echo $_SESSION['mail'];

  // on verifie quoi
  //qu on recoi trois valeur                                OK

  // que les deux nouveau password sont les memes           OK
  // que les deux psw sont un minimum securiser             OK

  // que l ancier psw correspond                            OK
  //ensuite on met a jour la base de donne                  OK



  // on renvoi ok ou ko                                       OK


function testlastpassword($old_psw, $mail_user)
  {
      $psd = hash('whirlpool', $old_psw);
      include "../config/database.php";
      try {
          $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $query = $dbh->prepare("SELECT * FROM users WHERE mail=:mail");
          $query->execute(array('mail' => $mail_user));

          $result = $query->fetch(PDO::FETCH_ASSOC);//ca recup sous forme de tableau associatif lesvaleur des mon bdd
          if ($psd == $result['password'])
              {
                return (1);
              }
            }
      catch(PDOException $e)
      {
          echo "Impossible to know if login and pswd are correct. The mistake is :".$e;
      }
}

function update_motdepasse($new_psw, $mail_user)
{
    include "../config/database.php";
    try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $new_psw = hash('whirlpool', $new_psw);
        $query= $dbh->prepare("UPDATE users SET password = :passwor WHERE mail = :mai");
        $query->execute(array(':passwor' => $new_psw, ':mai' => $mail_user));
        $query->closeCursor();
        return 1;
        }
    catch(PDOException $e)
    {
      return ($e->getMessage());
    }
}

  $_SESSION['error'] = null;
  $_SESSION['succes'] = null;
  $mail_user = $_SESSION['mail'];
  $old_psw = $_POST['old_password'];
  $new_psw1 = $_POST['new_pass1'];
  $new_psw2 = $_POST['new_pass2'];

  if ($old_psw == "" || $old_psw == null || $new_psw1 == "" || $new_psw1 == null || $new_psw2 == "" || $new_psw2 == null) {
    $_SESSION['error'] = "Vous devez remplir tout les champs";
    header("Location: ../admin.php");
    return;
  }
  if ($new_psw2 != $new_psw1)
    {
      $_SESSION['error'] = "les mot de passe ne corresponde pas";
      header("Location: ../admin.php");
      return;
    }
  if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}$#', $new_psw1) != 1 || strlen($new_psw1) > 15)
  {
    $_SESSION['error'] = 'Le mot de passe doit contenir au moins une lettre majuscule, 1 lettre miniscule et un chiffre. doit etre compris entre 6 et 15 lettres';
    header("Location: ../admin.php");
    return;
  }


  if (testlastpassword($old_psw, $mail_user) != 1)
      {
        $_SESSION['error'] = "le mot de passe ne  correspond pas a l ancien enregegistre";
        header("Location: ../admin.php");
        return;
  }
  if (update_motdepasse($new_psw1, $mail_user) != 1)
  {
    $_SESSION['error'] = "echec de mise a jour du password dans la base de donne";
    header("Location: ../admin.php");
    return;
  }
    $_SESSION['succes'] = 'votre mot de passe a bien ete mis a jour';
    header("Location: ../admin.php")

?>
