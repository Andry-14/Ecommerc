<?php
require_once("../config/config.php");

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../index.php");
    exit();
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($username) || empty($password)) {
    header("Location: ../index.php?errore=Inserire username e password");
    exit();
}

try {
    $sql = "SELECT * FROM utenti WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $utente = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($utente && password_verify($password, $utente['password'])) {
        
        $_SESSION['utente'] = $utente['username'];
        $_SESSION['idUtente'] = $utente['idUtente'];
        $_SESSION['tipologia'] = $utente['tipologia'];
        $_SESSION['nome'] = $utente['nome'];
        $_SESSION['email'] = $utente['email'];
        
        setcookie(
            "username",
            $utente['username'],
            time() + (86400 * 30),
            "/"
        );
        
        if ($utente['tipologia'] == "admin") {
            header("Location: ../admin/dashboard.php");
        } elseif ($utente['tipologia'] == "fornitore") {
            header("Location: ../fornitore/dashboard.php");
        } else {
            header("Location: ../cliente/dashboard.php");
        }
        exit();
        
    } else {
        header("Location: ../index.php?errore=Username o password errati");
        exit();
    }
    
} catch (PDOException $e) {
    header("Location: ../index.php?errore=Errore: " . urlencode($e->getMessage()));
    exit();
}
?>