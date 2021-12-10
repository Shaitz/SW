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
$ch = curl_init();
$url = "http://localhost/SW/vips/vipusers/" . $_POST['vips'];
//$url = "https://sw.ikasten.io/~udelrio002/vips/vipusers/" . $_POST['vips'];
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
$output = curl_exec($ch);
$respuesta = json_decode($output, true);

if ($respuesta["VIP eliminado"] == "error")
    echo "<font color='red'>El usuario introducido no está en la lista VIP.</font>";
else
    echo '¡El usuario ' . '<strong>' . $respuesta["VIP eliminado"] . '</strong> ha sido eliminado de la lista VIP!<br/> <img src = ../images/eliminado.gif height = 220px width = 400px>';

curl_close($ch);
?>