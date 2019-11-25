<?php
session_start();
if (!isset($_SESSION['id']))
{

  $_SESSION["temp"] = NULL;
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CAMAGRU YOUR FAVORITE SOCIAL NETWORK</title>
    <link rel="stylesheet" href="css/master.css">

  </head>
  <body class="container">
    <?php include("fragment/header.php");?>
    <p> <br> <br> <br>  </p>

    <h3>Bienvenue internaute</h3>
    <p>Inscris toi pour pouvoir jouir des tous les features du sites !<br></p>
    <p>Sinon tu peux jeter un oeil sur le contenu que les membres inscrit on mis sur le site</p>

    <p>Pour pouvoir voir/ajouter des likes/commentaires il faut s inscrire !</p>


    <div>
      <div>
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

          echo "<img src='gallery/$res' class='photo_index'>" ;

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
      <link rel="stylesheet" href="css/master.css">

      <title></title>
    </head>
    <body>
      <body>
        <?php include("fragment/header.php");?>
        <p> <br> <br> <br>  </p>

        <h3>Gallery des membres !</h3>


        <div >
          <div style="">
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

            //faire une condition non inscrit pour voir uniquement les photos OK

            $nombrephoto--;

            echo '<span>';

              if (isset($_SESSION['error']))
                echo $_SESSION['error'];
              $_SESSION['error'] = null;
              if (isset($_SESSION['succes']))
              echo $_SESSION['succes'];
              $_SESSION['succes'] = null;

          echo  '</span>';
            $nombredepage = $nombrephoto / 5;
            //comme ca 5 element par page
            $indexpourlapage = 1;
            while($nombrephoto >= 0)
            {
              $res = $result[$nombrephoto]['img'];
              $galleryid = $result[$nombrephoto]['id'];
                echo "<br/>";
              echo "<img src='gallery/$res' class='photo_index'>" ;
              echo "<br/>";
              echo "<a href='action/a_like2.php?imgPath=$galleryid'<strong>LIKE</strong></a>";

              //on va afficher le nombre de like ici

              try {

                $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // $query= $dbh->prepare("SELECT * FROM `like` WHERE userid = :u AND galleryid = :i");
                //
                // $query->execute([':u' => $uid, ':i' => $img]);
                //
                // $ress = $query->fetchAll();

                $query= $dbh->prepare("SELECT COUNT(*) FROM `like` WHERE userid = :u AND galleryid = :i");
                $query->execute([':u' => $_SESSION['id'], ':i' => $galleryid]);

                $countmax = $query->fetchAll();

                $nombredelike = $countmax[0]['COUNT(*)'];

                echo " Cette Photo à <strong>".$nombredelike." LIKE</strong> ";

              } catch (PDOException $e) {
                echo "jsai pas";
              echo "ERROR: ".$e->getMessage();
              }



              //ok on a afficher l image , le boutton like, avant d afficher lenvoi de commentaire on va afficher la liste des commentaires

              try {
                //include_once ('config/database.php');

                echo "<br>";


                $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query= $dbh->prepare("SELECT * FROM commentaire WHERE galleryid = :gallery");


                $query->execute([':gallery' => $galleryid]);

                $tableaucommentaire = $query->fetchAll(PDO::FETCH_ASSOC);

              } catch (PDOException $e) {
                echo 'error de recuperation des commentaires';
              }
              //je dois recuperer le nombre de commentaire
              echo "<br><div class='title'>Commentaires :</div><br>";
              $i = 0;
              while (isset($tableaucommentaire[$i]['comment']))
              {
                try {
                  $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $query= $dbh->prepare("SELECT username FROM users WHERE id = :userid");
                  $query->execute([':userid' => $tableaucommentaire[$i]['userid']]);

                  $nomdumecquiacommenter = $query->fetchAll();






                } catch (PDOException $e) {

                }

                echo "<p class='title'>".$nomdumecquiacommenter[0]['username']. " à poster ce commentaire :  <p class='title'>   ".htmlspecialchars($tableaucommentaire[$i]['comment']). "</p></p>";
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

            echo "  <br><br><br><br><br><br><div style='text-align:center;'>
              ------ 2019 - REELBOUR © - 19 SCHOOL FROM 42-NETWORK ------
              </div>"
            ?>
          </div>
        </div>


    </body>
  </html>
<?php }?>
