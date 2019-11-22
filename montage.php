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
    <!-- <link rel="stylesheet" href="css/master.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<!-- Compiled and minified JavaScript -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script> --> -->

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
      <img id="test" src="about:blank" alt="Photo" title="Photo" />
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



    <div class="gallery_montage">
      <?php


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
    </body>
  </html>
  <?php } ?>
