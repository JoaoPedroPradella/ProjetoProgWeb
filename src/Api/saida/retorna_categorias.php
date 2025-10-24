<?php
declare(strict_types=1);
use App\Models\Usuario;
use App\Models\BancoDeDados;

require_once __DIR__ . '/../../../vendor/autoload.php';

$bd = new BancoDeDados('infojp');
$sql = "SELECT token FROM usuarios_api WHERE token = '" . $_REQUEST["token"] . "'";
$dados = $bd->selecionarRegistro($sql);

if (empty($dados)) {
    echo "<script>
        alert('Token inválido!')
        window.location.href = '../menu.php'
    </script>";
}

$linhas = array();
$rs = $bd->selecionarRegistros("select * from categorias");

foreach ($rs as $row) {
    $linhas[] = [
        'cd_categoria' => $row['cd_categoria'],
        'ds_categoria' => $row['ds_categoria']
    ];
}

$json_string = json_encode($linhas);
echo $json_string;
