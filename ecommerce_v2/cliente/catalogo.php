<?php

require_once("../config/config.php");
require_once("../functions.php");

if($_SESSION['tipologia'] != "cliente") {
    die("Accesso negato");
}

$products = getAllProducts();

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Catalogo Prodotti</title>
    <style>
        body { font-family: Arial; background-color: #f2f2f2; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: auto; }
        .header { background-color: white; padding: 20px; border-radius: 5px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .menu a { padding: 10px 15px; margin: 0 5px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 3px; }
        .menu a.logout { background-color: #f44336; }
        .products { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .product { background-color: white; padding: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .product h3 { margin-top: 0; color: #333; }
        .product p { color: #666; font-size: 14px; }
        .product .price { font-size: 20px; color: #4CAF50; font-weight: bold; margin: 10px 0; }
        .product .stock { font-size: 14px; color: #999; }
        .btn { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 3px; text-decoration: none; }
        .btn:hover { background-color: #45a049; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Catalogo Prodotti</h1>
        <div class="menu">
            <a href="dashboard.php">Dashboard</a>
            <a href="carrello.php">🛒 Carrello</a>
            <a href="miei_ordini.php">📋 Miei Ordini</a>
            <a href="../autenticazione/logout.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="products">
        <?php foreach($products as $product) { ?>
        <div class="product">
            <h3><?php echo htmlspecialchars($product['nome']); ?></h3>
            <p><?php echo htmlspecialchars(substr($product['descrizione'], 0, 100)) . '...'; ?></p>
            <p class="stock">Disponibili: <?php echo $product['quantita']; ?></p>
            <div class="price">€<?php echo number_format($product['prezzo'], 2); ?></div>
            <?php if($product['quantita'] > 0) { ?>
            <form method="POST" action="carrello.php" style="display:inline;">
                <input type="hidden" name="product_id" value="<?php echo $product['idProdotto']; ?>">
                <input type="hidden" name="action" value="add">
                <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['quantita']; ?>" style="width: 50px; padding: 5px;">
                <button type="submit" class="btn">Aggiungi al Carrello</button>
            </form>
            <?php } else { ?>
            <button class="btn" disabled>Non Disponibile</button>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</div>

</body>
</html>