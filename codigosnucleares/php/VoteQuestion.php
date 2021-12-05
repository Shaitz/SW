<?php
    session_start();
    include 'DbConfig.php';
    $voto = $_GET['ans'];
    if ($voto == "like")
    {
        try
        {
            $dsn = "mysql:host=$server;dbname=$basededatos";
            $link = new PDO($dsn, $user, $pass);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        $stmt_vote = $link->prepare("update Preguntas set Likes = Likes + 1 where Numero = ?");
        $stmt_vote->bindParam(1, $_SESSION['current_q']);
        $stmt_vote->setFetchMode(PDO::FETCH_ASSOC); 
        $stmt_vote->execute();

        $stmt_get_votes = $link->prepare("select Likes from Preguntas where Numero = ?");
        $stmt_get_votes->bindParam(1, $_SESSION['current_q']);
        $stmt_get_votes->setFetchMode(PDO::FETCH_ASSOC); 
        $stmt_get_votes->execute();
        if ($row = $stmt_get_votes->fetch())
        {
            echo json_encode(array("likes" => $row['Likes']));
        }
    }
    else if ($voto == "dislike")
    {
        try
        {
            $dsn = "mysql:host=$server;dbname=$basededatos";
            $link = new PDO($dsn, $user, $pass);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        $stmt_vote = $link->prepare("update Preguntas set Dislikes = Dislikes + 1 where Numero = ?");
        $stmt_vote->bindParam(1, $_SESSION['current_q']);
        $stmt_vote->setFetchMode(PDO::FETCH_ASSOC); 
        $stmt_vote->execute();

        $stmt_get_votes = $link->prepare("select Dislikes from Preguntas where Numero = ?");
        $stmt_get_votes->bindParam(1, $_SESSION['current_q']);
        $stmt_get_votes->setFetchMode(PDO::FETCH_ASSOC); 
        $stmt_get_votes->execute();
        if ($row = $stmt_get_votes->fetch())
        {
            echo json_encode(array("dislikes" => $row['Dislikes']));
        }
    }
?>