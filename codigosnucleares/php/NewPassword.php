<?php include "DbConfig.php";
session_start();
if (isset($_SESSION['user']))
    header("Layout.php");
?>
<?php
if (isset($_POST['new_password'])) 
{
    $new_pass = $_POST['newPass'];
    $new_pass_c = $_POST['newPassConfirm'];
    $token = $_GET['token'];

    if (strlen($new_pass) < 8 || $new_pass != $new_pass_c)
    {
        $error = "La contraseña debe tener al menos 8 caracteres y las contraseñas tienen que coincidir.";
    }
    else
    {
        try
        {
            $dsn = "mysql:host=$server;dbname=$basededatos";
            $link = new PDO($dsn, $user, $pass);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        $stmt_get_token = $link->prepare("select email from password_reset where token = ?");
        $stmt_get_token->bindParam(1, $token);
        $stmt_get_token->setFetchMode(PDO::FETCH_ASSOC); 
        $stmt_get_token->execute();
        while ($row = $stmt_get_token->fetch())
        {
            $email_reset = $row['email'];
        }
        $link = null;
        
      if ($email_reset) 
      {
        $new_pass = md5($new_pass);
        try
        {
            $dsn = "mysql:host=$server;dbname=$basededatos";
            $link = new PDO($dsn, $user, $pass);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        $stmt_update_pw = $link->prepare("update Usuarios set Contraseña = ? where Email = ?");
        $stmt_update_pw->bindParam(1, $new_pass);
        $stmt_update_pw->bindParam(2, $email_reset);
        $stmt_update_pw->execute();
        $link = null;
        header('location: LogIn.php');
      }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <style>
      .respuesta
      {
          color:red;
      }
  </style>
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
    <div>
        <h1 style="font-size:300%;font-family:courier;background-color:lightblue;">Nueva Contraseña</h1><br>
        <form class="login-form" method="post">
            <h2 class="form-title">Cambiar Contraseña</h2>
            <div class="form-group">
                <label>Nueva Contraseña</label>
                <input type="password" name="newPass">
            </div>
            <div class="form-group">
                <label>Confirmar Nueva Contraseña</label>
                <input type="password" name="newPassConfirm">
            </div>
            <div class="form-group">
                <button type="submit" name="new_password">Enviar</button>
            </div>
	    </form>
        <div class = "respuesta">
            <?php if(isset($error))
                {
                    echo $error;
                } ?>
        </div>
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>