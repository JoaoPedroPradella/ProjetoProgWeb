<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Models\BancoDeDados;

$bd = new BancoDeDados();

$json = file_get_contents("http://192.168.0.202/erp/json/buscaclientes.php?ds_nome=joao&ds_token=83570964");

$obj = json_decode($json);
$cd_produto = [];
$i = 0;

foreach ($obj as $key => $value) {
    $cd_cliente[$i] = $value->cd_cliente;
    $nm_cliente[$i] = $value->nm_cliente;
    echo $value->cd_cliente;
    echo $value->nm_cliente;
    $i++;
}
?>


