<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Models\BancoDeDados;


$json = isset($_POST['produtos']) ? $_POST['produtos'] : '';

if ($json == '') {
    echo json_encode(['erro' => 'Json não encontrado']);
    exit;
}

$obj = json_decode($json);
$i = 0;
$bd = new BancoDeDados('pedro_api');
$sql = 'INSERT INTO produtos (cd_produto, vl_quantidade, ds_produto, ds_categoria, qt_estoque, vl_compra, vl_venda, ds_unidade, ds_situacao, ds_cor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

foreach ($obj as $key => $value) {
    $params = [
        $cd_produto[$i] = $value->cd_produto,
        $vl_quantidade[$i] = $value->vl_quantidade,
        $ds_produto[$i] = $value->ds_produto,
        $ds_categoria[$i] = $value->ds_categoria,
        $qt_estoque[$i] = $value->qt_estoque,
        $vl_compra[$i] = $value->vl_compra,
        $vl_venda[$i] = $value->vl_venda,
        $ds_unidade[$i] = $value->ds_unidade,
        $ds_situacao[$i] = $value->ds_situacao,
        $ds_cor[$i] = $value->ds_cor
    ];

    $this->bd->executarComando($sql, $params);
    $i++;
}

echo json_encode(['sucesso' => 'Produtos cadastrados']);

?>

