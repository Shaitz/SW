<?php
$local=0; //0 para la nube
if ($local==1){
    $server="localhost";
    $user="root";
    $pass="";
    $basededatos="quiz";
}
else{
    $server="https://sw.ikasten.io/pmasw/";
    $user="G19";
    $pass="35VHZskBwNxae";
    $basededatos="db_G19";
}
?>
