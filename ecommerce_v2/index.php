<?php
require_once("config/config.php");
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>E-Commerce</title>

    <style>
        body{
            font-family: Arial;
            background-color: #f2f2f2;
            text-align: center;
        }

        .container{
            width: 400px;
            margin: auto;
            background-color: white;
            padding: 20px;
            margin-top: 50px;
            border-radius: 10px;
        }

        input{
            width: 90%;
            padding: 10px;
            margin: 5px;
        }

        button{
            padding: 10px 20px;
            margin-top: 10px;
        }
    </style>

</head>
<body>

    <div class="container">

    <?php

    if(isset($_SESSION['utente'])){

        echo "<h1>Benvenuto " . $_SESSION['utente'] . "</h1>";

        echo "<p>Ruolo: " . $_SESSION['tipologia'] . "</p>";

    if(isset($_COOKIE['username'])){

        echo "<p>Bentornato " . $_COOKIE['username'] . "</p>";

    }

    echo "<a href='auth/logout.php'>Logout</a>";

    }else{

    if(isset($_GET['errore'])){
        echo "<p style='color:red;'>Login errato</p>";
    }

    if(isset($_GET['successo'])){
        echo "<p style='color:green;'>Registrazione completata</p>";
    }

?>

    <h1>Login</h1>

    <form action="/ecommerce_v2/autenticazione/login.php" method="POST">

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>

    </form>

    <hr>

    <h1>Registrazione</h1>

    <form action="/ecommerce_v2/autenticazione/registrazione.php" method="POST">

        <input type="text" name="nome" placeholder="Nome" required>

        <input type="text" name="cognome" placeholder="Cognome" required>

        <input type="text" name="username" placeholder="Username" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        

        <button type="submit">Registrati</button>

    </form>

<?php
}
?>

</div>

</body>
</html>