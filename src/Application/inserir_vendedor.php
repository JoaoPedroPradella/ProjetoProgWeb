<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Vendedor;

$form['id'] = isset($_POST['id']) ? $_POST['id'] : '';
$form['nome'] = isset($_POST['nome']) ? $_POST['nome'] : '';

$bd = new BancoDeDados();
$novoVendedor = new Vendedor($bd);

try {
    echo json_encode($novoVendedor->cadastrar($form));

} catch (Exception $e) {
    echo json_encode (['erro_bd' => $e -> getMessage()]);
}