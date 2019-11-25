<?php
session_start();

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


if($_SERVER["REQUEST_METHOD"] == "POST")
{
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
          echo "pas le bon fichier mg";
          $_SESSION['error'] = "Erreur : Veuillez sélectionner un format de fichier valide. c a d PNG";
          header("Location: ../montage.php");
        }
      // Vérifie la taille du fichier - 5Mo maximum
      $maxsize = 5 * 1024 * 1024;
      if($filesize > $maxsize)
      {
        echo "taille trop grande";
        $_SESSION['error'] = "La taille d un fichier neut peut exceder 5 Mo";
        header("Location: ../montage.php");
      }
      // Vérifie le type MIME du fichier
      if(in_array($filetype, $allowed)){
          // Vérifie si le fichier existe avant de le télécharger.
          if(file_exists("upload/" . $_FILES["photo"]["name"])){
            echo "le fichier existe deja d ailleur ca devrai marcher ca enft non je dois mettre un nom avec timestamp";
            $_SESSION['error'] = $_FILES["photo"]["name"] . " existe déjà.";
            header("Location: ../montage.php");
          } else{


            // du coup je verif le filtre seulement ici
            if (isset($_SESSION['filtre']))
            {
              if (!(is_dir("../tmp/")))
              {
                mkdir("../tmp/");
              }
              move_uploaded_file($_FILES["photo"]["tmp_name"], "../tmp/" . $_FILES["photo"]["name"]);
              // cette condition marche que si ya deux dfiltre mais bon pas le time
              $cat = '$cat';


              if ($_SESSION['filtre'] == $cat)
                  $filtr = "../img/cat.png";
              else
                  $filtr = "../img/jsaipa.png";




              $nomdelimagequivaetreenregistre = time();

              mettre_un_filtre("../tmp/".$_FILES["photo"]["name"], $filtr, "../gallery/" . $nomdelimagequivaetreenregistre . ".png");

              unlink("../tmp/".$_FILES["photo"]["name"]);
              // mtn que ca c fait on va inserer la nouvelle image dans la base de donnee

              mettre_dans_bdd($nomdelimagequivaetreenregistre.".png", $_SESSION["id"]);


            //  echo "machalah tout s est bien passé";
              $_SESSION['succes'] = "Votre image à ete upload et superpose avec succes";


              header("Location: ../montage.php");
          }
          else {
            echo 'vous devez selectionner une filtre';
            $_SESSION['error'] = 'vous devez selectionner une filtree consigne de l ecole';
            header("Location: ../montage.php");
          }
        }
}
        else{
        echo "probleme de telechargement du fichier";
        $_SESSION['error'] = "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.";
        header("Location: ../montage.php");
      }
  } else{
    echo 'Probleme d upload; avez vous bien selectionner votre fichier ?';
    $_SESSION['error'] = "Error: " . $_FILES["photo"]["error"];
    header("Location: ../montage.php");
  }

}
else
{
echo "probleme dupload";
$_SESSION['error'] = 'probleme d upload';
header("Location: ../montage.php");
}

?>


<!--






//Verifier avec get qu un filtre est set

echo "on entre on met session error a null puis on tcheck si filtre est set <br />";
$_SESSION['error'] = null;

if(isset($_SESSION['filtre']))
{
  echo "session filtre existe";

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
            echo "pas le bon fichier mg";
            $_SESSION['error'] = "Erreur : Veuillez sélectionner un format de fichier valide. c a d PNG";
            header("Location: ../montage.php");
          }
        // Vérifie la taille du fichier - 5Mo maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize)
        {
          echo "taille trop grande";
          $_SESSION['error'] = "La taille d un fichier neut peut exceder 5 Mo";
          header("Location: ../montage.php");
        }
        // Vérifie le type MIME du fichier
        if(in_array($filetype, $allowed)){
            // Vérifie si le fichier existe avant de le télécharger.
            if(file_exists("upload/" . $_FILES["photo"]["name"])){
              echo "le fichier existe deja d ailleur ca devrai marcher ca";
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

                    echo 'le filtre choisi est ';
                    echo $filtr;

                mettre_un_filtre("../gallery/".$_FILES["photo"]["name"], $filtr, "../gallery/test.png");


                echo "machalah tout s est bien passé";
                $_SESSION['succes'] = "Votre image à ete upload et superpose avec succes";


                header("Location: ../montage.php");
            }
        } else{
          echo "probleme de telechargement du fichier";
          $_SESSION['error'] = "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.";
          header("Location: ../montage.php");
        }
    } else{
      echo 'erreur a determinie';
      $_SESSION['error'] = "Error: " . $_FILES["photo"]["error"];
      header("Location: ../montage.php");
    }
}
else
{
  echo "probleme dupload";
  $_SESSION['error'] = 'probleme d upload';
  header("Location: ../montage.php");
}
}
else
{
  echo 'Vous devez selectionner un filtre pour enregistrer la photo ! desole consigne de 19';
  $_SESSION['error'] = 'Vous devez selectionner un filtre pour enregistrer la photo ! desole consigne de 19';
  header("Location: ../montage.php");
} -->
