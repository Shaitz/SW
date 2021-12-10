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
        $curl = curl_init();
        //$url = "http://localhost/SW/vips/vipusers/" . $_POST['vips'];
        $url = "https://sw.ikasten.io/~udelrio002/vips/vipusers/" . $_POST['vips'];
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $str = curl_exec($curl);
        echo $str;
    }
?>