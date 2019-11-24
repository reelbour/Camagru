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
      <title>CAMAGRU YOUR FAVORITE SOCIAL NETWORK</title>
      <!-- <link rel="stylesheet" href="css/master.css"> -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

      <title></title>
    </head>
    <body>
      <body class="container">
        <?php include("fragment/header.php");?>
        <p> <br> <br> <br>  </p>

        <h3>Gallery des membres !</h3>


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

            //print_r($result);
            //pour afficher dans le while j ai besoin de
            //gallery/ nom de l image.png                                 OK
            //pouvoir liker les photos (boutton href)                     OK
            // pouvoir commenter les photos                               OK
            // pouvoir voir les commentaires                              OK
            // pouvoir voir le nombre de likes                            KO

            //faire une condition non inscrit pour voir uniquement les photos

            $nombrephoto--;

            echo '<span>';

              if (isset($_SESSION['error']))
                echo $_SESSION['error'];
              $_SESSION['error'] = null;
              if (isset($_SESSION['succes']))
              echo $_SESSION['succes'];
              $_SESSION['succes'] = null;

          echo  '</span>';

            while($nombrephoto >= 0)
            {
              $res = $result[$nombrephoto]['img'];
              $galleryid = $result[$nombrephoto]['id'];
                echo "<br/>";
              echo "<img src='gallery/$res'>" ;
              echo "<br/>";
              echo "<a href='action/a_like2.php?imgPath=$galleryid'<strong>LIKE</strong></a>";
              echo "<br><br>";
              //ok on a afficher l image , le boutton like, avant d afficher lenvoi de commentaire on va afficher la liste des commentaires

              try {
                //include_once ('config/database.php');
              
                echo "<br>";


                $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query= $dbh->prepare("SELECT comment FROM commentaire WHERE galleryid = :gallery");


                $query->execute([':gallery' => $galleryid]);

                $tableaucommentaire = $query->fetchAll(PDO::FETCH_ASSOC);


              } catch (PDOException $e) {
                echo 'error de recuperation des commentaires';
              }
              //je dois recuperer le nombre de commentaire
              echo "<br>Commentaires :<br>";
              $i = 0;
              while (isset($tableaucommentaire[$i]['comment']))
              {
                echo "<p>" .htmlspecialchars($tableaucommentaire[$i]['comment']). "<p/>";
                $i++;
              }


              //print_r($tableaucommentaire);


              //print_r($query);


              ?>
              <form action="action/a_comment.php" method="post">
                <label>Ajouter un commentaire :</label>
                <input type="text" name="comment" value="">
                <?php
                echo "  <input type='hidden' name='galleryid' value='$galleryid' >" ;
                ?>
                <input name="submit" type="submit" value="ENVOYER ">
              </form>
              <?php

              $nombrephoto--;
            }


            ?>
          </div>
        </div>
        <?php include("fragment/footer.php");?>

    </body>
  </html>
<?php }?>
