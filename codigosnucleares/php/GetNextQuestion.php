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
        //echo json_encode(array("pregunta" => $row['Pregunta'], "inc1" => $row['IncAns1'], "inc2" => $row['IncAns2'], "inc3" => $row['IncAns3'], "correcta" => $row['CorrectAns'], "img" => $row['Imagen']));
        $pregunta = $row['Pregunta'];
        $inc1 = $row['IncAns1'];
        $inc2 = $row['IncAns2'];
        $inc3 = $row['IncAns3'];
        $correcta = $row['CorrectAns'];
        $img = $row['Imagen'];
        $numero = $row['Numero'];
        echo '<label id = "pregunta_id">'.$numero.'. </label>';
        echo '<label for='.$pregunta.'>'.$pregunta.'</label><br>';
        echo "<img src=../images/" .$img ." height=80px width=100px><br>";
        echo '<input type=radio id='.$correcta. ' name=respuesta value="'.$correcta.'">'.$correcta.'<br>';
        echo '<input type=radio id='.$inc1. ' name=respuesta value="'.$inc1.'">'.$inc1.'<br>';
        echo '<input type=radio id='.$inc2. ' name=respuesta value="'.$inc2.'">'.$inc2.'<br>';
        echo '<input type=radio id='.$inc3. ' name=respuesta value="'.$inc3.'">'.$inc3.'<br>';
    }
?>