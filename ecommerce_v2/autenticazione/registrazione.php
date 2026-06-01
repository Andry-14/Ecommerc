<?php
require_once __DIR__ . '/../config/config.php';

if (!isset($conn)) {
    die('Errore: connessione al database non disponibile.');
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../index.php");
    exit();
}

$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$cognome = isset($_POST['cognome']) ? trim($_POST['cognome']) : '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($nome) || empty($cognome) || empty($username) || empty($email) || empty($password)) {
    header("Location: ../index.php?errore=Compilare tutti i campi");
    exit();
}

try {
    $sql_check = "SELECT idUtente FROM utenti WHERE username = ? OR email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->execute([$username, $email]);
    
    if ($stmt_check->rowCount() > 0) {
        header("Location: ../index.php?errore=Username o email già utilizzati");
        exit();
    }
} catch (PDOException $e) {
    header("Location: ../index.php?errore=Errore database");
    exit();
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $sql = "INSERT INTO utenti (nome, cognome, username, email, password, tipologia) 
            VALUES (?, ?, ?, ?, ?, 'cliente')";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nome, $cognome, $username, $email, $password_hash]);
    
    header("Location: ../index.php?successo=Registrazione completata! Effettua il login");
    exit();
    
} catch (PDOException $e) {
    header("Location: ../index.php?errore=Errore nella registrazione");
    exit();
}
?>