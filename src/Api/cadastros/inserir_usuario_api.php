<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Usuario;

$form['id'] = isset($_POST['id']) ? $_POST['id'] : '';
$form['nome'] = isset($_POST['nome']) ? $_POST['nome'] : '';
$form['email'] = isset($_POST['email']) ? $_POST['email'] : '';
$form['senha'] = isset($_POST['senha']) ? $_POST['senha'] : '';
$form['status'] = isset($_POST['status']) ? $_POST['status'] : '';


if (in_array('', $form)) {
    echo json_encode(['erro' => 'Existem campos vazios. Verifique!']);
}

$bd = new BancoDeDados();
$novoUsuario = new Usuario($bd);

try {
    echo json_encode($novoUsuario->cadastrar_api($form));

} catch (Exception $e) {
    echo json_encode (['erro_bd' => $e -> getMessage()]);
}