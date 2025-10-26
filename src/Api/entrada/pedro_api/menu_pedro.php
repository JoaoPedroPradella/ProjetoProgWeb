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
        <a href="cad_clientes.php?nome=<?= $nome?>&token=<?= $token?>"><button>Clientes</button></a>
        <a href="cad_produtos.php?nome=<?= $nome?>&token=<?= $token?>"><button>Produtos</button></a>
        <a href="cad_vendas.php?nome=<?= $nome?>&token=<?= $token?>"><button>Vendas</button></a>
        <a href="cad_veiculos.php?nome=<?= $nome?>&token=<?= $token?>"><button>Veículos</button></a>
        <a href="cad_usuarios.php?nome=<?= $nome?>&token=<?= $token?>"><button>Usuarios</button></a>
    </div>
</body>

</html>
