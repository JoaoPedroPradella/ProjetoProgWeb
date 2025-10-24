<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Models\BancoDeDados;


$json = isset($_POST['veiculos']) ? $_POST['veiculos'] : '';

if ($json == '') {
    echo json_encode(['erro' => 'Json não encontrado']);
    exit;
}

$obj = json_decode($json);
$i = 0;
$bd = new BancoDeDados('pedro_api');
$sql = 'INSERT INTO veiculos (cd_veiculo, ds_tipo, ds_placa, ds_cor, ds_situacao) VALUES (?, ?, ?, ?, ?)';

foreach ($obj as $key => $value) {
    $params = [
        $cd_veiculo[$i] = $value->cd_veiculo,
        $ds_tipo[$i] = $value->ds_tipo,
        $ds_placa[$i] = $value->ds_placa,
        $ds_cor[$i] = $value->ds_cor,
        $ds_situacao[$i] = $value->ds_situacao,
    ];

    $this->bd->executarComando($sql, $params);
    $i++;
}

echo json_encode(['sucesso' => 'Veículos cadastrados']);

?>

