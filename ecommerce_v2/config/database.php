<?php

$db_host = "127.0.0.1";
$db_port = "3306";
$dbname = "ecommerce_v2";
$user = "root";
$password = "";

try{

    $conn = new PDO(
        "mysql:host=$db_host;port=$db_port;dbname=$dbname",
        $user,
        $password
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){

    die("Errore connessione: " . $e->getMessage());

}

?>