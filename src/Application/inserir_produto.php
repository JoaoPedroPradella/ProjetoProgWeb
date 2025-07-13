<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Produto;

$form['id'] = isset($_POST['id']) ? $_POST['id'] : '';
$form['desc'] = isset($_POST['desc']) ? $_POST['desc'] : '';
$form['und'] = isset($_POST['und']) ? $_POST['und'] : '';
$form['custo'] = isset($_POST['custo']) ? $_POST['custo'] : '';
$form['qtd'] = isset($_POST['qtd']) ? $_POST['qtd'] : '';
$form['preco'] = isset($_POST['preco']) ? $_POST['preco'] : '';
$form['status'] = isset($_POST['status']) ? $_POST['status'] : '';


if (in_array('', $form)) {
    echo json_encode(['erro' => 'Existem campos vazios. Verifique!']);
}

$form['categ'] = isset($_POST['categ']) ? $_POST['categ'] : '';

if ($form['preco'] <= 0 || $form['custo'] <= 0) {
    echo json_encode(['erro' => 'O valor de venda e de custo não podem ser menor ou igual a 0!']);
    exit;
} else if ($form['qtd'] <= 0) {
    echo json_encode(['erro' => 'A quantidade não pode ser menor ou igual a 0!']);
    exit;
}


$bd = new BancoDeDados();
$novoProduto = new Produto($bd);

try {
    echo json_encode($novoProduto->cadastrar($form));

} catch (Exception $e) {
    echo json_encode (['erro_bd' => $e -> getMessage()]);
}