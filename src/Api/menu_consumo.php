<?php
declare(strict_types=1);
use App\Models\Usuario;

session_set_cookie_params(['httponly' => true]);
session_start();

if (!isset($_SESSION['id'], $_SESSION['token'])) {
    // usuário não está logado, redireciona para login
    header('Location: ../../index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consumo-APIS</title>
</head>
<body>
    <h1>Consumir APIs</h1>
    <button id="btn_pedro">Pedro API</button>
</body>
</html>

<script src="../../vendor/js/jquery.js"></script>
<script src="entrada/pedro_api/pedro_api.js"></script>