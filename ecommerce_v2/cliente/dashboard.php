<?php

require_once("../config/config.php");
require_once("../functions.php");

if($_SESSION['tipologia'] != "cliente") {
    die("Accesso negato");
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Cliente</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            background-color: white;
            padding: 20px;
            margin-top: 20px;
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 10px;
        }
        .menu {
            display: flex;
            gap: 10px;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        .menu a {
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .menu a:hover {
            background-color: #45a049;
        }
        .menu a.logout {
            background-color: #f44336;
        }
        .menu a.logout:hover {
            background-color: #da190b;
        }
        .welcome {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Dashboard Cliente</h1>
    
    <div class="welcome">
        <h2>Benvenuto, <?php echo htmlspecialchars($_SESSION['utente']); ?></h2>
        <p>Sfoglia il nostro catalogo di prodotti e effettua i tuoi acquisti.</p>
    </div>

    <div class="menu">
        <a href="catalogo.php">📦 Catalogo Prodotti</a>
        <a href="carrello.php">🛒 Carrello</a>
        <a href="miei_ordini.php">📋 Miei Ordini</a>
        <a href="profilo.php">👤 Profilo</a>
        <a href="../autenticazione/logout.php" class="logout">🚪 Logout</a>
    </div>
</div>

</body>
</html>