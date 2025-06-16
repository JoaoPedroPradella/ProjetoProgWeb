<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Servico;

$id = isset($_POST['id']) ? $_POST['id'] : '';
$tipo = isset($_POST['listagem']) ? $_POST['listagem'] : '';

if ($tipo == '') {
    if ($id == '') {
        echo json_encode(['erro' => 'ID não encontrado']);
        exit;
    }
}

$bd = new BancoDeDados;
$servico = new Servico($bd);

try {
    echo json_encode($servico->listarServicos($id, $tipo));
} catch (Exception $e) {
    echo json_encode(['erro' => $e->getMessage()]);
};
