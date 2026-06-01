<?php

require_once("../config/config.php");
require_once("../functions.php");

checkRole("admin");

$customers = getAllCustomers();

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione Clienti - Admin</title>
    <style>
        body { font-family: Arial; background-color: #f2f2f2; }
        .container { max-width: 1200px; margin: auto; background-color: white; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        a { margin: 10px 5px 10px 0; display: inline-block; padding: 10px 15px; background-color: #2196F3; color: white; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h1>Gestione Clienti</h1>
    <a href="dashboard.php">← Torna al Dashboard</a>
    <a href="../autenticazione/logout.php" style="background-color: #f44336;">Logout</a>

    <h2>Elenco Clienti</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Email</th>
            <th>Username</th>
        </tr>
        <?php foreach($customers as $customer) { ?>
        <tr>
            <td><?php echo $customer['idUtente']; ?></td>
            <td><?php echo htmlspecialchars($customer['nome']); ?></td>
            <td><?php echo htmlspecialchars($customer['cognome']); ?></td>
            <td><?php echo htmlspecialchars($customer['email']); ?></td>
            <td><?php echo htmlspecialchars($customer['username']); ?></td>
        </tr>
        <?php } ?>
    </table>

</div>

</body>
</html>