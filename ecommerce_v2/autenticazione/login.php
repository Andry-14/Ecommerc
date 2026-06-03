<?php

session_start();

$configFile = __DIR__ . "/../config/config.php";
require_once($configFile);

if (!isset($conn)) {
    if (defined('DB_DSN') && defined('DB_USER') && defined('DB_PASS')) {
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } elseif (defined('DB_HOST') && defined('DB_NAME') && defined('DB_USER') && defined('DB_PASS')) {
        $conn = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    } else {
        die("Database connection not configured.");
    }
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM Utenti WHERE username = ?";

$stmt = $conn->prepare($sql);

$stmt->execute([$username]);

$utente = $stmt->fetch(PDO::FETCH_ASSOC);

if($utente && password_verify($password, $utente['password'])){

    // SESSIONI
    $_SESSION['utente'] = $utente['username'];

    $_SESSION['idUtente'] = $utente['idUtente'];

    $_SESSION['tipologia'] = $utente['tipologia'];

    // COOKIE
    setcookie(
        "username",
        $utente['username'],
        time() + 3600
    );

    // REDIRECT
    if($utente['tipologia'] == "admin"){

        header("Location: /ecommerce_v2/admin/dashboard.php");

    }elseif($utente['tipologia'] == "fornitore"){

        header("Location: /ecommerce_v2/fornitore/dashboard.php");

    }else{

        header("Location: /ecommerce_v2/cliente/dashboard.php");

    }

    exit();

}else{

    header("Location: /ecommerce_v2/index.php?errore=1");

    exit();

}

?>