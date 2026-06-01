<?php

require_once("../config/config.php");
require_once("../functions.php");

checkRole("admin");

$suppliers = getAllSuppliers();
$products = getAllProducts();
$selected_supplier = null;
$supplier_products = [];

if(isset($_GET['supplier']) && is_numeric($_GET['supplier'])) {
    $selected_supplier = $_GET['supplier'];
    $supplier_products = getSupplierProducts($selected_supplier);
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione Forniture - Admin</title>
    <style>
        body { font-family: Arial; background-color: #f2f2f2; }
        .container { max-width: 1200px; margin: auto; background-color: white; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        .btn { padding: 8px 12px; background-color: #2196F3; color: white; border: none; cursor: pointer; }
        .btn-danger { background-color: #f44336; }
        form { background-color: #f9f9f9; padding: 15px; margin: 20px 0; border-radius: 5px; }
        select, input { padding: 8px; margin: 5px 0; }
        a { margin: 10px 5px 10px 0; display: inline-block; padding: 10px 15px; background-color: #2196F3; color: white; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h1>Gestione Forniture</h1>
    <a href="dashboard.php">← Torna al Dashboard</a>
    <a href="../autenticazione/logout.php" style="background-color: #f44336;">Logout</a>

    <h2>Registra Fornitore</h2>
    <form method="POST">
        <input type="hidden" name="action" value="register">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="cognome" placeholder="Cognome" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="text" name="azienda" placeholder="Nome Azienda" required>
        <button type="submit" class="btn">Registra Fornitore</button>
    </form>

    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'register') {
        $result = registerSupplier($_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['username'], $_POST['azienda']);
        if($result) {
            echo "<p style='color:green;'>Fornitore registrato con successo. Password temporanea: temp_password</p>";
        } else {
            echo "<p style='color:red;'>Errore nella registrazione del fornitore</p>";
        }
    }
    ?>

    <h2>Assegna Prodotti ai Fornitori</h2>
    <form method="POST">
        <input type="hidden" name="action" value="assign">
        <select name="supplier_id" required onchange="this.form.submit()">
            <option value="">Seleziona Fornitore</option>
            <?php foreach($suppliers as $supplier) { ?>
            <option value="<?php echo $supplier['idUtente']; ?>" <?php echo (isset($_GET['supplier']) && $_GET['supplier'] == $supplier['idUtente']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($supplier['nome'] . ' - ' . $supplier['azienda']); ?>
            </option>
            <?php } ?>
        </select>
    </form>

    <?php if($selected_supplier) { ?>
    <h3>Aggiungi Prodotto al Fornitore</h3>
    <form method="POST">
        <input type="hidden" name="action" value="add_product">
        <input type="hidden" name="supplier_id" value="<?php echo $selected_supplier; ?>">
        <select name="product_id" required>
            <option value="">Seleziona Prodotto</option>
            <?php foreach($products as $product) { ?>
            <option value="<?php echo $product['idProdotto']; ?>">
                <?php echo htmlspecialchars($product['nome']); ?>
            </option>
            <?php } ?>
        </select>
        <button type="submit" class="btn">Aggiungi Prodotto</button>
    </form>

    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'add_product') {
        $result = addSupplierProduct($_POST['supplier_id'], $_POST['product_id']);
        if($result) {
            header("Location: forniture.php?supplier=" . $_POST['supplier_id']);
            exit();
        } else {
            echo "<p style='color:red;'>Errore: prodotto già assegnato a questo fornitore</p>";
        }
    }
    ?>

    <h3>Prodotti Forniti</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrizione</th>
            <th>Prezzo</th>
            <th>Quantita</th>
            <th>Azioni</th>
        </tr>
        <?php foreach($supplier_products as $product) { ?>
        <tr>
            <td><?php echo $product['idProdotto']; ?></td>
            <td><?php echo htmlspecialchars($product['nome']); ?></td>
            <td><?php echo htmlspecialchars($product['descrizione']); ?></td>
            <td>€<?php echo number_format($product['prezzo'], 2); ?></td>
            <td><?php echo $product['quantita']; ?></td>
            <td>
                <a href="?action=remove&supplier=<?php echo $selected_supplier; ?>&product=<?php echo $product['idProdotto']; ?>" class="btn btn-danger" onclick="return confirm('Confermi la rimozione?');">Rimuovi</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <?php } ?>

    <?php
    if(isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['supplier']) && isset($_GET['product'])) {
        if(removeSupplierProduct($_GET['supplier'], $_GET['product'])) {
            header("Location: forniture.php?supplier=" . $_GET['supplier']);
            exit();
        }
    }
    ?>

</div>

</body>
</html>