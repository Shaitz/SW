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
      shuffle($preguntas_restantes);
      $_SESSION['preguntas_restantes'] = $preguntas_restantes;
  }
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script language=JavaScript src="../js/ShowCurrentQuestion.js"></script>
  <style>
.boton
{
    font-size: 16px;
    font-family: inherit;
    background-color: #fff;
    border: 1px solid;
    border-radius: 4px;
    color: #fff !important;
    text-transform: uppercase;
    text-decoration: none;
    background: #b470e2;
    padding: 20px;
    display: inline-block;
}
.boton:hover
{
    background: #ed9230;
    letter-spacing: 1px;
    -webkit-box-shadow: 0px 5px 40px -10px rgba(0,0,0,0.57);
    -moz-box-shadow: 0px 5px 40px -10px rgba(0,0,0,0.57);
    box-shadow: 5px 40px -10px rgba(0,0,0,0.57);
}
.laik
{
    background: url(../images/like.png);
    width:30px; 
    height:30px; 
    border: 0;
    background-size: 100%;
}
.laik:hover
{
    background-color: blue;
}
.dlike
{
    background: url(../images/dislike.png);
    width:30px; 
    height:30px; 
    border: 0;
    background-size: 100%;
}
.dlike:hover
{
    background-color: red;
}
.fuente
{
  font-size: 20px;
}
  </style>
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
  <input type="button" value="Siguiente" name="next" id="next" class = "boton">

  <div id = "lapregunta"></div>
    <label id = "pregunta_id" class = "fuente"></label>
    <label id = "pregunta_sentencia" class = "fuente"></label>

      <input type="button" id = "like" class = "laik">
      <label id = likes style="font-size:20px"></label>
      <input type="button" id = dislike class = "dlike">
      <label id = dislikes style="font-size:20px"></label><br>

  <div id = "laimagen"></div>
    <img id = "image" src=../images/test height=80px width=100px><br>
  <div id = "container"></div>
    <input type=radio id="resp1" name=respuesta value="1"><label id = "respLabel1" class = "fuente"></label><br>
    <input type=radio id="resp2" name=respuesta value="2"><label id = "respLabel2" class = "fuente"></label><br>
    <input type=radio id="resp3" name=respuesta value="3"><label id = "respLabel3" class = "fuente"></label><br>
    <input type=radio id="resp4" name=respuesta value="4"><label id = "respLabel4" class = "fuente"></label><br>
  <div>
    <input type="button" value="Comprobar" name="verify" id="verify" class = "boton">
  </div>
  <div id = "larespuesta">
    <label id = "correcta"></label><br>
    <label id = "incorrecta"></label>
  </div>
  <div id = "resultado">
    <label id = "fin"></label><br>
    <label id = "puntuacion"></label><br>
    <label id = "aciertos"></label><br>
    <label id = "fallos"></label>
  </div>

  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
