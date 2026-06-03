<?php

require_once _DIR_ . '/../config/config.php';

if (!isset($conn)) {
    die('Database connection not available.');
}

$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$username = $_POST['username'];
$email = $_POST['email'];

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$tipologia = "utente";

$sql = "INSERT INTO Utenti
(nome, cognome, username, password, tipologia, email)
VALUES
(?,?,?,?,?,?)";

$stmt = $conn->prepare($sql);

$stmt->execute([
    $nome,
    $cognome,
    $username,
    $password,
    $tipologia,
    $email
]);

header("Location: ../index.php");
exit();

?>