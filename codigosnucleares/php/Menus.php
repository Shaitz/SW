<?php
if(isset($_SESSION['user']))
{
  $lafoto = $_SESSION['foto'];
  $user_email = $_SESSION['user'];
  $newUrl = 'HandlingQuizesAjax.php?email='.$user_email;
}
else
  $newUrl = 'QuestionFormWithImage.php';
?>
<div id='page-wrap'>
<header class='main' id='h1'>
  <span class="right"><a href="SignUp.php"><?php if(!isset($user_email))echo "Registro";?></a></span>
        <span class="right"><a href="LogIn.php"><?php if(!isset($user_email))echo "Login";?></a></span>
        <span class="right"> <?php if(isset($user_email))echo $user_email;?></span>
        <span class="right"><?php if(isset($lafoto)) echo "<img src='../images/$lafoto' height='50px' width='50px'>"; ?> </span>
        <span class="right" ><a href="LogOut.php"><?php if(isset($user_email)) echo "Logout"; else echo ""; ?></a></span>
</header>
<nav class='main' id='n1' role='navigation'>
  <span><a href='Layout.php'>Inicio</a></span>
  <span><?php if(!isset($_SESSION['user'])) echo "<a href=$newUrl> <font color='red'>Gestionar Preguntas</font></a>"; else if($_SESSION['rol'] != "Admin") echo "<a href=$newUrl> Gestionar Preguntas</a>";else if($_SESSION['rol'] == "Admin") echo "<a href=HandlingAccounts.php> Gestionar Cuentas</a>";?></span>
  <span><?php if(isset($_SESSION['user']) && $_SESSION['rol'] == "Profesor") echo "<a href=HandlingVipsAjax.php> Gestionar VIPs"; else if (isset($_SESSION['user']) && $_SESSION['rol'] != 'Admin') echo "<a href=Play.php> A Jugar!"?></span>
  <span><a href='Credits.php'>Creditos</a></span>
  <span></span>
  <span><a href='SearchUser.php'>Buscar Usuario</a></span>
</nav>

