<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Categoria;

$form['id'] = isset($_POST['id']) ? $_POST['id'] : '';
$form['desc'] = isset($_POST['desc']) ? $_POST['desc'] : '';


if (in_array('', $form)) {
    echo json_encode(['erro' => 'Existem campos vazios. Verifique!']);
}

$bd = new BancoDeDados();
$novoCliente = new Categoria($bd);


try {
    echo json_encode($novoCliente->cadastrar($form));

} catch (Exception $e) {
    echo json_encode (['erro_bd' => $e -> getMessage()]);
}