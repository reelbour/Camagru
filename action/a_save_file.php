<?php
session_start();

// debut des Fonction

// adpater la fonction pour l action save file take picture ta capter
function mettre_dans_bdd($pathfichier, $userid)
{
    include_once '../config/database.php';

    try {
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query= $dbh->prepare("INSERT INTO gallery (userid, img) VALUES (:userid, :img)");
        $query->execute(array(':userid' => $userid, ':img' => $pathfichier));
        $_SESSION['succes'] = 'normalment on a enregistrer dans la bdd';
        }
      catch (PDOException $e) {
        return ($e->getMessage());
      }
}


function mettre_un_filtre($source, $sourcefiltre, $pathfichier)
{
  // Charge le cachet et la photo afin d'y appliquer le tatouage numérique
    $stamp = imagecreatefrompng($sourcefiltre);
    $im = imagecreatefrompng($source);

// Définit les marges pour le cachet et récupère la hauteur et la largeur de celui-ci
  $marge_right = 10;
  $marge_bottom = 10;
  $sx = imagesx($stamp);
  $sy = imagesy($stamp);

// Copie le cachet sur la photo en utilisant les marges et la largeur de la
// photo originale  afin de calculer la position du cachet
  imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

// Affichage et libération de la mémoire
  header('Content-type: image/png');
  imagepng($im, $pathfichier);
  imagedestroy($im);
}

function save_in_dossier($img_a_sauver, $idfichier)
{
  if (file_exists('../tmp/'))
  {
    if(file_exists("../tmp/". $idfichier . ".png"))
    {
      $_SESSION['error'] = 'le fichier existe deja';
      echo "le fichier existe deja";
      return;
    }
    file_put_contents('../tmp/'.$idfichier.'.png', $img_a_sauver);

  }
}
//
//
//
//fin des Fonction




if ($_POST['image'] != '' || $_POST['image'] != null)
{

    if(isset($_SESSION['filtre']))
    {
      $img64 = $_POST['image'];
      $img_decode = base64_decode(substr($img64, 22));
      //$id = '5';
      $nomdelimagequivaetreenregistre = time();
      save_in_dossier($img_decode, $nomdelimagequivaetreenregistre);

      $filtr;
      // cette condition marche que si ya deux dfiltre mais bon pas le time
      $cat = '$cat';
      if ($_SESSION['filtre'] == $cat)
          $filtr = "../img/cat.png";
      else
          $filtr = "../img/jsaipa.png";




            mettre_un_filtre("../tmp/".$nomdelimagequivaetreenregistre.".png", $filtr, "../gallery/".$nomdelimagequivaetreenregistre.".png");
            //mtn on va mettre l image dans la base de donne (le chemin)

            mettre_dans_bdd($nomdelimagequivaetreenregistre.".png", $_SESSION["id"]);
            unlink("../tmp/" .$nomdelimagequivaetreenregistre. ".png");


    // save_in_dossier($ret, $id);
      $_SESSION['succes'] = 'la photo a bien été enregistrer';
      header("Location: ../montage.php");
    }
    else
    {
      $_SESSION['error'] = 'Vous devez selectionner un filtre pour enregistrer la photo ! desole consigne de 19';
      header("Location: ../montage.php");
    }
}
else {
  $_SESSION['error'] = 'Vous devez prendre une photo pour l enregistrer vous pouvez egalement en uploader une (si j ai pas oublie de le faire)';
  header("Location: ../montage.php");
}
?>
