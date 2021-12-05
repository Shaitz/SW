<?php
session_start();
if (!isset($_SESSION['user']))
    header("Location: Layout.php");

if (isset($_SESSION['user']) && $_SESSION['rol'] == 'Admin')
    header("Location: Layout.php");

if (isset($_SESSION['preguntas_restantes']) && empty($_SESSION['preguntas_restantes']))
{
    unset($_SESSION['tema_preguntas']);
    unset($_SESSION['puntuacion']);
    unset($_SESSION['aciertos']);
    unset($_SESSION['fallos']);
}
    
if (isset($_SESSION['tema_preguntas']))
    header("Location: AnswerQuestions.php?tema=" . $_SESSION['tema_preguntas']);

?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script language=JavaScript src="../js/ShowThemes.js"></script>
  <link rel="stylesheet" href="../styles/scroll_table.css" />
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
  <input type="button" value="Ver Temas" name="themes" id="themes">
    <div id = "temas">
      
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
