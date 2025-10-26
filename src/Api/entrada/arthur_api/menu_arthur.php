<?php

declare(strict_types=1);

use App\Models\Usuario;

session_set_cookie_params(['httponly' => true]);
session_start();

$token = isset($_REQUEST["token"]) ? $_REQUEST["token"] : '';

if ($token == '' || $token == 'null' || empty($token)) {
    echo "<script>
        alert('Token inválido!')
        window.location.href = '../../menu_consumo.php'
    </script>";
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arthur API</title>
</head>

<body>
    <h1>Entidades Arthur API</h1>
    <div>
        <a href="cad_funcionarios.php?token=<?= $token?>"><button>Funcionários</button></a>
        <a href="cad_clientes.php?token=<?= $token?>"><button>Clientes</button></a>
        <a href="cad_produtos.php?token=<?= $token?>"><button>Produtos</button></a>
        <a href="cad_categorias.php?token=<?= $token?>"><button>Categorias</button></a>
        <a href="cad_vendas.php?token=<?= $token?>"><button>Vendas</button></a>
        <a href="cad_itens_vendas.php?token=<?= $token?>"><button>Itens Vendas</button></a>
        <a href="cad_receitas.php?token=<?= $token?>"><button>Receitas</button></a>
    </div>
</body>

</html>
