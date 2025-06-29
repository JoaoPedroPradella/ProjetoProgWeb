<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Cliente;

$id = isset($_POST['id']) ? $_POST['id'] : '';
$tipo = isset($_POST['listagem']) ? $_POST['listagem'] : '';
$situacao = isset($_POST['situacao']) ? $_POST['situacao'] : '';

if ($tipo == '' && $situacao == '') {
    if ($id == '') {
        echo json_encode(['erro' => 'ID não encontrado']);
        exit;
    }
}

$bd = new BancoDeDados;
$cliente = new Cliente($bd);

try {
    echo json_encode($cliente->listarClientes($id, $tipo, $situacao));
} catch (Exception $e) {
    echo json_encode(['erro' => $e->getMessage()]);
};
