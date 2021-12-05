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
    if ($next_question != null)
        $_SESSION['current_q'] = $next_question;
    $stmt_remaining_questions->bindParam(1, $next_question);
    $stmt_remaining_questions->setFetchMode(PDO::FETCH_ASSOC); 
    $stmt_remaining_questions->execute();
    while ($row = $stmt_remaining_questions->fetch())
    {
        $random = rand(1,4);
        if ($random == 1)
            echo json_encode(array("numero"=> $row['Numero'],"pregunta" => $row['Pregunta'], "resp2" => $row['IncAns1'], "resp3" => $row['IncAns2'], "resp4" => $row['IncAns3'], "resp1" => $row['CorrectAns'], "imagen" => $row['Imagen'], "likes" => $row['Likes'], "dislikes" => $row['Dislikes']));
        if ($random == 2)
            echo json_encode(array("numero"=> $row['Numero'],"pregunta" => $row['Pregunta'], "resp2" => $row['CorrectAns'], "resp3" => $row['IncAns1'], "resp4" => $row['IncAns2'], "resp1" => $row['IncAns3'], "imagen" => $row['Imagen'], "likes" => $row['Likes'], "dislikes" => $row['Dislikes']));
        if ($random == 3)
            echo json_encode(array("numero"=> $row['Numero'],"pregunta" => $row['Pregunta'], "resp2" => $row['IncAns3'], "resp3" => $row['CorrectAns'], "resp4" => $row['IncAns1'], "resp1" => $row['IncAns2'], "imagen" => $row['Imagen'], "likes" => $row['Likes'], "dislikes" => $row['Dislikes']));
        if ($random == 4)
            echo json_encode(array("numero"=> $row['Numero'],"pregunta" => $row['Pregunta'], "resp2" => $row['IncAns2'], "resp3" => $row['IncAns3'], "resp4" => $row['CorrectAns'], "resp1" => $row['IncAns1'], "imagen" => $row['Imagen'], "likes" => $row['Likes'], "dislikes" => $row['Dislikes']));
    }
?>