<?php
    session_start();
    include 'DbConfig.php';

    try
    {
        $dsn = "mysql:host=$server;dbname=$basededatos";
        $link = new PDO($dsn, $user, $pass);
    }catch(PDOException $e){
        echo $e->getMessage();
    }
    $stmt_remaining_questions = $link->prepare("select * from Preguntas where Numero = ?");
    $next_question = array_shift($_SESSION['preguntas_restantes']); // eliminar la primera pregunta y mostrarlo.
    $stmt_remaining_questions->bindParam(1, $next_question);
    $stmt_remaining_questions->setFetchMode(PDO::FETCH_ASSOC); 
    $stmt_remaining_questions->execute();
    while ($row = $stmt_remaining_questions->fetch())
    {
        echo json_encode(array("numero"=> $row['Numero'],"pregunta" => $row['Pregunta'], "resp2" => $row['IncAns1'], "resp3" => $row['IncAns2'], "resp4" => $row['IncAns3'], "resp1" => $row['CorrectAns'], "imagen" => $row['Imagen']));
    }
?>