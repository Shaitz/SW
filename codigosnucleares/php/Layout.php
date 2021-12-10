<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script language=JavaScript src="../js/GetRanking.js"></script>
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
    <div>

    <h1 style="font-size:300%;font-family:courier;background-color:lightblue;">Quiz: El juego de las preguntas</h1><br>
    <h2>TOP QUIZERS</h2><br>
    <div id = "ranking"></div>
      
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
