<?php

require_once("../config/config.php");

if($_SESSION['tipologia'] != "admin"){
    die("Accesso negato");
}

echo "<h1>Area Admin</h1>";

?>