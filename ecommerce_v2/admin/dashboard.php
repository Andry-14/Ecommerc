<?php
require_once("../config/config.php");

if($_SESSION['tipologia'] != "admin"){
    header("Location: ../index.php");
    exit();
}
?>

<h1>Dashboard Admin</h1>

<a href="prodotti.php">Gestione Prodotti</a><br>
<a href="forniture.php">Gestione Fornitori</a>