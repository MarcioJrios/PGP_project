<?php

$hostDB = "localhost";
$userDB = "adm_site_aposta";
$senhaDB = "12345679?";
$databaseDB = "id10903184_site_aposta";

// $hostDB = "localhost";
// $userDB = "id7255481_adminpetevida";
// $senhaDB = "12345679?";
// $databaseDB = "id7255481_petevida";

$conexao = mysqli_connect($hostDB, $userDB, $senhaDB, $databaseDB) or
    die("Houve um erro de conexão ao banco de dados.");
mysqli_query($conexao, "SET NAMES 'utf8'");
mysqli_query($conexao, 'SET character_set_connection=utf8');
mysqli_query($conexao, 'SET character_set_client=utf8');
mysqli_query($conexao, 'SET character_set_results=utf8');
?>
