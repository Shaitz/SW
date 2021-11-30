<?php
  session_start();
  include "DbConfig.php";
  if (isset($_SESSION['user']))
    header("Layout.php");
?>
<?php 
if (isset($_POST['resetear_pw'])) 
{
    $email = $_POST['email'];
    $count = 0;

    try
    {
        $dsn = "mysql:host=$server;dbname=$basededatos";
        $link = new PDO($dsn, $user, $pass);
    }catch(PDOException $e){
        echo $e->getMessage();
    }
    $stmt_usuarios = $link->prepare('select Email from Usuarios where Email = ?');
    $stmt_usuarios->bindParam(1, $email);
    $stmt_usuarios->setFetchMode(PDO::FETCH_ASSOC);
    $stmt_usuarios->execute();
    while($row = $stmt_usuarios->fetch())
    {
        ++$count;
    }
    $link = null;
  
    if($count > 0) 
    {
        /*  Generar random token    */
        $token = bin2hex(random_bytes(50));
    
        try
        {
            $dsn = "mysql:host=$server;dbname=$basededatos";
            $link = new PDO($dsn, $user, $pass);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        $stmt_insertar_token = $link->prepare("INSERT INTO password_reset(email, token) VALUES (?,?)");
        $stmt_insertar_token->bindParam(1, $email);
        $stmt_insertar_token->bindParam(2, $token);
        if (!$stmt_insertar_token->execute())
            die('Error en la query: ');
        $link = null;
        /*      Enviar email al usuario con token    */
        $to = $email;
        $subject = "Resetear la contraseña en sw.ikasten.io";
        //$msg = "Hola, haz click en este enlace \"https://sw.ikasten.io/~udelrio002/codigosnucleares/php/NewPassword.php?token=" . $token . "\" para resetear la contraseña en nuestra página.";
        $msg = "Hola, haz click en este enlace \"localhost/sw/codigosnucleares/php/NewPassword.php?token=" . $token . "\" para resetear la contraseña en nuestra página.";
        $msg = wordwrap($msg,70);
        $headers = "From: noreply@swikastenio.com";
        mail($to, $subject, $msg, $headers);
        header('location: SendLink.php?email=' . $email);
    }
    else
        $error = "Usuario no encontrado.";
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <?php include '../html/Head.html'?>
  <style>
      input[type="text"]
      {
          width: 260px;
      }
      .introducir
      {
        font-size: 16px;
        font-weight: bold;
      }
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
    <h1 style="font-size:300%;font-family:courier;background-color:lightblue;">Resetear Contraseña</h1><br>    
    </div>
    <div>
        <form method="post" action="ResetPass.php">
            <p class = "introducir">Introduce el Email a Recuperar</p>
            <input type="text" name="email">
            <input type="submit" name="resetear_pw" value = "Enviar">
            <div class = "respuesta">
            <?php if(isset($error))
                {
                    echo $error;
                } ?>
            </div>
        </form>
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>