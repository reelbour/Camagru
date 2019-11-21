<?php
session_start();
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
  if (file_exists('../gallery/'))
  {
    if(file_exists("../gallery/$idfichier"))
    {
      $_SESSION['error'] = 'le fichier existe deja';
      echo "le fichier existe deja";
      return;
    }
    file_put_contents('../gallery/image'.$idfichier.'.png', $img_a_sauver);

  }
}

if ($_POST['image'] != '' || $_POST['image'] != null)
{

    if(isset($_SESSION['filtre']))
    {
      $img64 = $_POST['image'];
      $img_decode = base64_decode(substr($img64, 22));
      $id = '5';
      save_in_dossier($img_decode, $id);

      $filtr;
      // cette condition marche pas !
      
      if ($_SESSION['filtre'] == $cat)
          $filtr = "../img/cat.png";
      else
          $filtr = "../img/jsaipa.png";

      $ret = mettre_un_filtre("../gallery/image".$id.".png", $filtr, "../gallery/image".$id.".png");
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
