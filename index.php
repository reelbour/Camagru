<?php
session_start();
if (!isset($_SESSION['id']))
{
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CAMAGRU YOUR FAVORITE SOCIAL NETWORK</title>
    <!-- <link rel="stylesheet" href="css/master.css"> -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<!-- Compiled and minified JavaScript -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script> -->

  </head>
  <body class="container">
    <?php include("fragment/header.php");?>
    <p> <br> <br> <br>  </p>

    <h3>Bienvenue internaute</h3>
    <p>Inscris toi pour pouvoir jouir des tous les features du sites !<br></p>
    <p>Sinon tu peux jeter un oeil sur le contenu que les membres inscrit on mis sur le site</p>

    <p>Pour pouvoir voir/ajouter des likes/commentaires il faut s inscrire !</p>


    <div class="contenu">
      <div class="main">
        <?php
          //on recupere le nombre d image
        try {
          include_once('config/database.php');
          $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $queryx= $dbh->prepare("SELECT COUNT(*) FROM gallery");

          $queryx->execute();
          $resultx = $queryx->fetchAll(PDO::FETCH_ASSOC);
          $nombrephoto = $resultx[0]['COUNT(*)'];
          //echo $nombrephoto;
        } catch (PDOException $e) {

        }
        try {
                include_once 'config/database.php';
                    $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $query= $dbh->prepare("SELECT * FROM gallery");
                    $query->execute();


                    $result = $query->fetchAll(PDO::FETCH_ASSOC);//ca recup sous forme de tableau associatif lesvaleur des mon bdd
                  }
        catch (PDOException $e)
        {

        }

      //  print_r($result);
        //pour afficher dans le while j ai besoin de
        //gallery/ nom de l image.png
        //pouvoir liker les photos (boutton href)
        // pouvoir commenter les photos
        // pouvoir voir les commentaires
        // pouvoir voir le nombre de likes

        //faire une condition non inscrit pour voir uniquement les photos

        $nombrephoto--;
        while($nombrephoto >= 0)
        {
          $res = $result[$nombrephoto]['img'];

          echo "<img src='gallery/$res'>" ;

          $nombrephoto--;
        }


        ?>
      </div>
    </div>
    <?php include("fragment/footer.php");?>
  </body>
</html>
<?php } else {?>



  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title></title>
    </head>
    <body>
<p>a faire</p>
    </body>
  </html>
<?php }?>
