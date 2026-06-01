<?php

require_once("../config/config.php");
require_once("../functions.php");

checkRole("admin");

$orders = getAllOrders();
$selected_order = null;
$order_items = [];

if(isset($_GET['view']) && is_numeric($_GET['view'])) {
    $selected_order = $_GET['view'];
    $order_items = getOrderItems($selected_order);
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione Ordini - Admin</title>
    <style>
        body { font-family: Arial; background-color: #f2f2f2; }
        .container { max-width: 1200px; margin: auto; background-color: white; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        .btn { padding: 8px 12px; background-color: #2196F3; color: white; border: none; cursor: pointer; text-decoration: none; }
        a { margin: 10px 5px 10px 0; display: inline-block; padding: 10px 15px; background-color: #2196F3; color: white; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h1>Gestione Ordini</h1>
    <a href="dashboard.php">← Torna al Dashboard</a>
    <a href="../autenticazione/logout.php" style="background-color: #f44336;">Logout</a>

    <h2>Elenco Ordini</h2>
    <table>
        <tr>
            <th>ID Ordine</th>
            <th>Cliente</th>
            <th>Prezzo Totale</th>
            <th>Data Ordine</th>
            <th>Stato</th>
            <th>Azioni</th>
        </tr>
        <?php foreach($orders as $order) { ?>
        <tr>
            <td><?php echo $order['idOrdine']; ?></td>
            <td><?php echo htmlspecialchars($order['nome'] . ' ' . $order['cognome']); ?></td>
            <td>€<?php echo number_format($order['prezzo_totale'], 2); ?></td>
            <td><?php echo htmlspecialchars($order['data_ordine']); ?></td>
            <td><?php echo htmlspecialchars($order['stato']); ?></td>
            <td>
                <a href="?view=<?php echo $order['idOrdine']; ?>" class="btn">Visualizza Dettagli</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <?php if($selected_order) { ?>
    <h2>Dettagli Ordine #<?php echo $selected_order; ?></h2>
    <table>
        <tr>
            <th>ID Prodotto</th>
            <th>Nome Prodotto</th>
            <th>Quantita</th>
            <th>Prezzo</th>
        </tr>
        <?php foreach($order_items as $item) { ?>
        <tr>
            <td><?php echo $item['idProdotto']; ?></td>
            <td><?php echo htmlspecialchars($item['nome']); ?></td>
            <td><?php echo $item['quantita']; ?></td>
            <td>€<?php echo number_format($item['prezzo'], 2); ?></td>
        </tr>
        <?php } ?>
    </table>
    <?php } ?>

</div>

</body>
</html>