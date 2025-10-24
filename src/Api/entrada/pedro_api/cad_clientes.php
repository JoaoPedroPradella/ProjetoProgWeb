<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Models\BancoDeDados;


$json = isset($_POST['clientes']) ? $_POST['clientes'] : '';

if ($json == '') {
    echo json_encode(['erro' => 'Json não encontrado']);
    exit;
}

$obj = json_decode($json);
$i = 0;
$bd = new BancoDeDados('pedro_api');
$sql = 'INSERT INTO clientes (cd_cliente, nm_cliente, ds_telefone, ds_endereco, ds_cpf_cnpj, ds_bairro, ds_cidade, ds_uf, nr_cep, ds_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

foreach ($obj as $key => $value) {
    $params = [
        $cd_cliente[$i] = $value->cd_cliente,
        $nm_cliente[$i] = $value->nm_cliente,
        $ds_telefone[$i] = $value->ds_telefone,
        $ds_endereco[$i] = $value->ds_endereco,
        $ds_cpf_cnpj[$i] = $value->ds_cpf_cnpj,
        $ds_bairro[$i] = $value->ds_bairro,
        $ds_cidade[$i] = $value->ds_cidade,
        $ds_uf[$i] = $value->ds_uf,
        $nr_cep[$i] = $value->nr_cep,
        $ds_status[$i] = $value->ds_status
    ];

    $this->bd->executarComando($sql, $params);
    $i++;
}

echo json_encode(['sucesso' => 'Clientes cadastrado']);

?>

