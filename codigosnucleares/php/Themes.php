<?php
    include 'DbConfig.php';
    try
    {
        $dsn = "mysql:host=$server;dbname=$basededatos";
        $link = new PDO($dsn, $user, $pass);
    }catch(PDOException $e){
        echo $e->getMessage();
    }
    $stmt_themes = $link->prepare("select distinct Tema from Preguntas");
    $stmt_themes->setFetchMode(PDO::FETCH_ASSOC); 
    $stmt_themes->execute();
    echo '<table border=1 style="border:3px solid black;margin-left:auto;margin-right:auto;"> <tr> <th> Tema </th> </tr>';
    while ($row = $stmt_themes->fetch())
    {
        echo '<tr><td>' . "<a href=AnswerQuestions.php?tema=" . $row['Tema'] . ">". $row['Tema'] . "</a>" . '</td></tr>';
    }
    echo '</table>';
    $link = null;
?>