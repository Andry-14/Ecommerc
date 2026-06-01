<?php

require_once("../config/config.php");
require_once("../functions.php");

if($_SESSION['tipologia'] != "fornitore") {
    die("Accesso negato");
}

$products = getSupplierProducts($_SESSION['idUtente']);

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Prodotti Forniti</title>
    <style>
        body { font-family: Arial; background-color: #f2f2f2; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: auto; }
        .header { background-color: white; padding: 20px; border-radius: 5px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .menu a { padding: 10px 15px; margin: 0 5px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 3px; }
        .menu a.logout { background-color: #f44336; }
        .content { background-color: white; padding: 20px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Prodotti Forniti</h1>
        <div class="menu">
            <a href="dashboard.php">Dashboard</a>
            <a href="../autenticazione/logout.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="content">
        <?php if(count($products) == 0) { ?>
        <p>Non hai ancora prodotti assegnati. Contatta l'amministratore.</p>
        <?php } else { ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrizione</th>
                <th>Prezzo</th>
                <th>Quantita Disponibile</th>
            </tr>
            <?php foreach($products as $product) { ?>
            <tr>
                <td><?php echo $product['idProdotto']; ?></td>
                <td><?php echo htmlspecialchars($product['nome']); ?></td>
                <td><?php echo htmlspecialchars(substr($product['descrizione'], 0, 50)) . '...'; ?></td>
                <td>€<?php echo number_format($product['prezzo'], 2); ?></td>
                <td><?php echo $product['quantita']; ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php } ?>
    </div>
</div>

</body>
</html>