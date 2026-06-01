<?php

require_once("../config/config.php");
require_once("../functions.php");

if($_SESSION['tipologia'] != "cliente") {
    die("Accesso negato");
}

if(!isset($_SESSION['carrello'])) {
    $_SESSION['carrello'] = [];
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    
    if($quantity > 0) {
        if(isset($_SESSION['carrello'][$product_id])) {
            $_SESSION['carrello'][$product_id] += $quantity;
        } else {
            $_SESSION['carrello'][$product_id] = $quantity;
        }
    }
    header("Location: carrello.php");
    exit();
}

if(isset($_GET['remove'])) {
    $product_id = intval($_GET['remove']);
    unset($_SESSION['carrello'][$product_id]);
    header("Location: carrello.php");
    exit();
}

$total = 0;
$cart_items = [];
foreach($_SESSION['carrello'] as $product_id => $quantity) {
    $product = getProductById($product_id);
    if($product) {
        $cart_items[] = [
            'product' => $product,
            'quantity' => $quantity,
            'subtotal' => $product['prezzo'] * $quantity
        ];
        $total += $product['prezzo'] * $quantity;
    }
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Carrello</title>
    <style>
        body { font-family: Arial; background-color: #f2f2f2; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: auto; }
        .header { background-color: white; padding: 20px; border-radius: 5px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .menu a { padding: 10px 15px; margin: 0 5px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 3px; }
        .menu a.logout { background-color: #f44336; }
        .cart-content { background-color: white; padding: 20px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        .btn { padding: 8px 12px; background-color: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 3px; text-decoration: none; }
        .btn-danger { background-color: #f44336; }
        .btn:hover { opacity: 0.9; }
        .total { font-size: 20px; font-weight: bold; text-align: right; margin-top: 20px; }
        .checkout { text-align: right; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Carrello</h1>
        <div class="menu">
            <a href="catalogo.php">← Continua Shopping</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="../autenticazione/logout.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="cart-content">
        <?php if(count($cart_items) == 0) { ?>
        <p>Il carrello è vuoto. <a href="catalogo.php">Vai al catalogo</a></p>
        <?php } else { ?>
        <table>
            <tr>
                <th>Prodotto</th>
                <th>Prezzo</th>
                <th>Quantita</th>
                <th>Subtotale</th>
                <th>Azioni</th>
            </tr>
            <?php foreach($cart_items as $item) { ?>
            <tr>
                <td><?php echo htmlspecialchars($item['product']['nome']); ?></td>
                <td>€<?php echo number_format($item['product']['prezzo'], 2); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>€<?php echo number_format($item['subtotal'], 2); ?></td>
                <td>
                    <a href="?remove=<?php echo $item['product']['idProdotto']; ?>" class="btn btn-danger" onclick="return confirm('Rimuovere dal carrello?');">Rimuovi</a>
                </td>
            </tr>
            <?php } ?>
        </table>

        <div class="total">
            Totale: €<?php echo number_format($total, 2); ?>
        </div>

        <div class="checkout">
            <form method="POST" action="checkout.php" style="display:inline;">
                <input type="hidden" name="total" value="<?php echo $total; ?>">
                <button type="submit" class="btn" style="padding: 12px 20px; font-size: 16px;">Procedi al Pagamento</button>
            </form>
        </div>
        <?php } ?>
    </div>
</div>

</body>
</html>