<?php
    include 'DbConfig.php';
    session_start();
    if (!isset($_GET['id']) || !isset($_GET['pregunta']))
    {
        header("Location: Layout.php");
        exit();
    }
    $idPregunta = $_GET['id'];
    $pregunta = $_GET['pregunta'];
    try
    {
    $dsn = "mysql:host=$server;dbname=$basededatos";
    $link = new PDO($dsn, $user, $pass);
    }catch(PDOException $e){
        echo $e->getMessage();
    }
    $stmt_comprobar = $link->prepare("select CorrectAns, Dificultad from Preguntas where Numero = ?");
    $stmt_comprobar->bindParam(1, $idPregunta);
    $stmt_comprobar->setFetchMode(PDO::FETCH_ASSOC); 
    $stmt_comprobar->execute();

    if (!isset($_SESSION['puntuacion']))
    { 
        $_SESSION['puntuacion'] = 0;
        $_SESSION['aciertos'] = 0;
        $_SESSION['fallos'] = 0;
    }

    while ($row = $stmt_comprobar->fetch())
    {
        if ($row['CorrectAns'] == $pregunta)
        {
            $_SESSION['puntuacion'] += $row['Dificultad'];
            ++$_SESSION['aciertos'];
        }
        else
        {
            --$_SESSION['puntuacion'];
            ++$_SESSION['fallos'];
        }
            
        echo json_encode(array("respuestaC" => $row['CorrectAns'], "tuRespuesta" => $pregunta));
    }
?>