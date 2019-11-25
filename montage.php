<?php
  session_start();
  if (isset($_SESSION['username']))
  {

    $_SESSION['filtre'] = null;

    if (isset($_GET['selected']))
    {
      $_SESSION['filtre'] = $_GET['selected'];
    }
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>prenez une photo</title>
    <link rel="stylesheet" href="css/master.css">

  </head>

  <body class="container">


    <?php include('fragment/header.php');?>

    <div class="img_superposable">
    <a href="?selected=$cat"> <img src="img/cat.png" width="150px" height="150px" alt=""></a>
    <a href="?selected=$jsaipa"><img src="img/jsaipa.png" width="150px" height="150px" alt=""></a>
    </div>


    <fieldset style="width: 640px; display: inline-block;">
      <legend>Webcam</legend>
      <video autoplay></video><br />
      <button onclick="takephoto();">Prendre une photo</button>
      <form action="action/a_upload.php" method="post" enctype="multipart/form-data">
        <label for="fileUpload">Fichier:</label>
        <input type="file" name="photo" id="fileUpload">
        <input type="submit" name="submit" value="Upload">
        <!-- <p><strong>Note:</strong> Seuls le format .png est autorisé jusqu'à une taille maximale de 5 Mo.</p> -->
        <span>
          <?php
          if (isset($_SESSION['error']))
            echo $_SESSION['error'];
          $_SESSION['error'] = null;
          if (isset($_SESSION['succes']))
          echo $_SESSION['succes'];
          $_SESSION['succes'] = null;
          ?>
        </span>

      </form>
    </fieldset>


    <fieldset style="width: 640px; display: inline-block;">
      <legend>Photo</legend>
      <img id="test" src="" alt="Photo" title="Photo" />
      <form class="" action="action/a_save_file.php" method="post">
      <input type="text" name="image" style="display:none">
      <button type="submit" name="submit">Enregistrer la photo</button>
      </form>

    </fieldset>

    <canvas style="display: none;" width="640" height="480"></canvas>

    <script type="text/javascript">
      var video = document.querySelector('video');
      var canvas = document.querySelector('canvas');
      var photo = document.querySelector('img#test');

      navigator.getMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
      navigator.getMedia({ video: { mandatory: { maxWidth: 640, maxHeight: 480 } } }, function(stream) {
        video.srcObject = stream;

      }, function(e) {
        console.log("Failed!", e);
      });

      function takephoto() {
        var ctx = canvas.getContext("2d").drawImage(video, 0, 0, 640, 480);
        var data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);
        document.querySelector('input[name=image]').value = data;

      }


    </script>



    <div>
      <?php

// on va faire une requete avant pour le Count


try {
      include_once 'config/database.php';

      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $queryx= $dbh->prepare("SELECT COUNT(*) FROM gallery WHERE userid=:userid");
      $idusercount = $_SESSION["id"];
      $queryx->execute(array('userid' => $idusercount));
      $resultx = $queryx->fetchAll(PDO::FETCH_ASSOC);



    $nombreentre = $resultx[0]['COUNT(*)'];


    //  echo "<br />";
    //  print_r($resultx);


    //  closeCursor($queryx);


} catch (PDOException $e) {
  return($e->getMessage());
}

                //include '../setup/database.php'


try {
        include_once 'config/database.php';
            $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query= $dbh->prepare("SELECT * FROM gallery WHERE userid=:userid");

            $s = $_SESSION["id"];

            $query->execute(array('userid' => $s));

            //$_SESSION['id']));

            $result = $query->fetchAll(PDO::FETCH_ASSOC);//ca recup sous forme de tableau associatif lesvaleur des mon bdd

// jai besoin de recup avec un select count le nomnre de colone sinon ca bug sa mere
        //  print_r($result);
          $i = $nombreentre - 1;

            while($i >= 0)
              {
              //  print_r($result);
              $var = $result[$i]['img'];

              $galleryid = $result[$i]['id'];
            //  print_r($result);
              //echo $var;
              ?>
              <div>
                <?php




                echo "<img src='gallery/$var' width='200px' height='200px;' >";
                echo "<br/>";
                echo "<a href='action/a_del_image.php?imgPath=$var&imgId=$galleryid'><strong>X</strong></a>";
                echo "              ";
                echo "<a href='action/a_like.php?imgPath=$galleryid'<strong>LIKE</strong></a>";
//<img src="gallery/" 1574441745.png="" <="" div="">

                echo  '</div>';

            $i--;
            }
          }

       catch (PDOException $e) {
        return($e->getMessage());
      }
      ?>
    </div>
    <?php include('fragment/footer.php');?>

  </body>

</html>
<?php } else { ?>

  <!DOCTYPE html>
  <html lang="fr" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title></title>
    </head>
    <body>
      <h3>Vous devez vous connectez pour acceder a cette page, cliquer <a href="index.php">ICI</a> pour revenir a l'acceuil </h3>
      <h3>Si vous souhaitez vous inscrire cliquer <a href="form/signup.php">ICI</a> pour vous inscire</h3>
    </body>
  </html>
  <?php } ?>
