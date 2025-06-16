<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Veiculo;

$id = isset($_POST['id']) ? $_POST['id'] : '';

if ($id == '') {
    return json_encode(['erro'=>'ID não encontrado']);
    exit;
};

$bd = new BancoDeDados();
$excVeiculo = new Veiculo($bd);

try {
    echo json_encode($excVeiculo->excluirVeiculo($id));
} catch (Exception $e) {
    echo json_encode(['erro' => $e -> getMessage()]);
}

