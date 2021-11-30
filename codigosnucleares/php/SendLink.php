<?php
session_start();
if (isset($_SESSION['user']))
    header("Layout.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include '../html/Head.html'?>
  </head>
  <body>
    <?php include '../php/Menus.php' ?>
    <section class="main" id="s1">
      <div>
        <form class="login-form" action="LogIn.php" method="post" style="text-align: center;">
            <p>
                Hemos enviado un email a  <b><?php echo $_GET['email'] ?></b> para ayudar a recuperar tu cuenta. 
            </p>
            <p>Por favor inicia sesión en tu correo y haz click en el enlace que te hemos enviado para recuperar tu cuenta.</p>
	    </form>   
      </div>
    </section>
    <?php include '../html/Footer.html' ?>
  </body>
</html>
  