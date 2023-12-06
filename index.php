<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);   
    ini_set('error_reporting', E_ALL);
    session_start();
   
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Andrea's bakery</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.1.1/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
      body{
        background-image: url("./img/bakery.jpg");
        height:100vh;
        width: 100%;
        background-position:center;
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
      }
    </style>
  </head>
  <body >
  <?php
        include "views/topmenu.php";
      ?>
    <div class="container"> 
      <?php
        //dynamic html content generated here by controller.
        require_once 'controllers/MainController.php';
        (new MainController())->processRequest();
      ?>
      </div>
  </body>
</html>