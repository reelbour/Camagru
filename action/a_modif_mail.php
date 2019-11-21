<?php
session_start();


// verifier que les deux valeurs sont du texte alphanumerique sans script     KO

// en veriter ne mettre qu un input pour nouveau mail et username pas beosin de verifier vu qu il est connecter
function update_mail($user, $mail_user)
{
    include "../config/database.php";
    try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query= $dbh->prepare("UPDATE users SET mail = :mai WHERE username = :username");
        $query->execute(array(':mai' => $mail_user, ':username' => $user));
        $query->closeCursor();
        return 1;
        }
    catch(PDOException $e)
    {
      return ($e->getMessage());
    }
}

function tchek_if_mail_exist($mail)
{
  include "../config/database.php";
  try {
      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $query= $dbh->prepare("SELECT * FROM users WHERE mail = :mail");
      $query->execute(array(':mail' => $mail));
      $result = $query->fetch(PDO::FETCH_ASSOC);//ca recup sous forme de tableau associatif lesvaleur des mon bdd
      if ($mail === $result['mail'])
          {
            return (1);
          }
        }
  catch(PDOException $e)
  {
    return ($e->getMessage());
  }
}

$new_mail = $_POST['new_mail'];
if ($new_mail == "" || $new_mail == null)
{
  $_SESSION['error'] = "Vous devez remplir le champ nouveeau mail et pas faire chier a cliquer pour les couilles du pape merci";
  header("Location: ../admin.php");
return;
}
if(!filter_var($new_mail, FILTER_VALIDATE_EMAIL)) {
  $_SESSION['error'] = "Vous devez entrer une adresse mail valide";
  header("Location: ../admin.php");
  return;
}

if (tchek_if_mail_exist($new_mail) == 1)
{
  $_SESSION['error'] = "le mail choisi est deja affilier a un compte, tu veux me baiser ? un compte par mail frere";
  header("Location: ../admin.php");
  return;
}

if (update_mail( $_SESSION['username'], $new_mail) != 1)
{
  $_SESSION['error'] = "echec de mise a jour du mail dans la base de donne";
  header("Location: ../admin.php");
  return;
}
  $_SESSION['succes'] = 'votre mail a bien ete mis a jour';
  $_SESSION['mail'] = $new_mail;
  header("Location: ../admin.php");
?>
