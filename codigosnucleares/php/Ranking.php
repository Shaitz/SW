<?php

$curl = curl_init();
//$url = "http://localhost/SW/codigosnucleares/php/vipusers/ranking";
$url = "https://sw.ikasten.io/~udelrio002/vips/vipusers/";
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$str = curl_exec($curl);
echo '<table border=1 style="border:3px solid black;margin-left:auto;margin-right:auto;"><tr><th>Email</th><th>Puntos</th></tr><tr><td>' . $str . '</td><td>' . $str . '</td></tr></table>';

?>