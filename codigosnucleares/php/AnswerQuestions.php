<?php
  session_start();
  include 'DbConfig.php';

  if (!isset($_SESSION['user']))
      header("Location: Layout.php");
  if (isset($_SESSION['user']) && $_SESSION['rol'] == 'Admin')
      header("Location: Layout.php");
  if (!isset($_GET['tema']))
      header("Location: Layout.php");
  if (!isset($_SESSION['tema_preguntas']))
  {
      $_SESSION['tema_preguntas'] = $_GET['tema'];
      try
      {
        $dsn = "mysql:host=$server;dbname=$basededatos";
        $link = new PDO($dsn, $user, $pass);
      }catch(PDOException $e){
        echo $e->getMessage();
      }
      $stmt_questions = $link->prepare("select Numero from Preguntas where Tema = ?");
      $stmt_questions->bindParam(1, $_SESSION['tema_preguntas']);
      $stmt_questions->setFetchMode(PDO::FETCH_ASSOC); 
      $stmt_questions->execute();
      $preguntas_restantes = array();
      while ($row = $stmt_questions->fetch())
      {
          $preguntas_restantes[] = $row['Numero'];
      }
      $_SESSION['preguntas_restantes'] = $preguntas_restantes;
  }
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script language=JavaScript src="../js/ShowCurrentQuestion.js"></script>
  <link rel="stylesheet" href="../styles/scroll_table.css" />
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
  <input type="button" value="Siguiente" name="next" id="next">

<div id = "lapregunta"></div>
<div id = "laimagen"></div>
<div id = "container"></div>
<div>
  <input type="button" value="Comprobar" name="verify" id="verify">
</div>
<div id = "larespuesta"></div>

  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
