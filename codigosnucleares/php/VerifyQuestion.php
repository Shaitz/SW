<?php
    include 'DbConfig.php';
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
    $stmt_comprobar = $link->prepare("select CorrectAns from Preguntas where Numero = ?");
    $stmt_comprobar->bindParam(1, $idPregunta);
    $stmt_comprobar->setFetchMode(PDO::FETCH_ASSOC); 
    $stmt_comprobar->execute();
    while ($row = $stmt_comprobar->fetch())
    {
        if ($row['CorrectAns'] == $pregunta)
            echo json_encode(array("respuesta" => '1'));
        else
            echo json_encode(array("respuesta" => '0'));
    }
?>