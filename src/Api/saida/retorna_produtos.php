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
$rs = $bd->selecionarRegistros("select * from produtos");

foreach ($rs as $row) {
    $linhas[] = [
        'cd_produto' => $row['cd_produto'],
        'ds_produto' => $row['ds_produto'],
        'ds_unidade' => $row['ds_unidade'],
        'vl_custo' => $row['vl_compra']
    ];
}

$json_string = json_encode($linhas);
echo $json_string;
