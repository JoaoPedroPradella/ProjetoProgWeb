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
$rs = $bd->selecionarRegistros("select * from servicos");

foreach ($rs as $row) {
    $linhas[] = [
        'cd_servico' => $row['cd_servico'],
        'ds_servico' => $row['ds_servico'],
        'vl_hora' => $row['vl_hora'],
        'vl_minimo' => $row['vl_minimo'],
        'ds_situacao' => $row['ds_situacao']
    ];
}

$json_string = json_encode($linhas);
echo $json_string;
