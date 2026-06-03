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

$sql = "SELECT * FROM Prodotti";
$stmt = $conn->prepare($sql);
$stmt->execute();
$prodotti = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Prodotti</h1>

<a href="aggiungi_prodotto.php">+ Aggiungi Prodotto</a>

<table border="1">
<tr>
    <th>Nome</th>
    <th>Prezzo</th>
    <th>Azioni</th>
</tr>

<?php foreach($prodotti as $p){ ?>
<tr>
    <td><?= $p['nome'] ?></td>
    <td><?= $p['prezzo'] ?></td>
    <td>
        <a href="modifica_prodotto.php?id=<?= $p['idProdotto'] ?>">Modifica</a>
        <a href="elimina_prodotto.php?id=<?= $p['idProdotto'] ?>">Elimina</a>
    </td>
</tr>
<?php } ?>

</table>