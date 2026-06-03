<?php

require_once("../config/config.php");

if($_SESSION['tipologia'] != "fornitore"){
    die("Accesso negato");
}

echo "<h1>Area Fornitore</h1>";

?>