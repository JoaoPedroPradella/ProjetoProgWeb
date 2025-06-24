<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Compra;

header('Content-Type: application/json');

$itens = isset($_POST['objItens'])  ? $_POST['objItens']     : '';
$pagamentos = isset($_POST['objPag'])  ? $_POST['objPag']     : '';
$form['cliente'] = isset($_POST['cliente'])  ? $_POST['cliente']     : '';
$form['veiculo'] = isset($_POST['veiculo'])  ? $_POST['veiculo']     : '';
$form['frete'] = isset($_POST['frete'])  ? $_POST['frete']     : '';
$form['valTotal'] = isset($_POST['total'])  ? $_POST['total']     : '';

$dadosItens = json_decode($itens, true);
$dadosPagamentos = json_decode($pagamentos, true);


if (empty($dadosItens)) {
    echo json_encode(['erro' => 'Não é possível cadastrar uma compra sem itens!']);
    exit;
}

if (empty($dadosPagamentos)) {
    echo json_encode(['erro' => 'Não é possível cadastrar uma compra sem pagamentos!']);
    exit;
}

if (in_array('', $form)) {
    echo json_encode('Existem campos vazios. Verifique!');
    exit;
}

$bd = new BancoDeDados();
$novaCompra = new Compra($bd);

try {
    echo json_encode($novaCompra->cadastrar($form, $dadosItens, $dadosPagamentos));
} catch (Exception $e) {
    // Captura exceções e retorna o erro
    echo json_encode(['erro' => $e->getMessage()]);
}
