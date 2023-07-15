<?php

$sevidor="localhost";
$baseDeDatos="app";
$usuarios="root";
$contraseña="";
try{
    $conexion=new PDO("mysql:host=$sevidor;dbname=$baseDeDatos",$usuarios,$contraseña);
}catch(Exception $ex){
    echo $ex->getMessage();
}

?>