<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Venda;


$id = isset($_POST['id']) ? $_POST['id'] : '';
$itens = isset($_POST['objItens'])  ? $_POST['objItens']     : '';
$servicos = isset($_POST['objServ'])  ? $_POST['objServ']     : '';

$dadosItens = json_decode($itens, true);
$dadosServicos = json_decode($servicos, true);

if ($id == '') {
    echo json_encode(['erro' => 'ID não econtrado']);
    exit();
}

if (empty($dadosItens) && empty($dadosServicos)) {
    echo json_encode(['erro' => 'Não é possível cancelar uma venda sem itens!']);
    exit;
}

$bd = new BancoDeDados;
$venda = new Venda($bd);

try {
    echo json_encode($venda->cancelarVenda($id, $dadosItens));
} catch (Exception $e) {
    echo json_encode(['erro' => $e->getMessage()]);
}
