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
$rs = $bd->selecionarRegistros("select * from clientes");

foreach ($rs as $row) {
    $linhas[] = [
        'cd_cliente' => $row['cd_cliente'],
        'ds_nome' => $row['ds_nome'],
        'ds_cpf_cnpj' => $row['ds_cpf_cnpj'],
        'ds_tel' => $row['ds_tel'],
        'ds_cep' => $row['ds_cep'],
        'ds_uf' => $row['ds_uf'],
        'ds_municipio' => $row['ds_municipio'],
        'ds_logradouro' => $row['ds_logradouro'],
        'tp_tipo' => $row['tp_tipo']
    ];
}

$json_string = json_encode($linhas);
echo $json_string;
