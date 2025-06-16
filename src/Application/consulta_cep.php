<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Cliente;

$cep = isset($_POST['cep']) ? $_POST['cep'] : '';

if ($cep == '') {
    echo json_encode(['erro' => 'CEP vazio']);
    exit;
}

