<?php
    session_start();
    if (!isset($_SESSION['user']))
    {
        header("Location: Layout.php");
        exit();
    }
    if (isset($_SESSION['rol']))
    {
        if ($_SESSION['rol'] != "Profesor")
        {
            header("Location: Layout.php");
            exit();
        }
    };
    if (isset($_POST['vips']))
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/SW/vips/vipusers/");
        //curl_setopt($ch, CURLOPT_URL, "https://sw.ikasten.io/~udelrio002/vips/vipusers/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        $data = array('email' => $_POST['vips']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        $respuesta = json_decode($output, true);

        if ($respuesta["Creado VIP"] == "error")
            echo "<font color='red'>El usuario introducido ya es VIP.</font>";
        else if ($respuesta["Creado VIP"] == "errorMatricula")
            echo "<font color='red'>El usuario no está matriculado.</font>";
        else
            echo '¡El usuario ' . '<strong>' . $respuesta["Creado VIP"] . '</strong> ha sido añadido como VIP!<br/> <img src = ../images/añadido.gif height = 220px width = 400px>';

        curl_close($ch);
    }
?>