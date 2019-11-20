<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>getUserMedia() API Demo</title>
  </head>
  <body>
    <?php include('fragment/header.php');?>
    <fieldset style="width: 640px; display: inline-block;">
      <legend>Webcam</legend>
      <video autoplay></video><br />
      <button onclick="takephoto();">Prendre une photo</button>
    </fieldset>

    <fieldset style="width: 640px; display: inline-block;">
      <legend>Photo</legend>
      <img id="test" src="about:blank" alt="Photo" title="Photo" />
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
  </body>
</html>
