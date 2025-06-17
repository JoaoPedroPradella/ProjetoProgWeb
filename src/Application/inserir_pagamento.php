<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Pagamento;

$form['id'] = isset($_POST['id']) ? $_POST['id'] : '';
$form['desc'] = isset($_POST['desc']) ? $_POST['desc'] : '';

$bd = new BancoDeDados();
$novoPagamento = new Pagamento($bd);

try {
    echo json_encode($novoPagamento->cadastrar($form));

} catch (Exception $e) {
    echo json_encode (['erro_bd' => $e -> getMessage()]);
}