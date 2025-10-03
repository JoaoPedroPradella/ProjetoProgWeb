<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;

$bd = new BancoDeDados();

$json = file_get_contents("http://192.168.0.200/json/produtos_ws.php?cdu=1&pwd=senha");

$obj = json_decode($json);
$cd_produto = [];
$i = 0;
foreach ($obj as $key => $value) {
    $cd_produto[$i] = $value->cd_produto;
    echo $value->ds_produto;
    echo $value->ds_unidade;
    echo $value->vl_custo;
    $i++;
}

echo ($cd_produto[0]);
?>


