<?php include 'DbConfig.php';
include 'IncreaseGlobalCounter.php' ?>
<?php
    session_start();
    if (isset($_SESSION['user']))
    {
      header("Location: Layout.php");
      die();
    }
    if (isset($_POST['enviar']))
    {
        $error = "";
        $us_email = trim($_POST['emailUser']);
        $us_pw = trim($_POST['passwordUser']);
        $cont = 0;

        try
        {
          $dsn = "mysql:host=$server;dbname=$basededatos";
          $link = new PDO($dsn, $user, $pass);
        }catch(PDOException $e){
          echo $e->getMessage();
        }

        $pw_encrypted = md5($us_pw);
        
        $stmt_usuarios = $link->prepare('select * from Usuarios where Email = ? and Contraseña = ?');
        $stmt_usuarios->bindParam(1, $us_email);
        $stmt_usuarios->bindParam(2, $pw_encrypted);
        $stmt_usuarios->setFetchMode(PDO::FETCH_OBJ);
        $stmt_usuarios->execute();

        while($row = $stmt_usuarios->fetch())
          ++$cont;

        if($cont == 0)
            $error = "Datos incorrectos.";

        else
        {
          $stmt_usuarios = $link->prepare('select * from Usuarios where Email = ? and Contraseña = ?');
          $stmt_usuarios->bindParam(1, $us_email);
          $stmt_usuarios->bindParam(2, $pw_encrypted);
          $stmt_usuarios->setFetchMode(PDO::FETCH_OBJ);
          $stmt_usuarios->execute();
          while ($row = $stmt_usuarios->fetch())
          {    
            $estado_usuario = $row->Estado;
          }
        }
        $link = null;
        if ($error == "")
        {
          if ($estado_usuario == "Activo")
          {
            try
            {
              $dsn = "mysql:host=$server;dbname=$basededatos";
              $link = new PDO($dsn, $user, $pass);
            }catch(PDOException $e){
              echo $e->getMessage();
            }
            $stmt_tipo = $link->prepare("select * from Usuarios where Email = ?");
            $stmt_tipo->bindParam(1, $us_email);
            $stmt_tipo->setFetchMode(PDO::FETCH_ASSOC); 
            $stmt_tipo->execute();

            while ($row = $stmt_tipo->fetch())
            {
              $type = $row['Tipo'];
              $lafoto = $row['Foto'];
            }
            
            $link = null;

            $_SESSION['user'] = $us_email;
            $_SESSION['foto'] = $lafoto;
            $_SESSION['rol'] = $type;
            incrementar();
            header("Location: Layout.php");
          }
          else
          {
            $error .= "Estas Baneado.";
          }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <?php include '../html/Head.html'?>
  <style>
input {
  font-size: 16px;
  font-size: max(16px, 1em);
  font-family: inherit;
  padding: 0.25em 0.5em;
  background-color: #fff;
  border: 1px solid;
  border-radius: 4px;
}
.resetpw
{
  position:relative;
  font-size: 12px;
  top: 20px;
}
  </style>
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
    <div>
    <h1 style="font-size:300%;font-family:courier;background-color:lightblue;">Login</h1><br>
    <form id="register" name="register" method="POST" enctype="multipart/form-data">

      <div class=form-group>
      <label for="emailUser">E-mail<span style="color: #800080">(*)</span>:</label>
      <input style="width: 400px" type="text" id="emailUser" name="emailUser" placeholder="nombre222@ikasle.ehu.eus | nombre@ehu.es" value="<?php if ( isset($us_email) ) echo $us_email; ?>"><br>
      </div>

      <div class=form-group>
      <label for="passwordUser">Contraseña<span style="color: #800080">(*)</span>:</label>
      <input style="width: 300px" type="password" id="passwordUser" name="passwordUser"><br>
      <?php if(isset($error))
      {
          echo "<font color='red'>".$error."</font>";
      } ?>
      </div>
      <div>
      <input type="submit" value="Enviar" name="enviar" id="enviar">
    </div>
    <div class = "resetpw">
    <a href="ResetPass.php"> ¿Olvidaste la Contraseña? </a>
    </div>
      <?php
            if (isset($error) && $error == 'Estas Baneado.')
            echo '<br/><img src = ../images/banned.gif height = 220px width = 400px>';
       ?>
    </form>
      
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
