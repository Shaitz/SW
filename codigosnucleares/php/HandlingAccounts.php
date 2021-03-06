<?php 
include 'DbConfig.php';
?>
<?php 
session_start();
if (!isset($_SESSION['user']))
{
    header("Location: Layout.php");
    die();
}
if (isset($_SESSION['user']) && $_SESSION['rol'] != "Admin")
{
    header("Location: Layout.php");
    die();
}
?>
<!DOCTYPE html>
<html>
<head>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="../styles/jquery.toast.min.css">
  <link rel="stylesheet" href="../styles/bootstrap.min.css" />
  <link rel="stylesheet" href="../styles/boton_tablas.css" />
  <script src="../js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../js/jquery.toast.min.js"></script>
  <script language=JavaScript src="../js/Ban.js"></script>

  <?php include '../html/Head.html'?>
</head>
<body>
  <?php include '../php/Menus.php' ?>
  
  <section class="main" id="s1">
    <div>
    <h1 style="font-size:300%;font-family:courier;background-color:lightblue;">Gestion de Cuentas</h1><br>  
      <form id="accounts" name="accounts" method="POST" enctype="multipart/form-data">
      <div>   
        <div class = elform>
          Usuario a Gestionar <br/>
          <input type=text style = "width: 250px" id=usuario_modificado><br/><br/>
          <input type=button value="Ban/Unban" id=ban class = "Bbutton buttonC">
          <input type=button value=Eliminar id=delete class = "Bbutton buttonC2">
        </div>
        <div id = "usrs" class = "tablas">
        </div>
      </div>
      </form>
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>