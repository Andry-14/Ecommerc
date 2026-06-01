<?php

require_once("../config/config.php");

// Check if config.php defines $conn, otherwise create connection
if(!isset($conn)) {
    $conn = new PDO("mysql:host=localhost;dbname=ecommerce_v2", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM Utenti WHERE username = ?";

$stmt = $conn->prepare($sql);

$stmt->execute([$username]);

$utente = $stmt->fetch(PDO::FETCH_ASSOC);

if($utente && password_verify($password, $utente['password'])){

    // CREAZIONE SESSIONI
    $_SESSION['utente'] = $utente['username'];

    $_SESSION['idUtente'] = $utente['idUtente'];

    $_SESSION['tipologia'] = $utente['tipologia'];

    // COOKIE
    setcookie(
        "username",
        $utente['username'],
        time() + 3600
    );

    // REDIRECT IN BASE AL RUOLO
    if($utente['tipologia'] == "admin"){

        header("Location: ../admin/dashboard.php");

    }elseif($utente['tipologia'] == "fornitore"){

        header("Location: ../fornitore/dashboard.php");

    }else{

        header("Location: ../cliente/dashboard.php");

    }

    exit();

}else{

    echo "Username o password errati";

}
?>