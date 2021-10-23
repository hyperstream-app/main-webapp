<?php
require 'assets/includes/functions.php';
if(isset($_GET['id'])) {
  connectToStore();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
  <section class="section">
    <div class="container">
      <div class="columns">
        <div class="column justify-content-center">
          <center>
          <h1 class="title">
            Connect To Shop using QR Code
          </h1>
            <video autoplay id="video"></video><br>
          </center>
        </div>
        
      </div>
    </div>
  </section><br><br>
  <?php include('assets/includes/navbar.php'); ?>
  <script type="text/javascript" src="assets/js/instascan.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>