<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Categoria;

$id = isset($_POST['id']) ? $_POST['id'] : '';

if ($id == '') {
    return json_encode(['erro'=>'ID não encontrado']);
    exit;
};

$bd = new BancoDeDados();
$excCategoria = new Categoria($bd);

try {
    echo json_encode($excCategoria->excluirCategoria($id));
} catch (Exception $e) {
    echo json_encode(['erro' => $e -> getMessage()]);
}

