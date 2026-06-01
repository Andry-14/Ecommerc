<?php

require_once("../config/config.php");
require_once("../functions.php");

checkRole("admin");

$action = isset($_GET['action']) ? $_GET['action'] : '';
$products = getAllProducts();

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione Prodotti - Admin</title>
    <style>
        body { font-family: Arial; background-color: #f2f2f2; }
        .container { max-width: 1200px; margin: auto; background-color: white; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        .btn { padding: 8px 12px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .btn-danger { background-color: #f44336; }
        .btn-edit { background-color: #2196F3; }
        form { background-color: #f9f9f9; padding: 15px; margin: 20px 0; border-radius: 5px; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; }
        a { margin: 10px 5px 10px 0; display: inline-block; padding: 10px 15px; background-color: #2196F3; color: white; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h1>Gestione Prodotti</h1>
    <a href="dashboard.php">← Torna al Dashboard</a>
    <a href="../autenticazione/logout.php" style="background-color: #f44336;">Logout</a>

    <?php
    if(isset($_GET['msg'])) {
        echo "<p style='color:green;'>" . htmlspecialchars($_GET['msg']) . "</p>";
    }
    ?>

    <h2>Aggiungi Nuovo Prodotto</h2>
    <form method="POST">
        <input type="hidden" name="action" value="add">
        <input type="text" name="nome" placeholder="Nome Prodotto" required>
        <textarea name="descrizione" placeholder="Descrizione" required></textarea>
        <input type="number" name="prezzo" placeholder="Prezzo" step="0.01" required>
        <input type="number" name="quantita" placeholder="Quantita" required>
        <button type="submit" class="btn">Aggiungi</button>
    </form>

    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if($_POST['action'] == 'add') {
            $result = addProduct($_POST['nome'], $_POST['descrizione'], $_POST['prezzo'], $_POST['quantita']);
            if($result) {
                header("Location: prodotti.php?msg=Prodotto aggiunto con successo");
                exit();
            } else {
                echo "<p style='color:red;'>Errore nell'aggiunta del prodotto</p>";
            }
        } elseif($_POST['action'] == 'edit') {
            $result = updateProduct($_POST['id'], $_POST['nome'], $_POST['descrizione'], $_POST['prezzo'], $_POST['quantita']);
            if($result) {
                header("Location: prodotti.php?msg=Prodotto modificato con successo");
                exit();
            } else {
                echo "<p style='color:red;'>Errore nella modifica del prodotto</p>";
            }
        }
    }
    ?>

    <h2>Elenco Prodotti</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrizione</th>
            <th>Prezzo</th>
            <th>Quantita</th>
            <th>Azioni</th>
        </tr>
        <?php foreach($products as $product) { ?>
        <tr>
            <td><?php echo $product['idProdotto']; ?></td>
            <td><?php echo htmlspecialchars($product['nome']); ?></td>
            <td><?php echo htmlspecialchars($product['descrizione']); ?></td>
            <td>€<?php echo number_format($product['prezzo'], 2); ?></td>
            <td><?php echo $product['quantita']; ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?php echo $product['idProdotto']; ?>">
                    <input type="text" name="nome" value="<?php echo htmlspecialchars($product['nome']); ?>" style="width:100px;">
                    <input type="number" name="prezzo" value="<?php echo $product['prezzo']; ?>" step="0.01" style="width:80px;">
                    <input type="number" name="quantita" value="<?php echo $product['quantita']; ?>" style="width:80px;">
                    <input type="hidden" name="descrizione" value="<?php echo htmlspecialchars($product['descrizione']); ?>">
                    <button type="submit" class="btn btn-edit">Modifica</button>
                </form>
                <a href="?action=delete&id=<?php echo $product['idProdotto']; ?>" class="btn btn-danger" onclick="return confirm('Confermi la cancellazione?');">Elimina</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <?php
    if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        if(deleteProduct($_GET['id'])) {
            header("Location: prodotti.php?msg=Prodotto eliminato con successo");
            exit();
        }
    }
    ?>

</div>

</body>
</html>