<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Models\BancoDeDados;


$json = isset($_POST['vendas']) ? $_POST['vendas'] : '';

if ($json == '') {
    echo json_encode(['erro' => 'Json não encontrado']);
    exit;
}

$obj = json_decode($json);
$i = 0;
$bd = new BancoDeDados('pedro_api');
$sql = 'INSERT INTO vendas (cd_venda, cd_cliente, dt_venda, ds_status, vl_venda, cd_usuario) VALUES (?, ?, ?, ?, ?, ?)';

foreach ($obj as $key => $value) {
    $params = [
        $cd_venda[$i] = $value->cd_venda,
        $cd_cliente[$i] = $value->cd_cliente,
        $dt_venda[$i] = $value->dt_venda,
        $ds_status[$i] = $value->ds_status,
        $vl_venda[$i] = $value->vl_venda,
        $cd_usuario[$i] = $value->cd_usuario,
    ];

    $this->bd->executarComando($sql, $params);
    $i++;
}

echo json_encode(['sucesso' => 'Vendas cadastradas']);

?>

