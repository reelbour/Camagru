<?php
session_start();

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


    echo "on sors";
  }
  echo 'on sors';
}
$img64 = $_POST['image'];
$img_decode = base64_decode(substr($img64, 22));
$id = '5';
save_in_dossier($img_decode, $id);
header("Location: ../montage.php");

?>
