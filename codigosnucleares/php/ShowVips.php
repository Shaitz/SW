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
$curl = curl_init();
$url = "http://localhost/SW/vips/vipusers/";
//$url = "https://sw.ikasten.io/~udelrio002/vips/vipusers/";
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$str = curl_exec($curl);
echo '<table border=1 style="border:3px solid black;margin-left:auto;margin-right:auto;"><tr><th>VIPS</th></tr><tr><td>' . $str . '</td></tr></table>';
?>