<?php
  session_start();
  if (isset($_SESSION['username']))
  {
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>prenez une photo</title>
    <link rel="stylesheet" href="css/master.css">
  </head>

  <body>

    <?php include('fragment/header.php');?>

    <div class="img_superposable">

      <img src="img/cat.png" width="150px" height="150px" alt="">
      <img src="img/jsaipa.png" width="150px" height="150px" alt="">
    </div>


    <fieldset style="width: 640px; display: inline-block;">
      <legend>Webcam</legend>
      <video autoplay></video><br />
      <button onclick="takephoto();">Prendre une photo</button>
    </fieldset>

    <fieldset style="width: 640px; display: inline-block;">
      <legend>Photo</legend>
      <img id="test" src="about:blank" alt="Photo" title="Photo" />
      <form class="" action="index.html" method="post">
          <button type="button" name="button">Enregistrer la photo</button>
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
      }
    </script>
    <div class="gallery_montage">

      <p>p</p>
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
