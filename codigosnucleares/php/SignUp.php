<?php include 'DbConfig.php' ?>
<?php
    require_once 'ClientVerifyEnrollment.php';
    session_start();
    if (isset($_SESSION['user']))
    {
      header("Location: Layout.php");
      die();
    }
    if (isset($_POST['enviar']))
    {
        $error_email="";
        $error_nom="";
        $error_pw="";
        $error = "";
        $us_tipo = trim($_POST['tipoUser']);
        $us_email = trim($_POST['emailUser']);
        $us_nombre = trim($_POST['nombreApellidos']);
        $us_pw = trim($_POST['passwordUser']);
        $us_pw2 = trim($_POST['passwordUser2']);
        $cont = 0;

        $regEmailStud = preg_match("/^([a-z]+[0-9]{3}@ikasle\.ehu\.(eus|es))$/", $us_email);
        $regEmailProf = preg_match("/^(([a-z]+|[a-z]+\.[a-z]+)@ehu\.(eus|es))$/", $us_email);
        $regNombre = preg_match("/^[A-Za-z]{2,}\s[A-Za-z]{2,}([A-Za-z]|\s)*$/", $us_nombre);

        /*  CONEXION PDO ver si usuario existe */
        try
        {
          $dsn = "mysql:host=$server;dbname=$basededatos";
          $link = new PDO($dsn, $user, $pass);
        }catch(PDOException $e){
          echo $e->getMessage();
        }
        $stmt_usuarios = $link->prepare('select * from Usuarios where Email = ?');
        $stmt_usuarios->bindParam(1, $us_email);
        $stmt_usuarios->setFetchMode(PDO::FETCH_ASSOC);
        $stmt_usuarios->execute();
        while($row = $stmt_usuarios->fetch())
        {
          ++$cont;
        }
        $link = null;

        //$matriculado = verificarMatricula($us_email);
        $matriculado = "SI"; /////////////////////////////////////////////////
        if ($us_tipo == "Estudiante" && !$regEmailStud || $us_tipo == "Profesor" && !$regEmailProf)
        {
            $error_email = "Email no válido.";
            $error_email = ""; /////////////////////////////////////////////////
        }

        if($cont > 0)
        {
            $error_email .= "El email está en uso.";
        }

        if ($matriculado == "NO")
        {
            $error_email .= "Este correo no esta matriculado.";
        }

        if (!$regNombre)
        {
            $error_nom = "Nombre no válido.";
        }

        if (strlen($us_pw) < 8 || $us_pw != $us_pw2)
        {
            $error_pw = "La contraseña debe tener al menos 8 caracteres y las contraseñas tienen que coincidir.";
        }

        if ($error_email == "" && $error_nom == "" && $error_pw == "" && $matriculado == "SI")
        {
            try
            {
              $dsn = "mysql:host=$server;dbname=$basededatos";
              $link = new PDO($dsn, $user, $pass);
            }catch(PDOException $e){
              echo $e->getMessage();
            }

            if (!strlen($_FILES["imagen"]["name"]) < 1) 
            {
                $target_dir = "../images/";
                $target_file = $target_dir . $_FILES["imagen"]["name"];
      
                if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) 
                {
                  exit(1);
                }
      
                $image = $_FILES["imagen"]["name"]; // para guardar en una variable el nombre de la imagen
              } 
              else 
              {
                $default_images = array("brainlet1.jpg", "brainlet2.jpg", "brainlet3.jpg", "brainlet4.jpg", "brainlet5.jpg", "brainlet6.jpg", "brainlet7.jpg", "brainlet8.jpg", "brainlet9.jpg", "brainlet10.jpg");
                $image = $default_images[rand(0,9)];
              }
              $encrypted_pw = md5($us_pw);
              $stmt_insertar_usuario = $link->prepare("INSERT INTO Usuarios(Tipo, Email, Nombre, Contraseña, Foto) VALUES (?,?,?,?,?)");
              $stmt_insertar_usuario->bindParam(1, $us_tipo);
              $stmt_insertar_usuario->bindParam(2, $us_email);
              $stmt_insertar_usuario->bindParam(3, $us_nombre);
              $stmt_insertar_usuario->bindParam(4, $encrypted_pw);
              $stmt_insertar_usuario->bindParam(5, $image);
              if (!$stmt_insertar_usuario->execute()) {
                die('Error en la query: ');
              }
              echo "Registrado correctamente.";
              $link = null;
              header("Location: LogIn.php");
        }
        echo($error);
    }
?>

<!DOCTYPE html>
<html>
<head>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script language=JavaScript src="../js/ValidateFieldsQuestionJQ.js"></script>
  <script language=JavaScript src="../js/ShowImageInForm.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
  input[type=text], input[type=password] 
  {
    font-size: 16px;
    font-size: max(16px, 1em);
    font-family: inherit;
    padding: 0.25em 0.5em;
    background-color: #fff;
    border: 1px solid;
    border-radius: 4px;
  }
  </style>
  <?php include '../html/Head.html'?>
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
    <div>
    <h1 style="font-size:300%;font-family:courier;background-color:lightblue;">Registrarse</h1><br>
      <form id="register" name="register" method="POST" enctype="multipart/form-data">

      <div class="form-check">
      Tipo de usuario<span style="color: #800080">(*)</span>:
      <input type="radio" id="estudiante" name="tipoUser" value="Estudiante" checked>
      <label for="estudiante">Estudiante</label>
      <input type="radio" id="profesor" name="tipoUser" value="Profesor">
      <label for="profesor">Profesor</label><br><br>
      </div>

      <div class=form-group>
      <label for="emailUser">E-mail<span style="color: #800080">(*)</span>:</label>
      <input style="width: 400px" type="text" id="emailUser" name="emailUser" placeholder="nombre222@ikasle.ehu.eus | nombre@ehu.es" value="<?php if ( isset($us_email) ) echo $us_email; ?>"><br>
      <?php if(isset($error_email))
      {
          echo "<font color='red'>".$error_email."</font>";
      } ?>
      </div>

      <div class=form-group>
      <label for="nombreApellidos">Nombre y Apellidos<span style="color: #800080">(*)</span>:</label>
      <input style="width: 300px" type="text" id="nombreApellidos" name="nombreApellidos" placeholder="Hugh Jass" value="<?php if ( isset($us_nombre) ) echo $us_nombre; ?>"><br>
      <?php if(isset($error_nom))
      {
          echo "<font color='red'>".$error_nom."</font>";
      } ?>
      </div>

      <div class=form-group>
      <label for="passwordUser">Contraseña<span style="color: #800080">(*)</span>:</label>
      <input style="width: 300px" type="password" id="passwordUser" name="passwordUser"><br>
      <?php if(isset($error_pw))
      {
          echo "<font color='red'>".$error_pw."</font>";
      } ?>
      </div>
      
      <div class=form-group>
      <label for="passwordUser2">Repetir contraseña<span style="color: #800080">(*)</span>:</label>
      <input style="width: 300px" type="password" id="passwordUser2" name="passwordUser2">
      </div>

      <label for="imagen">Imagen:</label>
      <input type="file" name="imagen" id="imagen" accept="image/*" onchange="readURL(event)">
      <button type="button" id="borrar" name="borrar" value="Borrar">Borrar</button><br>
      <div id="marco">

      </div>
      <br>
      <input type="submit" value="Enviar" name="enviar" id="enviar">
      </form>
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>