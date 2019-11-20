<?php
session_start();


// verifier que les deux valeurs sont du texte alphanumerique sans script     KO

// en veriter ne mettre qu un input pour nouveau mail et username pas beosin de verifier vu qu il est connecter
function update_username($new_user, $mail_user)
{
    include "../config/database.php";
    try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query= $dbh->prepare("UPDATE users SET username = :username WHERE mail = :mai");
        $query->execute(array(':username' => $new_user, ':mai' => $mail_user));
        $query->closeCursor();
        return 1;
        }
    catch(PDOException $e)
    {
      return ($e->getMessage());
    }
}

function tchek_if_user_exist($username)
{
  include "../config/database.php";
  try {
      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $query= $dbh->prepare("SELECT * FROM users WHERE username = :username");
      $query->execute(array(':username' => $username));
      $result = $query->fetch(PDO::FETCH_ASSOC);//ca recup sous forme de tableau associatif lesvaleur des mon bdd
      if ($username === $result['username'])
          {
            return (1);
          }
        }
  catch(PDOException $e)
  {
    return ($e->getMessage());
  }
}

$new_username = $_POST['new_username'];
if ($new_username == "" || $new_username == null)
{
  $_SESSION['error'] = "Vous devez remplir le champ nouveeau user et pas faire chier a cliquer pour les couilles du pape merci";
  header("Location: ../admin.php");
return;
}
if (strlen($new_username) < 3)
{
  $_SESSION['error'] = "l username doit faire au moins 3 lettres";
  header("Location: ../admin.php");
  return;

}

if (tchek_if_user_exist($new_username) == 1)
{
  $_SESSION['error'] = "le nom d utilisateur choisi existe deja";
  header("Location: ../admin.php");
}

if (update_username($new_username, $_SESSION['mail']) != 1)
{
  $_SESSION['error'] = "echec de mise a jour du password dans la base de donne";
  header("Location: ../admin.php");
  return;
}
  $_SESSION['succes'] = 'votre username a bien ete mis a jour';
  $_SESSION['username'] = $new_username;
  header("Location: ../admin.php");
?>
