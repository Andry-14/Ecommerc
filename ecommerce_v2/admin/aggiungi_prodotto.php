<?php
require_once("../config/config.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($conn)) {
    if (isset($pdo)) {
        $conn = $pdo;
    } elseif (isset($db)) {
        $conn = $db;
    } else {
        die("Database connection not available.");
    }
}

if (!isset($_SESSION['tipologia']) || $_SESSION['tipologia'] != "admin"){
    header("Location: ../index.php");
    exit();
}

if($_POST){

    $sql = "INSERT INTO Prodotti (nome, prezzo, descrizione, immagine)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $_POST['nome'],
        $_POST['prezzo'],
        $_POST['descrizione'],
        $_POST['immagine']
    ]);

    header("Location: prodotti.php");
    exit();
}
?>

<h1>Aggiungi Prodotto</h1>

<form method="POST">
    <input name="nome" placeholder="Nome"><br>
    <input name="prezzo" placeholder="Prezzo"><br>
    <textarea name="descrizione"></textarea><br>
    <input name="immagine" placeholder="Immagine URL"><br>
    <button>Aggiungi</button>
</form>