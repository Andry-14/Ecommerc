<?php

require_once("../config/config.php");

if($_SESSION['tipologia'] != "cliente"){
    die("Accesso negato");
}

echo "<h1>Area Cliente</h1>";

?>