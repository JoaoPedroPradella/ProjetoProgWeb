<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\BancoDeDados;
use App\Models\Servico;

$form['id'] = isset($_POST['id']) ? $_POST['id'] : '';
$form['desc'] = isset($_POST['desc']) ? $_POST['desc'] : '';
$form['tipo'] = isset($_POST['tipo']) ? $_POST['tipo'] : '';
$form['vlmin'] = isset($_POST['vlmin']) ? $_POST['vlmin'] : '';
$form['vlhr'] = isset($_POST['vlhr']) ? $_POST['vlhr'] : '';
$form['status'] = isset($_POST['status']) ? $_POST['status'] : '';


if (in_array('', $form)) {
    echo json_encode(['erro' => 'Existem campos vazios. Verifique!']);
}

if ($form['vlhr'] <= 0 || $form['vlmin'] <= 0) {
    echo json_encode(['erro' => 'O valor da hora e o valor não podem ser menor ou igual a 0!']);
    exit;
}


$bd = new BancoDeDados();
$novoServico = new Servico($bd);

try {
    echo json_encode($novoServico->cadastrar($form));

} catch (Exception $e) {
    echo json_encode (['erro_bd' => $e -> getMessage()]);
}