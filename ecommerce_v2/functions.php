<?php

require_once("config/database.php");

// Check role
function checkRole($required_role) {
    if(!isset($_SESSION['tipologia']) || $_SESSION['tipologia'] != $required_role) {
        die("Accesso negato");
    }
}

// Get all products
function getAllProducts() {
    global $conn;
    try {
        $sql = "SELECT * FROM Prodotti";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        return [];
    }
}

// Get product by ID
function getProductById($id) {
    global $conn;
    try {
        $sql = "SELECT * FROM Prodotti WHERE idProdotto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        return null;
    }
}

// Add product (Admin)
function addProduct($nome, $descrizione, $prezzo, $quantita) {
    global $conn;
    try {
        $sql = "INSERT INTO Prodotti (nome, descrizione, prezzo, quantita) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$nome, $descrizione, $prezzo, $quantita]);
    } catch(Exception $e) {
        return false;
    }
}

// Update product (Admin)
function updateProduct($id, $nome, $descrizione, $prezzo, $quantita) {
    global $conn;
    try {
        $sql = "UPDATE Prodotti SET nome = ?, descrizione = ?, prezzo = ?, quantita = ? WHERE idProdotto = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$nome, $descrizione, $prezzo, $quantita, $id]);
    } catch(Exception $e) {
        return false;
    }
}

// Delete product (Admin)
function deleteProduct($id) {
    global $conn;
    try {
        $sql = "DELETE FROM Prodotti WHERE idProdotto = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$id]);
    } catch(Exception $e) {
        return false;
    }
}

// Get all customers
function getAllCustomers() {
    global $conn;
    try {
        $sql = "SELECT idUtente, nome, cognome, email, username FROM Utenti WHERE tipologia = 'cliente'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        return [];
    }
}

// Get all orders
function getAllOrders() {
    global $conn;
    try {
        $sql = "SELECT o.*, u.nome, u.cognome FROM Ordini o JOIN Utenti u ON o.idCliente = u.idUtente ORDER BY o.data_ordine DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        return [];
    }
}

// Get customer orders
function getCustomerOrders($customerId) {
    global $conn;
    try {
        $sql = "SELECT * FROM Ordini WHERE idCliente = ? ORDER BY data_ordine DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$customerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        return [];
    }
}

// Get order items
function getOrderItems($orderId) {
    global $conn;
    try {
        $sql = "SELECT c.*, p.nome FROM Contenuti c JOIN Prodotti p ON c.idProdotto = p.idProdotto WHERE c.idOrdine = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        return [];
    }
}

// Register supplier (Admin)
function registerSupplier($nome, $cognome, $email, $username, $azienda) {
    global $conn;
    try {
        $password = password_hash('temp_password', PASSWORD_DEFAULT);
        $sql = "INSERT INTO Utenti (nome, cognome, email, username, password, tipologia, azienda) VALUES (?, ?, ?, ?, ?, 'fornitore', ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$nome, $cognome, $email, $username, $password, $azienda]);
    } catch(Exception $e) {
        return false;
    }
}

// Get all suppliers
function getAllSuppliers() {
    global $conn;
    try {
        $sql = "SELECT * FROM Utenti WHERE tipologia = 'fornitore'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        return [];
    }
}

// Add supplier product
function addSupplierProduct($supplierId, $productId) {
    global $conn;
    try {
        $sql = "INSERT INTO Forniture (idFornitore, idProdotto) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$supplierId, $productId]);
    } catch(Exception $e) {
        return false;
    }
}

// Get supplier products
function getSupplierProducts($supplierId) {
    global $conn;
    try {
        $sql = "SELECT p.* FROM Prodotti p JOIN Forniture f ON p.idProdotto = f.idProdotto WHERE f.idFornitore = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$supplierId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        return [];
    }
}

// Remove supplier product
function removeSupplierProduct($supplierId, $productId) {
    global $conn;
    try {
        $sql = "DELETE FROM Forniture WHERE idFornitore = ? AND idProdotto = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$supplierId, $productId]);
    } catch(Exception $e) {
        return false;
    }
}

// Create order
function createOrder($customerId, $totalPrice) {
    global $conn;
    try {
        $sql = "INSERT INTO Ordini (idCliente, prezzo_totale, data_ordine, stato) VALUES (?, ?, NOW(), 'pendente')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$customerId, $totalPrice]);
        return $conn->lastInsertId();
    } catch(Exception $e) {
        return false;
    }
}

// Add order item
function addOrderItem($orderId, $productId, $quantity, $price) {
    global $conn;
    try {
        $sql = "INSERT INTO Contenuti (idOrdine, idProdotto, quantita, prezzo) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$orderId, $productId, $quantity, $price]);
    } catch(Exception $e) {
        return false;
    }
}

// Update product quantity
function updateProductQuantity($productId, $quantity) {
    global $conn;
    try {
        $sql = "UPDATE Prodotti SET quantita = quantita - ? WHERE idProdotto = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$quantity, $productId]);
    } catch(Exception $e) {
        return false;
    }
}

?>