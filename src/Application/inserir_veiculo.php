<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Veiculo;

$form['id'] = isset($_POST['id']) ? $_POST['id'] : '';
$form['tipo'] = isset($_POST['tipo']) ? $_POST['tipo'] : '';
$form['placa'] = isset($_POST['placa']) ? $_POST['placa'] : '';
$form['cor'] = isset($_POST['cor']) ? $_POST['cor'] : '';
$form['status'] = isset($_POST['status']) ? $_POST['status'] : '';

$bd = new BancoDeDados();
$novoVeiculo = new Veiculo($bd);

try {
    echo json_encode($novoVeiculo->cadastrar($form));

} catch (Exception $e) {
    echo json_encode (['erro_bd' => $e -> getMessage()]);
}