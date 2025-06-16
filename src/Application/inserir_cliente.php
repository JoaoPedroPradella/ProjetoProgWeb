<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Cliente;

$form['id'] = isset($_POST['id']) ? $_POST['id'] : '';
$form['nome'] = isset($_POST['nome']) ? $_POST['nome'] : '';
$form['cpf_cnpj'] = isset($_POST['cpf_cnpj']) ? $_POST['cpf_cnpj'] : '';
$form['telefone'] = isset($_POST['telefone']) ? $_POST['telefone'] : '';
$form['cep'] = isset($_POST['cep']) ? $_POST['cep'] : '';
$form['uf'] = isset($_POST['uf']) ? $_POST['uf'] : '';
$form['munic'] = isset($_POST['munic']) ? $_POST['munic'] : '';
$form['lograd'] = isset($_POST['lograd']) ? $_POST['lograd'] : '';
$form['status'] = isset($_POST['status']) ? $_POST['status'] : '';


if (in_array('', $form)) {
    echo json_encode(['erro' => 'Existem campos vazios. Verifique!']);
}

$bd = new BancoDeDados();
$novoCliente = new cliente($bd);

// Validar CPF e CNPJ
if (strlen($form['cpf_cnpj']) == '11') {
    if (!$novoCliente->validaCPF($form['cpf_cnpj'])) {
        echo json_encode(['erro' => 'CPF inválido. Verifique!']);
        exit;
    }
} else if (strlen($form['cpf_cnpj']) == '14') {
    if (!$novoCliente->validarCNPJ($form['cpf_cnpj'])){
        echo json_encode(['erro' => 'CNPJ inválido. Verifique!']);
        exit;
    }
} else {
    echo json_encode(['erro' => 'CPF ou CNPJ inválidos. Verifique!']);
    exit;
}

try {
    echo json_encode($novoCliente->cadastrar($form));

} catch (Exception $e) {
    echo json_encode (['erro_bd' => $e -> getMessage()]);
}