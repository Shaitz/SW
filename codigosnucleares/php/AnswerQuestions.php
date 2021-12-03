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
  <label id = "pregunta_id"> 0 </label>
  <label id = "pregunta_sentencia"> Pregunta </label><br>
<div id = "laimagen"></div>
  <img id = "image" src=../images/test height=80px width=100px><br>
<div id = "container"></div>
  <input type=radio id="resp1" name=respuesta value="1"><label id = "respLabel1">1</label><br>
  <input type=radio id="resp2" name=respuesta value="2"><label id = "respLabel2">2</label><br>
  <input type=radio id="resp3" name=respuesta value="3"><label id = "respLabel3">3</label><br>
  <input type=radio id="resp4" name=respuesta value="4"><label id = "respLabel4">4</label><br>
<div>
  <input type="button" value="Comprobar" name="verify" id="verify">
</div>
<div id = "larespuesta">
  <label id = "siono">Tu respuesta: </label>
</div>

  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
