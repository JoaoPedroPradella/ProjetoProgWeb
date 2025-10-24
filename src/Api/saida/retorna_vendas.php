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
$rs = $bd->selecionarRegistros("select * from vendas");

foreach ($rs as $row) {
    $linhas[] = [
        'cd_venda' => $row['cd_venda'],
        'dt_emissao' => $row['dt_emissao'],
        'vl_frete' => $row['vl_frete'],
        'vl_total' => $row['vl_total'],
        'ds_situacao' => $row['ds_situacao'],
        'cd_vendedor' => $row['cd_vendedor'],
        'cd_veiculo' => $row['cd_veiculo'],
        'cd_cliente' => $row['cd_cliente']
    ];
}

$json_string = json_encode($linhas);
echo $json_string;
