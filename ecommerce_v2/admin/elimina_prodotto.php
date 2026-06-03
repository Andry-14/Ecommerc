<?php
require_once("../config/config.php");

if (!isset($conn)) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=ecommerce_v2;charset=utf8", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

if($_SESSION['tipologia'] != "admin"){
    header("Location: ../index.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM Prodotti WHERE idProdotto=?");
$stmt->execute([$id]);

header("Location: prodotti.php");
exit();
?>