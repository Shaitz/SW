<?php
    include 'DbConfig.php';
    session_start();
    if (isset($_SESSION['preguntas_restantes']) && empty($_SESSION['preguntas_restantes']))
    {
        try
        {
            $dsn = "mysql:host=$server;dbname=$basededatos";
            $link = new PDO($dsn, $user, $pass);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        $stmt_puntuacion = $link->prepare("select PuntuacionMax from Usuarios where Email = ?");
        $stmt_puntuacion->bindParam(1, $_SESSION['user']);
        $stmt_puntuacion->setFetchMode(PDO::FETCH_ASSOC); 
        $stmt_puntuacion->execute();
        if ($row = $stmt_puntuacion->fetch())
        {
            $puntuacion = $row['PuntuacionMax'];
        }
        if ($puntuacion < $_SESSION['puntuacion'])
        {
            $stmt_puntuar = $link->prepare("update Usuarios set PuntuacionMax = ? where Email = ?");
            $stmt_puntuar->bindParam(1, $_SESSION['puntuacion']);
            $stmt_puntuar->bindParam(2, $_SESSION['user']);
            $stmt_puntuar->setFetchMode(PDO::FETCH_ASSOC); 
            $stmt_puntuar->execute();
        }
        echo json_encode(array("aciertos" => $_SESSION['aciertos'], "fallos" => $_SESSION['fallos'], "puntuacion" => $_SESSION['puntuacion']));
        unset($_SESSION['tema_preguntas']);
        unset($_SESSION['puntuacion']);
        unset($_SESSION['aciertos']);
        unset($_SESSION['fallos']);
    }
    else
    {
        echo 0;
    }
?>