<?php

declare(strict_types=1);

use App\Models\Usuario;

session_set_cookie_params(['httponly' => true]);
session_start();

$nome = isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : '';
$token = isset($_REQUEST["token"]) ? $_REQUEST["token"] : '';

if ($token == '' || $token == 'null' || empty($token)) {
    echo "<script>
        alert('Token inválido!')
        window.location.href = '../../menu_consumo.php'
    </script>";
} else if ($nome == '' || $nome == 'null' || empty($nome)) {
    echo "<script>
        alert('Nome inválido!')
        window.location.href = '../../menu_consumo.php'
    </script>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedro API</title>
</head>

<body>
    <h1>Entidades Pedro API</h1>
    <div>
        <button id="cliente" data-nome="<?= $nome?>" data-token="<?= $token?>">Clientes</button>
        <button id="produto" data-nome="<?= $nome?>" data-token="<?= $token?>">Produtos</button>
        <button id="venda" data-nome="<?= $nome?>" data-token="<?= $token?>">Vendas</button>
        <button id="usuario" data-nome="<?= $nome?>" data-token="<?= $token?>">Usuarios</button>
        <button id="veiculo" data-nome="<?= $nome?>" data-token="<?= $token?>">Usuarios</button>
    </div>
</body>

</html>

<script src="../../../../vendor/js/jquery.js"></script>
<script src="pedro_api.js"></script>