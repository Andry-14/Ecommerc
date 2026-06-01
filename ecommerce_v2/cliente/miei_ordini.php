<?php

require_once("../config/config.php");
require_once("../functions.php");

if($_SESSION['tipologia'] != "cliente") {
    die("Accesso negato");
}

$orders = getCustomerOrders($_SESSION['idUtente']);
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
    <title>Miei Ordini</title>
    <style>
        body { font-family: Arial; background-color: #f2f2f2; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: auto; }
        .header { background-color: white; padding: 20px; border-radius: 5px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .menu a { padding: 10px 15px; margin: 0 5px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 3px; }
        .menu a.logout { background-color: #f44336; }
        .content { background-color: white; padding: 20px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        .btn { padding: 8px 12px; background-color: #2196F3; color: white; border: none; cursor: pointer; border-radius: 3px; text-decoration: none; }
        .btn:hover { background-color: #0b7dda; }
        .success { background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Miei Ordini</h1>
        <div class="menu">
            <a href="dashboard.php">Dashboard</a>
            <a href="catalogo.php">📦 Catalogo</a>
            <a href="../autenticazione/logout.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="content">
        <?php if(isset($_GET['success'])) { ?>
        <div class="success">✓ Ordine effettuato con successo!</div>
        <?php } ?>

        <?php if(count($orders) == 0) { ?>
        <p>Non hai ancora effettuato ordini. <a href="catalogo.php">Vai al catalogo</a></p>
        <?php } else { ?>
        <table>
            <tr>
                <th>ID Ordine</th>
                <th>Data</th>
                <th>Totale</th>
                <th>Stato</th>
                <th>Azioni</th>
            </tr>
            <?php foreach($orders as $order) { ?>
            <tr>
                <td><?php echo $order['idOrdine']; ?></td>
                <td><?php echo htmlspecialchars($order['data_ordine']); ?></td>
                <td>€<?php echo number_format($order['prezzo_totale'], 2); ?></td>
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
                <th>Prodotto</th>
                <th>Quantita</th>
                <th>Prezzo Unitario</th>
                <th>Subtotale</th>
            </tr>
            <?php foreach($order_items as $item) { ?>
            <tr>
                <td><?php echo htmlspecialchars($item['nome']); ?></td>
                <td><?php echo $item['quantita']; ?></td>
                <td>€<?php echo number_format($item['prezzo'], 2); ?></td>
                <td>€<?php echo number_format($item['prezzo'] * $item['quantita'], 2); ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php } ?>
        <?php } ?>
    </div>
</div>

</body>
</html>