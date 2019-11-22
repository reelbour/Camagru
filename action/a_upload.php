<?php

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



//Verifier avec get qu un filtre est set

if(isset($_SESSION['filtre']))
{

// Vérifier si le formulaire a été soumis
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Vérifie si le fichier a été uploadé sans erreur.
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
        $allowed = array("png" => "image/png");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];

        // Vérifie l'extension du fichier
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed))
          {
            $_SESSION['error'] = "Erreur : Veuillez sélectionner un format de fichier valide. c a d PNG";
            header("Location: ../montage.php");
          }
        // Vérifie la taille du fichier - 5Mo maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize)
        {
          $_SESSION['error'] = "La taille d un fichier neut peut exceder 5 Mo";
          header("Location: ../montage.php");
        }
        // Vérifie le type MIME du fichier
        if(in_array($filetype, $allowed)){
            // Vérifie si le fichier existe avant de le télécharger.
            if(file_exists("upload/" . $_FILES["photo"]["name"])){
              $_SESSION['error'] = $_FILES["photo"]["name"] . " existe déjà.";
              header("Location: ../montage.php");
            } else{
                move_uploaded_file($_FILES["photo"]["tmp_name"], "../gallery/" . $_FILES["photo"]["name"]);
                // cette condition marche que si ya deux dfiltre mais bon pas le time
                $cat = '$cat';

                if ($_SESSION['filtre'] == $cat)
                    $filtr = "../img/cat.png";
                else
                    $filtr = "../img/jsaipa.png";

                mettre_un_filtre("../gallery/".$_FILES["photo"]["name"], $filtr, "../gallery/test.png");

                $_SESSION['succes'] = "Votre image à ete upload et superpose avec succes";


                header("Location: ../montage.php");
            }
        } else{
          $_SESSION['error'] = "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.";
          header("Location: ../montage.php");
        }
    } else{
      $_SESSION['error'] = "Error: " . $_FILES["photo"]["error"];
      header("Location: ../montage.php");
    }
}
else
{
  $_SESSION['error'] = 'probleme d upload';
  header("Location: ../montage.php");
}
}
else
{
  $_SESSION['error'] = 'Vous devez selectionner un filtre pour enregistrer la photo ! desole consigne de 19';
  header("Location: ../montage.php");
}
?>
