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

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM Prodotti WHERE idProdotto = ?");
$stmt->execute([$id]);
$prodotto = $stmt->fetch();

if($_POST){

    $sql = "UPDATE Prodotti SET nome=?, prezzo=?, descrizione=? WHERE idProdotto=?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $_POST['nome'],
        $_POST['prezzo'],
        $_POST['descrizione'],
        $id
    ]);

    header("Location: prodotti.php");
    exit();
}
?>

<h1>Modifica Prodotto</h1>

<form method="POST">
    <input name="nome" value="<?= $prodotto['nome'] ?>"><br>
    <input name="prezzo" value="<?= $prodotto['prezzo'] ?>"><br>
    <textarea name="descrizione"><?= $prodotto['descrizione'] ?></textarea><br>
    <button>Salva</button>
</form>