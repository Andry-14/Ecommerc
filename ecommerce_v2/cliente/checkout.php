<?php

require_once("../config/config.php");
require_once("../functions.php");

if($_SESSION['tipologia'] != "cliente") {
    die("Accesso negato");
}

if(!isset($_SESSION['carrello']) || count($_SESSION['carrello']) == 0) {
    header("Location: carrello.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_SESSION['idUtente'];
    $total_price = floatval($_POST['total']);
    
    // Create order
    $order_id = createOrder($customer_id, $total_price);
    
    if($order_id) {
        // Add items to order and update quantities
        foreach($_SESSION['carrello'] as $product_id => $quantity) {
            $product = getProductById($product_id);
            if($product) {
                addOrderItem($order_id, $product_id, $quantity, $product['prezzo']);
                updateProductQuantity($product_id, $quantity);
            }
        }
        
        // Clear cart
        $_SESSION['carrello'] = [];
        
        header("Location: miei_ordini.php?success=1");
        exit();
    } else {
        $error = "Errore nella creazione dell'ordine";
    }
}

$cart_items = [];
$total = 0;
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
    <title>Checkout</title>
    <style>
        body { font-family: Arial; background-color: #f2f2f2; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; background-color: white; padding: 30px; border-radius: 5px; }
        h1 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        .total { font-size: 20px; font-weight: bold; text-align: right; margin: 20px 0; }
        form { margin-top: 30px; }
        label { display: block; margin: 10px 0 5px 0; font-weight: bold; }
        input { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px; box-sizing: border-box; }
        .btn { padding: 12px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 3px; font-size: 16px; }
        .btn:hover { background-color: #45a049; }
        .btn-back { background-color: #2196F3; }
        .btn-back:hover { background-color: #0b7dda; }
        a { text-decoration: none; display: inline-block; margin-right: 10px; }
    </style>
</head>
<body>

<div class="container">
    <h1>Checkout</h1>

    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

    <h2>Riepilogo Ordine</h2>
    <table>
        <tr>
            <th>Prodotto</th>
            <th>Prezzo</th>
            <th>Quantita</th>
            <th>Subtotale</th>
        </tr>
        <?php foreach($cart_items as $item) { ?>
        <tr>
            <td><?php echo htmlspecialchars($item['product']['nome']); ?></td>
            <td>€<?php echo number_format($item['product']['prezzo'], 2); ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td>€<?php echo number_format($item['subtotal'], 2); ?></td>
        </tr>
        <?php } ?>
    </table>

    <div class="total">Totale: €<?php echo number_format($total, 2); ?></div>

    <form method="POST">
        <h2>Informazioni di Pagamento</h2>
        <label for="card_number">Numero Carta (TEST):</label>
        <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required>
        
        <label for="card_holder">Intestatario Carta:</label>
        <input type="text" id="card_holder" name="card_holder" placeholder="Nome Cognome" required>
        
        <label for="expiry">Data Scadenza (MM/YY):</label>
        <input type="text" id="expiry" name="expiry" placeholder="12/25" required>
        
        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" placeholder="123" required>

        <input type="hidden" name="total" value="<?php echo $total; ?>">
        
        <button type="submit" class="btn">Conferma Ordine</button>
        <a href="carrello.php" class="btn btn-back">Torna al Carrello</a>
    </form>
</div>

</body>
</html>