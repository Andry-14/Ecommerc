<?php

require_once("../config/config.php");
require_once("../functions.php");

if($_SESSION['tipologia'] != "cliente") {
    die("Accesso negato");
}

$user = getUserInfo($_SESSION['idUtente']);
$message = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(updateCustomerInfo($_SESSION['idUtente'], $_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['telefono'])) {
        $message = "Profilo aggiornato con successo!";
        $user = getUserInfo($_SESSION['idUtente']);
    } else {
        $message = "Errore nell'aggiornamento del profilo";
    }
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Profilo Cliente</title>
    <style>
        body { font-family: Arial; background-color: #f2f2f2; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: auto; background-color: white; padding: 30px; border-radius: 5px; }
        h1 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
        .menu { margin-bottom: 20px; }
        .menu a { padding: 10px 15px; margin: 5px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 3px; }
        .menu a.logout { background-color: #f44336; }
        form { margin-top: 20px; }
        label { display: block; margin: 15px 0 5px 0; font-weight: bold; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 3px; box-sizing: border-box; }
        .btn { padding: 12px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 3px; font-size: 16px; margin-top: 20px; }
        .btn:hover { background-color: #45a049; }
        .message { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<div class="container">
    <h1>Profilo Cliente</h1>

    <div class="menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="../autenticazione/logout.php" class="logout">Logout</a>
    </div>

    <?php if($message) { ?>
    <div class="message <?php echo (strpos($message, 'successo') !== false) ? 'success' : 'error'; ?>">
        <?php echo $message; ?>
    </div>
    <?php } ?>

    <?php if($user) { ?>
    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>

        <label for="cognome">Cognome:</label>
        <input type="text" id="cognome" name="cognome" value="<?php echo htmlspecialchars($user['cognome']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>

        <label for="telefono">Telefono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($user['telefono'] ?? ''); ?>">

        <button type="submit" class="btn">Salva Modifiche</button>
    </form>
    <?php } ?>
</div>

</body>
</html>