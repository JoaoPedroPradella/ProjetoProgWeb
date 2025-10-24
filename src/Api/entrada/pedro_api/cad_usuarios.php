<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Models\BancoDeDados;


$json = isset($_POST['usuarios']) ? $_POST['usuarios'] : '';

if ($json == '') {
    echo json_encode(['erro' => 'Json não encontrado']);
    exit;
}

$obj = json_decode($json);
$i = 0;
$bd = new BancoDeDados('pedro_api');
$sql = 'INSERT INTO usuarios (cd_usuario, ds_usuario, ds_cpf, ds_email, ds_celular, ds_endereco, ds_uf, ds_cidade, ds_situacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

foreach ($obj as $key => $value) {
    $params = [
        $cd_usuario[$i] = $value->cd_usuario,
        $ds_usuario[$i] = $value->ds_usuario,
        $ds_cpf[$i] = $value->ds_cpf,
        $ds_email[$i] = $value->ds_email,
        $ds_celular[$i] = $value->ds_celular,
        $ds_endereco[$i] = $value->ds_endereco,
        $ds_uf[$i] = $value->ds_uf,
        $ds_cidade[$i] = $value->ds_cidade,
        $ds_situacao[$i] = $value->ds_situacao
    ];

    $this->bd->executarComando($sql, $params);
    $i++;
}

echo json_encode(['sucesso' => 'Usuarios cadastrado']);

?>

